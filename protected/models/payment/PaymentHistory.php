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
 * @property string $request_id
 * @property string $invoice_id
 * @property integer $status
 */
class PaymentHistory extends CActiveRecord
{

    const STATUS_NEW = 0;
    const STATUS_IN_PROGRESS = 1;
    const STATUS_COMPLETE = 2;
    const STATUS_FAILURE = -1;

    const TYPE_SYSTEM = 1;
    const TYPE_PAYMENT = 2;
    const TYPE_UNITELLER = 3;

    const MAX_RECORD = 10;


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
        return 'history';
    }

    public function getPaymentDesc()
    {
        $txt = '';
        if ($this->term_id != 0){
            $txt .= 'Терминал ' . $this->term_id;
        } else {
            $txt .= 'Пополнение';
        }
        return $txt;
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_NEW => Yii::t('payment', 'Новая'),
            self::STATUS_IN_PROGRESS => Yii::t('payment', 'Проводится'),
            self::STATUS_COMPLETE => Yii::t('payment', 'Успешная'),
            self::STATUS_FAILURE => Yii::t('payment', 'Сбойная'),
        );
    }

    public function getTypeList()
    {
        return array(

            self::TYPE_SYSTEM => Yii::t('payment', 'Приход'),
            self::TYPE_PAYMENT => Yii::t('payment', 'Расход'),
            self::TYPE_UNITELLER => Yii::t('payment', 'Приход'),
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
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, wallet_id, amount, creation_date, status, request_id', 'required'),
            array('user_id, wallet_id, amount, type', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_id, wallet_id, amount, creation_date, type, status, request_id, invoice_id', 'safe', 'on' => 'search'),
        );
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->creation_date = date('Y-m-d H:i:s');
            if (!$this->status) $this->status = self::STATUS_NEW;
            if (!$this->type) $this->type = self::TYPE_PAYMENT;
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

    public function beforeSave()
    {
        $this->amount = ($this->amount) * 100;
        return parent::beforeSave();
    }

    protected function afterSave()
    {
        Yii::app()->cache->delete('historys_wallet_' . $this->wallet_id);
        parent::afterSave();
    }

    public function afterFind()
    {
        if ($this->amount != 0)  $this->amount = ($this->amount) / 100;

        $delta = Yii::app()->params['defaultTimezone'] * 60 * 60;
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

    public function getListByWalletId($id, $count=20)
    {
        $history = Yii::app()->cache->get('historys_wallet_'.$id);
        if (!$history) {
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
        if ($filterDate && preg_match("~^[0-9]{2}.[0-9]{2}.[0-9]{4}$~", $filterDate)) {
            $criteria->compare('day(`creation_date`)', substr($filterDate, 0, 2));
            $criteria->compare('month(`creation_date`)', substr($filterDate, 3, 2));
            $criteria->compare('year(`creation_date`)', substr($filterDate, 6));
        }
        if ($filterTerm) {
            $termCriteria = new CDbCriteria;
            $termCriteria->addSearchCondition('name', $filterTerm);
            $terms = Term::model()->findAll($termCriteria);
            $inTerms = array();
            foreach ($terms as $term) {
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
}
