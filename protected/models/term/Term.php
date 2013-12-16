<?php

/**
* This is the model class for table "term".
*
* The followings are the available columns in table 'term':
* @property integer $id
* @property string $term_id
* @property string $firm_id
* @property string $name
* @property integer $status
* @property integer $type
* @property string $seans_date
* @property string $upload_time
* @property string $upload_period
* @property string $download_time
* @property string $download_period
*/
class Term extends CActiveRecord
{
  const STATUS_VALID = 1;
  const STATUS_BANNED = -1;

  const TYPE_POS = 0;
  const TYPE_VENDING = 1;

  public $parent_firm;
  public $child_firm;

  public function getStatusList()
  {
    return array(
      self::STATUS_VALID => Yii::t('user', 'Активен'),
      self::STATUS_BANNED => Yii::t('user', 'Заблокирован'),
    );
  }

  public function getStatus()
  {
    $data = $this->getStatusList();
    return $data[$this->status];
  }

  public function getTypeList()
  {
    return array(
      self::TYPE_POS => Yii::t('user', 'Платежный'),
      self::TYPE_VENDING => Yii::t('user', 'Вендинговый'),
    );
  }

  public function getType()
  {
    $data = $this->getTypeList();
    return $data[$this->type];
  }

  /**
  * Returns the static model of the specified AR class.
  * @param string $className active record class name.
  * @return Term the static model class
  */
  public static function model($className=__CLASS__)
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
    return 'term.term';
  }

  /**
  * @return array validation rules for model attributes.
  */
  public function rules()
  {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
      array('term_id, firm_id, name, status, type', 'required'),
      array('status, firm_id, type', 'numerical', 'integerOnly'=>true),
      array('term_id', 'length', 'max'=>50),
      array('upload_time, upload_period, download_time, download_period', 'date', 'format'=>'HH:mm:ss'),
      array('term_id', 'unique'),
      array('name', 'length', 'max'=>300),
      // The following rule is used by search().
      // Please remove those attributes that should not be searched.
      array('id, term_id, firm_id, name, status, seans_date, upload_time, upload_period, download_time, download_period', 'safe', 'on'=>'search'),
    );
  }

  /**
  * @return array customized attribute labels (name=>label)
  */
  public function attributeLabels()
  {
    return array(
      'id' => 'ID',
      'term_id' => 'ID',
      'name' => 'Имя',
      'status' => 'Статус',
      'seans_date' => 'Дата сеанса',
      'upload_time' => 'Время отправки отчёта',
      'upload_period' => 'Период между отправками',
      'download_time' => 'Время загрузки конфигурации',
      'download_period' => 'Период между загрузками',
      'firm_id' => 'Владелец',
      'child_firm' => 'Арендатор',
      'type' => 'Тип',
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

    $criteria=new CDbCriteria;

    $criteria->compare('id',$this->id);
    $criteria->compare('t.term_id',$this->term_id,true);
    $criteria->compare('name',$this->name,true);
    $criteria->compare('status',$this->status);
    $criteria->compare('type',$this->type);
    $criteria->compare('seans_date',$this->seans_date,true);
    $criteria->compare('upload_time',$this->upload_time,true);
    $criteria->compare('download_time',$this->download_time,true);
    $criteria->compare('upload_period',$this->upload_period,true);
    $criteria->compare('download_period',$this->download_period,true);

    return new CActiveDataProvider($this, array(
        'criteria' => $criteria,
        'pagination' => array(
          'pageSize' => 30,
        ),
        'sort' => array(
        'defaultOrder' => 't.term_id ASC',),

    ));
  }
}