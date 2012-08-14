<?php

class DefaultController extends Controller
{

    /**
     * Lists all models.
     */
    public $layout = '//layouts/admin_column1';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return CMap::mergeArray(parent::filters(), array(
            'accessControl', // perform access control for CRUD operations
        ));
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => array('index'),
                'users' => UserModule::getAdmins(),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('User', array(
            'criteria' => array(
                'condition' => 'status>' . User::STATUS_BANED,
            ),
            'pagination' => array(
                'pageSize' => Yii::app()->controller->module->user_page_size,
            ),
        ));

        $this->render('/user/index', array(
            'dataProvider' => $dataProvider,
        ));
    }

}