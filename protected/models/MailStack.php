<?php

/**
 * This is the model class for table "mail_stack".
 *
 * The followings are the available columns in table 'mail_stack':
 * @property integer $id
 * @property string $senders
 * @property string $recipients
 * @property string $subject
 * @property string $body
 * @property string $attach
 * @property string $creation_date
 * @property integer $lock
 *
 */
class MailStack extends CActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PaymentUser the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return CDbConnection database connection
     */
    public function getDbConnection()
    {
        return Yii::app()->dbStack;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'stack.mail';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('senders, recipients, subject, body, creation_date', 'required'),
            array('lock', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, senders, recipients, subject, body, attach, creation_date, lock', 'safe', 'on' => 'search'),
        );
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord)
            $this->creation_date = new CDbExpression('NOW()');

        return parent::beforeValidate();
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'senders' => 'От кого',
            'recipients' => 'Кому',
            'subject' => 'Тема',
            'body' => 'Сообщение',
            'attach' => 'Вложения',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('senders', $this->senders, true);
        $criteria->compare('recipients', $this->recipients, true);
        $criteria->compare('subject', $this->subject, true);
        $criteria->compare('body', $this->body, true);
        $criteria->compare('attach', $this->attach, true);
        $criteria->compare('creation_date', $this->creation_date, true);
        $criteria->compare('lock', $this->lock);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
