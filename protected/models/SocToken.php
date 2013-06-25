<?php

/**
 * This is the model class for table "soc_token".
 *
 */
class SocToken extends CActiveRecord {

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


  public function getTypeList() {
    return array(
        self::TYPE_GOOGLE=>Yii::t('user', 'google'),
		self::TYPE_FACEBOOK=>Yii::t('user', 'facebook'),
		self::TYPE_TWITTER=>Yii::t('user', 'twitter'),
		self::TYPE_YOUTUBE=>Yii::t('user', 'youtube'),
		self::TYPE_DEVIANTART=>Yii::t('user', 'deviantart'),
		self::TYPE_BEHANCE=>Yii::t('user', 'behance'),
		self::TYPE_VIMEO=>Yii::t('user', 'vimeo'),
		self::TYPE_VK=>Yii::t('user', 'vk'),
		self::TYPE_FOURSQUARE=>Yii::t('user', 'foursquare'),
		self::TYPE_LINKEDIN=>Yii::t('user', 'linkedin'),
		self::TYPE_INSTAGRAM=>Yii::t('user', 'instagram'),
    );
  }

  public function getType() {
    $data=$this->getTypeList();
    return $data[$this->type];
  }

  /**
   * Returns the static model of the specified AR class.
   * @param string $className active record class name.
   * @return User the static model class
   */
  public static function model($className=__CLASS__) {
    return parent::model($className);
  }

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'soc_token';
  }
}