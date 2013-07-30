<?php

/**
 * This is the model class for table "store_order".
 *
 * The followings are the available columns in table 'store_order':
 * @property integer $id
 * @property integer $id_order_list
 * @property integer $id_customer
 * @property string $delivery 
 * @property string $payment
 * @property integer $status
 */
class storeOrder extends CActiveRecord
{

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

}