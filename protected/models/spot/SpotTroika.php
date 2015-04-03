<?php

/**
 * This is the model class for table "spot_troika".
 *
 * The followings are the available columns in table 'spot_troika':
 * @property integer $discodes_id
 */

class SpotTroika extends CActiveRecord
{
    
    const STATUS_NEW = 'new';
    const STATUS_INPROGRESS = 'inprogress';
    const STATUS_RELEASED = 'released';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_REMOVED = 'removed';
    
    const STATE_ACTIVE = 0;
    const STATE_LOST = 1;
    const STATE_BROKEN = 3;
    const STATE_NOT_NEED = 5;
    const STATE_REISSUED = 6;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Spot the static model class
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
        return 'spot_troika';
    }

    public static function hasTroika($discodes_id)
    {
        $flag = self::Model()->findByPk($discodes_id);
        if ($flag)
            return true;
        
        return false;
    }
    
    public static function getCard($hard_id)
    {
        $ch = curl_init();
        $url = Yii::app()->params['api']['troika'] . '/api/card/hard_id/' . $hard_id;
        
        curl_setopt($ch, CURLOPT_USERPWD, 
            Yii::app()->params['api_user']['login'] 
            . ':' 
            . Yii::app()->params['api_user']['password']);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CAINFO, Yii::app()->params['ssl']);
        
        try {
            $result = curl_exec($ch);
        } catch (Exception $e) {
            Yii::log(
                    'Curl exception: ' . $e->getMessage() . PHP_EOL .
                    'URL: ' . $url . PHP_EOL .
                    'Options: ' . var_export($options, true)
                    , 'error', 'application'
            );
            return false;
        }
        
        $headers = curl_getinfo($ch);
        
        if (empty($headers['http_code']) or $headers['http_code'] != 200)
            return false;
        
        $result = CJSON::decode($result, true);

        if (empty($result['status']) or !isset($result['troika_state']))
            return false;
                
        return $result;        
    }
    
    public static function lostCard($hard_id)
    {
        $ch = curl_init();
        $url = Yii::app()->params['api']['troika'] . '/api/card/hard_id/' . $hard_id;
        
        $card = self::getCard($hard_id);
        if (!$card)
            return false;
        
        $card['status'] = self::STATUS_REMOVED;
        $card['troika_state'] = self::STATE_LOST;
        
        curl_setopt($ch, CURLOPT_USERPWD, 
            Yii::app()->params['api_user']['login'] 
            . ':' 
            . Yii::app()->params['api_user']['password']);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CAINFO, Yii::app()->params['ssl']);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $card);
 
        try {
            $result = curl_exec($ch);
        } catch (Exception $e) {
            Yii::log(
                    'Curl exception: ' . $e->getMessage() . PHP_EOL .
                    'URL: ' . $url . PHP_EOL .
                    'Options: ' . var_export($options, true)
                    , 'error', 'application'
            );
            return false;
        }

        $headers = curl_getinfo($ch);
        
        if (empty($headers['http_code']) or $headers['http_code'] != 200)
            return false;
        
        return true;        
    }
    
    public static function isActive($card)
    {
        if (empty($card['status']) or !isset($card['troika_state']))
            return false;
        
        $status_active = array(self::STATUS_DELIVERED);
        $state_active = array(self::STATE_ACTIVE);
        
        if(!in_array($card['status'], $status_active) or !in_array($card['troika_state'], $state_active))
            return false;
        
        return true;
    }
    
}
