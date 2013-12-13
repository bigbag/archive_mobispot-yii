<?php

class HelpController extends MController
{

    public $layout = '//corp/layouts/all';

    public function actionIndex()
    {
        $this->render('index', array(
        ));
    }

    //Отсылка вопроса
    public function actionSendQuestion()
    {
        $data = $this->validateRequest();
        $error = "yes";
        $content = '';
        $data = $this->getJson();

        if (isset($data['email']) and isset($data['name']) and isset($data['question']))
        {
            MMail::question(Yii::app()->par->load('generalEmail'), $data, $this->getLang());
            $content = Yii::t('help', 'Вопрос отправлен');
            $error = "no";
        }
        echo json_encode(array('error' => $error, 'content' => $content));
    }
}