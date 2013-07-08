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

}