<?php

class User extends CActiveRecord
{
    /**
     * The followings are the available columns in table 'users':
     * @var integer $id
     * @var string $username
     * @var string $password
     * @var string $email
     * @var string $activkey
     * @var integer $createtime
     * @var integer $lastvisit
     * @var integer $superuser
     * @var integer $status
     * @var integer $type
     * @var string $vkontakte_id
     * @var string $facebook_id
     * @var string $odnoklassniki_id
     * @var integer city_id
     */

    const STATUS_NOACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_BANED = -1;

    const TYPE_RUNBEE = 0;
    const TYPE_CUSTOMER = 1;
    const TYPE_MODER = 2;

    public $superuser;
    public $vkontakte_id;
    public $facebook_id;
    public $odnoklassniki_id;
    public $city_id;

    /**
     * Returns the static model of the specified AR class.
     * @return CActiveRecord the static model class
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
        return Yii::app()->getModule('user')->tableUsers;
    }

    public function byCategory($category_id)
    {
        if($category_id != 0){
            $this->getDbCriteria()->mergeWith(array(
                'condition' => "runbee_category.category_id='$category_id'",
                'with' => 'runbee_category'
            ));
        }
        return $this;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.

        return ((Yii::app()->getModule('user')->isAdmin()) ? array(
            array('email, createtime, lastvisit, superuser, status, type, city_id', 'required'),
            array('username', 'length', 'max' => 20, 'min' => 3, 'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
            array('password', 'length', 'max' => 128, 'min' => 4, 'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
            array('vkontakte_id, facebook_id, odnoklassniki_id', 'length', 'max' => 200),
            array('email', 'email'),
            array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
            array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u', 'message' => UserModule::t("Incorrect symbols (A-z0-9).")),
            array('status', 'in', 'range' => array(self::STATUS_NOACTIVE, self::STATUS_ACTIVE, self::STATUS_BANED)),
            array('type', 'in', 'range' => array(self::TYPE_RUNBEE, self::TYPE_CUSTOMER, self::TYPE_MODER)),
            array('superuser', 'in', 'range' => array(0, 1)),
            array('createtime, lastvisit, superuser, status, type, city_id', 'numerical', 'integerOnly' => true),
        ) : ((Yii::app()->user->id == $this->id) ? array(
            array('email', 'required'),
            array('username', 'length', 'max' => 20, 'min' => 3, 'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
            array('email', 'email'),
            array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u', 'message' => UserModule::t("Incorrect symbols (A-z0-9).")),
            array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
        ) : array()));
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        $relations = array(
            'profile' => array(self::HAS_ONE, 'Profile', 'user_id'),
            'runbee_category' => array(self::HAS_ONE, 'RunbeeArea', 'runbee_id'),
            'city' => array(self::BELONGS_TO, 'City', 'city_id'),
        );
        if (isset(Yii::app()->getModule('user')->relations)) $relations = array_merge($relations, Yii::app()->getModule('user')->relations);
        return $relations;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'username' => UserModule::t("username"),
            'password' => UserModule::t("password"),
            'verifyPassword' => UserModule::t("Retype Password"),
            'email' => UserModule::t("E-mail"),
            'verifyEmail' => UserModule::t("Retype Email"),
            'verifyCode' => UserModule::t("Verification Code"),
            'id' => UserModule::t("Id"),
            'city_id' => 'Город',
            'activkey' => UserModule::t("activation key"),
            'createtime' => UserModule::t("Registration date"),
            'lastvisit' => UserModule::t("Last visit"),
            'superuser' => UserModule::t("Superuser"),
            'status' => UserModule::t("Status"),
            'type' => UserModule::t("Type"),
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
            'runbee' => array(
                'condition' => 'status=' . self::TYPE_RUNBEE,
            ),
            'customer' => array(
                'condition' => 'status=' . self::TYPE_CUSTOMER,
            ),
            'moder' => array(
                'condition' => 'status=' . self::TYPE_MODER,
            ),
            'superuser' => array(
                'condition' => 'superuser=1',
            ),
            'notsafe' => array(
                'select' => 'id, username, password, email, activkey, createtime, lastvisit, superuser, status, type',
            ),
        );
    }

    public function defaultScope()
    {
        return array(
            'select' => 'id, username, email, createtime, lastvisit, superuser, status, type, city_id',
        );
    }

    public static function itemAlias($type, $code = NULL)
    {
        $_items = array(
            'UserStatus' => array(
                self::STATUS_NOACTIVE => UserModule::t('Not active'),
                self::STATUS_ACTIVE => UserModule::t('Active'),
                self::STATUS_BANED => UserModule::t('Banned'),
            ),
            'UserType' => array(
                self::TYPE_RUNBEE => UserModule::t("Runbee"),
                self::TYPE_CUSTOMER => UserModule::t("Customer"),
                self::TYPE_MODER => UserModule::t("Moderator"),
            ),
            'AdminStatus' => array(
                '0' => UserModule::t('No'),
                '1' => UserModule::t('Yes'),
            ),
        );
        if (isset($code))
            return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
        else
            return isset($_items[$type]) ? $_items[$type] : false;
    }
}