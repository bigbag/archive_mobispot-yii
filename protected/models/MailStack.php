<?php

/**
 * This is the model class for table "mail_stack".
 *
 * The followings are the available columns in table 'mail_stack':
 * @property integer $id
 * @property string $from
 * @property string $to
 * @property string $subject
 * @property string $body
 * @property string $creation_date
 * @property integer $lock
 */
class MailStack extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MailStack the static model class
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
		return 'mail_stack';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('from, to, subject, body, creation_date', 'required'),
			array('lock', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, from, to, subject, body, creation_date, lock', 'safe', 'on'=>'search'),
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
			'from' => 'От кого',
			'to' => 'Кому',
			'subject' => 'Тема',
			'body' => 'Сообщение',
			'creation_date' => 'Дата создания',
			'lock' => 'Флаг',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('from',$this->from,true);
		$criteria->compare('to',$this->to,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('body',$this->body,true);
		$criteria->compare('creation_date',$this->creation_date,true);
		$criteria->compare('lock',$this->lock);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}