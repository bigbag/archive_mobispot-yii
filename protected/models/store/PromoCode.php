<?php

/**
 * This is the model class for table "promo_code".
 *
 */
class PromoCode extends CActiveRecord
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
        return 'store.promo_code';
    }

    public function beforeSave()
    {
        $this->products = serialize($this->products);
        return parent::beforeSave();
    }

    protected function afterFind()
    {
        $this->products = unserialize($this->products);
        return parent::afterFind();
    }

}