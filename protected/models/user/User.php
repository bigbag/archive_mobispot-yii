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
 */
class User extends CActiveRecord
{

    const STATUS_NOACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_VALID = 2;
    const STATUS_BANNED = -1;
    const TYPE_USER = 0;
    const TYPE_ADMIN = 1;

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
            array('email', 'unique', 'message' => Yii::t('user', "The site already a registered member with Email")),
            array('password', 'length', 'max' => 128, 'min' => 2, 'message' => Yii::t('user', "Minimum password length 2 characters")),
            array('type, status', 'numerical', 'integerOnly' => true),
            array('email, password, activkey', 'length', 'max' => 128),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, email, password, activkey, creation_date, lastvisit, type, status', 'safe', 'on' => 'search'),
        );
    }

    public function getById($id)
    {
        $user = Yii::app()->cache->get('user_' . $id);
        if (!$user) {
            $user = self::model()->findByPk($id);
            Yii::app()->cache->set('user_' . $id, $user, 120);
        }
        return $user;
    }

    public function getActivkey($salt)
    {
        return sha1(microtime() . $salt);
    }

    public function getByEmail($email)
    {
        return User::model()->findByAttributes(array('email' => $email));
    }

    public function getSocInfo($serviceName)
    {
        try {
            $user_id = Yii::app()->user->id;
            $eauth = Yii::app()->eauth->getIdentity($serviceName);
            $eauth->redirectUrl = Yii::app()->user->returnUrl;
            $eauth->cancelUrl = $this->createAbsoluteUrl('/');

            if (!$eauth->authenticate())
                return false;
            $atributes = $eauth->getAttributes();
            $atributes['service'] = $serviceName;
            $atributes['user_id'] = ($user_id) ? $user_id : false;

            if (!isset($atributes['id']))
                return false;
            User::setCacheSocInfo($atributes);

            return $atributes;
        } catch (EAuthException $e) {
            Yii::log('AuthException' . $e->getMessage(), 'error', 'application');
            return false;
        }
    }

    public function setCacheSocInfo($info)
    {
        if (empty($info))
            return false;
        Yii::app()->cache->set('user_soc_' . Yii::app()->request->csrfToken, $info, 3600);
        return true;
    }

    public function getCacheSocInfo()
    {
        $info = Yii::app()->cache->get('user_soc_' . Yii::app()->request->csrfToken);
        if (!$info)
            return false;
        return $info;
    }

    public function clearCacheSocInfo()
    {
        return Yii::app()->cache->delete('user_soc_' . Yii::app()->request->csrfToken);
    }

    public function socialCheck($service, $soc_id)
    {
        $userToken = SocToken::model()->findByAttributes(array(
            'soc_id' => $soc_id
        ));
        if (!$userToken)
            return false;

        return array(
            'user' => User::model()->valid()->findByPk($userToken->user_id),
            'token' => $userToken,
        );
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->creation_date = date('Y-m-d H:i:s');
            $this->status = self::STATUS_NOACTIVE;
            $this->type = self::TYPE_USER;
        }

        if (!$this->lang)
            $this->lang = 0;

        return parent::beforeValidate();
    }

    public function beforeSave()
    {
        if ($this->password and !$this->activkey)
            $this->activkey = sha1(microtime() . $this->password);

        return parent::beforeSave();
    }

    protected function afterSave()
    {
        if ($this->isNewRecord) {
            $profile = new UserProfile;
            $profile->user_id = $this->id;
            $profile->sex = UserProfile::SEX_UNKNOWN;
            $profile->save();
        }

        Yii::app()->cache->delete('log_' . $this->id);

        parent::afterSave();
    }

    protected function afterDelete()
    {
        UserProfile::model()->deleteByPk($this->id);
        Spot::model()->updateAll(
                array(
            'status' => Spot::STATUS_REMOVED_SYS,
            'removed_date' => date('Y-m-d H:i:s')
                ), 'user_id=' . $this->id
        );
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
            'wallet' => array(self::HAS_MANY, 'PaymentWallet', 'user_id'),
        );
    }


    public function scopes()
    {
        return array(
            'active' => array(
                'condition' => 'status=' . self::STATUS_ACTIVE,
            ),
            'valid' => array(
                'condition' => 'status=' . self::STATUS_VALID,
            ),
            'notactvie' => array(
                'condition' => 'status=' . self::STATUS_NOACTIVE,
            ),
            'banned' => array(
                'condition' => 'status=' . self::STATUS_BANNED,
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
        $criteria->compare('lang', $this->lang);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
