<?php

class DatabaseController extends Controller
{
    public $layout = '//layouts/admin_column1';

    public function actionIndex()
    {
        $sql_code = false;
        $result = false;

        if (isset($_POST['sql_code'])) {
            $sql_code = trim($_POST['sql_code']);


            if (strncasecmp(substr($sql_code, 0, 6), 'select', 6) != 0) {
                Yii::app()->user->setFlash('error', 'Разрешено использовать только запросы на выборку.');
            } else {
                try {
                    $result = Spot::model()->findAllBySql($sql_code);
                } catch (CDbException $exc) {
                    $message = $exc->getMessage();
                    Yii::app()->user->setFlash('error', $message);
                }
            }

        }

        $this->render('index', array(
            'sql_code' => $sql_code,
            'result' => $result,
        ));
    }
}