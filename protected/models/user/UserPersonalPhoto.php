<?php

/**
 * This is the model class for table "user_personal_photo".
 *
 * The followings are the available columns in table 'user_personal_photo':
 * @property integer $user_id
 * @property string $photo_data
 */
class UserPersonalPhoto extends CActiveRecord {

  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return UserPersonalPhoto the static model class
   */
  public static function model($className = __CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'user_personal_photo';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
        array('user_id, photo_data', 'required'),
        array('user_id', 'numerical', 'integerOnly' => true),
        // The following rule is used by search().
        // Please remove those attributes that should not be searched.
        array('user_id, photo_data', 'safe', 'on' => 'search'),
    );
  }

  public function setPhoto($user_id, $data) {

    $photo = UserPersonalPhoto::model()->findByPk($user_id);
    if (!$photo)
      $photo = new UserPersonalPhoto();

    $photo->user_id = $user_id;
    $photo->photo_data = serialize($data);

    if ($photo->save())
      return true;
    else
      return false;
  }

  public function getPhoto($user_id) {
    $photo = UserPersonalPhoto::model()->findByPk($user_id);
    if (!empty($photo->photo_data))
      return unserialize($photo->photo_data);
    else
      return array();
  }

  public function removePhoto($user_id, $data) {
    $photo = UserPersonalPhoto::model()->findByPk($user_id);
    if (!empty($photo->photo_data)) {
      $photo_array = unserialize($photo->photo_data);

      if (($key = array_search($data, $photo_array)) !== FALSE) {
        unset($photo_array[$key]);
        $photo->photo_data = serialize($photo_array);
        if ($photo->save())
          return true;
      }
    }
    else
      return false;
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
    return array(
        'user' => array(self::BELONGS_TO, 'User', 'user_id'),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
        'user_id' => 'Пользователь',
        'photo_data' => 'Данные',
    );
  }

  /**
   * Retrieves a list of models based on the current search/filter conditions.
   * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
   */
  public function search() {
    // Warning: Please modify the following code to remove attributes that
    // should not be searched.

    $criteria = new CDbCriteria;

    $criteria->compare('user_id', $this->user_id);
    $criteria->compare('photo_data', $this->photo_data, true);

    return new CActiveDataProvider($this, array(
        'criteria' => $criteria,
    ));
  }

}