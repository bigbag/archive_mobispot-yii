<?php

/**
 * This is the model class for table "firm_term".
 *
 * The followings are the available columns in table 'firm_term':
 * @property integer $id
 * @property integer $term_id
 * @property integer $firm_id
 * @property integer $child_firm_id
 * @property string $creation_date
 */
class FirmTerm extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'firm_term';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('term_id, firm_id, creation_date', 'required'),
            array('term_id, firm_id, child_firm_id', 'numerical', 'integerOnly'=>true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, term_id, firm_id, child_firm_id, creation_date', 'safe', 'on'=>'search'),
        );
    }

    public function beforeSave()
    {
        if !($this->creation_date) $this->creation_date = date('Y-m-d H:i:s');
        if !($this->child_firm_id) $this->child_firm_id = $this->firm_id ;

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
            'child_firm' => array(self::BELONGS_TO, 'Firm', 'child_firm_id'),
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
            'firm_id' => 'Firm',
            'child_firm_id' => 'Child Firm',
            'creation_date' => 'Creation Date',
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
        $criteria->compare('firm_id',$this->firm_id);
        $criteria->compare('child_firm_id',$this->child_firm_id);
        $criteria->compare('creation_date',$this->creation_date,true);

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
     * @return FirmTerm the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
