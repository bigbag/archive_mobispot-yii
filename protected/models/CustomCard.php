<?php

/**
 * This is the model class for table "custom_card".
 *
 */
class CustomCard extends CActiveRecord
{
    const TYPE_GUU = 'guu';
    const TYPE_SIMPLE = 'simple';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
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
        return 'custom_card';
    }
    
    public function getNumber()
    {
        $counter = $this->id + 100;
        if ($counter >= 1000) 
            return (string)$counter;
        else 
            return '0' . $counter;
        
    }

    public static function getNextNum($type=self::TYPE_SIMPLE) {
        //$guu_cards = self::model()->findAllByAttributes(array('type'=>self::TYPE_GUU));
        $guu_cards = self::model()->findAll();
        $counter = count($guu_cards) + 100 + 1;
        
        if ($counter >= 1000) 
            return (string)$counter;
        else 
            return '0' . $counter;
        
    }
    
    public static function getDefaults($type) {
        $defaults = array(
            self::TYPE_GUU=>
            array(
                'email' => 'admin@guu.ru',
                'shipping_name' => 'Admin',
                'phone' => 'Admin',
                'address' => 'Рязанский проспект, 99',
                'city' => 'Москва',
                'zip' => '109542',
                'type' => self::TYPE_GUU,
                'shirt_img' => 'guu_card_frame.jpg',
                'number' => self::getNextNum(self::TYPE_GUU),
                'token' => Yii::app()->request->csrfToken,
                'name' => '',
                'position' => '', 
                'department' => '',
            ),
            self::TYPE_SIMPLE=>
             array(
                'email' => '',
                'shipping_name' => '',
                'phone' => '',
                'address' => '',
                'city' => '',
                'zip' => '',
                'type' => self::TYPE_SIMPLE,
                'shirt_img' => 'simple_card_frame.jpg',
                'number' => self::getNextNum(self::TYPE_SIMPLE),
                'token' => Yii::app()->request->csrfToken,
                'name' => '',
                'position' => '', 
                'department' => '',
            )
        );
        
        if (empty($defaults[$type]))
            return false;
        
        return $defaults[$type];
    }
    
    
}
