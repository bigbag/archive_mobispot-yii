<?php

/**
 * This is the model class for table "user_personal_field".
 *
 * The followings are the available columns in table 'user_personal_field':
 * @property integer $spot_id
 * @property string $contacts
 * @property string $social
 * @property string $text
 */
class UserPersonalField extends CActiveRecord {

  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return UserPersonalField the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'user_personal_field';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
        array('spot_id', 'required'),
        array('spot_id', 'numerical', 'integerOnly'=>true),
        array('contacts, social, text', 'length', 'max'=>300),
        // The following rule is used by search().
        // Please remove those attributes that should not be searched.
        array('spot_id, contacts, social, text', 'safe', 'on'=>'search'),
    );
  }

  public function getField($spot_id) {

    $data=Yii::app()->cache->get('spot_personal_field_'.$spot_id);
    if (!$data) {
      $field=UserPersonalField::model()->findByPk($spot_id);

      $data=array(9999);
      if (!empty($field->contacts))
        $data=array_merge($data, unserialize($field->contacts));
      if (!empty($field->social))
        $data=array_merge($data, unserialize($field->social));
      if (!empty($field->text))
        $data=array_merge($data, unserialize($field->text));
    }
    return $data;
  }

  public function setField($spot_id, $type_id, $data) {
    $data=serialize($data);
    $old_field=UserPersonalField::model()->findByPk($spot_id);

    if (!$old_field) {
      $field=new UserPersonalField();
      $field->spot_id=$spot_id;
    }
    else
      $field=$old_field;

    switch ($type_id) {
      case (SpotPersonalField::TYPE_CONTACTS):
        $field->contacts=$data;
        break;
      case (SpotPersonalField::TYPE_SOCIAL):
        $field->social=$data;
        break;
      case (SpotPersonalField::TYPE_TEXT):
        $field->text=$data;
        break;
    }
    $field->save();
  }

  protected function afterSave() {
    Yii::app()->cache->delete('spot_personal_field_'.$this->spot_id);

    parent::afterSave();
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
        'spot_id'=>'Spot',
        'contacts'=>'Contacts',
        'social'=>'Social',
        'text'=>'Text',
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

    $criteria->compare('spot_id', $this->spot_id);
    $criteria->compare('contacts', $this->contacts, true);
    $criteria->compare('social', $this->social, true);
    $criteria->compare('text', $this->text, true);

    return new CActiveDataProvider($this, array(
        'criteria'=>$criteria,
    ));
  }

}