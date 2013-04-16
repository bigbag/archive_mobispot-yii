<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property integer $payment_id
 * @property string $email
 * @property integer $status
 * @property integer $mobispot_id
 */
class PaymentUser extends CActiveRecord
{
  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return PaymentUser the static model class
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
    return 'payment.user';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules()
  {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
      array('payment_id, email', 'required'),
      array('payment_id, status, mobispot_id', 'numerical', 'integerOnly'=>true),
      array('email', 'length', 'max'=>150),
      // The following rule is used by search().
      // Please remove those attributes that should not be searched.
      array('id, payment_id, email, status, mobispot_id', 'safe', 'on'=>'search'),
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
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels()
  {
    return array(
      'id' => 'ID',
      'payment_id' => 'Payment',
      'email' => 'Email',
      'status' => 'Status',
      'mobispot_id' => 'Mobispot',
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
    $criteria->compare('payment_id',$this->payment_id);
    $criteria->compare('email',$this->email,true);
    $criteria->compare('status',$this->status);
    $criteria->compare('mobispot_id',$this->mobispot_id);

    return new CActiveDataProvider($this, array(
      'criteria'=>$criteria,
    ));
  }
}