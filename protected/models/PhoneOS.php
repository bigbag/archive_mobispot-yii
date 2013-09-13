<?php

/**
 * This is the model class for table "phone_os".
 *
 */
class PhoneOS extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

     
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'phone_os';
    }

}