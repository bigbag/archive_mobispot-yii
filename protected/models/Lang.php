<?php

/**
 * This is the model class for table "lang".
 *
 * The followings are the available columns in table 'lang':
 * @property integer $id
 * @property string $name
 * @property string $desc
 */
class Lang extends CActiveRecord
{
    const DEFAULT_DESC = 'en';
    const DEFAULT_ID = 0;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Lang the static model class
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
        return 'lang';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, desc', 'required'),
            array('name', 'length', 'max' => 10),
            array('desc', 'length', 'max' => 150),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, desc', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    public function setCurrentLang()
    {
        $all_lang = Lang::getLangArray();
        $select_lang = 'en';

        if (isset(Yii::app()->request->cookies['lang'])) {
            $select_lang = Yii::app()->request->cookies['lang']->value;
        } elseif (Yii::app()->user->id) {
            $user = User::getById(Yii::app()->user->id);
            $select_lang = $user->lang;
        } else {
            $lang_request = Yii::app()->getRequest()->getPreferredLanguage();
            $select_lang = substr($lang_request,0,1);
        }

        if (!isset($all_lang[$select_lang])) $select_lang = 'ru';

        Yii::app()->request->cookies['lang'] = new CHttpCookie('lang', $select_lang);
        Yii::app()->language = $select_lang;
    }


    public function getCurrentLang()
    {
        $current_lang = Yii::app()->request->cookies['lang'];
        if ($current_lang and !empty(Yii::app()->request->cookies['lang']->value)) 
            return Yii::app()->request->cookies['lang']->value;
        return self::DEFAULT_DESC;
    }


    public static function getLangArray()
    {
        $lang = Yii::app()->cache->get('lang_array');
        if (!$lang) {
            $lang = CHtml::listData(
                Lang::model()->findAll(array('order' => 'name')),
                'name',
                'desc'
            );

            Yii::app()->cache->set('lang_array', $lang, 36000);
        }
        return $lang;
    }

    protected function afterSave()
    {
        Yii::app()->cache->delete('lang_array');

        parent::afterSave();
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('desc', $this->desc, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
