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
 * @property string $password
 */
class StoreCustomerForm extends CActiveRecord
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
        return 'customer';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('email, first_name, last_name, target_first_name, target_last_name, address, city, phone, country, zip', 'required'),
            array('email', 'email'),
            array('email', 'unique'),
            array('password', 'new_user_password'),
            array('password', 'length', 'min' => 5),
        );
    }
    
    public function new_user_password($attr, $params) {
        $user = User::model()->findByAttributes(array('email' => $this->email));

        if(!$user and empty($this->$attr)) {
            $this->addError('password', Yii::t('store', 'Укажите пароль для новой учетной записи'));
        }
    }
}
