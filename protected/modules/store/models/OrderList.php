<?php

/**
 * This is the model class for table "order_list".
 *
 * The followings are the available columns in table 'order_list':
 * @property integer $id
 * @property integer $id_list
 * @property integer $id_product
 * @property integer $quantity
 * @property string $color
 * @property string $size
 */
class OrderList extends CActiveRecord {

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function getDbConnection(){
        return Yii::app()->dbStore;
    }
	
    public function tableName()
    {
        return 'store.order_list';
    }

}