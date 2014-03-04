<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $photo
 * @property string $description
 * @property string $color
 * @property string $size
 * @property string surface
 */
class StoreProduct extends CActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getDbConnection()
    {
        return Yii::app()->dbStore;
    }

    public function tableName()
    {
        return 'store.product';
    }
    
    public function beforeSave()
    {
        $this->photo = serialize($this->photo);
        $this->color = serialize($this->color);
        $this->surface = serialize($this->surface);
        $this->size = serialize($this->size);
        return parent::beforeSave();
    }

    protected function afterFind()
    {
        $this->photo = unserialize($this->photo);
        $this->color = unserialize($this->color);
        $this->surface = unserialize($this->surface);
        $this->size = unserialize($this->size);
        return parent::afterFind();
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, size', 'required'),
        );
    }
}