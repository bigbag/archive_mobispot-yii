<?php

/**
 * This is the model class for table "settings".
 *
 * The followings are the available columns in table 'settings':
 * @property integer $id
 * @property string $name
 * @property string $desc
 * @property string $value
 * @property string $change_date
 * @property string $user_id
 */
class Settings extends CActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Settings the static model class
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
        return 'settings';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, desc, value, change_date, user_id', 'required'),
            array('name, desc', 'filter', 'filter' => 'trim'),
            array('name, desc', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('name', 'unique'),
            array('name', 'length', 'max' => 150),
            array('desc', 'length', 'max' => 300),
            array('value, change_date, user_id', 'length', 'max' => 45),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, desc, value, change_date, user_id', 'safe', 'on' => 'search'),
        );
    }

    public function beforeValidate()
    {
        if (!$this->change_date)
            $this->change_date = new CDbExpression('NOW()');

        if (!isset($this->user_id))
            $this->user_id = Yii::app()->user->id;

        return parent::beforeValidate();
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
            'id' => 'ID',
            'name' => 'Название',
            'desc' => 'Описание',
            'value' => 'Значение',
            'change_date' => 'Дата изменения',
            'user_id' => 'Пользователь',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('desc', $this->desc, true);
        $criteria->compare('value', $this->value, true);
        $criteria->compare('change_date', $this->change_date, true);
        $criteria->compare('user_id', $this->user_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 30,
            ),
            'sort' => array('defaultOrder' => 't.desc ASC',)
        ));
    }

}
