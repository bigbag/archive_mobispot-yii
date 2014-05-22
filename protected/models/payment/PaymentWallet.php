<?php

/**
 * This is the model class for table "wallet".
 *
 * The followings are the available columns in table 'wallet':
 * @property integer $id
 * @property string $payment_id
 * @property string $hard_id
 * @property string $name
 * @property integer $user_id
 * @property integer $discodes_id
 * @property string $creation_date
 * @property string $status
 * @property integer $blacklist
 * @property integer $type
 */
class PaymentWallet extends CActiveRecord
{

    const STATUS_NOACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_BANNED = -1;

    const TYPE_DEMO = 0;
    const TYPE_FULL = 3;

    const ACTIVE_ON = 1;
    const ACTIVE_OFF = 0;

    public function getStatusList()
    {
        return array(
            self::STATUS_NOACTIVE => Yii::t('user', 'Не активирован'),
            self::STATUS_ACTIVE => Yii::t('user', 'Активирован'),
            self::STATUS_BANNED => Yii::t('user', 'Заблокирован'),
        );
    }

    public function getAllSpot()
    {
        return array(
            self::TYPE_FULL => Yii::t('account', 'Полный'),
            self::TYPE_DEMO => Yii::t('account', 'Демо'),
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PaymentWallet the static model class
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
        return 'wallet';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('hard_id, name, payment_id, user_id, creation_date', 'required'),
            array('user_id, discodes_id, status', 'numerical', 'integerOnly' => true),
            array('hard_id, payment_id', 'length', 'max' => 20),
            array('name', 'filter', 'filter' => 'trim'),
            array('name', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, hard_id, payment_id, name, user_id, discodes_id, status, creation_date', 'safe', 'on' => 'search'),
        );
    }

    public function getFreeByDiscodesId($discodes_id)
    {
        $wallet = Yii::app()->cache->get('wallet_discodes_' . $discodes_id);
        if (!$wallet)
        {
            $wallet = PaymentWallet::model()->findByAttributes(
                    array(
                        'discodes_id' => $discodes_id,
                        'user_id' => 0,
                    )
            );
            Yii::app()->cache->set('wallet_discodes_' . $discodes_id, $wallet, 120);
        }
        return $wallet;
    }

    public function getActivByDiscodesId($discodes_id)
    {
        return PaymentWallet::model()->findByAttributes(
            array(
                'discodes_id' => $discodes_id,
                'user_id' => Yii::app()->user->id,
                'status' => PaymentWallet::STATUS_ACTIVE,
            )
        );
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord)
        {
            $this->creation_date = date('Y-m-d H:i:s');
            if (!$this->status) $this->status = self::STATUS_ACTIVE;
            if (!$this->type) $this->type = self::TYPE_FULL;
            if (!$this->blacklist) $this->blacklist = self::ACTIVE_OFF;
            if (!$this->name) $this->name = 'My Spot';
        }

        return parent::beforeValidate();
    }

    protected function afterSave()
    {
        Yii::app()->cache->delete('wallet_discodes_' . $this->discodes_id);
        parent::afterSave();
    }

    public function selectUser($user_id)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('user_id', $user_id);
        $this->getDbCriteria()->mergeWith($criteria);
        return $this;
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
            'spot' => array(self::BELONGS_TO, 'Spot', 'discodes_id'),
            'loyalties' => array(self::MANY_MANY, 'Loyalty', 'wallet_loyalty(wallet_id, loyalty_id)'),
            'actions' => array(self::HAS_MANY, 'WalletLoyalty', 'wallet_id'),
            'smsInfo' => array(self::HAS_ONE, 'SmsInfo', 'wallet_id'),
        );
    }

    public static function getByWalletId($id, $page = 1, $count = 5)
    {
        $answer = array();
        $criteria = new CDbCriteria;
        $wallet = self::model()->with('loyalties')->findByPk($id);
        return $answer;
    }


    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'hard_id' => 'Hard',
            'payment_id' => 'Payment',
            'user_id' => 'User',
            'discodes_id' => 'Spot',
            'creation_date' => 'Creation Date',
            'name' => 'Name',
            'status' => 'Status',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('hard_id', $this->hard_id, true);
        $criteria->compare('payment_id', $this->payment_id, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('discodes_id', $this->discodes_id);
        $criteria->compare('status', $this->status);
        $criteria->compare('creation_date', $this->creation_date, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('blacklist', $this->blacklist, true);
        $criteria->compare('type', $this->type, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
