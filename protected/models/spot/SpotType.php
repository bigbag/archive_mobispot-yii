<?php

/**
 * This is the model class for table "spot_type".
 *
 * The followings are the available columns in table 'spot_type':
 * @property integer $type_id
 * @property string $name
 * @property string $desc
 * @property integer $type
 * @property text $key
 */
class SpotType extends CActiveRecord
{

    public $fields_flag;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SpotType the static model class
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
        return 'spot_type';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, key', 'required'),
            array('name, key', 'length', 'max' => 150),
            array('name, desc, key', 'filter', 'filter' => 'trim'),
            array('name, desc, key', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('type_id, name, desc, key', 'safe', 'on' => 'search'),
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
        );
    }

    public function beforeSave()
    {
        $this->field = serialize($this->field);
        return parent::beforeSave();
    }

    protected function afterFind()
    {
        $this->field = unserialize($this->field);
        return parent::afterFind();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'type_id' => 'ID',
            'name' => 'Название',
            'desc' => 'Описание',
            'key' => 'Ключ',
            'field' => 'Поля',
        );
    }

    public static function getSpotType()
    {
        $spot_type = Yii::app()->cache->get('spot_type');
        if (!$spot_type)
        {
            $spot_type = SpotType::model()->findAll(array('order' => 'name'));

            Yii::app()->cache->set('spot_type', $spot_type, 36000);
        }
        return $spot_type;
    }

    public static function getSpotTypeArray()
    {
        $spot_type = Yii::app()->cache->get('spot_type_array');
        if (!$spot_type)
        {
            $spot_type = CHtml::listData(SpotType::getSpotType(), 'type_id', 'name');

            Yii::app()->cache->set('spot_type_array', $spot_type, 36000);
        }
        return $spot_type;
    }

    protected function afterSave()
    {
        Yii::app()->cache->delete('spot_type');
        Yii::app()->cache->delete('spot_type_array');

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

        $criteria->compare('type_id', $this->type_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('desc', $this->desc, true);
        $criteria->compare('key', $this->key, true);
        $criteria->compare('field', $this->field, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array('defaultOrder' => 'name')
        ));
    }

}