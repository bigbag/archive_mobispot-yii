<?php

/**
 * This is the model class for table "term".
 *
 * The followings are the available columns in table 'term':
 * @property integer $id
 * @property integer $type
 * @property string $name
 * @property string $tz
 * @property integer $status
 * @property string $report_date
 * @property string $config_date
 * @property string $blacklist_date
 * @property string $upload_start
 * @property string $upload_stop
 * @property integer $upload_period
 * @property string $download_start
 * @property string $download_stop
 * @property integer $download_period
 * @property integer $blacklist
 * @property integer $settings_id
 * @property string $version
 */
class Term extends CActiveRecord
{
    const STATUS_VALID = 1;
    const STATUS_BANNED = 0;

    const BLACKLIST_ON = 1;
    const BLACKLIST_OFF = 0;

    const TYPE_POS = 0;
    const TYPE_VENDING = 1;

    /**
    * @return string the associated database table name
    */
    public function tableName()
    {
        return 'term';
    }

    /**
    * @return array validation rules for model attributes.
    */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, name', 'required'),
            array('id, type, status, upload_period, download_period, blacklist, settings_id', 'numerical', 'integerOnly'=>true),
            array('name', 'length', 'max'=>300),
            array('tz', 'length', 'max'=>150),
            array('upload_start, upload_stop, download_start, download_stop', 'length', 'max'=>256),
            array('version', 'length', 'max'=>128),
            array('report_date, config_date, blacklist_date', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, type, name, tz, status, report_date, config_date, blacklist_date, upload_start, upload_stop, upload_period, download_start, download_stop, download_period, blacklist, settings_id, version', 'safe', 'on'=>'search'),
        );
    }

    /**
    * @return array customized attribute labels (name=>label)
    */
    public function attributeLabels()
    {
        return array(
        'id' => 'ID',
        'type' => 'Type',
        'name' => 'Name',
        'tz' => 'Tz',
        'status' => 'Status',
        'report_date' => 'Report Date',
        'config_date' => 'Config Date',
        'blacklist_date' => 'Blacklist Date',
        'upload_start' => 'Upload Start',
        'upload_stop' => 'Upload Stop',
        'upload_period' => 'Upload Period',
        'download_start' => 'Download Start',
        'download_stop' => 'Download Stop',
        'download_period' => 'Download Period',
        'blacklist' => 'Blacklist',
        'settings_id' => 'Settings',
        'version' => 'Version',
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
        $criteria->compare('type',$this->type);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('tz',$this->tz,true);
        $criteria->compare('status',$this->status);
        $criteria->compare('report_date',$this->report_date,true);
        $criteria->compare('config_date',$this->config_date,true);
        $criteria->compare('blacklist_date',$this->blacklist_date,true);
        $criteria->compare('upload_start',$this->upload_start,true);
        $criteria->compare('upload_stop',$this->upload_stop,true);
        $criteria->compare('upload_period',$this->upload_period);
        $criteria->compare('download_start',$this->download_start,true);
        $criteria->compare('download_stop',$this->download_stop,true);
        $criteria->compare('download_period',$this->download_period);
        $criteria->compare('blacklist',$this->blacklist);
        $criteria->compare('settings_id',$this->settings_id);
        $criteria->compare('version',$this->version,true);

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
    * @return Term the static model class
    */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
