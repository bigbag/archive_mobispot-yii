<?php

/**
 * This is the model class for table "spot_field".
 *
 * The followings are the available columns in table 'spot_field':
 * @property integer $field_id
 * @property string $name
 * @property string $desc
 * @property string $widget
 */
class SpotField extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SpotField the static model class
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
        return 'spot_field';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, desc, widget', 'required'),
            array('name', 'length', 'max' => 300),
            array('name', 'unique'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('field_id, name, desc, widget', 'safe', 'on' => 'search'),
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

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'field_id' => 'ID',
            'name' => 'Название',
            'desc' => 'Описание',
            'widget' => 'Виджет',
        );
    }

    public static function getSpotFields()
    {
        $spot_fields = Yii::app()->cache->get('spot_fields');
        if ($spot_fields === false) {
            $spot_fields = SpotField::model()->findAll(array('order'=>'t.name'));

            Yii::app()->cache->set('spot_fields', $spot_fields, 36000);
        }
        return $spot_fields;
    }

    protected function afterSave()
    {
        Yii::app()->cache->delete('spot_fields');
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

        $criteria->compare('field_id', $this->field_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('desc', $this->desc, true);
        $criteria->compare('widget', $this->widget, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 30,
            ),
            'sort' => array('defaultOrder' => 'name')
        ));
    }
}