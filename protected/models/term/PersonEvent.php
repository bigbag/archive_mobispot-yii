<?php

/**
 * This is the model class for table "person_event".
 *
 * The followings are the available columns in table 'person_event':
 * @property integer $id
 * @property integer $person_id
 * @property integer $term_id
 * @property integer $event_id
 * @property integer $firm_id
 * @property integer $timeout
 */
class PersonEvent extends CActiveRecord
{
    const STATUS_ACTIVE = 1
    const STATUS_BANNED = 0

    const LIKE_TIMEOUT = 100000

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'person_event';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('person_id, term_id, event_id, firm_id', 'required'),
            array('person_id, term_id, event_id, firm_id, timeout', 'numerical', 'integerOnly'=>true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, person_id, term_id, event_id, firm_id, timeout', 'safe', 'on'=>'search'),
        );
    }

    public function beforeSave()
    {
        if (!$this->timeout) $this->timeout = 300;
        if (!$this->status) $this->status = self::STATUS_ACTIVE;

        return parent::beforeSave();
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
            'firm' => array(self::BELONGS_TO, 'Firm', 'firm_id'),
            'person' => array(self::BELONGS_TO, 'Person', 'person_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'person_id' => 'Person',
            'term_id' => 'Term',
            'event_id' => 'Event',
            'firm_id' => 'Firm',
            'timeout' => 'Timeout',
        );
    }

    public function addByUserLoyaltyId($user_id, $loyalty_id)
    {
        $result = False;
        $loyalty = Loyalty::model()->findByPk($loyalty_id);
        $wallet = PaymentWallet::model()->findByAttributes(
            array('user_id'=>$user_id)
        );

        if ($loyalty and $wallet ) 
        {
            $person = Person::model()->findByAttributes(
                array(
                    'firm_id'=>$loyalty->firm_id,
                    'payment_id'=>$wallet->payment_id,
                )
            );

            if (!$person)
            {
                $person = new Person();
                $person->name = 'Участник промо-кампании';
                $person->firm_id = $loyalty->firm_id;
                $person->hard_id = $wallet->hard_id;
                $person->payment_id = $wallet->payment_id;
                $person->save();
            }

            foreach ($loyalty->terms_id as $term_id) {
                $personEvent = new PersonEvent():
                $personEvent->person_id = $person->id;
                $personEvent->term_id = $term_id;
                $personEvent->event_id = $loyalty->event_id;
                $personEvent->firm_id = $loyalty->firm_id;
                $personEvent->timeout = self::LIKE_TIMEOUT;

                if ($personEvent->save()) $result = True;
            }
        }

        return $result

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
        $criteria->compare('person_id',$this->person_id);
        $criteria->compare('term_id',$this->term_id);
        $criteria->compare('event_id',$this->event_id);
        $criteria->compare('firm_id',$this->firm_id);
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
     * @return PersonEvent the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
