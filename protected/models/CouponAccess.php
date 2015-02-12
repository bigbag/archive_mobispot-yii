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
    
    public static function userAccess()
    {
        $answer = false;
        
        if (Yii::app()->user->isGuest)
            return $answer;
        
        $userSpots = Spot::model()->findAllByAttributes(array('user_id' => Yii::app()->user->id));
        
        if (!count($userSpots))
            return $answer;
        
        $list = $userSpots[0]->discodes_id;
        for($i = 1; $i < count($userSpots); $i++)
            $list .= ',' . $userSpots[$i]->discodes_id;
        
        $criteria = new CDbCriteria;
        $criteria->condition .= ' discodes_id in (' . $list . ')';

        if (CouponAccess::model()->count($criteria))
            $answer = true;

        return $answer;
    }
}
