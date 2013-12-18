<?php

/**
 * This is the model class for table "term_event".
 *
 * The followings are the available columns in table 'term_event':
 * @property integer $id
 * @property integer $term_id
 * @property integer $event_id
 * @property integer $cost
 * @property string $start
 * @property string $stop
 * @property integer $age
 * @property integer $timeout
 */
class TermEvent extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'term_event';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('term_id, event_id', 'required'),
            array('term_id, event_id, cost, age, timeout', 'numerical', 'integerOnly'=>true),
            array('start, stop', 'length', 'max'=>10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, term_id, event_id, cost, start, stop, age, timeout', 'safe', 'on'=>'search'),
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
            'term' => array(self::BELONGS_TO, 'Term', 'term_id'),
            'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'term_id' => 'Term',
            'event_id' => 'Event',
            'cost' => 'Cost',
            'start' => 'Start',
            'stop' => 'Stop',
            'age' => 'Age',
            'timeout' => 'Timeout',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('term_id',$this->term_id);
        $criteria->compare('event_id',$this->event_id);
        $criteria->compare('cost',$this->cost);
        $criteria->compare('start',$this->start,true);
        $criteria->compare('stop',$this->stop,true);
        $criteria->compare('age',$this->age);
        $criteria->compare('timeout',$this->timeout);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * @return CDbConnection the database connection used for this class
     */
    public function getDbConnection()
    {
        return Yii::app()->dbTerm;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TermEvent the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
