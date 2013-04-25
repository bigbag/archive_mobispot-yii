<?php

class SpotController extends MController
{
    public $layout = '//layouts/mobile';


    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'application.extensions.kcaptcha.KCaptchaAction',
                'maxLength' => 6,
                'minLength' => 5,
                'foreColor' => array(mt_rand(0, 100), mt_rand(0, 100), mt_rand(0, 100)),
                'backColor' => array(mt_rand(200, 210), mt_rand(210, 220), mt_rand(220, 230))
            ),
        );
    }

    public function actionIndex()
    {
        if (Yii::app()->request->getQuery('url', 0)) {
            $url = Yii::app()->request->getQuery('url', 0);
            $spot = Spot::model()->mobil()->findByAttributes(array('url' => $url));
            if (!isset(Yii::app()->session['spot_view_error']) and $spot) {
				$spotContent=SpotContent::getSpotContent($spot);
				$content = $spotContent['content'];
				$dataKeys = array_keys($content['keys']);
				$fileKeys = array_keys($content['keys'], 'file');
				$addon = '';
				//одна ссылка
				$urlVal = new CUrlValidator;
 
				if((count($content['data']) == 1) && ($urlVal->validateValue($content['data'][$dataKeys[0]]))){
					$this->redirect($content['data'][$dataKeys[0]]);
				}
				//только файлы
				elseif(count($fileKeys) == count($dataKeys)){
					$this->render('/widget/spot/send',	array('content'=>$content));
				}
				//стандартное отображение
				else{
					$this->render('/widget/spot/personal', array('content'=>$content));
				}
            } else {
                $session = Yii::app()->session;
                $session->open();
                if (isset(Yii::app()->session['spot_view_error'])) {
                    $this->redirect(array('error'));
                } else {
                    Yii::app()->session['spot_view_error'] = 1;
                    throw new CHttpException(404, 'The requested page does not exist.');
                }
            }

        } else throw new CHttpException(404, 'The requested page does not exist.');
    }

    public function actionGetCard()
    {
        $url = Yii::app()->request->getQuery('id');
        $spot = Spot::model()->findByAttributes(array('url' => $url));
        if ($spot and $spot->spot_type->key == 'personal') {
            //$content = SpotModel::model()->findByAttributes(array('spot_id' => $spot->discodes_id, 'spot_type_id' => $spot->spot_type_id));
			$spotContent = SpotContent::getSpotContent($spot);
			$content = $spotContent['content'];
            if ($content and isset($content['razreshit-skachivat-vizitku_3'][0])) {

                $data = array();
                if ($content['kontaktyi_3'] !== null) $data = $data + $content['kontaktyi_3'];
                if ($content['sotsseti_3'] !== null) $data = $data + $content['sotsseti_3'];
                if ($content['opisanie_3'] !== null) $data = $data + $content['opisanie_3'];

                $all_field = SpotPersonalField::getPersonalFieldAll();
                $select_field = UserPersonalField::getField($spot->discodes_id);

                if (!$select_field) $select_field = array(9999);

                $text = $this->renderPartial('/widget/vcard',
                    array(
                        'content' => $content,
                        'spot' => $spot,
                        'all_field' => $all_field,
                        'data' => $data,
                        'select_field' => $select_field,
                    ),
                    true);
                header('Content-type: text/x-vcard');
                header('Content-Disposition: attachment; filename="card.vcf"');
                echo $text;
            } else $this->redirect('/');

        } else $this->redirect('/');
    }

    public function actionError()
    {
        if (isset(Yii::app()->session['spot_view_error'])) {
            $form = new ErrorForm();
            if (isset($_POST['ErrorForm'])) {
                $form->attributes = $_POST['ErrorForm'];
                if ($form->validate() and (!isset($_POST['email'][1]))) {
                    unset(Yii::app()->session['spot_view_error']);
                    unset(Yii::app()->session['Yii_Captcha']);
                    $this->redirect('/');
                }
            }
            $this->render('error', array(
                'form' => $form,
            ));
        } else $this->redirect('http://mobispot.com');

    }
}