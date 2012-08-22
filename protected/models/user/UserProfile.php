<?php

/**
 * This is the model class for table "user_profile".
 *
 * The followings are the available columns in table 'user_profile':
 * @property integer $user_id
 * @property string $name
 * @property string $place
 * @property integer $sex
 * @property integer $birthday_day
 * @property integer $birthday_month
 * @property integer $birthday_year
 * @property string $photo
 * @property string $facebook_id
 * @property string $twitter_id
 * @property integer $use_photo
 *
 * The followings are the available model relations:
 * @property User $user
 */
class UserProfile extends CActiveRecord
{
    const SEX_UNKNOWN = 0;
    const SEX_MALE = 1;
    const SEX_FEMALE = 2;

    public function getSexList()
    {
        return array(
            self::SEX_MALE => Yii::t('user', 'Мужской'),
            self::SEX_FEMALE => Yii::t('user', 'Женский'),
        );
    }

    public function getSex()
    {
        $data = $this->getSexList();
        return $data[$this->sex];
    }
    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserProfile the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_profile';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, sex, use_photo, photo', 'required'),
			array('user_id, sex, birthday_day, birthday_month, birthday_year, use_photo', 'numerical', 'integerOnly'=>true),
            array('name, place', 'filter', 'filter' => 'trim'),
            array('name, place', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
			array('name, place', 'length', 'max'=>300),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'Пользователь',
			'name' => 'Имя',
			'place' => 'Город',
			'sex' => 'Пол',
			'birthday_day' => 'Birthday Day',
			'birthday_month' => 'Birthday Month',
			'birthday_year' => 'Birthday Year',
			'photo' => 'Photo',
			'facebook_id' => 'Facebook',
			'twitter_id' => 'Twitter',
			'use_photo' => 'Use Photo',
		);
	}

    public function beforeValidate()
    {
        return parent::beforeValidate();
    }

    protected function afterSave()
    {
        Yii::app()->cache->delete('user_' . $this->user_id);
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

		$criteria=new CDbCriteria;

		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('place',$this->place,true);
		$criteria->compare('sex',$this->sex);
		$criteria->compare('birthday_day',$this->birthday_day);
		$criteria->compare('birthday_month',$this->birthday_month);
		$criteria->compare('birthday_year',$this->birthday_year);
		$criteria->compare('photo',$this->photo,true);
		$criteria->compare('facebook_id',$this->facebook_id,true);
		$criteria->compare('twitter_id',$this->twitter_id,true);
		$criteria->compare('use_photo',$this->use_photo);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}