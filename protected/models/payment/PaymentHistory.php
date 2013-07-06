<?php

/**
 * This is the model class for table "history".
 *
 * The followings are the available columns in table 'history':
 * @property integer $id
 * @property string $desc
 * @property integer $user_id
 * @property integer $wallet_id
 * @property integer $summ
 * @property string $creation_date
 * @property integer $type
 * @property integer $status
 */
class PaymentHistory extends CActiveRecord
{

    const STATUS_NEW = 0;
    const STATUS_COMPLETE = 1;
    const STATUS_FAILURE = -1;
    const TYPE_MINUS = -1;
    const TYPE_PLUS = 1;

    public function getStatusList()
    {
        return array(
            self::STATUS_NEW => Yii::t('user', 'Новая'),
            self::STATUS_COMPLETE => Yii::t('user', 'Успешная'),
            self::STATUS_FAILURE => Yii::t('user', 'Сбойная'),
        );
    }

    public function getTypeList()
    {
        return array(
            self::TYPE_MINUS => Yii::t('user', 'Расход'),
            self::TYPE_PLUS => Yii::t('user', 'Приход'),
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
            array('user_id, wallet_id, summ, creation_date, status', 'required'),
            array('user_id, wallet_id, summ, type', 'numerical', 'integerOnly' => true),
            array('desc', 'length', 'max' => 300),
            array('desc', 'filter', 'filter' => 'trim'),
            array('desc', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, desc, user_id, wallet_id, summ, creation_date, type, status', 'safe', 'on' => 'search'),
        );
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord)
        {
            $this->creation_date = new CDbExpression('NOW()');
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
            'user' => array(self::BELONGS_TO, 'PaymentUser', 'user_id'),
            'wallet' => array(self::BELONGS_TO, 'Wallet', 'wallet_id'),
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

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => '№',
            'desc' => 'Операция',
            'user_id' => 'Пользователь',
            'wallet_id' => 'Кошелёк',
            'summ' => 'Сумма',
            'creation_date' => 'Дата',
            'type' => 'Тип',
            'status' => 'Статус',
        );
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
        $criteria->compare('desc', $this->desc, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('wallet_id', $this->wallet_id);
        $criteria->compare('summ', $this->summ);
        $criteria->compare('creation_date', $this->creation_date, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}