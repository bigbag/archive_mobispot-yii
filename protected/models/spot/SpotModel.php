<?php
class SpotModel extends EMongoSoftDocument
{
    // You still can define a field(s), that always will be defined
    // like in normal EMongoDocument, but this is optional
    public $spot_id;
    public $user_id;
    public $lang_id;
    public $spot_type_id;

    // As always define the getCollectionName() and model() methods !

    public function getCollectionName()
    {
        return 'spot_content';
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function indexes()
    {
        return array(
            'users_index' => array(
                'key' => array(
                    'user_id' => EMongoCriteria::SORT_ASC,
                    'user_id.embeded_field' => EMongoCriteria::SORT_DESC
                ),
                'unique' => false,
            ),
            'spot_index' => array(
                'key' => array(
                    'spot_id' => EMongoCriteria::SORT_ASC,
                    'spot_id.embeded_field' => EMongoCriteria::SORT_DESC
                ),
                'unique' => false,
            ),
        );
    }

    public function rules()
    {
        return array(
            array('spot_id, user_id, lang_id, spot_type_id', 'required'),
        );
    }

    public function setField($obj, $data){
        foreach ($data as $key => $value) {
            $obj->{$key} = $value;
        }
        return $obj;
    }

    public function getContent($lang_id, $spot_id, $user_id, $spot_type_id)
    {

        $content = SpotModel::model()->findByAttributes(array('spot_id' => $spot_id, 'spot_type_id' => $spot_type_id));
        if (!$content) {
            $model = new SpotModel();
            $model->lang_id = $lang_id;
            $model->spot_id = $spot_id;
            $model->user_id = $user_id;
            $model->spot_type_id = $spot_type_id;
            $model->initSoftAttributes(SpotLinkTypeField::getSpotFieldSlug($spot_type_id));
            $model->save();
            $content = $model;
        }
        return $content;
    }
}