<?php

class DefaultController extends Controller
{
    public $layout = '//layouts/mobile';
	public function actionIndex()
	{
		$this->render('index');
	}
}