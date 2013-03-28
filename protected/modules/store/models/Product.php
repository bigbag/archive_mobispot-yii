<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $photo
 * @property string $description
 * @property string $color
 * @property string $size
 */
class Product extends CActiveRecord {

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
	
    public function getDbConnection(){
        return Yii::app()->dbStore;
    }
 
    public function tableName()
    {
        return 'store.product';
    }

}