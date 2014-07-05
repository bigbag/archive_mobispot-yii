<?php

/**
 * This is the model class for table "spot".
 *
 * The followings are the available columns in table 'spot':
 * @property integer $discodes_id
 * @property string $code
 * @property string $name
 * @property string $url
 * @property string $barcode
 * @property integer $type
 * @property integer $lang
 * @property integer $user_id
 * @property integer $premium
 * @property string $generated_date
 * @property string $registered_date
 * @property string $removed_date
 * @property integer $status
 * @property string $code128
 * @property integer $hard_type
 */

class Spot extends CActiveRecord
{
    const STATUS_GENERATED = 0;
    const STATUS_ACTIVATED = 1;
    const STATUS_REGISTERED = 2;
    const STATUS_CLONES = 3;
    const STATUS_REMOVED_USER = 4;
    const STATUS_REMOVED_SYS = 5;
    const STATUS_INVISIBLE = 6;

    const TYPE_DEMO = 0;
    const TYPE_FULL = 3;

    public $spot_type_name;

    public function getAllSpot()
    {
        return array(
            self::TYPE_FULL => Yii::t('spot', 'Full'),
            self::TYPE_DEMO => Yii::t('spot', 'Demo'),
        );
    }

    public function getPremium()
    {
        return Discodes::getPremium();
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Spot the static model class
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
        return 'spot';
    }

    public static function getSpot($data = array())
    {
        return Spot::model()->findByAttributes($data);
    }

    public static function getActivatedSpot($activ_code)
    {
        return Spot::model()->findByAttributes(array(
                    'code' => $activ_code,
                    'status' => Spot::STATUS_ACTIVATED
        ));
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('discodes_id, hard_type, code, status, premium, generated_date', 'required'),
            array('discodes_id, type, hard_type, user_id, premium, status', 'numerical', 'integerOnly' => true),
            array('name', 'filter', 'filter' => 'trim'),
            array('discodes_id', 'unique'),
            array('name', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('url', 'length', 'max' => 128),
            array('name', 'length', 'max' => 300),
            array('code', 'length', 'max' => 10),
            array('barcode', 'length', 'max' => 32),
            array('registered_date, removed_date', 'safe'),
            array('code128, code, hard_type, name, discodes_id, type, spot_type_name, user_id, barcode, premium, status, generated_date, registered_date, removed_date', 'safe', 'on' => 'search'),
        );
    }

    public function scopes()
    {
        return array(
            'all' => array(),
            'personal' => array(
                'condition' => 'type=:type',
                'params' => array(
                    'type' => self::TYPE_FULL,
                ),
            ),
            'used' => array(
                'condition' => 'status=:status1 or status=:status2 or status=:status3',
                'params' => array(
                    ':status1' => self::STATUS_REGISTERED,
                    ':status2' => self::STATUS_CLONES,
                    ':status3' => self::STATUS_INVISIBLE,
                ),
            ),
            'mobil' => array(
                'condition' => 'status=:status1 or status=:status2',
                'params' => array(
                    ':status1' => self::STATUS_REGISTERED,
                    ':status2' => self::STATUS_CLONES,
                ),
            ),
        );
    }

    public function selectUser($user_id)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('user_id', $user_id);
        $this->getDbCriteria()->mergeWith($criteria);
        return $this;
    }

    public function beforeValidate()
    {
        if (!$this->type) $this->type = self::TYPE_FULL;
        if (!$this->lang) $this->lang = 'en';
        if (!$this->name) $this->name = 'My Spot';
        if (!$this->hard_type) $this->hard_type = 1;
        if ($this->isNewRecord) $this->generated_date = date('Y-m-d H:i:s');

        if (!($this->registered_date) and ($this->status == self::STATUS_REGISTERED)) {
            $this->registered_date = date('Y-m-d H:i:s');
        }

        if (!($this->removed_date) and ($this->status == self::STATUS_REMOVED_USER or $this->status == self::STATUS_REMOVED_SYS)) {
            $this->removed_date = date('Y-m-d H:i:s');
        }

        return parent::beforeValidate();
    }

    protected function afterDelete()
    {
        $dis = Discodes::model()->findByPk($this->discodes_id);
        $dis->status = Discodes::STATUS_INIT;
        $dis->save();

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
            'discodes' => array(self::BELONGS_TO, 'Discodes', 'discodes_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'lang' => array(self::BELONGS_TO, 'Lang', 'lang'),
            'hard' => array(self::BELONGS_TO, 'SpotHardType', 'hard_type'),
        );
    }


    public static function getActiveByUserId($user_id, $valid=false)
    {
        if (!$valid) {
            $user = User::model()->findByPk($user_id);
            if (!$user) return false;
        }

        return Spot::model()->used()->findAllByAttributes(
            array('user_id'=>$user_id,),
            array('order'=>'registered_date desc'));
    }

    public function getBindedNets()
    {
        $answer = array();

        $spotContent = SpotContent::getSpotContent($this);
        if (!$spotContent) {
            $spotContent = SpotContent::initPersonal($this, $spotContent);
        }

        $content = $spotContent->content;
        $content_keys = $content['keys'];
        $socInfo = new SocInfo;

        foreach ($content_keys as $key => $type) {
            if ('socnet' == $type)
                $link = $content['data'][$key];
            elseif ('content' == $type)
                $link = $content['data'][$key]['binded_link'];
            else
                continue;

            $net = $socInfo->getNetByLink($link);
            if (empty($net))
                continue;

            $answer[] = $net;
        }

        return $answer;
    }

    public function getNetDown($link)
    {
        $netDown = '';

        $spotNets = $this->getBindedNets();
        $socInfo = new SocInfo;
        $net = $socInfo->getNetByLink($link);
        if (!empty($net) and !SocInfo::nameInList($net['name'], $spotNets))
            $netDown = $net['name'];

        return $netDown;
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

        $criteria->with = 'spot_type';
        $criteria->compare('code', $this->code, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('discodes_id', $this->discodes_id);
        $criteria->compare('type', $this->type);
        $criteria->compare('spot_type.name', $this->spot_type_name, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('barcode', $this->barcode, true);
        $criteria->compare('premium', $this->premium);
        $criteria->compare('status', $this->status);
        $criteria->compare('generated_date', $this->generated_date, true);
        $criteria->compare('registered_date', $this->registered_date, true);
        $criteria->compare('removed_date', $this->removed_date, true);
        $criteria->compare('code128', $this->code128, true);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            ),
            'sort' => array(
                'defaultOrder' => 'generated_date DESC',),
        ));
    }
}
