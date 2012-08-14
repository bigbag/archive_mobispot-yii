<?php

/**
 * This is the model class for table "discodes".
 *
 * The followings are the available columns in table 'discodes':
 * @property integer $id
 * @property string $code
 * @property integer $status
 * @property integer $type
 * @property integer $premium
 * @property integer $user_id
 * @property string $creation_date
 */
class Discodes extends CActiveRecord
{
    const TYPE_PERSONA = 0;
    const TYPE_FIRM = 1;

    const PREMIUM_NO = 0;
    const PREMIUM_YES = 1;

    const STATUS_INIT = -1;
    const STATUS_GENERATED = 0;
    const STATUS_ISSUED = 1;
    const STATUS_REGISTERED = 2;
    const STATUS_CLONES = 3;
    const STATUS_REMOVED = 4;

    public function getTypeList()
    {
        return array(
            self::TYPE_PERSONA => 'Физик',
            self::TYPE_FIRM => 'Юрик',
        );
    }

    public function getPremiumList()
    {
        return array(
            self::PREMIUM_NO => 'Обычный',
            self::PREMIUM_YES => 'Красивый',
        );
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_INIT => 'Чистый',
            self::STATUS_GENERATED => 'Сгенерирован',
            self::STATUS_ISSUED => 'Выдан',
            self::STATUS_REGISTERED => 'Зарегистрирован',
            self::STATUS_CLONES => 'Клон',
            self::STATUS_REMOVED => 'Удалён',
        );
    }


    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Discodes the static model class
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
        return 'discodes';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, premium, user_id, creation_date', 'required'),
            array('id, status, type, premium, user_id', 'numerical', 'integerOnly' => true),
            array('premium', 'in', 'range' => array_keys($this->getPremiumList())),
            array('type', 'in', 'range' => array_keys($this->getTypeList())),
            array('status', 'in', 'range' => array_keys($this->getStatusList())),
            array('code', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, code, status, type, premium, user_id, creation_date', 'safe', 'on' => 'search'),
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
            'id' => 'ID',
            'code' => 'Код',
            'status' => 'Статус',
            'type' => 'Тип',
            'premium' => 'Премиум',
            'user_id' => 'Пользователь',
            'creation_date' => 'Дата создания',
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
        $criteria->compare('code', $this->code, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('type', $this->type);
        $criteria->compare('premium', $this->premium);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('creation_date', $this->creation_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}