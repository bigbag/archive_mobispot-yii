<?php

/**
 * This is the model class for table "auto".
 *
 * The followings are the available columns in table 'auto':
 * @property integer $id
 * @property integer $wallet_id
 * @property integer $history_id
 * @property string $card_pan
 * @property integer $amount
 * @property string $creation_date
 * @property integer $type
 * @property integer $status
 */
class PaymentAuto extends CActiveRecord
{
    const STATUS_ON = 1;
    const STATUS_OFF = 0;

    const TYPE_CEILING = 0;
    const TYPE_LIMIT = 1;

    const LIMIT = 40;
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
        return 'payment.reccurent';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('wallet_id, history_id, card_pan, amount, creation_date, type, status', 'required'),
            array('history_id, wallet_id, type, status', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, wallet_id, history_id, card_pan, amount, creation_date, type, status', 'safe', 'on' => 'search'),
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
            'history' => array(self::BELONGS_TO, 'PaymentHistory', 'history_id'),
            'wallet' => array(self::BELONGS_TO, 'PaymentWallet', 'wallet_id'),
        );
    }

    public function beforeSave()
    {
        $this->amount = ($this->amount) * 100;
        return parent::beforeSave();
    }

        public function afterFind()
    {
        $this->amount = ($this->amount) / 100;

        $delta = 4 * 60 * 60;
        $this->creation_date = date('H:i d.m.Y', strtotime($this->creation_date) + $delta);

        return parent::afterFind();
    }


    public function beforeValidate()
    {
        if ($this->isNewRecord)
        {
            $this->creation_date = date('Y-m-d H:i:s');
            if (!$this->status)
                $this->status = self::STATUS_OFF;
        }

        return parent::beforeValidate();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'history_id' => Yii::t('payment', '№'),
            'wallet_id' => Yii::t('payment', 'Кошелёк'),
            'card_pan' => Yii::t('payment', 'ПАН карты'),
            'amount' => Yii::t('payment', 'Сумма'),
            'creation_date' => Yii::t('payment', 'Дата'),
            'type' => Yii::t('payment', 'Тип'),
            'status' => Yii::t('payment', 'Статус'),
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
        $criteria->compare('history_id', $this->history_id);
        $criteria->compare('wallet_id', $this->wallet_id);
        $criteria->compare('amount', $this->amount, true);
        $criteria->compare('card_pan', $this->card_pan, true);
        $criteria->compare('creation_date', $this->creation_date, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}