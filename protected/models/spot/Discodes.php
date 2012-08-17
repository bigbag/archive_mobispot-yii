<?php

/**
 * This is the model class for table "discodes".
 *
 * The followings are the available columns in table 'discodes':
 * @property integer $id
 * @property integer $status
 * @property integer $premium
 */
class Discodes extends CActiveRecord
{

    const PREMIUM_NO = 0;
    const PREMIUM_YES = 1;

    const STATUS_INIT = 0;
    const STATUS_GENERATED = 1;

    public function getPremiumList()
    {
        return array(
            self::PREMIUM_NO => 'Обычный',
            self::PREMIUM_YES => 'Красивый',
        );
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_INIT => 'Чистый',
            self::STATUS_GENERATED => 'Сгенерирован',
        );
    }

    public function getPremium()
    {
        $data = $this->getPremiumList();
        return $data[$this->premium];
    }

    public function getStatus()
    {
        $data = $this->getStatusList();
        return $data[$this->status];
    }


    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Discodes the static model class
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
        return 'discodes';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, premium', 'required'),
            array('id, status, premium', 'numerical', 'integerOnly' => true),
            array('premium', 'in', 'range' => array_keys($this->getPremiumList())),
            array('status', 'in', 'range' => array_keys($this->getStatusList())),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, status, premium', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'status' => 'Статус',
            'premium' => 'Премиум',
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
        $criteria->compare('status', $this->status);
        $criteria->compare('premium', $this->premium);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 30,
            ),
            'sort' => array('defaultOrder' => 'id ASC',)
        ));
    }
}