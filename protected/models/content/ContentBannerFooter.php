<?php

/**
 * This is the model class for table "content_banner_footer".
 *
 * The followings are the available columns in table 'content_banner_footer':
 * @property integer $id
 * @property string $link
 * @property string $title
 * @property string $lang
 * @property string $image
 */
class ContentBannerFooter extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ContentBannerFooter the static model class
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
		return 'content_banner_footer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('link, image', 'required'),
			array('link, image', 'length', 'max'=>300),
			array('title', 'length', 'max'=>150),
			array('lang', 'length', 'max'=>2),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, link, title, image, lang', 'safe', 'on'=>'search'),
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

    public function getBanner()
    {
        $dependency = new CDbCacheDependency("SELECT MAX(id) FROM content_banner_footer WHERE lang = '" . Yii::app()->language . "'");
        return ContentBannerFooter::model()->cache(600, $dependency)->findAllByAttributes(array('lang' => Yii::app()->language));
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'link' => 'Ссылка',
            'image' => 'Изображение',
			'title' => 'Заголовок',
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
		$criteria->compare('link',$this->link,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('lang',$this->lang,true);
        $criteria->compare('image',$this->image,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}