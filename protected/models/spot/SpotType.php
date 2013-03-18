<?php

/**
 * This is the model class for table "spot_type".
 *
 * The followings are the available columns in table 'spot_type':
 * @property integer $type_id
 * @property string $name
 * @property string $desc
 * @property integer $type
 * @property text $pattern
 * @property string $lang
 */
class SpotType extends CActiveRecord {

  public $fields;
  public $fields_flag;

  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return SpotType the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'spot_type';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
        array('name, pattern, lang', 'required'),
        array('fields_flag', 'required', 'message'=>'Необходимо добавить хотя бы одно поле.'),
        array('name, pattern', 'length', 'max'=>150),
        array('name, desc, pattern', 'filter', 'filter'=>'trim'),
        array('name, desc, pattern', 'filter', 'filter'=>array($obj=new CHtmlPurifier(), 'purify')),
        // The following rule is used by search().
        // Please remove those attributes that should not be searched.
        array('type_id, name, desc, lang', 'safe', 'on'=>'search'),
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
    return array(
        'fields'=>array(self::MANY_MANY, 'SpotField',
            'spot_link_type_field(type_id, field_id)'),
        'lang'=>array(self::BELONGS_TO, 'Lang', 'lang'),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
        'type_id'=>'ID',
        'name'=>'Название',
        'desc'=>'Описание',
        'pattern'=>'Шаблон',
        'lang'=>'Язык',
        'fields'=>'Поля',
    );
  }

  public static function getSpotType() {
    $spot_type=Yii::app()->cache->get('spot_type');
    if ($spot_type=false) {
      $spot_type=SpotType::model()->findAll(array('order'=>'name'));

      Yii::app()->cache->set('spot_type', $spot_type, 36000);
    }
    return $spot_type;
  }

  public static function getSpotTypeArray() {
    $spot_type=Yii::app()->cache->get('spot_type_array');
    if ($spot_type=false) {
      $spot_type=CHtml::listData(SpotType::getSpotType(), 'type_id', 'name');

      Yii::app()->cache->set('spot_type_array', $spot_type, 36000);
    }
    return $spot_type;
  }

  protected function afterSave() {
    if ($this->fields) {
      $conn=Yii::app()->db;
      $conn->createCommand()->delete(SpotLinkTypeField::tableName(), 'type_id=:type_id', array(':type_id'=>$this->type_id));
      foreach ($this->fields as $field) {
        $field->type_id=$this->type_id;
        $field->save();
      }
    }

    Yii::app()->cache->delete('spot_type');
    Yii::app()->cache->delete('spot_type_array');

    parent::afterSave();
  }

  /**
   * Retrieves a list of models based on the current search/filter conditions.
   * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
   */
  public function search() {
    // Warning: Please modify the following code to remove attributes that
    // should not be searched.

    $criteria=new CDbCriteria;

    $criteria->compare('type_id', $this->type_id);
    $criteria->compare('name', $this->name, true);
    $criteria->compare('desc', $this->desc, true);
    $criteria->compare('pattern', $this->pattern, true);
    $criteria->compare('lang', $this->lang, true);

    return new CActiveDataProvider($this, array(
        'criteria'=>$criteria,
        'sort'=>array('defaultOrder'=>'name')
    ));
  }

}