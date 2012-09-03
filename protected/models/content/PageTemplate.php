<?php

/**
 * This is the model class for table "page_template".
 *
 * The followings are the available columns in table 'page_template':
 * @property integer $id
 * @property string $name
 * @property string $desc
 * @property string $content
 */
class PageTemplate extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PageTemplate the static model class
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
		return 'page_template';
	}

    public function getLang()
    {
        $data = Lang::getLang();
        return  $data[$this->status];
    }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, desc, content', 'required'),
			array('name', 'length', 'max'=>150),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, desc, content', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'name' => 'Название',
			'desc' => 'Описание',
			'content' => 'Содержимое',
		);
	}

    public static function getTemplate()
    {
        $templates = Yii::app()->cache->get('templates');
        if ($templates === false) {
            $templates = PageTemplate::model()->findAll(array('order' => 'id'));

            Yii::app()->cache->set('templates', $templates, 36000);
        }
        return $templates;
    }

    public static function getTemplateArray()
    {
        $templates = Yii::app()->cache->get('templates_array');
        if ($templates === false) {
            $templates = CHtml::listData(PageTemplate::getTemplate(), 'id', 'name');

            Yii::app()->cache->set('templates_array', $templates, 36000);
        }
        return $templates;
    }

    protected function afterSave()
    {
        Yii::app()->cache->delete('templates');
        Yii::app()->cache->delete('templates_array');

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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('content',$this->content,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}