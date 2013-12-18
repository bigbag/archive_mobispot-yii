<?php

/**
 * This is the model class for table "person".
 *
 * The followings are the available columns in table 'person':
 * @property integer $id
 * @property string $name
 * @property string $tabel_id
 * @property string $birthday
 * @property integer $firm_id
 * @property string $card
 * @property string $hard_id
 * @property string $payment_id
 * @property string $creation_date
 * @property integer $status
 * @property integer $wallet_status
 * @property integer $type
 */
class Person extends CActiveRecord
{
    const STATUS_VALID = 1
    const STATUS_BANNED = 0

    const TYPE_TIMEOUT = 0
    const TYPE_WALLET = 1

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'person';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, creation_date', 'required'),
            array('firm_id, status, wallet_status, type', 'numerical', 'integerOnly'=>true),
            array('tabel_id', 'length', 'max'=>150),
            array('card', 'length', 'max'=>8),
            array('hard_id', 'length', 'max'=>128),
            array('payment_id', 'length', 'max'=>32),
            array('birthday', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, tabel_id, birthday, firm_id, card, hard_id, payment_id, creation_date, status, wallet_status, type', 'safe', 'on'=>'search'),
        );
    }

    public function beforeSave()
    {
        if (!$this->creation_date) $this->creation_date = date('Y-m-d H:i:s');
        if (!$this->status) $this->status = self::STATUS_VALID;
        if (!$this->wallet_status) $this->wallet_status = self::STATUS_VALID;
        if (!$this->type) $this->type = self::TYPE_TIMEOUT;
        if (!$this->name) $this->name = 'Anonim';

        return parent::beforeSave();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'tabel_id' => 'Tabel',
            'birthday' => 'Birthday',
            'firm_id' => 'Firm',
            'card' => 'Card',
            'hard_id' => 'Hard',
            'payment_id' => 'Payment',
            'creation_date' => 'Creation Date',
            'status' => 'Status',
            'wallet_status' => 'Wallet Status',
            'type' => 'Type',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('tabel_id',$this->tabel_id,true);
        $criteria->compare('birthday',$this->birthday,true);
        $criteria->compare('firm_id',$this->firm_id);
        $criteria->compare('card',$this->card,true);
        $criteria->compare('hard_id',$this->hard_id,true);
        $criteria->compare('payment_id',$this->payment_id,true);
        $criteria->compare('creation_date',$this->creation_date,true);
        $criteria->compare('status',$this->status);
        $criteria->compare('wallet_status',$this->wallet_status);
        $criteria->compare('type',$this->type);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * @return CDbConnection the database connection used for this class
     */
    public function getDbConnection()
    {
        return Yii::app()->dbTerm;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Person the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
