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

    public function releaseTroikaCard($wallet, $user)
    {
        $url = Yii::app()->params['api']['troika'] . '/api/card/release/';

        $auth = array(
            'login' => Yii::app()->params['api_user']['login'],
            'password' => Yii::app()->params['api_user']['password']
        );

        $data = array(
            'hard_id' => $wallet->hard_id,
            'user_id' => $user->user_id,
            'user_email' => $user->user_email);

        $card = CJSON::decode(MHttp::setCurlRequest($url, $data, $auth), true);
        if (empty($card['card_id'])) {
            return false;
        }

        $spot_troika = new SpotTroika;
        $spot_troika->discodes_id = $wallet->discodes_id;
        $spot_troika->save();
    }

    public static function getCard($hard_id)
    {
        $card = Yii::app()->cache->get('troika_' . $hard_id);

        if (!$card) {
            $url = Yii::app()->params['api']['troika'] . '/api/card/hard_id/' . $hard_id;

            $auth = array('login' => Yii::app()->params['api_user']['login'],
                'password' => Yii::app()->params['api_user']['password']);

            $card = CJSON::decode(MHttp::setCurlRequest($url, MHttp::TYPE_GET, array(), $auth), true);

            if (empty($card['status']) or !isset($card['troika_state'])) {
                Yii::app()->cache->set('troika_' . $hard_id, false, 60);
                return false;
            }

            Yii::app()->cache->set('troika_' . $hard_id, $card, 60);
        }

        return $card;
    }

    public static function lostCard($hard_id)
    {
        $url = Yii::app()->params['api']['troika'] . '/api/card/hard_id/' . $hard_id;

        $card = self::getCard($hard_id);
        if (!$card)
            return false;

        $card['status'] = self::STATUS_REMOVED;
        $card['troika_state'] = self::STATE_LOST;

        $auth = array('login' => Yii::app()->params['api_user']['login'],
                'password' => Yii::app()->params['api_user']['password']);

        $result = MHttp::setCurlRequest($url, Mhttp::TYPE_POST, array(), $auth, array(), $card);
        Yii::app()->cache->delete('troika_' . $hard_id);
        
        return true;
    }

    public static function isActive($card)
    {
        if (empty($card['status']) or !isset($card['troika_state']))
            return false;

        $status_active = array(self::STATUS_DELIVERED);
        $state_active = array(self::STATE_ACTIVE);

        if (!in_array($card['status'], $status_active) or !in_array($card['troika_state'], $state_active))
            return false;

        return true;
    }

    public static function isBlockedCard($discodes_id)
    {
        if (!self::hasTroika($discodes_id))
            return false;

        $wallet = PaymentWallet::model()->findByAttributes(
            array('discodes_id'=>$discodes_id));

        if (!$wallet)
            return true;

        $troika = self::getCard($wallet->hard_id);
        if (!$troika)
            return true;

        if (!self::isActive($troika))
            return true;

        return false;
    }

    public static function getStatusDescr($card)
    {
        if (empty($card['status']) or !isset($card['troika_state']))
            return Yii::t('spot', 'Карта заблокирована');

        if (self::STATE_ACTIVE != $card['troika_state'])
            return Yii::t('spot', 'Карта заблокирована');

        if (self::STATUS_NEW == $card['status'])
            return Yii::t('spot', 'Заказ на карту обрабатывается');

        if (self::STATUS_INPROGRESS == $card['status'])
            return Yii::t('spot', 'Карта в процессе выпуска');

        if (self::STATUS_RELEASED == $card['status'])
            return Yii::t('spot', 'Карта передана в службу доставки');

        if (self::STATUS_DELIVERED == $card['status'])
            return Yii::t('spot', 'Карта доставлена и активна');

        if (self::STATUS_REMOVED == $card['status'])
            return Yii::t('spot', 'Карта заблокирована');

        if (self::isActive($card))
            return Yii::t('spot', 'Карта активна');

        return Yii::t('spot', 'Карта заблокирована');
    }

}
