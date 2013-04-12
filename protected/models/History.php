<?php

/**
 * This is the model class for table "history".
*/

/*
status:
0 - draft
1 - order

3 - paid / complete
*/

class History extends CActiveRecord {

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
	
    public function getDbConnection(){
        return Yii::app()->dbStore;
    }
 
    public function tableName()
    {
        return 'store.history';
    }

}
