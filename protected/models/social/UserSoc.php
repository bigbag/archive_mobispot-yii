<?php

/**
 * This is the model class for table "user_soc".
 *
 */
class UserSoc extends CActiveRecord
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

    public function getTypeList()
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
        $data = $this->getTypeList();
        return $data[$this->type];
    }

    public function beforeSave()
    {
        $this->data = serialize($this->data);
        return parent::beforeSave();
    }

    protected function afterFind()
    {
        $this->data = unserialize($this->data);
        return parent::afterFind();
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
        return 'user_soc';
    }

}
