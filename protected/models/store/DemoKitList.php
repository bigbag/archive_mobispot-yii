<?php

/**
 * This is the model class for table "demo_kit_list".
 */
class DemoKitList extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getDbConnection()
    {
        return Yii::app()->dbStore;
    }

    public function tableName()
    {
        return 'store.demo_kit_list';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('order_id, spot_type, count', 'required'),
            array('order_id, spot_type, count', 'numerical', 'integerOnly' => true),
        );
    }
    
    public function saveFromArray($products, $order_id)
    {
        $success = false;
        $config = DemoKitOrder::getConfig();
        foreach($products as $product_id => $product_count)
        {
            if (!DemoKitOrder::getProduct($product_id))
                continue;
            
            $item = new self();
            $item->order_id = $order_id;
            $item->spot_type = $product_id;
            $item->count = $product_count;
            if ($item->save())
                $success = true;
        }
        
        return $success;
    }
}
