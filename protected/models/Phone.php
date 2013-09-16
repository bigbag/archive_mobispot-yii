<?php

/**
 * This is the model class for table "phone".
 *
 */
class Phone extends CActiveRecord
{
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
        $phones=self::model()->with('os')->findAll();
        $brands = array();
        $answer = array();
        
        foreach($phones as $phone)
        {
            if (!isset($brands[$phone->brand]))
                $brands[$phone->brand] = array();
            
            $brands[$phone->brand][] = array('id' => $phone->slug,  'name' => $phone->name, 'year' => $phone->year, 'page' => $phone->page, 'turnNfc' => $phone->os->turn_nfc, 'OS' =>$phone->os->name);
        }
        
        foreach ($brands as $brand=>$models)
        {
            $answer[] = array('brand' => $brand, 'models' => $models);
        }
        
        return str_replace('"', "'", json_encode($answer));
    }

}