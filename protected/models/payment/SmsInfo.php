<?php

/**
 * This is the model class for table "sms_info".
 *
 * The followings are the available columns in table 'sms_info':
 * @property string $id
 * @property string $wallet_id
 * @property string $user_id
 * @property string $last_sms
 * @property integer $day_count
 * @property string $phone
 * @property integer $status
 */
class SmsInfo extends CActiveRecord
{

    const STATUS_ON = 1;
    const STATUS_OFF = 0;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sms_info';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wallet_id, user_id, phone, status', 'required'),
			array('day_count, status', 'numerical', 'integerOnly'=>true),
			array('wallet_id, user_id', 'length', 'max'=>20),
			array('phone', 'length', 'max'=>64),
			array('last_sms', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, wallet_id, user_id, last_sms, day_count, phone, status', 'safe', 'on'=>'search'),
		);
	}

    public function beforeValidate()
    {
        if ($this->isNewRecord)
        {
            if (!$this->status) $this->status = self::STATUS_OFF;
        }

        return parent::beforeValidate();
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'user_id' => array(self::BELONGS_TO, 'User', 'user_id'),
            'wallet_id' => array(self::BELONGS_TO, 'PaymentWallet', 'wallet_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'wallet_id' => 'Wallet',
			'user_id' => 'User',
			'last_sms' => 'Last Sms',
			'day_count' => 'Day Count',
			'phone' => 'Phone',
			'status' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('wallet_id',$this->wallet_id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('last_sms',$this->last_sms,true);
		$criteria->compare('day_count',$this->day_count);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->dbPayment;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className status record class name.
	 * @return SmsInfo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function getByWalletId($wallet_id)
    {
        $answer = array();

        $wallet = PaymentWallet::model()->findByPk($wallet_id);
        $userWallets = PaymentWallet::model()->with('smsInfo')->findAllByAttributes(
            array('user_id' => $wallet->user_id)
        );
        $answer['phone'] = '';
        $answer['status'] = false;
        $answer['sms_all_wallets'] = true;
        foreach ($userWallets as $userWallet)
        {
            if ((!$answer['phone']  || $userWallet->id == $wallet_id) && !empty($userWallet->smsInfo->phone))
                $answer['phone'] = $userWallet->smsInfo->phone;
            if (empty($userWallet->smsInfo->status) || !($userWallet->smsInfo->status) || empty($userWallet->smsInfo->phone))
                $answer['sms_all_wallets'] = false;
            if ($userWallet->id == $wallet_id && isset($userWallet->smsInfo->status))
                $answer['status'] = $userWallet->smsInfo->status;
        }
        
        return $answer;
    }
}
