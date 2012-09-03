<?php

/**
 * This is the model class for table "mail_template".
 *
 * The followings are the available columns in table 'mail_template':
 * @property integer $id
 * @property string $name
 * @property string $desc
 * @property string $content
 * @property integer $lang_id
 * @property string $subject
 * @property string $slug
 */
class MailTemplate extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MailTemplate the static model class
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
        return 'mail_template';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, desc, content, lang_id, slug, subject', 'required'),
            array('name, desc, lang_id, slug', 'filter', 'filter' => 'trim'),
            array('name', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('name', 'length', 'max' => 150),
            array('slug', 'length', 'max' => 300),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, desc, content, lang_id, slug, subject', 'safe', 'on' => 'search'),
        );
    }

    public function beforeValidate()
    {
        if (!$this->slug)
            $this->slug = YText::translit($this->name);

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
            'slug' => 'Код',
            'desc' => 'Описание',
            'lang_id' => 'Язык',
            'subject' => 'Тема',
            'content' => 'Содержимое',
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
        $criteria->compare('lang_id', $this->lang_id);
        $criteria->compare('slug', $this->slug);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('desc', $this->desc, true);
        $criteria->compare('subject', $this->subject, true);
        $criteria->compare('content', $this->content, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}