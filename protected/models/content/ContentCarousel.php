<?php

/**
* This is the model class for table "content_carousel".
*
* The followings are the available columns in table 'content_carousel':
* @property integer $id
* @property string $name
* @property string $desc
* @property string $image
* @property string $image_focus
* @property string $lang
*/
class ContentCarousel extends CActiveRecord
{
  /**
  * Returns the static model of the specified AR class.
  * @param string $className active record class name.
  * @return ContentCarousel the static model class
  */
  public static function model($className=__CLASS__)
  {
    return parent::model($className);
  }
  
  public function getLang()
  {
    $data = Lang::getLangArray();
    return $data[$this->lang];
  }
  
  /**
  * @return string the associated database table name
  */
  public function tableName()
  {
    return 'content_carousel';
  }
  
  /**
  * @return array validation rules for model attributes.
  */
  public function rules()
  {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
      array('name, desc, image, image_focus', 'required'),
      array('name', 'length', 'max'=>150),
      array('desc, image', 'length', 'max'=>300),
      array('lang', 'length', 'max'=>10),
      // The following rule is used by search().
      // Please remove those attributes that should not be searched.
      array('id, name, desc, image, image_focus, lang', 'safe', 'on'=>'search'),
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
      'lang' => array(self::BELONGS_TO, 'Lang', 'lang'),
    );
  }
  
  public function getCarousel()
  {
    $dependency = new CDbCacheDependency("SELECT MAX(id) FROM content_carousel WHERE lang = '" . Yii::app()->language . "'");
    return ContentCarousel::model()->cache(600, $dependency)->findAllByAttributes(array('lang' => Yii::app()->language));
  }
  
  /**
  * @return array customized attribute labels (name=>label)
  */
  public function attributeLabels()
  {
    return array(
      'id' => 'ID',
      'name' => 'Название',
      'desc' => 'Описание',
      'image' => 'Иконка',
      'image_focus' => 'Активная иконка',
      'lang' => 'Язык',
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
    $criteria->compare('name',$this->name,true);
    $criteria->compare('desc',$this->desc,true);
    $criteria->compare('image',$this->image,true);
    $criteria->compare('image_focuse',$this->image_focus,true);
    
    $criteria->compare('lang',$this->lang,true);
    
    return new CActiveDataProvider($this, array(
        'criteria'=>$criteria,
        'pagination' => array(
          'pageSize' => 30,
        ),
    ));
  }
}