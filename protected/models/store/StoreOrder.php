<?php

/**
 * This is the model class for table "store_order".
 *
 * The followings are the available columns in table 'store_order':
 * @property integer $id
 * @property integer $id_customer
 * @property string $delivery
 * @property string $delivery_data
 * @property string $payment
 * @property string $payment_data
 * @property integer $status
 * @property integer $promo_id
 * @property string $buy_date
 */
class StoreOrder extends CActiveRecord
{

    const STATUS_CANCELED = -1;
    const STATUS_CART = 0;
    const STATUS_PAYMENT_WAIT = 1;      //передано на оплату
    const STATUS_SUCCESS_REDIRECT = 2;  //пользователь пререведен магазином на shopSuccessURL
    const STATUS_PAID = 3;
    
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getDbConnection()
    {
        return Yii::app()->dbStore;
    }

    public function tableName()
    {
        return 'store_order';
    }

    public function beforeSave()
    {
        $this->delivery_data = serialize($this->delivery_data);
        $this->payment_data = serialize($this->payment_data);
        return parent::beforeSave();
    }

    protected function afterFind()
    {
        $this->delivery_data = unserialize($this->delivery_data);
        $this->payment_data = unserialize($this->payment_data);
        return parent::afterFind();
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_customer, status', 'required'),
            array('id_customer, delivery, status, promo_id', 'numerical', 'integerOnly' => true),
        );
    }
    
    public function itemsList() 
    {
        $items = StoreOrderList::model()->findAllByAttributes(array('id_order' => $this->id));
        
        $list = array();
        
        $productList = StoreProduct::getList();
        foreach ($items as $item) {
            $list[] = array(
                'name' => $productList[$item->id_product]->name,
                'code' => $productList[$item->id_product]->code,
                'type' => $productList[$item->id_product]->type,
                'id_order' => $item->id_order,
                'quantity' => $item->quantity,
                'color' => $item->color,
                'price' => $item->price,
                'id_custom_card' => $item->id_custom_card,
            );
        }
        
        return $list;
    }
    
    public function troikaList()
    {
        $list = $this->itemsList();
        $troikaList = array();
        
        foreach ($list as $item){
            if (CustomCard::TYPE_TROIKA == $item['type'])
                $troikaList[] = $item;
        }
        
        return $troikaList;
    }
    
    public function subtotal($items=false)
    {
        $items = StoreOrderList::model()->findAllByAttributes(array('id_order' => $this->id));
        $subtotal = 0;
        
        foreach ($items as $item) {
            $subtotal += $item->price * $item->quantity;
        }
        
        return $subtotal;
    }
    
    public function tax()
    {
        return 0;
    }
    
    public function discount()
    {
        return 0;
    }
    
    public static function getDraft($id_customer)
    {
        $order = StoreOrder::model()->findByAttributes(array(
            'id_customer' => $id_customer,
            'status' => self::STATUS_CART,
        ));
        
        if ($order)
            return $order;

        $order = new StoreOrder;
        $order->id_customer = $id_customer;
        $order->status = self::STATUS_CART;
        $order->save();
        
        return $order;
    }

    public function mailOrder()
    {
        if (!$this->id)
            return false;
        
        $mailOrder = array('id'=>$this->id);
        
        $customer = StoreCustomer::model()->findByPk($this->id_customer);
        $delivery = StoreDelivery::model()->findByPk($this->delivery);
        $items = $this->itemsList();
        
        if (!$customer or !$delivery or empty($items))
            return false;
        
        $mailOrder['order'] = $this;
        $mailOrder['delivery'] = $delivery;
        $mailOrder['customer'] = $customer;
        $mailOrder['items'] = $items;
        $mailOrder['subtotal'] = $this->subtotal($items);
        $mailOrder['shipping'] = $delivery->price;
        $mailOrder['tax'] = $this->tax();
        $mailOrder['total'] = $mailOrder['subtotal'] + $mailOrder['shipping'] - $this->discount();
        
        return $mailOrder;
    }
    
    public function customCardsMailOrders($baseOrder=false)
    {
        $mailOrders = array();
        
        if (!$baseOrder)
            $baseOrder = $this->mailOrder();
        
        foreach($baseOrder['items'] as $item) {
            if (empty($item['id_custom_card']))
                continue;
            
            $card = CustomCard::model()->findByPk($item['id_custom_card']);
            
            if (empty($card->img))
                continue;
            
            $draw_hole = false;
            if (empty($card->photo) and empty($card->logo) and empty($card->name) and empty($card->position)) {
                $draw_hole = true;
            }
            
            $mailOrders[] = array(
                'shipping_name' => $baseOrder['customer']->target_first_name,
                'phone' => $baseOrder['customer']->phone,
                'address' => $baseOrder['customer']->address,
                'city' => $baseOrder['customer']->city,
                'zip' => $baseOrder['customer']->zip,
                'front_img' => $card->img,
                'back_img' => CustomCard::backByType($item['type']),
                'draw_hole' => $draw_hole,
            );
        }

        return $mailOrders;
    }
    
    public function registerUser($lang)
    {
        $customer = StoreCustomer::model()->findByPk($this->id_customer);
        
        if (!$customer or empty($customer->email))
            return false;
        
        $user = User::model()->findByAttributes(array('email'=>$customer->email));
        if ($user)
            return $user->id;
        
        if (empty($customer->password))
            return false;
        
        $user = new User;
        $user->email = $customer->email;
        $user->password = $customer->password;
        $user->activkey = sha1(microtime() . $user->password);
        $user->lang = $lang;
        
        if (!$user->save())
        {
            return false;
        }

        return $user->id;
    }
    
    public function makeTroika($user_id)
    {
        Yii::setPathOfAlias('Predis',Yii::getPathOfAlias('ext.predis'));

        require_once(Yii::getPathOfAlias('ext.celery-php') . DIRECTORY_SEPARATOR . 'amqp.php');
        require_once(Yii::getPathOfAlias('ext.celery-php') . DIRECTORY_SEPARATOR . 'redisconnector.php');
        require_once(Yii::getPathOfAlias('ext.celery-php') . DIRECTORY_SEPARATOR . 'celery.php' );
        
        $error = 'no';
        $path = Yii::app()->getBaseUrl(true) . StoreProduct::CARDS_PATH;
        $items = $this->troikaList();
        $customer = StoreCustomer::model()->findByPk($this->id_customer);
        $user = User::model()->findByPk($user_id);

        if (!$customer or !$user)
            return false;
        
        if (empty($items))
            return true;
        
        foreach ($items as $item)
        {
            if (empty($item['id_custom_card']))
            {
                $error = 'yes';
                continue;
            }
            
            $data = array(
                'user_id' => $user->id,
                'user_email' => $user->email
            );
            
            $card = CustomCard::model()->findByPk($item['id_custom_card']);
            
            if (!empty($card->img))
                $data['image'] = $path . $card->img;
            if (!empty($card->photo))
                $data['photo'] = $path . $card->photo;
            if (!empty($card->logo))
                $data['logo'] = $path . $card->logo;
            if (!empty($card->name))
                $data['name'] = $card->name;
            if (!empty($card->position))
                $data['position'] = $card->position;

            $c = new Celery(
                Yii::app()->params['redis_celery']['server'],
                Yii::app()->params['redis_celery']['login'],
                Yii::app()->params['redis_celery']['password'],
                Yii::app()->params['redis_celery']['vhost'],
                Yii::app()->params['redis_celery']['exchange'],
                Yii::app()->params['redis_celery']['binding'],
                Yii::app()->params['redis_celery']['port'],
                Yii::app()->params['redis_celery']['connector']
            );

            $c->postTask('troika.order.tasks.create_order_from_store', array(CJSON::encode($data, true)));
        }
        
        if ('no' == $error)
            return true;
        
        return false;
    }

}
