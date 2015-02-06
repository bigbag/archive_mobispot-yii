<?php

/**
 * This is the model class for table "custom_card".
 *
 */
class CustomCard extends CActiveRecord
{
    
    const TYPE_GUU = 1;
    const TYPE_SIMPLE = 2;
    
    const URL_GUU = 'guu';
    const URL_SIMPLE = 'simple';

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

    public static function getGUUNum() {
        //$guu_cards = self::model()->findAllByAttributes(array('type'=>self::TYPE_GUU));
        $guu_cards = self::model()->findAll();
        $counter = count($guu_cards) + 100 + 1;
        
        if ($counter >= 1000) 
            return (string)$counter;
        else 
            return '0' . $counter;
        
    }
    
    public static function getDefaults($url_part) {
        if ($url_part == self::URL_GUU)
            return array(
                'email' => 'admin@guu.ru',
                'shipping_name' => 'Admin',
                'phone' => 'Admin',
                'address' => 'Рязанский проспект, 99',
                'city' => 'Москва',
                'zip' => '109542',
                'type' => self::TYPE_GUU,
                'shirt_img' => 'guu_card_frame.jpg',
            );
    }
    
    
}
