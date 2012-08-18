<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $activkey
 * @property string $creation_date
 * @property string $lastvisit
 * @property integer $type
 * @property integer $status
 */
class User extends CActiveRecord
{

    const STATUS_NOACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_BANNED = -1;

    const TYPE_USER = 0;
    const TYPE_ADMIN = 1;

    public function getStatusList()
    {
        return array(
            self::STATUS_NOACTIVE => Yii::t('user', 'Not active'),
            self::STATUS_ACTIVE => Yii::t('user', 'Active'),
            self::STATUS_BANNED => Yii::t('user', 'Banned'),
        );
    }

    public function getTypeList()
    {
        return array(
            self::TYPE_USER => Yii::t('user', 'User'),
            self::TYPE_ADMIN => Yii::t('user', 'Admin'),
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
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
            array('email, password, activkey, creation_date, lastvisit', 'required'),
            array('email', 'email'),
            array('email', 'unique', 'message' => Yii::t('user', "This user's email address already exists.")),
            array('password', 'length', 'max' => 128, 'min' => 5, 'message' => Yii::t('user', "Incorrect password (minimal length 5 symbols).")),
            array('type, status', 'numerical', 'integerOnly' => true),
            array('email, password, activkey', 'length', 'max' => 128),
            array('type', 'in', 'range' => array_keys($this->getTypeList())),
            array('status', 'in', 'range' => array_keys($this->getStatusList())),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, email, password, activkey, creation_date, lastvisit, type, status', 'safe', 'on' => 'search'),
        );
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->creation_date = new CDbExpression('NOW()');
            $this->lastvisit = $this->creation_date;
            $this->status = self::STATUS_NOACTIVE;
            $this->type = self::TYPE_USER;
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'password' => Yii::t('user', "password"),
            'verifyPassword' => Yii::t('user', "Retype Password"),
            'email' => Yii::t('user', "E-mail"),
            'verifyEmail' => Yii::t('user', "Retype Email"),
            'verifyCode' => Yii::t('user', "Verification Code"),
            'id' => Yii::t('user', "Id"),
            'activkey' => Yii::t('user', "activation key"),
            'creation_date' => Yii::t('user', "Registration date"),
            'lastvisit' => Yii::t('user', "Last visit"),
            'status' => Yii::t('user', "Status"),
            'type' => Yii::t('user', "Type"),
        );
    }

    public function scopes()
    {
        return array(
            'active' => array(
                'condition' => 'status=' . self::STATUS_ACTIVE,
            ),
            'notactvie' => array(
                'condition' => 'status=' . self::STATUS_NOACTIVE,
            ),
            'banned' => array(
                'condition' => 'status=' . self::STATUS_BANED,
            ),
            'admin' => array(
                'condition' => 'status=' . self::TYPE_ADMIN,
            ),
            'user' => array(
                'condition' => 'status=' . self::TYPE_USER,
            ),
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
        $criteria->compare('password', $this->password, true);
        $criteria->compare('activkey', $this->activkey, true);
        $criteria->compare('creation_date', $this->creation_date, true);
        $criteria->compare('lastvisit', $this->lastvisit, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}