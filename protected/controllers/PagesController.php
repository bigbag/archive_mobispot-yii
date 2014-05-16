<?php

class PagesController extends MController
{

    public function actionReaders()
    {
        $this->layout = '//layouts/all';
        $this->render('readers', array('phones' => Phone::getJsonPhones(), 'devices' => Phone::getJsonDevices()));
    }

    public function actionHelp()
    {
        $this->layout = '//layouts/all';
        $this->render('help', array());
    }

    public function actionDemoKit()
    {
        $this->layout = '//layouts/all';
        $config = DemoKitOrder::getConfig();
        $this->render(
            'demo_kit', 
            array(
                'config'=>$config,
            )
        );
    }
}
