<?php

/**
 * This is the model class for table "loyalty".
 *
 * The followings are the available columns in table 'loyalty':
 * @property integer $id
 * @property string $terms_id
 * @property string $event_id
 * @property string $firm_id
 * @property integer $rules
 * @property integer $interval
 * @property string $amount
 * @property string $threshold
 * @property string $desc
 * @property string $creation_date
 * @property string $start_date
 * @property string $stop_date
 * @property integer $sharing_type
 * @property integer $limit
 * @property integer $timeout
 */
class Loyalty extends CActiveRecord
{

    const RULE_FIXED = 0;
    const RULE_RATE = 1;
    const RULE_DISCOUNT = 2;
    const RULE_PRESENT = 3;

    const STATUS_NOT_ACTUAL = 0;
    const STATUS_ACTUAL = 1;
    const STATUS_ALL = 2;
    const STATUS_MY = 100;

    const PAGE_ALL = 'all';
    const PAGE_MY = 'my';
    const PAGE_NEW = 'new';  
    
    const FACEBOOK_LIKE = 1;
    const FACEBOOK_SHARE = 2;
    const TWITTER_SHARE = 3;
    const TWITTER_RETWIT = 4;
    const TWITTER_READING = 5;
    const TWITTER_HASHTAG = 6;
    const FOURSQUARE_CHECKIN = 7;
    const FOURSQUARE_MAYOR = 8;
    const FOURSQUARE_BADGE = 9;
    const INSTAGRAM_LIKE = 10;
    const INSTAGRAM_FOLLOWING = 11;
    const GOOGLE_CIRCLE = 12;
    const GOOGLE_PLUS_ONE = 13;
    const YOUTUBE_FOLLOWING = 14;
    const YOUTUBE_VIEWS = 15;

    public function getRulesList()
    {
        return array(
            self::RULE_FIXED => Yii::t('wallet', 'fixedly'),
            self::RULE_RATE => Yii::t('wallet', 'percentage'),
            self::RULE_RATE => Yii::t('wallet', 'discount'),
            self::RULE_RATE => Yii::t('wallet', 'gift'),
        );
    }

