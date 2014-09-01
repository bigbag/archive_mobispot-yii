<?php

/**
 * This is the model class for table "loyalty_sharing".
 *
 */
class LoyaltySharing extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Loyalty the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return CDbConnection database connection
     */
    public function getDbConnection()
    {
        return Yii::app()->dbPayment;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'loyalty_sharing';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('loyalty_id, sharing_type', 'required'),
            array('loyalty_id, sharing_type', 'numerical', 'integerOnly' => true),
        );
    }

    public function getLink()
    {
        return $this->link;
    }
}
