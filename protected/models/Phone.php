<?php

/**
 * This is the model class for table "phone".
 *
 */
class Phone extends CActiveRecord
{

    const TYPE_PHONE = 1;
    const TYPE_DEVICE = 2;
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
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'os' => array(self::BELONGS_TO, 'PhoneOS', 'os_id'),
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'phone';
    }
    
    public static function getJsonPhones()
    {
        $phones=self::model()->findAllByAttributes(array(
                    'type' => self::TYPE_PHONE,
                ));
        $brands = array();
        $answer = array();
        
        foreach($phones as $phone)
        {
            if (!isset($brands[$phone->brand]))
            {
                $brands[$phone->brand] = array();
                $brands[$phone->brand]['models'] = array();
                $brands[$phone->brand]['badModels'] = array();
            }
            
            if ($phone->has_trouble)
                $brands[$phone->brand]['badModels'][] = array('id' => $phone->slug,  'name' => $phone->name, 'page' => $phone->page);
            else
                $brands[$phone->brand]['models'][] = array('id' => $phone->slug,  'name' => $phone->name, 'page' => $phone->page);
        }
        
        foreach ($brands as $brand=>$brandPhones)
        {
            if (count($brandPhones['badModels']))
                $answer[] = array('brand' => $brand, 'models' => $brandPhones['models'], 'badModels' => $brandPhones['badModels']);
            else
                $answer[] = array('brand' => $brand, 'models' => $brandPhones['models']);
        }

        return str_replace('"', "'", json_encode($answer));
    }
    
    public static function getJsonDevices()
    {
        $phones=self::model()->findAllByAttributes(array(
                    'type' => self::TYPE_DEVICE,
                ));
        $brands = array();
        $answer = array();
        
        foreach($phones as $phone)
        {
            if (!isset($brands[$phone->brand]))
            {
                $brands[$phone->brand] = array();
                $brands[$phone->brand]['models'] = array();
            }
            
            $brands[$phone->brand]['models'][] = array('id' => $phone->slug,  'name' => $phone->name, 'page' => $phone->page);
        }
        
        foreach ($brands as $brand=>$brandPhones)
        {
            $answer[] = array('brand' => $brand, 'models' => $brandPhones['models']);
        }

        return str_replace('"', "'", json_encode($answer));
    }
}