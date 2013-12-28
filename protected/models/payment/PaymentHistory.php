<?php

/**
 * This is the model class for table "history".
 *
 * The followings are the available columns in table 'history':
 * @property integer $id
 * @property integer $user_id
 * @property integer $wallet_id
 * @property integer $term_id
 * @property integer $amount
 * @property string $creation_date
 * @property integer $type
 * @property integer $status
 */
class PaymentHistory extends CActiveRecord
{

    const STATUS_NEW = 0;
    const STATUS_COMPLETE = 1;
    const STATUS_FAILURE = -1;
    const STATUS_MISSING = -2;
    const DESC_FAILURE = 'Отмененное пополнение через Uniteller';
    const DESC_COMPLETE = 'Пополнение через Uniteller';
    const DESC_POS = 'Покупка';
    const TYPE_MINUS = -1;
    const TYPE_PLUS = 1;
    const TYPE_CASHBACK = 2;

    public function getPaymentDesc()
    {
        $txt = '';
        switch ($this->type)
        {
            case self::TYPE_MINUS:
                $txt.=Yii::t('payment', 'Покупка, ');
                $term = Term::model()->findByPk($this->term_id);
                if ($term)
                {
                    $txt.=$term->name;
                }
                else 
                {
                    $txt.=Yii::t('payment', 'терминал ') . $this->term_id;
                }
                break;

            case self::TYPE_PLUS:
                if ($this->status == self::STATUS_COMPLETE)
                {
                    $txt.=Yii::t('payment', 'Пополнение через Uniteller');
                }
                else
                {
                    $txt.=Yii::t('payment', 'Отмененное пополнение через Uniteller');
                }
            case self::TYPE_CASHBACK:
                break;
                $txt.=Yii::t('payment', 'Возврат средств, ');
                $term = Term::model()->findByPk($this->term_id);
                if ($term)
                {
                    $txt.=$term->name;
                }
                else
                {
                    $txt.=Yii::t('payment', 'терминал ') . $this->term_id;
                }
        }
        
        return $txt;
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_NEW => Yii::t('payment', 'Новая'),
            self::STATUS_COMPLETE => Yii::t('payment', 'Успешная'),
            self::STATUS_FAILURE => Yii::t('payment', 'Сбойная'),
        );
    }

    public function getTypeList()
    {
        return array(
            self::TYPE_MINUS => Yii::t('payment', 'Расход'),
            self::TYPE_PLUS => Yii::t('payment', 'Приход'),
        );
    }

    public function getType()
    {
        $data = $this->getTypeList();
        return $data[$this->type];
    }

    public function getStatus()
    {
        $data = $this->getStatusList();
        return $data[$this->status];
    }

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
        return 'payment.history';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, wallet_id, amount, creation_date, status', 'required'),
            array('user_id, wallet_id, amount, type', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_id, wallet_id, amount, creation_date, type, status', 'safe', 'on' => 'search'),
        );
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord)
        {
            $this->creation_date = date('Y-m-d H:i:s');
            if (!$this->status)
                $this->status = self::STATUS_NEW;
        }

        return parent::beforeValidate();
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
            'wallet' => array(self::BELONGS_TO, 'PaymentWallet', 'wallet_id'),
            'term' => array(self::BELONGS_TO, 'Term', 'term_id'),
        );
    }

    public function scopes()
    {
        return array(
            'complete' => array(
                'condition' => 'status=' . self::STATUS_COMPLETE,
            ),
            'failure' => array(
                'condition' => 'status=' . self::STATUS_FAILURE,
            ),
        );
    }

    public function getListByWalletId($id, $count=20)
    {
        $history = Yii::app()->cache->get('historys_wallet_'.$id);
        if (!$history)
        {
            $criteria = new CDbCriteria;
            $criteria->compare('wallet_id', $id);
            $criteria->order = 'id desc';
            $criteria->limit = $count;
            $history = self::model()->complete()->findAll($criteria);

            Yii::app()->cache->set('historys_wallet_'.$id, $history, 120);
        }
        return $history;
    }
    
    public function getListWithPagination($id, $page = 1, $filterDate = '', $filterTerm = '', $count=20)
    {
        $answer = array();
        
        $criteria = new CDbCriteria;
        $criteria->compare('wallet_id', $id);
        $criteria->order = 'id desc';
        if ($filterDate and CDateTimeParser::parse($filterDate,'dd.MM.yyyy'))
        {
            $criteria->compare('day(`creation_date`)', substr($filterDate, 0, 2));
            $criteria->compare('month(`creation_date`)', substr($filterDate, 3, 2));
            $criteria->compare('year(`creation_date`)', substr($filterDate, 6));
        }
        if ($filterTerm)
        {
            $termCriteria = new CDbCriteria;
            $termCriteria->addSearchCondition('name', $filterTerm);
            $terms = Term::model()->findAll($termCriteria);
            $inTerms = array();
            foreach ($terms as $term)
            {
                $inTerms[] = $term->id;
            }

            $criteria->addInCondition('term_id', $inTerms);
        }
        $countHistory = self::model()->complete()->count($criteria);
        $criteria->limit = $count;
        if ($page > 1)
            $criteria->offset = ($page - 1) * $count;

        $answer['history'] = self::model()->complete()->findAll($criteria);
        $answer['pagination'] = array('pages'=>ceil($countHistory / $count), 'current'=>$page);
        $answer['filter'] = array('date'=>$filterDate, 'term'=>$filterTerm);
        
        return $answer;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('payment', '№'),
            'user_id' => Yii::t('payment', 'Пользователь'),
            'wallet_id' => Yii::t('payment', 'Кошелёк'),
            'amount' => Yii::t('payment', 'Сумма'),
            'creation_date' => Yii::t('payment', 'Дата'),
            'type' => Yii::t('payment', 'Тип'),
            'status' => Yii::t('payment', 'Статус'),
        );
    }

    public function beforeSave()
    {
        $this->amount = ($this->amount) * 100;
        return parent::beforeSave();
    }

    protected function afterSave()
    {
        Yii::app()->cache->delete('historys_wallet_'.$this->wallet_id);
        parent::afterSave();
    }


    public function afterFind()
    {
        $this->amount = ($this->amount) / 100;

        $delta = 4 * 60 * 60;
        $this->creation_date = date('H:i d.m.Y', strtotime($this->creation_date) + $delta);

        return parent::afterFind();
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
        $criteria->compare('amount', $this->amount);
        $criteria->compare('creation_date', $this->creation_date, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}