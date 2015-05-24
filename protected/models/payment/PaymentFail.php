<?php

/**
 * This is the model class for table "fail".
 *
 * The followings are the available columns in table 'fail':
 * @property integer $report_id
 * @property integer $count
 * @property integer $timestamp
 * @property integer $lock
 * @property integer $wallet_id
 * @property string $payment_id
 */
class PaymentFail extends CActiveRecord
{
    const START_COUNT = 0;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PaymentHistory the static model class
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
        return 'fail';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('report_id, count, lock', 'required'),
            array('report_id, count, lock, wallet_id, timestamp', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('report_id, count, lock, wallet_id, timestamp, payment_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'report' => array(self::BELONGS_TO, 'Report', 'report_id'),
            'wallet' => array(self::BELONGS_TO, 'PaymentWallet', 'wallet_id'),
        );
    }


    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('report_id', $this->id);
        $criteria->compare('count', $this->user_id);
        $criteria->compare('wallet_id', $this->wallet_id);
        $criteria->compare('lock', $this->pan);
        $criteria->compare('timestamp', $this->type);
        $criteria->compare('payment_id', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
