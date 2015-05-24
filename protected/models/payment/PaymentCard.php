<?php

/**
 * This is the model class for table "payment_card".
 *
 * The followings are the available columns in table 'payment_card':
 * @property integer $id
 * @property integer $user_id
 * @property integer $wallet_id
 * @property string $pan
 * @property text $token
 * @property string $type
 * @property integer $status
 */
class PaymentCard extends CActiveRecord
{

    const STATUS_PAYMENT = 1;
    const STATUS_ARCHIV = 0;

    const MAX_CARDS_VIEW = 10;

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
        return 'payment_card';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, wallet_id, pan, token, type, status, system', 'required'),
            array('user_id, status, wallet_id, system', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_id, wallet_id, pan, token, type, status', 'safe', 'on' => 'search'),
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
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'wallet' => array(self::BELONGS_TO, 'PaymentWallet', 'wallet_id'),
        );
    }

    public function getJson()
    {
        $pan_leng = count($this->pan);
        return array(
            'id' => $this->id,
            'type' => $this->type,
            'pan' => mb_substr($this->pan, $pan_leng - 9),
            'status' => $this->status,
            'system' => $this->system,
        );
    }

    public function beforeSave()
    {
        if ($this->status == PaymentCard::STATUS_PAYMENT) {
            PaymentFail::model()->updateAll(
                array('count' => PaymentFail::START_COUNT), 
                'wallet_id=' . $this->wallet_id
            );
        }

        return parent::beforeSave();
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

        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('wallet_id', $this->wallet_id);
        $criteria->compare('pan', $this->pan, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('status', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
