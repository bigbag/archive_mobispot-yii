<?php

class PagesController extends MController
{

    public function actionReaders()
    {
        $this->layout = '//layouts/page';
        $this->render('readers', array('phones' => Phone::getJsonPhones(), 'devices' => Phone::getJsonDevices()));
    }

    public function actionHelp()
    {
        $this->layout = '//layouts/all';
        $this->render('help', array());
    }

    public function actionDemoKit()
    {
        $this->layout = '//layouts/demo-kit';
        $config = DemoKitOrder::getConfig();
        $this->render(
            'demo_kit',
            array(
                'config'=>$config,
            )
        );
    }
    
    public function actionClients()
    {
        $this->layout = '//layouts/page';
        $this->render('clients');
    }
    
    public function actionCardconstrucor()
    {
        $this->layout = '//layouts/page_constructor';
        $type = 'simple';
        if (Yii::app()->request->getQuery('type', 0)) 
            $type = Yii::app()->request->getQuery('type', 0);
        else
            MHttp::setNotFound();
        
        $card = CustomCard::getDefaults($type);
        if (!$card)
            MHttp::setNotFound();
        
        $this->render('card_constructor', array('card'=>str_replace('"', '&#34;', CJSON::encode($card))));
    }
    
    public function actionTroikaconstructor()
    {
        $valid = 'ieg2g7hg3';
        if (!Yii::app()->request->getQuery('key', 0) or Yii::app()->request->getQuery('key', 0) != $valid)
            MHttp::setNotFound();
        
        $this->layout = '//layouts/troika_constructor';
        $this->render('troika_constructor', array());
        
    }
    
    public function actionTroika()
    {
        $this->layout = '//layouts/page_promo';
        $this->render('troika');
    }
}