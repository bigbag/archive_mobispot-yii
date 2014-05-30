<?php

/**
 * This is the model class for table "soc_token".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property integer $type
 * @property integer $user_id
 * @property string $soc_id
 * @property string $soc_email
 * @property string $user_token
 * @property string $token_secret
 * @property integer $token_expires
 * @property integer $is_tech
 * @property integer $allow_login
 * @property string $soc_username
 * @property string $refresh_token
 */
class SocToken extends CActiveRecord
{

    const TYPE_GOOGLE = 0;
    const TYPE_FACEBOOK = 1;
    const TYPE_TWITTER = 2;
    const TYPE_YOUTUBE = 3;
    const TYPE_DEVIANTART = 4;
    const TYPE_BEHANCE = 5;
    const TYPE_VIMEO = 6;
    const TYPE_VK = 7;
    const TYPE_FOURSQUARE = 8;
    const TYPE_LINKEDIN = 9;
    const TYPE_INSTAGRAM = 10;
    const TYPE_TUMBLR = 11;

    public static function getTypeList()
    {
        return array(
            self::TYPE_GOOGLE => 'google_oauth',
            self::TYPE_FACEBOOK => 'facebook',
            self::TYPE_TWITTER => 'twitter',
            self::TYPE_YOUTUBE => 'youtube',
            self::TYPE_DEVIANTART => 'deviantart',
            self::TYPE_BEHANCE => 'behance',
            self::TYPE_VIMEO => 'vimeo',
            self::TYPE_VK => 'vk',
            self::TYPE_FOURSQUARE => 'foursquare',
            self::TYPE_LINKEDIN => 'linkedin',
            self::TYPE_INSTAGRAM => 'instagram',
        );
    }

    public function getType()
    {
        $data = self::getTypeList();
        return $data[$this->type];
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
        return 'soc_token';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('type, user_id, user_id', 'required'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, type, user_id, soc_id, soc_email, user_token, token_secret, token_expires, is_tech, allow_login, soc_username, refresh_token', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'user_wallet' => array(self::BELONGS_TO, 'User', 'user_id', 'with' => 'wallet'),
        );
    }

    public function getTypeByService($service)
    {
        $ind = -1;
        foreach (self::getTypeList() as $key => $value)
        {
            if ($value == $service)
                return $key;
        }
        return $ind;
    }

    public function setToken($info)
    {
        if (!isset($info['user_id']) or !isset($info['id']))
            return false;

        $userToken = SocToken::model()->findByAttributes(
            array(
                'soc_id'=>$info['id'])
            ); 
        if (!$userToken) $userToken = new SocToken;
        
        $userToken->type = SocToken::getTypeByService($info['service']);
        $userToken->user_id = $info['user_id'];
        $userToken->soc_id = $info['id'];
        $userToken->soc_email = (!empty($info['email'])) ? $info['email'] : Null;
        $userToken->user_token = (!empty($info['auth_token'])) ? $info['auth_token'] : Null;
        $userToken->token_secret = (!empty($info['auth_secret'])) ? $info['auth_secret'] : Null;
        $userToken->token_expires = (!empty($info['expires'])) ? $info['expires'] : Null;
        $userToken->soc_username = (!empty($info['name'])) ? $info['name'] : Null;
        $userToken->allow_login = true;
        
        if (SocInfo::writeAccessBySocInfo($info))
            $userToken->write_access = true;
            
        if ($userToken->save())
            return $userToken;
    }

}
