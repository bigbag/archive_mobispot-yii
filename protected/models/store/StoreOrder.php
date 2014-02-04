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
    const STATUS_PAYMENT_WAIT = 1;             //передано на оплату (через Uniteller)
    const STATUS_PAID = 2;


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
        return 'store.store_order';
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
}