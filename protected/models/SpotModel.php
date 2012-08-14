<?php
class SpotModel extends EMongoSoftDocument
{
    // You still can define a field(s), that always will be defined
    // like in normal EMongoDocument, but this is optional
    public $spot_id;
    public $user_id;
    public $spot_type_id;
    public $lang;

    // As always define the getCollectionName() and model() methods !

    public function getCollectionName()
    {
        return 'mixed_collection';
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}