<?php

class SpotController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/admin_column2';

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function getDisId($premium, $type, $activate = 0, $count)
    {

        $dis_cod = Discodes::model()->findAll(array(
            'select' => 'id',
            'condition' => 'status=0 and premium=:premium',
            'params' => array(':premium' => $premium),
            'limit' => $count
        ));

        if ($dis_cod) {

            $length = Spot::SYMBOL_LENGTH;

            foreach ($dis_cod as $row) {

                $code = '';
                if ($type == Spot::TYPE_PERSONA) $symbols = Spot::SYMBOL_PERSONA;
                else $symbols = Spot::SYMBOL_FIRM;

                $id = $row->id;

                $symbols = str_split($symbols);
                shuffle($symbols);

                $max = count($symbols) - 1;
                for ($i = 0; $i < $length; $i++) {
                    $code .= $symbols[rand(0, $max)];
                }

                $positions = range(0, 9);
                shuffle($positions);
                $positions = array_slice($positions, 0, strlen($id));
                sort($positions);

                for ($i = 0; $i < strlen($id); $i++) {
                    $code[$positions[$i]] = $id[$i];
                }

                $dis = Discodes::model()->findByPk($id);
                $dis->status = Discodes::STATUS_GENERATED;
                $dis->save();

                $spot = new Spot();
                $spot->discodes_id = $id;

                if ($activate == 1) $spot->status = Spot::STATUS_ACTIVATED;
                else $spot->status = Spot::STATUS_GENERATED;

                $spot->code = $code;
                $spot->premium = $dis->premium;
                $spot->type = $type;
                $spot->save();
            }
            return true;
        }
        return false;
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Spot'])) {
            $model->attributes = $_POST['Spot'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete()
    {
        $flag = false;
        $dis_id = 0;
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $id = explode('|', $id);
            if (isset($id[0])) {
                foreach ($id as $row) {
                    $spot = Spot::model()->findByPk((int)$row);
                    if ($spot) {
                        if ($spot->status == Spot::STATUS_GENERATED or $spot->status == Spot::STATUS_ACTIVATED) {
                            $dis_id = $spot->discodes_id;
                            if ($spot->delete()) {
                                $flag = true;
                            }
                        }
                    }
                }
            }
        }
        if (!isset($_GET['ajax'])) {
            if ($flag) Yii::app()->user->setFlash('spot', 'Спот ID ' . $dis_id . ' удалён.');
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : '/admin/spot');
        }

    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $this->layout = '//layouts/admin_column1';
        $model = new Spot('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Spot']))
            $model->attributes = $_GET['Spot'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionActivate()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $id = explode('|', $id);
            if (isset($id[0])) {
                foreach ($id as $row) {
                    $spot = Spot::model()->findByPk((int)$row);
                    if ($spot and $spot->status == Spot::STATUS_GENERATED) {
                        $spot->status = Spot::STATUS_ACTIVATED;
                        $spot->save();
                    }
                }
            }
        }

        if (!isset($_GET['ajax'])) {
            Yii::app()->user->setFlash('spot', 'Спот активирован.');
            $referer = Yii::app()->request->getUrlReferrer();
            $this->redirect($referer);
        }
    }

    public function actionNfc()
    {
        if (Yii::app()->request->getQuery('id', 0)) {
            $id = (int)Yii::app()->request->getQuery('id', 0);

        }
    }

    public function actionGenerate()
    {
        if (isset($_POST['SpotGenerate'])) {
            $count = (int)$_POST['SpotGenerate']['count'];
            if ($count < 1) $count = 1;

            $premium = (int)$_POST['SpotGenerate']['premium'];
            $type = (int)$_POST['SpotGenerate']['type'];
            $activate = (int)$_POST['SpotGenerate']['activate'];

            if ($this->getDisId($premium, $type, $activate, $count)) {
                if ($activate == 1) $message = 'Споты сгенерированы и активированы.';
                else $message = 'Споты сгенерированы.';
                Yii::app()->user->setFlash('spot', $message);
                $this->redirect('/admin/spot');
            }
        }
        $this->render('generate');
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = Spot::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'spot-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
