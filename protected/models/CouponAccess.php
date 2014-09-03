<?php

/**
 * This is the model class for table "coupon_access".
 *
 */
class CouponAccess extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Lang the static model class
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
        return 'coupon_access';
    }

    public static function access($discodes_id)
    {
        $answer = false;

        $access = CouponAccess::model()->findByAttributes(array('discodes_id' => $discodes_id));

        if ($access)
            $answer = true;

        return $answer;
    }
}
