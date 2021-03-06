<?php

/**
 * This is the model class for table "report".
 *
 * The followings are the available columns in table 'report':
 * @property integer $id
 * @property integer $term_id
 * @property integer $event_id
 * @property integer $person_id
 * @property string $name
 * @property string $payment_id
 * @property integer $term_firm_id
 * @property integer $person_firm_id
 * @property integer $amount
 * @property integer $corp_type
 * @property integer $type
 * @property string $creation_date
 * @property integer $status
 */
class Report extends CActiveRecord
{

    const TYPE_WHITE = 0;
    const TYPE_PAYMENT = 1;
    const TYPE_MPS = 2;

    const CORP_TYPE_OFF = 0;
    const CORP_TYPE_ON = 1;

    const DEFAULT_PAGE = 1;
    const POST_ON_PAGE = 10;

    const STATUS_NEW = 0;
    const STATUS_COMPLETE = 1;
    const STATUS_FAIL = -1;
    const STATUS_LOST = -2;

    const MAX_RECORD = 10;
    
    const FAILURE_TIMEOUT = 600;
    const DATE_DIFF = 14400;

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
        return Yii::app()->dbTerm;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'report';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('term_id, event_id, person_id, name, payment_id, term_firm_id, person_firm_id, amount, corp_type, type, creation_date, status', 'required'),
        );
    }


    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'term' => array(self::BELONGS_TO, 'Term', 'term_id'),
        );
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->creation_date = date('Y-m-d H:i:s');
            if (!$this->status) $this->status = self::STATUS_NEW;
            if (!$this->name) $this->name = 'Anonim';
            if (!$this->payment_type) $this->payment_type = self::TYPE_WHITE;
            if (!$this->amount) $this->amount = 0;
            if (!$this->person_id) $this->person_id = 0;
            if (!$this->type) $this->type = self::TYPE_WHITE;
        }

        return parent::beforeValidate();
    }

    public function afterFind()
    {
        if ($this->amount != 0)  $this->amount = ($this->amount) / 100;

        $delta = Yii::app()->params['defaultTimezone'] * 60 * 60;
        $this->creation_date = date('H:i d.m.Y', strtotime($this->creation_date) + $delta);

        return parent::afterFind();
    }
    
    public function isFailure()
    {
        if (self::STATUS_FAIL == $this->status)
            return true;
     
        if (self::STATUS_NEW != $this->status)
            return false;
     
        $wallet = PaymentWallet::model()->findByAttributes(array('payment_id' => $this->payment_id));
        if (!$wallet or PaymentWallet::STATUS_NOACTIVE == $wallet->blacklist)
            return true;
       
        return false;
    }
    
    public static function listHistory($payment_id, $date=null)
    {
        if (!$date)
            $date = time();
        
        $date += self::DATE_DIFF;
        
        $criteria = new CDbCriteria;
        
        $criteria->condition .= ' payment_id = "' . addslashes($payment_id) . '" and TO_DAYS(creation_date) >= TO_DAYS(\'' . date('Y-m-d H:i:s', $date) . '\')';
        
        $criteria->limit = Report::MAX_RECORD;
        $criteria->order = 'creation_date';

        return self::model()->findAll($criteria);
    }
}
