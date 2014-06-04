<?php

/**
 * This is the model class for table "firm".
 *
 * The followings are the available columns in table 'firm':
 * @property integer $id
 * @property string $name
 * @property string $inn
 * @property string $sub_domain
 * @property string $logo
 * @property string $address
 * @property string $email
 * @property string $report_email
 * @property string $report_excel
 * @property string $report_time
 * @property string $sending_date
 */
class Firm extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PaymentHistory the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return CDbConnection database connection
     */
    public function getDbConnection()
    {
        return Yii::app()->dbTerm;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'firm';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, inn, sub_domain, email, report_excel', 'required'),
            array('name', 'length', 'max' => 300),
            array('inn', 'length', 'max' => 50),
            array('sub_domain', 'length', 'max' => 200),
            array('logo, address, report_email, report_time, sending_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, inn, sub_domain, logo, address, email, report_email, report_excel, report_time, sending_date', 'safe', 'on' => 'search'),
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
            'name' => 'Name',
            'inn' => 'Inn',
            'sub_domain' => 'Sub Domain',
            'logo' => 'Logo',
            'address' => 'Address',
            'email' => 'Email',
            'report_email' => 'Report Email',
            'report_excel' => 'Report Excel',
            'report_time' => 'Report Time',
            'sending_date' => 'Sending Date',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('inn', $this->inn, true);
        $criteria->compare('sub_domain', $this->sub_domain, true);
        $criteria->compare('logo', $this->logo, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('report_email', $this->report_email, true);
        $criteria->compare('report_excel', $this->report_excel, true);
        $criteria->compare('report_time', $this->report_time, true);
        $criteria->compare('sending_date', $this->sending_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}
