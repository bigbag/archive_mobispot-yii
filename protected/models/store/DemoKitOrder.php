<?php

/**
 * This is the model class for table "demo_kit_order".
 */
class DemoKitOrder extends CActiveRecord
{
    const STATUS_CREATED = 0;

    const PAYMENT_BY_CARD = 'AC';
    const PAYMENT_BY_YM = 'PC';
    const PAYMENT_MAIL = 'email';
    
    const USD_CHAR_CODE = 'USD';

    public static function getConfig()
    {
        return array(
                'price' => 120,
                'defalutCountForAll' => 3,
                'fillAllMessage'=>Yii::t('store', 'All the fields must be filled'),
                'mailOrderMessage'=>Yii::t('store', 'Thank you for your purchase. Our manager will contact you soon for further transfer details.'),
                'toMainMessage' => Yii::t('store', 'To the main page'),
                'product' => array(
                    array(
                        'id' => 1,
                        'name' => Yii::t('store', 'Brace'),
                        'img' => '/uploads/store/product/brace_blue.png',
                        'descr' => Yii::t('store', 'Unique NFC wristband from Mobispot. Waterproof and sexy.'),
                        'price' => 120
                    ),
                    array(
                        'id' => 2,
                        'name' => Yii::t('store', 'Key'),
                        'img' => '/uploads/store/product/key_green.png',
                        'descr' => Yii::t('store', 'Occupies no space in your pocket but brings all the power of NFC.'),
                        'price' => 120
                    ),
                    array(
                        'id' => 3,
                        'name' => Yii::t('store', 'Card'),
                        'img' => '/uploads/store/product/card_red.png',
                        'descr' => Yii::t('store', 'Choice of conservative ones. If you get bored - draw something on it.'),
                        'price' => 120
                    )
                ),
                'shipping' => array(
                    array(
                        'id' => 1,
                        'name'=>Yii::t('store', 'Regular post'),
                        'price' => 25,
                        'descr' => Yii::t('store', '+$25 (5-7 days)'),
                    ),
                    array(
                        'id' => 2,
                        'name'=>Yii::t('store', 'DHL/TNT/UPS'),
                        'price' => 70,
                        'descr' => Yii::t('store', '+$70 (2-3 days)'),
                    )
                ),
                'payment' => array(
                    array(
                        'id' => 1,
                        'name' => Yii::t('store', 'VISA/MasterCard'),
                        'action' => self::PAYMENT_BY_CARD,
                    ),
                    array(
                        'id' => 2,
                        'name' => Yii::t('store', 'Yandex.Money'),
                        'action' => self::PAYMENT_BY_YM,
                    ),
                    array(
                        'id' => 3,
                        'name' => Yii::t('store', 'Bank transfer'),
                        'action' => self::PAYMENT_MAIL,
                    ),
                )
        );
    }

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
        return 'store.demo_kit_order';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('email', 'required'),
            array('email', 'email'),
            array('shipping, payment, status', 'numerical', 'integerOnly' => true),
            array('shipping', 'checkShipping'),
            array('payment', 'checkPayment'),
        );
    }

    public function getShipping($ids)
    {
        $answer = false;
        $config = DemoKitOrder::getConfig();

        foreach ($config['shipping'] as $shipping) {
            if ($shipping['id'] == $ids)
                $answer = $shipping;
        }

        return $answer;
    }

    public function checkShipping($attribute, $params)
    {
        $config = DemoKitOrder::getConfig();
        $shipping=self::getShipping($this->$attribute);

        if (!$shipping)
            $this->addError($attribute, Yii::t('store','Incorrect delivery method!'));
    }

    public function getPayment($idp)
    {
        $answer = false;
        $config = DemoKitOrder::getConfig();

        foreach ($config['payment'] as $payment) {
            if ($payment['id'] == $idp)
                $answer = $payment;
        }

        return $answer;
    }

    public function checkPayment($attribute, $params)
    {
        $config = DemoKitOrder::getConfig();
        $payment=self::getPayment($this->$attribute);

        if (!$payment)
            $this->addError($attribute, Yii::t('store','Invalid payment method'));
    }

    public function getProduct($idp)
    {
        $answer = false;
        $config = DemoKitOrder::getConfig();

        foreach ($config['product'] as $product) {
            if ($product['id'] == $idp)
                $answer = $product;
        }

        return $answer;
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->creation_date = date('Y-m-d H:i:s');
            $this->status = self::STATUS_CREATED;
        }

        return parent::beforeValidate();
    }

    public function calcSubtotal()
    {
        $config = self::getConfig();
        return $config['price'];
    }

    public function calcSumm()
    {
        $config = self::getConfig();
        $summ = $config['price'];

        if (empty($this->shipping))
            return $summ;

        $shipping = self::getShipping($this->shipping);
        $summ += $shipping['price'];

        return $summ;
    }

    public static function getDollarRate($timestamp = 0)
    {
        if ($timestamp == 0)
            $timestamp = time();
        $xml_rates = simplexml_load_file("http://www.cbr.ru/scripts/XML_daily.asp?date_req=".date("d/m/Y", $timestamp));
        foreach($xml_rates as $key=>$data){
            if($data->CharCode == self::USD_CHAR_CODE) {
                $rate = $data->Value;
            }
        }

        return (float)(str_replace(',', '.', $rate));
    }

    public function getSummRub()
    {
        return round($this->calcSumm() * self::getDollarRate(), 2);
    }

    public function fromArray($data)
    {
        $order = new self();

        if (!empty($data['email']))
            $order->email = $data['email'];
        if (!empty($data['name']))
            $order->name = $data['name'];
        if (!empty($data['phone']))
            $order->phone = $data['phone'];
        if (!empty($data['address']))
            $order->address = $data['address'];
        if (!empty($data['city']))
            $order->city = $data['city'];
        if (!empty($data['country']))
            $order->country = $data['country'];
        if (!empty($data['zip']))
            $order->zip = $data['zip'];
        if (!empty($data['shipping']))
            $order->shipping = $data['shipping'];
        if (!empty($data['payment']))
            $order->payment = $data['payment'];

        return $order;
    }

    public function makeMailOrder()
    {
        $mailOrder = array();
        $mailOrder['id'] = $this->id;
        $mailOrder['name'] = $this->name;
        $mailOrder['phone'] = $this->phone;
        $mailOrder['email'] = $this->email;
        $mailOrder['zip'] = $this->zip;
        $mailOrder['address'] = $this->address;
        $mailOrder['city'] = $this->city;
        $mailOrder['country'] = $this->country;
        $mailOrder['shipping'] = self::getShipping($this->shipping)['name'];
        $mailOrder['shipping_price'] = self::getShipping($this->shipping)['price'];
        $mailOrder['subtotal'] = $this->calcSubtotal();
        $mailOrder['total'] = $this->calcSumm();

        $items = array();
        $config = self::getConfig();
        foreach ($config['product'] as $item)
            $items[] = array('name' => $item['name'], 'count' => $config['defalutCountForAll']);

        $mailOrder['items'] = $items;

        return $mailOrder;
    }

}
