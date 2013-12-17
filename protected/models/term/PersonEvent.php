<?php

/**
* This is the model class for table "person_event".
*
* The followings are the available columns in table 'person_event':
* @property integer $id
* @property integer $person_id
* @property integer $term_id
* @property integer $firm_id
* @property integer $event_id
* @property string $timeout
*/
class PersonEvent extends CActiveRecord
{
  /**
  * Returns the static model of the specified AR class.
  * @param string $className active record class name.
  * @return PersonEvent the static model class
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
      return Yii::app()->dbTerm;
  }

  /**
  * @return string the associated database table name
  */
  public function tableName()
  {
    return 'term.person_event';
  }

  /**
  * @return array validation rules for model attributes.
  */
  public function rules()
  {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
      array('person_id, term_id, event_id, firm_id', 'required'),
      array('person_id, term_id, event_id', 'numerical', 'integerOnly'=>true),
      // array('timeout', 'date', 'format'=>'HH:mm'),
      // The following rule is used by search().
      // Please remove those attributes that should not be searched.
      array('id, person_id, term_id, event_id, timeout', 'safe', 'on'=>'search'),
    );
  }

  public function beforeValidate()
  {
    if (!isset($this->timeout)) $this->timeout = '00:00:00';


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
      'term' => array(self::BELONGS_TO, 'Term', 'term_id'),
      'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
      'person' => array(self::BELONGS_TO, 'Person', 'person_id'),
      'firm' => array(self::BELONGS_TO, 'Firm', 'firm_id'),
    );
  }

  /**
  * @return array customized attribute labels (name=>label)
  */
  public function attributeLabels()
  {
    return array(
      'id' => 'ID',
      'person_id' => 'Сотрудник',
      'term_id' => 'Терминал',
      'event_id' => 'Событие',
      'firm_id' => 'Фирма',
      'timeout' => 'Таймаут',
    );
  }

  public function selectTerm($term_id)
  {
    $this->getDbCriteria()->mergeWith(array(
        'condition' => "term_id = ".$term_id,
        'order' => 'term_id',
    ));
    return $this;
  }

  public function selectPerson($person_id)
  {
    $this->getDbCriteria()->mergeWith(array(
        'condition' => "person_id = ".$person_id,
        'order' => 'term_id',
    ));
    return $this;
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
    $criteria->compare('person_id',$this->person_id);
    $criteria->compare('term_id',$this->term_id);
    $criteria->compare('event_id',$this->event_id);
    $criteria->compare('firm_id',$this->firm_id);
    $criteria->compare('timeout',$this->timeout,true);

    return new CActiveDataProvider($this, array(
        'criteria'=>$criteria,
    ));
  }
}
