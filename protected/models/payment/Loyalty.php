<?php

/**
 * This is the model class for table "loyalty".
 *
 * The followings are the available columns in table 'loyalty':
 * @property integer $id
 * @property string $terms_id 
 * @property integer $rules
 * @property integer $interval
 * @property string $amount
 * @property string $threshold
 * @property string $desc
 * @property string $creation_date
 * @property string $start_date
 * @property string $stop_date 
 */
class Loyalty extends CActiveRecord
{
    const RULE_FIXED = 0;
    const RULE_RATE = 1;

    const STATUS_NOT_ACTUAL = 0;
    const STATUS_ACTUAL = 1;
    const STATUS_ALL = 2;
    const STATUS_MY = 100;

    public function getRulesList()
    {
        return array(
            self::RULE_FIXED => Yii::t('user', 'Фиксированно'),
            self::RULE_RATE => Yii::t('user', 'Процент'),
        );
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
        return 'payment.loyalty';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('terms_id, rules, interval, amount, threshold, creation_date, start_date, stop_date', 'required'),
            array('rules, interval', 'numerical', 'integerOnly' => true),
            array('amount', 'filter', 'filter' => 'trim'),
            array('desc', 'filter', 'filter' => 'trim'),
            array('id, terms_id, rules, interval, amount, threshold, creation_date, start_date, stop_date, desc', 'safe', 'on' => 'search'),
        );
    }

    public function beforeSave()
    {
        $this->terms_id = serialize($this->terms_id);
        $this->threshold = ($this->threshold) * 100;
        if (self::RULE_FIXED == $this->rules)
            $this->amount = ($this->amount) * 100;
        return parent::beforeSave();
    }
    
    protected function afterFind()
    {
        $this->terms_id = unserialize($this->terms_id);
        $this->threshold = ($this->threshold) / 100;
        if (self::RULE_FIXED == $this->rules)
            $this->amount = ($this->amount) / 100;

        return parent::afterFind();
    }
    
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'terms_id' => 'Terminals',
            'rules' => 'Rule',
            'interval' => 'Interval',
            'amount' => 'Amount',
            'threshold' => 'Threshold',
            'desc' => 'Description',
            'creation_date' => 'Creation Date',
            'start_date' => 'Start Date',
            'stop_date' => 'Stop Date',
        );
    }
    
    public function beforeValidate()
    {
        if ($this->isNewRecord)
        {
            $this->creation_date = date('Y-m-d H:i:s');
            if (!$this->rules) $this->rules = self::RULE_FIXED;
            if (!$this->interval) $this->interval = 1;
        }

        return parent::beforeValidate();
    }

    public function getAllLoyalties($status=self::STATUS_ALL, $page = 1, $search='', $count=10)
    {
        $answer = array();
        $userActions = array();
        $criteria = new CDbCriteria;
        $prefix = ' ';
        
        if (self::STATUS_ACTUAL == $status)
        {
            $criteria->condition .= ' TO_DAYS(stop_date) > TO_DAYS(NOW())';
            $prefix = ' AND ';
        }
        elseif (self::STATUS_NOT_ACTUAL == $status)
        {
            $criteria->condition .= ' TO_DAYS(stop_date) <= TO_DAYS(NOW())';
            $prefix = ' AND ';
        }
        elseif (self::STATUS_MY == $status and !Yii::app()->user->isGuest)
        {
        
            $criteria->condition .= ' EXISTS(SELECT WL.ID FROM `PAYMENT`.`WALLET_LOYALTY` AS WL WHERE WL.LOYALTY_ID = T.ID AND EXISTS(SELECT W.ID FROM `PAYMENT`.`WALLET` AS W WHERE WL.WALLET_ID = W.ID AND W.USER_ID = ' . Yii::app()->user->id . '))';
            $prefix = ' AND ';
        }
        
        if ($search)
        {
            if (preg_match("~^[0-9]+$~", $search))
            {
                $criteria->condition .= $prefix.'(amount =\''.($search*100).'\' OR `desc` LIKE \'%'.$search.'%\')';
            }
            elseif (preg_match("~^[0-9]{2}.[0-9]{2}.[0-9]{2}$~", $search) || preg_match("~^[0-9]{2}.[0-9]{2}.[0-9]{4}$~", $search))
            {
                $searchDate = date("Y-m-d H:i:s", mktime(0, 0, 0, substr($search, 3, 2), substr($search, 0, 2), '20'.substr($search, 6)));
                if (preg_match("~^[0-9]{2}.[0-9]{2}.[0-9]{4}$~", $search))
                    $searchDate = date("Y-m-d H:i:s", mktime(0, 0, 0, substr($search, 3, 2), substr($search, 0, 2), substr($search, 6)));
                $criteria->condition .= $prefix.'((TO_DAYS(stop_date) >= TO_DAYS(\''
                    .$searchDate
                    .'\') AND TO_DAYS(start_date) <= TO_DAYS(\''
                    .$searchDate
                    .'\'))'
                    .' OR t.`desc` LIKE \'%'.$search.'%\')';
            }
            else
                $criteria->addSearchCondition('`desc`', $search);
        }
        
        $countLoyalties = self::model()->count($criteria);
        $criteria->limit = $count;
        if ($page > 1)
            $criteria->offset = ($page - 1) * $count;
        
        $criteria->order = 'id desc';
    
        $answer['loyalties'] = self::model()->findAll($criteria);
        
        if (Yii::app()->user->id)
        {
            $userActions = WalletLoyalty::getByUserId(Yii::app()->user->id);
        }
        
        $answer['userActions'] = $userActions;
        $answer['search'] = $search;
        $answer['status'] = $status;
        $answer['pagination'] = array(
            'pages'=>ceil($countLoyalties / $count), 
            'current'=>$page);
        $answer['total'] = $countLoyalties;
        
        return $answer;
    }
    
    public function getRulesDesc()
    {
        $desc = '';
        
        switch ($this->rules)
        {
            case Loyalty::RULE_FIXED:
                if (1 == $this->interval)
                    $desc .= Yii::t('payment', 'На все покупки');
                else
                    $desc .= Yii::t('payment', 'За каждую').' <b>'.$this->interval.'</b> '.Yii::t('payment', 'покупку');
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
    
}
