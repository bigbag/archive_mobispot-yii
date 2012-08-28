<?php

/**
 * This is the model class for table "spot".
 *
 * The followings are the available columns in table 'spot':
 * @property string $code
 * @property string $name
 * @property integer $discodes_id
 * @property integer $spot_type_id
 * @property integer $user_id
 * @property integer $spot_hard_type_id
 * @property string $spot_hard
 * @property string $nfc
 * @property integer $type
 * @property integer $premium
 * @property integer $status
 * @property string $generated_date
 * @property string $registered_date
 * @property string $removed_date
 */
class Spot extends CActiveRecord
{
    const SYMBOL_LENGTH = 10;
    const SYMBOL_PERSONA = 'BbCcDdFfGgHhJjKkLlMmNnPpQqRrSsTtVvWwXxZz';
    const SYMBOL_FIRM = 'AaEeIiUuYy';

    const TYPE_PERSONA = 0;
    const TYPE_FIRM = 1;

    const STATUS_GENERATED = 0;
    const STATUS_ACTIVATED = 1;
    const STATUS_REGISTERED = 2;
    const STATUS_CLONES = 3;
    const STATUS_REMOVED_USER = 4;
    const STATUS_REMOVED_SYS = 5;
    const STATUS_INVISIBLE = 6;

    public $spot_type_name;

    public function getTypeList()
    {
        return array(
            self::TYPE_PERSONA => 'Физ. лиц',
            self::TYPE_FIRM => 'Юр. лиц',
        );
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_GENERATED => 'Сгенерирован',
            self::STATUS_ACTIVATED => 'Активирован',
            self::STATUS_REGISTERED => 'Зарегистрирован',
            self::STATUS_INVISIBLE => 'Невидим',
            self::STATUS_CLONES => 'Клон',
            self::STATUS_REMOVED_USER => 'Удалён пользователем',
            self::STATUS_REMOVED_SYS => 'Удалён системой',
        );
    }

    public function getPremiumList()
    {
        return Discodes::getPremiumList();
    }

    public function getType()
    {
        $data = $this->getTypeList();
        return $data[$this->type];
    }

    public function getStatus()
    {
        $data = $this->getStatusList();
        return $data[$this->status];
    }

    public function getPremium()
    {
        return Discodes::getPremium();
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Spot the static model class
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
        return 'spot';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('discodes_id, code, type, status, premium, generated_date', 'required'),
            array('discodes_id, spot_type_id, user_id, spot_hard_type_id, type, premium, status', 'numerical', 'integerOnly' => true),
            array('name', 'filter', 'filter' => 'trim'),
            array('discodes_id', 'unique'),
            array('name', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('type', 'in', 'range' => array_keys($this->getTypeList())),
            array('status', 'in', 'range' => array_keys($this->getStatusList())),
            array('name', 'length', 'max' => 300),
            array('code', 'length', 'max' => 10),
            array('spot_hard, nfc', 'length', 'max' => 32),
            array('registered_date, removed_date', 'safe'),
            array('code, name, discodes_id, spot_type_id, spot_type_name, user_id, spot_hard_type_id, spot_hard, nfc, type, premium, status, generated_date, registered_date, removed_date', 'safe', 'on' => 'search'),
        );
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->generated_date = new CDbExpression('NOW()');
            $this->status == self::STATUS_GENERATED;
        }

        if (!($this->registered_date) and ($this->status == self::STATUS_REGISTERED)) {
            $this->registered_date = new CDbExpression('NOW()');
        }

        if (!($this->removed_date) and ($this->status == self::STATUS_REMOVED_USER or $this->status == self::STATUS_REMOVED_SYS)) {
            $this->removed_date = new CDbExpression('NOW()');
        }

        return parent::beforeValidate();
    }

    protected function afterDelete()
    {
        $dis = Discodes::model()->findByPk($this->discodes_id);
        $dis->status = Discodes::STATUS_INIT;
        $dis->save();

        parent::afterDelete();
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'discodes' => array(self::BELONGS_TO, 'Discodes', 'discodes_id'),
            'spot_type' => array(self::BELONGS_TO, 'SpotType', 'spot_type_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'spot_hard_type' => array(self::BELONGS_TO, 'SpotHardType', 'spot_hard_type_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'code' => 'Код',
            'name' => 'Название',
            'discodes_id' => 'ДИС',
            'spot_type_id' => 'Тип спота',
            'spot_type_name' => 'Тип спота',
            'user_id' => 'Пользователь',
            'spot_hard_type_id' => 'Тип исполнения',
            'spot_hard' => 'Заводской номер',
            'nfc' => 'NFC',
            'type' => 'Физ. лиц/Юр. лиц',
            'status' => 'Статус',
            'premium' => 'Премиум',
            'generated_date' => 'Дата генерации',
            'registered_date' => 'Дата регистрации',
            'removed_date' => 'Дата удаления',
        );
    }

    public static function getUserSpot($user_id)
    {
        $user_spot = Yii::app()->cache->get('user_spot_'.$user_id);
        if ($user_spot === false) {
            $user_spot = Spot::model()->findByAttributes(array('user_id' => $user_id));

            Yii::app()->cache->set('user_spot_'.$user_id, $user_spot, 3600);
        }
        return $user_spot;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $sort = new CSort;
        $sort->attributes = array(
            'defaultOrder' => 'generated_date desc',
            'spot_type_name' => array(
                'asc' => 'spot_type.name',
                'desc' => 'spot_type.name DESC',
            ),

        );
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->with = 'spot_type';
        $criteria->compare('code', $this->code, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('discodes_id', $this->discodes_id);
        $criteria->compare('spot_type_id', $this->spot_type_id);
        $criteria->compare('spot_type.name', $this->spot_type_name, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('spot_hard_type_id', $this->spot_hard_type_id);
        $criteria->compare('spot_hard', $this->spot_hard, true);
        $criteria->compare('nfc', $this->nfc, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('premium', $this->premium);
        $criteria->compare('status', $this->status);
        $criteria->compare('generated_date', $this->generated_date, true);
        $criteria->compare('registered_date', $this->registered_date, true);
        $criteria->compare('removed_date', $this->removed_date, true);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            ),
            'sort' => $sort,
        ));
    }
}