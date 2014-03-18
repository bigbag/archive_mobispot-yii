<?php

/**
 * This is the model class for table "soc_token".
 *
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
    
    public function getTypeByService($service)
    {
        $ind = -1;
        foreach (self::getTypeList() as $key => $value) {
            if ($value == $service) return $key;
        }
        return $ind;
    }

    public function setToken($info, $user_id)
    {
        $userToken = new SocToken;
        $userToken->type = SocToken::getTypeByService($info['service']);
        $userToken->user_id = $user_id;
        $userToken->soc_id = $info['id'];
        $userToken->allow_login = true;
        $userToken->save();
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
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'user_wallet' => array(self::BELONGS_TO, 'User', 'user_id', 'with'=>'wallet'),
        );
    }
    
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'soc_token';
    }
}