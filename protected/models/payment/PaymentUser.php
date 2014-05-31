<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $email
 * @property integer $status
 * @property integer $mobispot_id
 * @property string $creation_date
 */
class PaymentUser extends CActiveRecord
{

    const STATUS_NOACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_BANNED = -1;

    public function getStatusList()
    {
        return array(
            self::STATUS_NOACTIVE => Yii::t('user', 'Не активирован'),
            self::STATUS_ACTIVE => Yii::t('user', 'Активирован'),
            self::STATUS_BANNED => Yii::t('user', 'Заблокирован'),
        );
    }

    public function getStatus()
    {
        $data = $this->getStatusList();
        return $data[$this->status];
    }

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
        return Yii::app()->dbPayment;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('email, creation_date', 'required'),
            array('status, mobispot_id', 'numerical', 'integerOnly' => true),
            array('email', 'length', 'max' => 150),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('status', 'in', 'range' => array_keys($this->getStatusList())),
            array('id, email, status, mobispot_id, creation_date', 'safe', 'on' => 'search'),
        );
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->creation_date = new CDbExpression('NOW()');
            $this->status = self::STATUS_NOACTIVE;
        }

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
            'mobispot_user' => array(self::BELONGS_TO, 'User', 'mobispot_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'email' => 'Email',
            'status' => 'Status',
            'mobispot_id' => 'Mobispot',
            'creation_date' => 'Creation Date',
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
        $criteria->compare('email', $this->email, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('mobispot_id', $this->mobispot_id);
        $criteria->compare('creation_date', $this->creation_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
