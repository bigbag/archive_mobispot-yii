<?php

/**
 * This is the model class for table "spot_hard".
 *
 * The followings are the available columns in table 'spot_hard':
 * @property integer $id
 * @property integer $discodes_id
 * @property string $hard_id
 * @property integer $spot_hard_type_id
 * @property string $chip_type
 */
class SpotHard extends CActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SpotHard the static model class
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
        return 'spot_hard';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('discodes_id, hard_id, spot_hard_type_id', 'required'),
            array('discodes_id, spot_hard_type_id', 'numerical', 'integerOnly' => true),
            array('hard_id', 'length', 'max' => 20),
            array('chip_type', 'length', 'max' => 4),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, discodes_id, hard_id, spot_hard_type_id, chip_type', 'safe', 'on' => 'search'),
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
            'discodes' => array(self::BELONGS_TO, 'Discodes', 'discodes_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'discodes_id' => 'Discodes',
            'hard_id' => 'Hard',
            'spot_hard_type_id' => 'Spot Hard Type',
            'chip_type' => 'Chip Type',
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
        $criteria->compare('discodes_id', $this->discodes_id);
        $criteria->compare('hard_id', $this->hard_id, true);
        $criteria->compare('spot_hard_type_id', $this->spot_hard_type_id);
        $criteria->compare('chip_type', $this->chip_type, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
