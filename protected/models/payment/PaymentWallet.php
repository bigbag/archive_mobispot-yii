<?php

/**
 * This is the model class for table "wallet".
 *
 * The followings are the available columns in table 'wallet':
 * @property integer $id
 * @property string $hard_id
 * @property string $payment_id
 * @property integer $user_id
 * @property integer $spot_id
 * @property string $creation_date
 * @property string $balance
 */
class PaymentWallet extends CActiveRecord
{
  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return PaymentWallet the static model class
   */
  public static function model($className=__CLASS__)
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
    return 'payment.wallet';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules()
  {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
      array('hard_id, payment_id, user_id, creation_date, balance', 'required'),
      array('user_id, spot_id', 'numerical', 'integerOnly'=>true),
      array('hard_id, payment_id', 'length', 'max'=>20),
      array('balance', 'length', 'max'=>150),
      // The following rule is used by search().
      // Please remove those attributes that should not be searched.
      array('id, hard_id, payment_id, user_id, spot_id, creation_date, balance', 'safe', 'on'=>'search'),
    );
  }

  public function beforeValidate() {
    if ($this->isNewRecord) {
      $this->creation_date=new CDbExpression('NOW()');
      if (!$this->balance) $this->balance=0;
    }

    return parent::beforeValidate();
  }

  /**
   * @return array relational rules.
   */
  public function relations()
  {
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
    return array(
        'user'=>array(self::BELONGS_TO, 'PaymentUser', 'user_id'),
        'spot'=>array(self::BELONGS_TO, 'Spot', 'spot_id'),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels()
  {
    return array(
      'id' => 'ID',
      'hard_id' => 'Hard',
      'payment_id' => 'Payment',
      'user_id' => 'User',
      'spot_id' => 'Spot',
      'creation_date' => 'Creation Date',
      'balance' => 'Balance',
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

    $criteria=new CDbCriteria;

    $criteria->compare('id',$this->id);
    $criteria->compare('hard_id',$this->hard_id,true);
    $criteria->compare('payment_id',$this->payment_id,true);
    $criteria->compare('user_id',$this->user_id);
    $criteria->compare('spot_id',$this->spot_id);
    $criteria->compare('creation_date',$this->creation_date,true);
    $criteria->compare('balance',$this->balance,true);

    return new CActiveDataProvider($this, array(
      'criteria'=>$criteria,
    ));
  }
}