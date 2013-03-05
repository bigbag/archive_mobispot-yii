<?php

/**
* This is the model class for table "user".
*
* The followings are the available columns in table 'user':
* @property integer $id
* @property integer $lang
* @property string $email
* @property string $password
* @property string $activkey
* @property string $creation_date
* @property string $lastvisit
* @property integer $type
* @property integer $status
* @property string $vkontakte_id
* @property string $facebook_id
* @property string $google_oauth_id
* @property string $twitter_id
*/
class User extends CActiveRecord
{
  const STATUS_NOACTIVE = 0;
  const STATUS_ACTIVE = 1;
  const STATUS_VALID = 2;
  const STATUS_BANNED = -1;
  
  const TYPE_USER = 0;
  const TYPE_ADMIN = 1;
  
  public function getStatusList()
  {
    return array(
      self::STATUS_NOACTIVE => Yii::t('user', 'Не активирован'),
      self::STATUS_ACTIVE => Yii::t('user', 'Активирован'),
      self::STATUS_VALID => Yii::t('user', 'Активен'),
      self::STATUS_BANNED => Yii::t('user', 'Заблокирован'),
    );
  }
  
  public function getTypeList()
  {
    return array(
      self::TYPE_USER => Yii::t('user', 'Пользователь'),
      self::TYPE_ADMIN => Yii::t('user', 'Админ'),
    );
  }
  
  public function getType()
  {
    $data = $this->getTypeList();
    return $data[$this->type];
  }
  
  public function getStatus()
  {
    $data = $this->getStatusList();
    return $data[$this->status];
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
      array('email, password, activkey, creation_date', 'required'),
      array('email', 'email'),
      array('email', 'unique', 'message' => Yii::t('user', "На сайте уже зарегистрирован пользователь с таким Email")),
      array('password', 'length', 'max' => 128, 'min' => 10, 'message' => Yii::t('user', "Минимальная длина пароля 5 символов")),
      array('type, status', 'numerical', 'integerOnly' => true),
      array('email, password, activkey', 'length', 'max' => 128),
      array('type', 'in', 'range' => array_keys($this->getTypeList())),
      array('status', 'in', 'range' => array_keys($this->getStatusList())),
      // The following rule is used by search().
      // Please remove those attributes that should not be searched.
      array('id, email, password, activkey, creation_date, lastvisit, type, status, facebook_id, google_oauth_id, twitter_id', 'safe', 'on' => 'search'),
    );
  }
  
  public function beforeValidate()
  {
    if ($this->isNewRecord) {
      $this->creation_date = new CDbExpression('NOW()');
      $this->status = self::STATUS_NOACTIVE;
      $this->type = self::TYPE_USER;
    }
    
    if (!$this->lang) $this->lang = 0;
    
    return parent::beforeValidate();
  }
  
  protected function afterSave()
  {
    if ($this->isNewRecord) {
      $profile = new UserProfile;
      $profile->user_id = $this->id;
      $profile->sex = UserProfile::SEX_UNKNOWN;
      $profile->use_photo = 0;
      $profile->save();
    }
    
    parent::afterSave();
  }
  
  protected function afterDelete()
  {
    UserProfile::model()->deleteByPk($this->id);
    Spot::model()->updateAll(array('status' => Spot::STATUS_REMOVED_SYS, 'removed_date' => new CDbExpression('NOW()')), 'user_id = ' . $this->id);
    parent::afterDelete();
  }
  
  
  /**
  * @return array relational rules.
  */
  public function relations()
  {
    // NOTE: you may need to adjust the relation name and the related
    // class name for the relations automatically generated below.
    return array(
      'profile' => array(self::BELONGS_TO, 'UserProfile', 'id'),
      'lang' => array(self::BELONGS_TO, 'Lang', 'lang'),
    );
  }
  
  /**
  * @return array customized attribute labels (name=>label)
  */
  public function attributeLabels()
  {
    return array(
      'password' => Yii::t('user', "Пароль"),
      'verifyPassword' => Yii::t('user', "Подтверждение пароля"),
      'email' => Yii::t('user', "E-mail"),
      'name' => Yii::t('user', "Имя"),
      'verifyEmail' => Yii::t('user', "Подтверждение Email"),
      'verifyCode' => Yii::t('user', "Проверочный код"),
      'id' => Yii::t('user', "Id"),
      'activkey' => Yii::t('user', "Ключ активации"),
      'creation_date' => Yii::t('user', "Дата регистрации"),
      'lastvisit' => Yii::t('user', "Дата последнего посещения"),
      'status' => Yii::t('user', "Статус"),
      'type' => Yii::t('user', "Тип"),
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
    $criteria->compare('vkontakte_id', $this->vkontakte_id);
    $criteria->compare('facebook_id', $this->facebook_id);
    $criteria->compare('google_oauth_id', $this->google_oauth_id);
    $criteria->compare('twitter_id', $this->twitter_id);
    
    $criteria->compare('lang', $this->lang);
    
    return new CActiveDataProvider($this, array(
        'criteria' => $criteria,
    ));
  }
  
  public function socialCheck($service, $soc_id)
  {
    $field = $service . '_id';
    return User::model()->findAllByAttributes(array($field => $soc_id));
  }
  
}