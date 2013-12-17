<?php

/**
* This is the model class for table "person".
*
* The followings are the available columns in table 'person':
* @property integer $id
* @property string $first_name
* @property string $midle_name
* @property string $last_name
* @property string $number
* @property integer $firm_id
* @property string $card
* @property string $hard_id
* @property string $creation_date
* @property integer $status
* @property string $department_id
* @property string $birthday
*/
class Person extends CActiveRecord
{
  const STATUS_VALID = 1;
  const STATUS_BANNED = -1;

  public function getStatusList()
  {
    return array(
      self::STATUS_VALID => Yii::t('user', 'Активен'),
      self::STATUS_BANNED => Yii::t('user', 'Удалён'),
    );
  }

  public function getStatus()
  {
    $data = $this->getStatusList();
    return $data[$this->status];
  }

  /**
  * Returns the static model of the specified AR class.
  * @param string $className active record class name.
  * @return Person the static model class
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
    return 'term.person';
  }

  /**
  * @return array validation rules for model attributes.
  */
  public function rules()
  {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
      array('first_name, midle_name, last_name, firm_id, creation_date', 'required'),
      array('firm_id, status, department_id', 'numerical', 'integerOnly'=>true),
      array('first_name, midle_name, last_name, number', 'length', 'max'=>150),
      array('card,', 'length', 'max'=>8),
      array('card,', 'length', 'min'=>1),
      //array('card', 'unique'),
      array('birthday', 'date', 'format'=>'yyyy-MM-dd'),
      // The following rule is used by search().
      // Please remove those attributes that should not be searched.
      array('id, first_name, department_id, midle_name, last_name,  number, firm_id, card, creation_date, status', 'safe', 'on'=>'search'),
    );
  }

  /**
  * @return array customized attribute labels (name=>label)
  */
  public function attributeLabels()
  {
    return array(
      'id' => 'ID',
      'first_name' => 'Имя',
      'midle_name' => 'Отчество',
      'last_name' => 'Фамилия',
      'number' => 'Табельный номер',
      'firm_id' => 'Фирма',
      'card' => 'Номер карты',
      'hard_id' => 'Карта',
      'creation_date' => 'Дата создания',
      'birthday' => 'Дата рождения',
      'status' => 'Статус',
      'department_id' => 'Отдел',
    );
  }

  public function beforeValidate()
  {
    if ($this->isNewRecord) {
      $this->creation_date = date("Y-m-d H:i:s", time());
      $this->status = self::STATUS_VALID;
    }

    if ($this->birthday){
      $tmp=explode('.',$this->birthday);
      if (count($tmp)==3){
        $this->birthday=$tmp[2].'-'.$tmp[1].'-'.$tmp[0];
      }
    }

    return parent::beforeValidate();
  }

  public function selectFirm($array=false)
  {
    $criteria=new CDbCriteria;
    if ($array) $criteria->addInCondition('firm_id',$array);

    $this->getDbCriteria()->mergeWith($criteria);
    return $this;
  }

  public function scopes()
  {
    return array(
      'all' => array(),
      'valid' => array(
        'condition'=>"status='".self::STATUS_VALID."'",
      ),
      'orderByName' => array(
        'order' => 'last_name, first_name',
      ),
    );
  }

  public function relations()
  {
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
    return array(
      'firm' => array(self::BELONGS_TO, 'Firm', 'firm_id'),
      'department' => array(self::BELONGS_TO, 'FirmDepartment', 'department_id'),
    );
  }

  public function selectPerson($persons_id){
    $criteria=new CDbCriteria;
    $criteria->addInCondition('id',$persons_id);
    $this->getDbCriteria()->mergeWith($criteria);
    return $this;
  }

  public function getPersonByCard($card)
  {
    $persons = Yii::app()->cache->get('person_by_card_' . $card);
    if ($persons === false) {
      $persons=Person::model()->findByAttributes(array('hard_id'=>$card));

      Yii::app()->cache->set('person_by_card_' . $card, $persons, 36000);
    }
    return $persons;
  }

  protected function afterSave()
  {
    Yii::app()->cache->delete('event_by_key_' . $this->hard_id);
    parent::afterSave();
  }

  /**
  * Retrieves a list of models based on the current search/filter conditions.
  * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
  */
  public function search($firm=false, $delete=false)
  {
    // Warning: Please modify the following code to remove attributes that
    // should not be searched.

    $criteria=new CDbCriteria;

    $criteria->compare('id',$this->id);
    $criteria->compare('first_name',$this->first_name,true);
    $criteria->compare('midle_name',$this->midle_name,true);
    $criteria->compare('last_name',$this->last_name,true);
    $criteria->compare('number',$this->number,true);
    $criteria->compare('firm_id',$this->firm_id);
    $criteria->compare('card',$this->card,true);
    $criteria->compare('hard_id',$this->hard_id,true);
    $criteria->compare('creation_date',$this->creation_date,true);
    $criteria->compare('status',$this->status);
    $criteria->compare('department_id',$this->department_id);
    $criteria->compare('birthday',$this->birthday,true);
    if ($firm) {
      $criteria->addInCondition('firm_id',$firm);
      if (!$delete) $criteria->compare('status',1);
    else $criteria->compare('status',-1);
    }

    return new CActiveDataProvider(get_class($this), array(
        'criteria' => $criteria,
        'pagination' => array(
          'pageSize' => 30,
        ),
        'sort' => array(
          'defaultOrder' => 'last_name ASC',
        ),

    ));
  }
}
