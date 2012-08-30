<?php
class SpotModel extends EMongoSoftDocument
{
    // You still can define a field(s), that always will be defined
    // like in normal EMongoDocument, but this is optional
    public $spot_id;
    public $user_id;
    public $lang_id;

    // As always define the getCollectionName() and model() methods !

    public function getCollectionName()
    {
        return 'spot_content1';
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function setDefault($lang_id, $spot_id, $user_id, $spot_type_id){

        $model = new SpotModel();
        $model->lang_id = $lang_id;
        $model->spot_id = $spot_id;
        $model->user_id = $user_id;
        $model->initSoftAttributes(SpotLinkTypeField::getSpotFieldSlug($spot_type_id));
        $model->save();
    }
}