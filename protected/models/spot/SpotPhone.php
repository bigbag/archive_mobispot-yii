<?php

/**
 * This is the model class for table "spot_phone".
 *
 * The followings are the available columns in table 'discodes':
 * @property integer $id
 * @property integer $discodes_id
 * @property integer $phone
 * @property integer $schooll_sms
 */

class SpotPhone extends CActiveRecord
{
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
        return 'spot_phone';
    }
    
    

}
