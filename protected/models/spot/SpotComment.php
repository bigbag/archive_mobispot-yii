<?php

/**
 * This is the model class for table "spot_comment".
 *
 * The followings are the available columns in table 'spot_comment':
 * @property integer $id
 * @property integer $spot_user_id
 * @property integer $comment_user_id
 * @property integer $spot_id
 * @property string $body
 * @property string $creation_date
 */
class SpotComment extends CActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SpotComment the static model class
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
        return 'spot_comment';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('spot_id, body, spot_user_id, creation_date', 'required'),
            array('spot_id', 'numerical', 'integerOnly' => true),
            array('body', 'filter', 'filter' => 'trim'),
            array('body', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, spot_user_id, comment_user_id, spot_id, body, creation_date', 'safe', 'on' => 'search'),
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
        return array(
            'spot' => array(self::BELONGS_TO, 'Spot', 'spot_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'spot_user_id' => 'Владелец спота',
            'comment_user_id' => 'Автор комментария',
            'body' => 'Комментарий',
            'spot_id' => 'Спот',
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
        $criteria->compare('spot_user_id', $this->spot_user_id);
        $criteria->compare('comment_user_id', $this->comment_user_id);
        $criteria->compare('spot_id', $this->spot_id);
        $criteria->compare('body', $this->body, true);
        $criteria->compare('creation_date', $this->creation_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}