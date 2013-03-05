<?php

/**
* This is the model class for table "spot_personal_field".
*
* The followings are the available columns in table 'spot_personal_field':
* @property integer $id
* @property string $name
* @property string $ico
* @property integer $type
* @property string $placeholder
*/
class SpotPersonalField extends CActiveRecord
{
  
  const TYPE_CONTACTS = 0;
  const TYPE_SOCIAL = 1;
  const TYPE_TEXT = 2;
  
  public function getTypeList()
  {
    return array(
      self::TYPE_CONTACTS => 'Контакты',
      self::TYPE_SOCIAL => 'Соц. Сети',
      self::TYPE_TEXT => 'Дополнительная информация',
    );
  }
  
  public function getType()
  {
    $data = $this->getTypeList();
    return $data[$this->type];
  }
  
  /**
  * Returns the static model of the specified AR class.
  * @param string $className active record class name.
  * @return SpotPersonalField the static model class
  */
  public static function model($className = __CLASS__)
  {
    return parent::model($className);
  }
  
  /**
  * @return string the associated database table name
  */
  public function tableName()
  {
    return 'spot_personal_field';
  }
  
  /**
  * @return array validation rules for model attributes.
  */
  public function rules()
  {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
      array('name, type', 'required'),
      array('name, ico, placeholder', 'length', 'max' => 300),
      array('name', 'filter', 'filter' => 'trim'),
      array('name', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
      array('type', 'in', 'range' => array_keys($this->getTypeList())),
      // The following rule is used by search().
      // Please remove those attributes that should not be searched.
      array('id, name, ico, placeholder', 'safe', 'on' => 'search'),
    );
  }
  
  public function beforeValidate()
  {
    
    return parent::beforeValidate();
  }
  
  
  /**
  * @return array relational rules.
  */
  public function relations()
  {
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
    return array();
  }
  
  /**
  * @return array customized attribute labels (name=>label)
  */
  public function attributeLabels()
  {
    return array(
      'id' => 'ID',
      'name' => 'Название',
      'ico' => 'Иконка',
      'placeholder' => 'Подсказка',
      'type' => 'Тип',
    );
  }
  
  public static function getPersonalField($type)
  {
    $personal_field = Yii::app()->cache->get('personal_field_' . $type);
    if ($personal_field === false) {
      $personal_field = SpotPersonalField::model()->findAllByAttributes(array('type' => $type));
      
      Yii::app()->cache->set('personal_field_' . $type, $personal_field, 36000);
    }
    return $personal_field;
  }
  
  public static function getPersonalFieldArray($type)
  {
    $personal_field = Yii::app()->cache->get('personal_field_array_' . $type);
    if ($personal_field === false) {
      $personal_field = CHtml::listData(SpotPersonalField::getPersonalField($type), 'id', 'name');
      
      Yii::app()->cache->set('personal_field_array_' . $type, $personal_field, 36000);
    }
    return $personal_field;
  }
  
  public static function getPersonalFieldAll()
  {
    $personal_field = Yii::app()->cache->get('personal_field_all');
    if ($personal_field === false) {
      $personal_field = SpotPersonalField::model()->findAll();
      
      Yii::app()->cache->set('personal_field_all', $personal_field, 36000);
    }
    return $personal_field;
  }
  
  public static function getPersonalFieldAllIco()
  {
    $personal_field = Yii::app()->cache->get('personal_field_all_ico');
    if ($personal_field === false) {
      $personal_field = CHtml::listData(SpotPersonalField::getPersonalFieldAll(), 'id', 'ico');
      
      Yii::app()->cache->set('personal_field_all_ico', $personal_field, 36000);
    }
    return $personal_field;
  }
  
  
  protected function afterSave()
  {
    Yii::app()->cache->delete('personal_field_id_' . $this->type);
    Yii::app()->cache->delete('personal_field_array_' . $this->type);
    Yii::app()->cache->delete('personal_field_all');
    Yii::app()->cache->delete('personal_field_all_ico');
    
    parent::afterSave();
    
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
    $criteria->compare('name', $this->name, true);
    $criteria->compare('ico', $this->ico, true);
    $criteria->compare('type', $this->type, true);
    $criteria->compare('placeholder', $this->placeholder, true);
    
    return new CActiveDataProvider(get_class($this), array(
        'criteria' => $criteria,
        'pagination' => array(
          'pageSize' => 30,
        ),
        'sort' => array('defaultOrder' => 'name asc',)
    ));
  }
}