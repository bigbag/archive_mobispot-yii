<?php

/**
 * This is the model class for table "order_list".
 *
 * The followings are the available columns in table 'order_list':
 * @property integer $id
 * @property integer $id_order
 * @property integer $id_product
 * @property integer $quantity
 * @property string $color
 * @property string $size_name
 * @property integer $price
 * @property string $surface
 */
class StoreOrderList extends CActiveRecord
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
        return 'store.order_list';
    }
    
    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_order, id_product, quantity, price', 'required'),
            array('id_order, id_product, quantity', 'numerical', 'integerOnly' => true),
        );
    }
}