    public function getPromoMessage()
    {
        $answer = Yii::t('wallet', 'Perform the action conditions!');
        $link = $this->getLink();

        $messages = array(
            self::FACEBOOK_LIKE =>
                Yii::t('wallet', "Click on the link and like page!"),
        );

        if (isset($messages[$this->sharing_type]))
            $answer = $messages[$this->sharing_type];

        return $answer;
    }

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
        return 'loyalty';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('terms_id, event_id, firm_id, rules, interval, amount, threshold, creation_date, start_date, stop_date', 'required'),
            array('rules, interval, sharing_type', 'numerical', 'integerOnly' => true),
            array('amount', 'filter', 'filter' => 'trim'),
            array('desc', 'filter', 'filter' => 'trim'),
            array('id, terms_id, event_id, rules, interval, amount, threshold, creation_date, start_date, stop_date, desc,sharing_type', 'safe', 'on' => 'search'),
        );
    }

    public function beforeSave()
    {
        //$this->terms_id = serialize($this->terms_id);
        $this->terms_id = json_encode($this->terms_id);
        $this->threshold = ($this->threshold) * 100;
        if (self::RULE_FIXED == $this->rules)
            $this->amount = ($this->amount) * 100;
        return parent::beforeSave();
    }

    protected function afterFind()
    {
        //$this->terms_id = unserialize($this->terms_id);
        $this->terms_id = CJSON::decode($this->terms_id, true);
        $this->threshold = ($this->threshold) / 100;
        if (self::RULE_FIXED == $this->rules)
            $this->amount = ($this->amount) / 100;

        return parent::afterFind();
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
            'firm' => array(self::BELONGS_TO, 'Firm', 'firm_id'),
        );
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->creation_date = date('Y-m-d H:i:s');
            if (!$this->rules)
                $this->rules = self::RULE_FIXED;
            if (!$this->interval)
                $this->interval = 1;
        }

        return parent::beforeValidate();
    }

    public function getAllLoyalties($status = self::STATUS_ALL, $page = 1, $search = '', $count = 10)
    {
        $answer = array();
        $userActions = array();
        $criteria = new CDbCriteria;
        $prefix = ' ';

        if (self::STATUS_ACTUAL == $status) {
            $criteria->condition .= ' TO_DAYS(stop_date) > TO_DAYS(NOW())';
            $prefix = ' AND ';
        } elseif (self::STATUS_NOT_ACTUAL == $status) {
            $criteria->condition .= ' TO_DAYS(stop_date) <= TO_DAYS(NOW())';
            $prefix = ' AND ';
        } elseif (self::STATUS_MY == $status and !Yii::app()->user->isGuest) {
            $sql = ' EXISTS(SELECT wl.id FROM ' . WalletLoyalty::tableName() . '
                AS wl WHERE wl.loyalty_id = t.id ';
            $sql .=' AND EXISTS(SELECT w.id FROM ' . PaymentWallet::tableName() . '
                AS w WHERE wl.wallet_id = w.id AND w.user_id = ' . Yii::app()->user->id . '))';

            $criteria->condition .= $sql;
            $prefix = ' AND ';
        }

        if ($search) {
            if (preg_match("~^[0-9]+$~", $search)) {
                $criteria->condition .= $prefix . '(amount =\'' . ($search * 100) . '\' OR `desc` LIKE \'%' . $search . '%\')';
            } elseif (CDateTimeParser::parse($search, 'dd.MM.yyyy') or CDateTimeParser::parse($search, 'dd.MM.yy')) {
                $searchDate = date("Y-m-d H:i:s", strtotime($search));

                $criteria->condition .= $prefix . '((TO_DAYS(stop_date) >= TO_DAYS(\''
                        . $searchDate
                        . '\') AND TO_DAYS(start_date) <= TO_DAYS(\''
                        . $searchDate
                        . '\'))'
                        . ' OR t.`desc` LIKE \'%' . $search . '%\')';
            } else
                $criteria->addSearchCondition('`desc`', $search);
        }

        $countLoyalties = self::model()->count($criteria);
        $criteria->limit = $count;
        if ($page > 1)
            $criteria->offset = ($page - 1) * $count;

        $criteria->order = 'id desc';

        $answer['loyalties'] = self::model()->findAll($criteria);

        if (Yii::app()->user->id) {
            $userActions = WalletLoyalty::getByUserId(Yii::app()->user->id);
        }

        $answer['userActions'] = $userActions;
        $answer['search'] = $search;
        $answer['status'] = $status;
        $answer['pagination'] = array(
            'pages' => ceil($countLoyalties / $count),
            'current' => $page);
        $answer['total'] = $countLoyalties;

        return $answer;
    }

    public function getRulesDesc()
    {
        $desc = '';

        switch ($this->rules) {
            case Loyalty::RULE_FIXED:
                if (1 == $this->interval)
                    $desc .= Yii::t('wallet', 'On all purchases');
                else
                    $desc .= Yii::t('wallet', 'For each') . ' <b>' . $this->interval . '</b> ' . Yii::t('wallet', 'purchase');
        }

        return $desc;
    }

    public function isActual()
    {
        if (floor(time() / 86400) > floor(strtotime($this->stop_date) / 86400))
            return false;
        else
            return true;
    }

    public static function followingLoyalty($loyalty_id)
    {
        $action = self::model()->findByPk($loyalty_id);
        $criteria = new CDbCriteria;
        $criteria->condition .= ' exists(select id from payment.wallet w where user_id = `user`.id) and t.type ='
                . SocInfo::getTokenBySharingType($action->sharing_type)
                . ' and t.user_token is not null';

        $tokens = SocToken::model()->with('user')->findAll($criteria);

        foreach ($tokens as $token) {
            $check = SocInfo::checkToken($token->type, $token->user_token, $token->token_secret);

            if (true === $check) {
                $likesStack = LikesStack::model()->findByAttributes(array(
                    'token_id' => $token->id,
                    'loyalty_id' => $loyalty_id,
                ));

                if (!$likesStack) {
                    $likesStack = new LikesStack;
                    $likesStack->token_id = $token->id;
                    $likesStack->loyalty_id = $loyalty_id;
                    $likesStack->save();
                }
            } elseif (false === $check) {
                $token->user_token = null;
                $token->token_secret = null;
                $token->allow_login = false;
                $token->save();
            }
        }

        return true;
    }

    public static function getCoupons($wallet_id = null, $page = self::PAGE_ALL, $phrase = '')
    {
        $criteria = new CDbCriteria;
        $answer = array();
        $loyaltyList = array();

        $criteria->condition .= ' coupon_class is not null and TO_DAYS(stop_date) > TO_DAYS(NOW())';
        if (self::PAGE_NEW == $page)
            $criteria->condition .= ' AND TO_DAYS(start_date) = (select max(TO_DAYS(m.start_date)) FROM ' . Loyalty::tableName() . ' AS m)';
        if ($phrase)
        {
            $phrase = addCslashes(addslashes($phrase), '%_');
            $criteria->condition .= 
                ' AND (`desc` LIKE \'%' . $phrase . '%\''
                .'OR `name` LIKE \'%' . $phrase . '%\')';
        }   
        $coupons = self::model()->findAll($criteria);

        if (null != $wallet_id) {
            $wallet = PaymentWallet::model()->findByPk($wallet_id);
            if ($wallet) {
                $wLoyalties = WalletLoyalty::model()->findAllByAttributes(array(
                    'wallet_id' => $wallet->id,
                    'checked' => true,
                ));


                foreach ($wLoyalties as $wl) {
                    $loyaltyList[] = $wl->loyalty_id;
                }
            }
        }

        foreach ($coupons as $coupon) {
            $part = false;
            if (in_array($coupon->id, $loyaltyList))
                $part = true;
            if (self::PAGE_MY != $page or $part)
                $answer[] = array(
                    'id' => $coupon->id,
                    'name' => $coupon->name,
                    'coupon_class' => $coupon->coupon_class,
                    'img' => $coupon->img,
                    'desc' => $coupon->desc,
                    'soc_block' => $coupon->soc_block,
                    'part' => $part,
                );
        }

        return $answer;
    }

    public function getLink()
    {
        $link = $this->link;

        if (!empty($link))
            return $link;

        if (strpos($this->desc, '<a ng-click="checkLike(' . $this->id . ')">') !== false)
            $link = substr($this->desc, (strpos($this->desc, '<a ng-click="checkLike(' . $this->id . ')">') + strlen('<a ng-click="checkLike(' . $this->id . ')">')));
            if (strpos($link, '</a>') > 0)
                $link = substr($link, 0, strpos($link, '</a>'));

        return $link;
    }

}
