<?php

/**
 * This is the model class for table "spot_content".
 *
 * The followings are the available columns in table 'spot':
 * @property integer $discodes_id
 * @property integer $user_id
 * @property integer $lang
 * @property integer $spot_type_id
 * @property text $content
 */
class SpotContent extends CActiveRecord {


  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return Spot the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'spot_content';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
        array('discodes_id, user_id, lang, spot_type_id', 'required'),
        array('discodes_id, user_id, spot_type_id', 'numerical', 'integerOnly'=>true),
        array('discodes_id, user_id, lang, spot_type_id, content', 'safe', 'on'=>'search'),
    );
  }

  public function beforeValidate() {

    if (!$this->lang) $this->lang='en';
    return parent::beforeValidate();
  }

  public function beforeSave()
  {
    $this->content=serialize($this->content);
    return parent::beforeSave();
  }

  protected function afterFind()
  {
    $this->content=unserialize($this->content);
    return parent::afterFind();
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
    return array(
        'spot'=>array(self::BELONGS_TO, 'Spot', 'discodes_id'),
        'spot_type'=>array(self::BELONGS_TO, 'SpotType', 'spot_type_id'),
        'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
        'lang'=>array(self::BELONGS_TO, 'Lang', 'lang'),
    );
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
        'discodes_id'=>'ID',
        'spot_type_id'=>'Тип спота',
        'user_id'=>'Пользователь',
        'lang'=>'Язык',
        'content'=>'Содержимое',
    );
  }

  public static function getSpotContent($discodes_id, $spot_type_id) {
    $spot_content=Yii::app()->cache->get('spot_content_'.$discodes_id);
    if (!$spot_content) {
      $spot_content=SpotContent::model()->findByAttributes(
        array(
          'discodes_id'=>$discodes_id,
          'spot_type_id'=>$spot_type_id,
        )
      );

      Yii::app()->cache->set('spot_content_'.$discodes_id, $spot_content, 60);
    }
    return $spot_content;
  }

  /**
   * Retrieves a list of models based on the current search/filter conditions.
   * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
   */
  public function search() {
    // Warning: Please modify the following code to remove attributes that
    // should not be searched.

    $criteria=new CDbCriteria;
    $criteria->compare('discodes_id', $this->discodes_id);
    $criteria->compare('spot_type_id', $this->spot_type_id);
    $criteria->compare('user_id', $this->user_id);
    $criteria->compare('content', $this->content, true);

    return new CActiveDataProvider(get_class($this), array(
        'criteria'=>$criteria,
        'pagination'=>array(
            'pageSize'=>20,
        ),
        'sort'=>array(
            'defaultOrder'=>'discodes_id ASC',),
    ));
  }
}