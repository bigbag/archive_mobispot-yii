<?php

/**
 * This is the model class for table "spot_hard_type".
 *
 * The followings are the available columns in table 'spot_hard_type':
 * @property integer $id
 * @property string $name
 * @property string $desc
 * @property string $photo
 */
class SpotHardType extends CActiveRecord {

  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return SpotHardType the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'spot_hard_type';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
        array('name', 'required'),
        array('name', 'length', 'max'=>300),
        array('name, desc', 'filter', 'filter'=>'trim'),
        array('name, desc', 'filter', 'filter'=>array($obj=new CHtmlPurifier(), 'purify')),
        array('photo', 'safe'),
        // The following rule is used by search().
        // Please remove those attributes that should not be searched.
        array('id, name, desc, photo', 'safe', 'on'=>'search'),
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
    return array();
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
        'id'=>'ID',
        'name'=>'Название',
        'desc'=>'Описание',
        'photo'=>'Фотография',
    );
  }

  public static function getSpotHardType() {
    $spot_hard_type=Yii::app()->cache->get('spot_hard_type');
    if (!$spot_hard_type) {
      $spot_hard_type=SpotHardType::model()->findAll();

      Yii::app()->cache->set('spot_hard_type', $spot_hard_type, 36000);
    }
    return $spot_hard_type;
  }

  protected function afterSave() {
    Yii::app()->cache->delete('spot_hard_type');
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

    $criteria->compare('id', $this->id);
    $criteria->compare('name', $this->name, true);
    $criteria->compare('desc', $this->desc, true);
    $criteria->compare('photo', $this->photo, true);

    return new CActiveDataProvider($this, array(
        'criteria'=>$criteria,
        'sort'=>array('defaultOrder'=>'name')
    ));
  }

}