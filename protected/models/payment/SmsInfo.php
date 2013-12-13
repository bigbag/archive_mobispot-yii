<?php

/**
 * This is the model class for table "sms_info".
 *
 * The followings are the available columns in table 'sms_info':
 * @property integer $id
 * @property integer $wallet_id 
 * @property integer $user_id
 * @property string $last_sms
 * @property integer $day_count 
 * @property string $phone 
 * @property string $active
 */
class SmsInfo extends CActiveRecord
{
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
        return 'payment.sms_info';
    }
    
    public static function getSmsInfoForWallet($wallet_id)
    {
        $answer = array();

        $wallet = PaymentWallet::model()->findByPk($wallet_id);
        $userWallets = PaymentWallet::model()->with('smsInfo')->findAllByAttributes(
            array('user_id' => $wallet->user_id)
        );
        $answer['phone'] = '';
        $answer['active'] = false;
        $answer['sms_all_wallets'] = true;
        foreach ($userWallets as $userWallet)
        {
            if ((!$answer['phone']  || $userWallet->id == $wallet_id) && !empty($userWallet->smsInfo->phone))
                $answer['phone'] = $userWallet->smsInfo->phone;
            if (empty($userWallet->smsInfo->active) || !($userWallet->smsInfo->active) || empty($userWallet->smsInfo->phone))
                $answer['sms_all_wallets'] = false;
            if ($userWallet->id == $wallet_id && isset($userWallet->smsInfo->active))
                $answer['active'] = $userWallet->smsInfo->active;
        }
        
        return $answer;
    }
}
