<?php

/**
 * This is the model class for table "page".
 *
 * The followings are the available columns in table 'page':
 * @property integer $id
 * @property integer $lang
 * @property string $creation_date
 * @property string $change_date
 * @property integer $user_id
 * @property string $title
 * @property string $slug
 * @property string $body
 * @property string $template_id
 * @property string $keywords
 * @property string $description
 * @property integer $status
 */
class Page extends CActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    public function getStatusList()
    {
        return array(
            self::STATUS_PUBLISHED => 'Опубликовано',
            self::STATUS_DRAFT => 'Черновик',
        );
    }

    public function getStatus()
    {
        $data = $this->getStatusList();
        return array_key_exists($this->status, $data) ? $data[$this->status]
            : Yii::t('page', '*неизвестно*');
    }

    public function getLang()
    {
        $data = Lang::getLangArray();
        return $data[$this->lang];
    }


    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Page the static model class
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
        return 'page';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('lang, creation_date, change_date, user_id, title, slug, body, template_id', 'required'),
            array('title, slug, description, keywords', 'filter', 'filter' => 'trim'),
            array('title, slug, description, keywords', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('user_id, status', 'numerical', 'integerOnly' => true),
            array('title, slug', 'length', 'max' => 150),
            array('template_id', 'length', 'max' => 300),
            array('keywords, description', 'safe'),
            array('status', 'in', 'range' => array_keys($this->getStatusList())),
            array('slug', 'match', 'pattern' => '/^[a-zA-Z0-9_\-]+$/', 'message' => 'Запрещенные символы в поле {attribute}'),
            array('slug', 'unique'),
            array('id, creation_date, change_date, user_id, title, slug, body, template_id, keywords, description, status', 'safe', 'on' => 'search'),
        );
    }

    public function beforeValidate()
    {
        if (!$this->slug)
            $this->slug = YText::translit($this->title);

        if ($this->isNewRecord) $this->creation_date = new CDbExpression('NOW()');
        if (!$this->change_date) $this->change_date = new CDbExpression('NOW()');

        if (!isset($this->user_id))
            $this->user_id = Yii::app()->user->id;

        return parent::beforeValidate();
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            'template' => array(self::BELONGS_TO, 'PageTemplate', 'template_id'),
            'lang' => array(self::BELONGS_TO, 'Lang', 'lang'),
        );
    }

    public function findBySlug($slug)
    {
        $dependency = new CDbCacheDependency("SELECT change_date FROM page WHERE slug LIKE '" . $slug . "'");
        return $this->cache(36000, $dependency)->find('slug = :slug', array(':slug' => trim($slug)));
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'lang' => 'Язык',
            'creation_date' => 'Дата создания',
            'change_date' => 'Дата изменения',
            'user_id' => 'Пользователь',
            'template_id' => 'Шаблон',
            'title' => 'Заголовок',
            'slug' => 'URL',
            'body' => 'Текст',
            'keywords' => 'Ключевые слова',
            'description' => 'Описание',
            'status' => 'Статус',
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
        $criteria->compare('lang', $this->lang);
        $criteria->compare('creation_date', $this->creation_date, true);
        $criteria->compare('change_date', $this->change_date, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('body', $this->body, true);
        $criteria->compare('template_id', $this->template_id, true);
        $criteria->compare('keywords', $this->keywords, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 30,
            ),
            'sort' => array('defaultOrder' => 'creation_date desc',)
        ));
    }
}