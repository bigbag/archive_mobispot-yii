<?php

/**
 * This is the model class for table "spot_content".
 *
 * The followings are the available columns in table 'spot':
 * @property integer $discodes_id
 * @property integer $user_id
 * @property integer $lang
 * @property text $content
 */
class SpotContent extends CActiveRecord
{

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
        return 'spot_content';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('discodes_id, user_id, lang', 'required'),
            array('discodes_id, user_id', 'numerical', 'integerOnly' => true),
            array('discodes_id, user_id, lang, content', 'safe', 'on' => 'search'),
        );
    }

    public function beforeValidate()
    {

        if (!$this->lang)
            $this->lang = 'en';
        return parent::beforeValidate();
    }

    public function beforeSave()
    {
        $this->content = serialize($this->content);
        return parent::beforeSave();
    }

    public function afterSave()
    {
        Yii::app()->cache->delete('spot_content_' . $this->discodes_id);
        return parent::beforeSave();
    }

    protected function afterFind()
    {
        $this->content = unserialize($this->content);
        return parent::afterFind();
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'spot' => array(self::BELONGS_TO, 'Spot', 'discodes_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'lang' => array(self::BELONGS_TO, 'Lang', 'lang'),
        );
    }

    public static function getSpotContent($spot)
    {
        $spot_content = Yii::app()->cache->get('spot_content_' . $spot->discodes_id);
        if (!$spot_content) {
            $spot_content = SpotContent::model()->findByAttributes(
                    array(
                'discodes_id' => $spot->discodes_id
                    ), array('order' => 'id DESC')
            );
            if ($spot_content)
                Yii::app()->cache->set('spot_content_' . $spot->discodes_id, $spot_content, 60);
        }
        return $spot_content;
    }

    public function initPersonal($spot, $spotContent = false)
    {
        if (!$spotContent)
            $spotContent = new SpotContent;

        $spotContent->discodes_id = $spot->discodes_id;
        $spotContent->user_id = $spot->user_id;
        $spotContent->lang = $spot->lang;

        $content = array();
        $content['counter'] = 0;
        $content['private'] = 0;
        $content['vcard'] = 0;
        $content['keys'] = array();
        $content['data'] = array();
        $spotContent->content = $content;

        return $spotContent;
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
        $criteria->compare('discodes_id', $this->discodes_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('content', $this->content, true);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            ),
            'sort' => array(
                'defaultOrder' => 'discodes_id ASC',),
        ));
    }

}
