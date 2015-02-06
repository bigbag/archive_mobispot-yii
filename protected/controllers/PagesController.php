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
    
    public function actionGuuCardConstrucor()
    {
        $this->layout = '//layouts/page_constructor';
        $this->render('guu_constructor', array('number'=>CustomCard::getGUUNum()));
    }
}