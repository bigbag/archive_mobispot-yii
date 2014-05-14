<?php

/**
 * This is the model class for table "log".
 *
 * The followings are the available columns in table 'log':
 * @property integer $id
 * @property integer $history_id
 * @property integer $wallet_id
 * @property string $rrn
 * @property string $card_pan
 * @property string $creation_date
 */
class PaymentLog extends CActiveRecord
{

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
        return 'log';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('history_id, wallet_id, rrn, card_pan', 'required'),
            array('history_id, wallet_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, history_id, wallet_id, rrn, card_pan', 'safe', 'on' => 'search'),
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

    public function getListByWalletId($id, $count = 20)
    {
        $logs = Yii::app()->cache->get('logs_wallet_' . $id);
        if (!$logs)
        {
            $criteria = new CDbCriteria;
            $criteria->compare('wallet_id', $id);
            $criteria->select = array('card_pan', 'history_id');
            $criteria->order = 'creation_date asc';
            $criteria->limit = $count;
            $logs = self::model()->findAll($criteria);

            Yii::app()->cache->set('logs_wallet_' . $id, $logs, 120);
        }
        return $logs;
    }

    protected function afterSave()
    {
        Yii::app()->cache->delete('logs_wallet_' . $this->wallet_id);
        parent::afterSave();
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
            'rrn' => Yii::t('payment', 'RRN'),
            'card_pan' => Yii::t('payment', 'ПАН карты'),
            'creation_date' => Yii::t('payment', 'Дата'),
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
        $criteria->compare('rrn', $this->rrn, true);
        $criteria->compare('card_pan', $this->card_pan, true);
        $criteria->compare('creation_date', $this->creation_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function getSystemByPan($pan)
    {
        $system = 'uniteller';
        if (preg_match('/^4[0-9\*]{12}([0-9]{3})?$/', $pan))
            $system = 'visa';
        elseif (preg_match('/^5[1-5][0-9\*]{14}$/', $pan))
            $system = 'mastercard';
        elseif (preg_match('/^(?:5020|6\\d{3})\\d{12\*}$/', $pan))
            $system = 'maestro';
        return $system;
    }

}
