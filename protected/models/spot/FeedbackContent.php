<?php

/**
 * This is the model class for table "feedback_content".
 *
 * The followings are the available columns in table 'feedback_content':
 * @property integer $id
 * @property integer $spot_id
 * @property string $creation_date
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $comment
 */
class FeedbackContent extends CActiveRecord {

  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return FeedbackContent the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'feedback_content';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
        array('spot_id, creation_date', 'required'),
        array('spot_id', 'numerical', 'integerOnly'=>true),
        array('name, phone, email, comment', 'filter', 'filter'=>'trim'),
        array('name, phone, email, comment', 'filter', 'filter'=>array($obj=new CHtmlPurifier(), 'purify')),
        array('name, phone, email', 'length', 'max'=>150),
        array('email', 'email'),
        array('comment', 'safe'),
        // The following rule is used by search().
        // Please remove those attributes that should not be searched.
        array('id, spot_id, creation_date, name, phone, email, comment', 'safe', 'on'=>'search'),
    );
  }

  public function beforeValidate() {
    $this->creation_date=new CDbExpression('NOW()');
    return parent::beforeValidate();
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
    return array(
        'spot'=>array(self::BELONGS_TO, 'Spot', 'spot_id'),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
        'id'=>'ID',
        'spot_id'=>'Спот',
        'creation_date'=>'Дата',
        'name'=>'Имя',
        'phone'=>'Телефон',
        'email'=>'Email',
        'comment'=>'Отзыв',
    );
  }

  /**
   * Retrieves a list of models based on the current search/filter conditions.
   * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
   */
  public function search() {
    // Warning: Please modify the following code to remove attributes that
    // should not be searched.

    $criteria=new CDbCriteria;

    $criteria->compare('id', $this->id);
    $criteria->compare('spot_id', $this->spot_id);
    $criteria->compare('creation_date', $this->creation_date, true);
    $criteria->compare('name', $this->name, true);
    $criteria->compare('phone', $this->phone, true);
    $criteria->compare('email', $this->email, true);
    $criteria->compare('comment', $this->comment, true);

    return new CActiveDataProvider($this, array(
        'criteria'=>$criteria,
    ));
  }

}