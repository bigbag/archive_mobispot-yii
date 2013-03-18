<?php

/**
 * This is the model class for table "content_links_footer".
 *
 * The followings are the available columns in table 'content_links_footer':
 * @property integer $id
 * @property string $link
 * @property string $name
 * @property string $lang
 */
class ContentLinksFooter extends CActiveRecord {

  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return ContentLinksFooter the static model class
   */
  public static function model($className = __CLASS__) {
    return parent::model($className);
  }

  public function getLang() {
    $data = Lang::getLangArray();
    return $data[$this->lang];
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'content_links_footer';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
        array('link, name', 'required'),
        array('link', 'length', 'max' => 150),
        array('name', 'length', 'max' => 300),
        array('lang', 'length', 'max' => 2),
        // The following rule is used by search().
        // Please remove those attributes that should not be searched.
        array('id, link, name, lang', 'safe', 'on' => 'search'),
    );
  }

  /**
   * @return array relational rules.
   */
  public function relations() {
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
    return array(
        'lang' => array(self::BELONGS_TO, 'Lang', 'lang'),
    );
  }

  public function getLinks() {
    $dependency = new CDbCacheDependency("SELECT MAX(id) FROM content_links_footer WHERE lang = '" . Yii::app()->language . "'");
    $criteria = new CDbCriteria;
    $criteria->condition = 'lang=:lang';
    $criteria->params = array('lang' => Yii::app()->language);
    $criteria->order = "id desc";
    $criteria->limit = 4;

    return ContentLinksFooter::model()->cache(600, $dependency)->findAll($criteria);
  }

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
        'id' => 'ID',
        'link' => 'Ссылка',
        'name' => 'Название',
        'lang' => 'Язык',
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

    $criteria->compare('id', $this->id);
    $criteria->compare('link', $this->link, true);
    $criteria->compare('name', $this->name, true);
    $criteria->compare('lang', $this->lang, true);

    return new CActiveDataProvider($this, array(
        'criteria' => $criteria,
        'pagination' => array(
            'pageSize' => 30,
        ),
    ));
  }

}