<?php

/**
 * This is the model class for table "delivery".
 */
class Delivery extends CActiveRecord {

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
	
    public function getDbConnection(){
        return Yii::app()->dbStore;
    }
 
    public function tableName()
    {
        return 'store.delivery';
    }

}