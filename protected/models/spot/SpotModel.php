<?php
class SpotModel extends EMongoSoftDocument
{
    // You still can define a field(s), that always will be defined
    // like in normal EMongoDocument, but this is optional
    public $spot_id;
    public $user_id;

    // As always define the getCollectionName() and model() methods !

    public function getCollectionName()
    {
        return 'mixed_collection';
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function setDefault($spot_id, $user_id, $spot_type_id){

        $model = new SpotModel();
        $model->spot_id = $spot_id;
        $model->user_id = $user_id;
        $model->initSoftAttributes(array('3_imya'));
        $model->save();
    }
}