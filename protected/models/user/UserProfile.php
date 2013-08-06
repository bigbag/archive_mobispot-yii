<?php

/**
 * This is the model class for table "user_profile".
 *
 * The followings are the available columns in table 'user_profile':
 * @property integer $user_id
 * @property string $name
 * @property string $city
 * @property integer $sex
 * @property integer $birthday
 * @property string $photo
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
    public static function model($className = __CLASS__)
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
            array('user_id, sex', 'required'),
            array('user_id, sex', 'numerical', 'integerOnly' => true),
            array('name, city', 'filter', 'filter' => 'trim'),
            array('name, city', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('name, city, birthday', 'length', 'max' => 300),
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
            'city' => 'Город',
            'sex' => 'Пол',
            'birthday' => 'Birthday',
            'photo' => 'Photo',
        );
    }

    public function beforeValidate()
    {
        if (!$this->sex)
            $this->sex = self::SEX_UNKNOWN;
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

        $criteria = new CDbCriteria;

        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('city', $this->city, true);
        $criteria->compare('sex', $this->sex);
        $criteria->compare('birthday', $this->birthday, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}