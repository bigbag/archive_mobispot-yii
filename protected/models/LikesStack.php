<?php

/**
 * This is the model class for table "likes_stack".
 *
 * The followings are the available columns in table 'likes_stack':
 * @property integer $id
 * @property integer $token_id
 * @property integer $loyalty_id
 *
 */
class LikesStack extends CActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LikesStack the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getDbConnection()
    {
        return Yii::app()->dbStack;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'stack.likes_stack';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('token_id, loyalty_id', 'required'),
            array('token_id, loyalty_id', 'numerical', 'integerOnly' => true),
        );
    }

}
