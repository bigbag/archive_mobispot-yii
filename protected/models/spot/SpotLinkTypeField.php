<?php

/**
 * This is the model class for table "spot_link_type_field".
 *
 * The followings are the available columns in table 'spot_link_type_field':
 * @property integer $id
 * @property integer $type_id
 * @property integer $field_id
 * @property string $name
 * @property string $slug
 */
class SpotLinkTypeField extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SpotLinkTypeField the static model class
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
		return 'spot_link_type_field';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type_id, field_id, name, slug', 'required'),
			array('type_id, field_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type_id, field_id, slug, name', 'safe', 'on'=>'search'),
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
            'spot_field' => array(self::BELONGS_TO, 'SpotField', 'field_id'),
            'spot_type' => array(self::BELONGS_TO, 'SpotType', 'type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'type_id' => 'Тип',
			'field_id' => 'Поле',
            'slug' => 'Обозначение',
			'name' => 'Название',
		);
	}

    public function beforeValidate()
    {
        if (!$this->slug)
            $this->slug = $this->type_id . '_'. YText::translit($this->name);

        return parent::beforeValidate();
    }

    public static function getSpotTypeFieldName($type_id)
    {
        $spot_type_field = Yii::app()->cache->get('spot_type_field_name_' . $type_id);
        if ($spot_type_field === false) {
            $spot_type_field = SpotLinkTypeField::model()->with('spot_field')->findAllByAttributes(array('type_id' =>$type_id));

            Yii::app()->cache->set('spot_type_field_name_' . $type_id, $spot_type_field, 36000);
        }
        return $spot_type_field;
    }

    public static function getSpotTypeField($type_id)
    {
        $spot_type_field = Yii::app()->cache->get('spot_type_field_' . $type_id);
        if ($spot_type_field === false) {
            $spot_type_field = SpotLinkTypeField::model()->findAllByAttributes(array('type_id' =>$type_id));

            Yii::app()->cache->set('spot_type_field_' . $type_id, $spot_type_field, 36000);
        }
        return $spot_type_field;
    }

    public static function getSpotFieldSlug($type_id)
    {
        $spot_field_slug = Yii::app()->cache->get('spot_type_field_slug_' . $type_id);
        if ($spot_field_slug === false) {
            $criteria = new CDbCriteria;
            $criteria->select = "slug";
            $criteria->compare('type_id', $type_id);
            $spot_field = SpotLinkTypeField::model()->findAll($criteria);

            $spot_field_slug = array();
            foreach ($spot_field as $row){
                $spot_field_slug[] = $row['slug'];
            }
            Yii::app()->cache->set('spot_type_field_slug_' . $type_id, $spot_field_slug, 36000);
        }
        return $spot_field_slug;
    }

    protected function afterSave()
    {
        Yii::app()->cache->delete('spot_type_field_' . $this->type_id);
        Yii::app()->cache->delete('spot_type_field_slug_' . $this->type_id);
        Yii::app()->cache->delete('spot_type_field_name_' . $this->type_id);

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

		$criteria->compare('id',$this->id);
		$criteria->compare('type_id',$this->type_id);
		$criteria->compare('field_id',$this->field_id);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}