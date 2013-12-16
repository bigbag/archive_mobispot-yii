<?php

/**
 * This is the model class for table "wallet_loyalty".
 *
 * The followings are the available columns in table 'wallet_loyalty':
 * @property integer $id
 * @property integer $wallet_id
 * @property integer $loyalty_id
 * @property string $summ
 */
class WalletLoyalty extends CActiveRecord
{
    const STATUS_NOT_ACTUAL = 0;
    const STATUS_ACTUAL = 1;
    const STATUS_ALL = 2;
    
    public function getRulesDesc()
    {
        $desc = '';
        
        switch ($this->loyalty->rules)
        {
            case Loyalty::RULE_FIXED:
                if (1 == $this->loyalty->interval)
                    $desc .= Yii::t('payment', 'На все покупки');
                else
                    $desc .= Yii::t('payment', 'За каждую').' <b>'.$this->loyalty->interval.'</b> '.Yii::t('payment', 'покупку');
        }
    
        return $desc;
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
        return 'payment.wallet_loyalty';
    }

    /**
     * @return array validation rules for model attributes.
     */

    public function beforeSave()
    {
        $this->summ = ($this->summ) * 100;

        return parent::beforeSave();
    }
    
    protected function afterFind()
    {
        $this->summ = ($this->summ) / 100;

        return parent::afterFind();
    }
    
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'loyalty'=>array(self::BELONGS_TO, 'Loyalty', 'loyalty_id'),
        );
    }
    
    public static function getLoyaltiesByWalletId($id, $status=self::STATUS_ACTUAL, $page = 1, $search='', $count=5)
    {
        $answer = array();
        
        $criteria = new CDbCriteria;
        $criteria->compare('wallet_id', $id);
        
        if ($search)
        {
            if (preg_match("~^[0-9]+$~", $search))
            {
                $criteria->condition .= ' AND (loyalty.amount =\''.($search*100).'\' OR loyalty.desc LIKE \'%'.$search.'%\')';
            }
            elseif (preg_match("~^[0-9]{2}.[0-9]{2}.[0-9]{2}$~", $search) || preg_match("~^[0-9]{2}.[0-9]{2}.[0-9]{4}$~", $search))
            {
                $searchDate = date("Y-m-d H:i:s", mktime(0, 0, 0, substr($search, 3, 2), substr($search, 0, 2), '20'.substr($search, 6)));
                if (preg_match("~^[0-9]{2}.[0-9]{2}.[0-9]{4}$~", $search))
                    $searchDate = date("Y-m-d H:i:s", mktime(0, 0, 0, substr($search, 3, 2), substr($search, 0, 2), substr($search, 6)));
                $criteria->condition .= ' AND ((TO_DAYS(loyalty.stop_date) >= TO_DAYS(\''
                    .$searchDate
                    .'\') AND TO_DAYS(loyalty.start_date) <= TO_DAYS(\''
                    .$searchDate
                    .'\'))'
                    .' OR loyalty.desc LIKE \'%'.$search.'%\')';
            }
            else
                $criteria->addSearchCondition('loyalty.desc', $search);
        }
        
        if (self::STATUS_ACTUAL == $status)
            $criteria->condition .= ' AND TO_DAYS(loyalty.stop_date) > TO_DAYS(NOW())';
        elseif (self::STATUS_NOT_ACTUAL == $status)
            $criteria->condition .= ' AND TO_DAYS(loyalty.stop_date) <= TO_DAYS(NOW())';

        $countLoyalties = self::model()->with('loyalty')->count($criteria);
        $criteria->limit = $count;
        if ($page > 1)
            $criteria->offset = ($page - 1) * $count;
        
        $criteria->order = 'loyalty.id desc';
        $answer['loyalties'] = self::model()->with('loyalty')->findAll($criteria);
        $answer['search'] = $search;
        $answer['pagination'] = array('pages'=>ceil($countLoyalties / $count), 'current'=>$page);
        $answer['total'] = $countLoyalties;

        
        return $answer;
    }
}
