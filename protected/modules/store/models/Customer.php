<?php

/**
 * This is the model class for table "customer".
 *
 * The followings are the available columns in table 'customer':
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $target_first_name
 * @property string $target_last_name
 * @property string $address
 * @property string $city
 * @property string $phone
 * @property string $country 
 */
class Customer extends CActiveRecord {

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
	
    public function getDbConnection(){
        return Yii::app()->dbStore;
    }
 
    public function tableName()
    {
        return 'store.customer';
    }

}