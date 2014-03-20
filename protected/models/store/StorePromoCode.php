<?php

/**
 * This is the model class for table "promo_code".
 * @property integer $id
 * @property string $code
 * @property string $products
 * @property integer $discount
 * @property integer $expires
 * @property integer $is_multifold
 * @property integer $used
 */
class StorePromoCode extends CActiveRecord
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

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('code, products, discount, expires', 'required'),
            array('discount, expires', 'numerical', 'integerOnly' => true),
        );
    }

}
