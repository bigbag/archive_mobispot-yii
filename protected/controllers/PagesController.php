<?php

class PagesController extends MController
{

    public function actionIndex()
    {
        $slug = Yii::app()->request->getQuery('id');

        $model = Page::findBySlug($slug);
        if ($model == null)
            $this->setNotFound();

        $this->render('page', array(
            'model' => $model
        ));
    }

    public function actionHelp()
    {
        $this->render('help', array());
    }

    public function actionSections($id)
    {
        $this->layout = '//layouts/slider';
        $this->render('sections/' . Yii::app()->language . '/' . $id);
    }

        //Отсылка вопроса
    public function actionSendQuestion()
    {
        if (Yii::app()->request->isPostRequest)
        {
            $error = "yes";
            $content = '';
            $data = $this->getJson();

            if (isset($data['token']) and $data['token'] == Yii::app()->request->csrfToken)
            {
                if (isset($data['email']) and isset($data['name']) and isset($data['question']))
                {
                    MMail::question(Yii::app()->par->load('generalEmail'), $data, $this->getLang());
                    $content = Yii::t('help', 'Вопрос отправлен');
                    $error = "no";
                }
            }
            echo json_encode(array('error' => $error, 'content' => $content));
        }
    }

}