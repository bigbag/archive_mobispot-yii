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
                $content = SpotModel::model()->findByAttributes(array('spot_id' => $spot->discodes_id, 'spot_type_id' => $spot->spot_type_id));
                $txt = '';

                switch ($spot->spot_type->pattern) {
                    case ('file'):
                        $url = Yii::app()->request->getBaseUrl(true) . '/uploads/spot/' . $content->fayl_6;
                        header("Location: " . $url);
                        break;

                    case ('link'):
                        header("Location: " . YText::formatUrl($content->adres_5));
                        break;

                    case ('feedback'):
                        $feedback = new FeedbackContent();
                        $error = false;
                        if (isset($_POST['FeedbackContent'])) {

                            $post_string = implode('', $_POST['FeedbackContent']);
                            if (!isset($post_string[1])) $error = true;

                            $feedback->attributes = $_POST['FeedbackContent'];
                            $feedback->spot_id = $spot->discodes_id;
                            if (!$error and $feedback->validate()) {
                                if ($feedback->save()) {
                                    $params['spot_name'] = $spot->name;
                                    $params['name'] = $feedback->name;
                                    $params['email'] = $feedback->email;
                                    $params['phone'] = $feedback->phone;
                                    $params['comment'] = $feedback->comment;
                                    MMail::spot_feedback($spot->user->email, $params, $spot->lang);

                                    $txt = $this->renderPartial('/widget/success', array(), true);
                                    break;
                                }
                            }
                        }
                        $txt = $this->renderPartial('/widget/spot/' . $spot->spot_type->pattern,
                            array(
                                'error' => $error,
                                'feedback' => $feedback,
                                'data' => $spot,
                                'content' => $content,
                            ),
                            true);

                        break;

                    case ('send'):
                        $form = new SendForm();
                        if (isset($_POST['SendForm'])) {
                            $form->attributes = $_POST['SendForm'];

                            if ($form->validate()) {
                                $data = array();

                                if (!empty($content->fayl_10)) {
                                    $file = $content->fayl_10;
                                    if (isset($file[1])) {
                                        foreach ($file as $row) {
                                            if (isset($row[1])) {
                                                $data['files'][] = $row;
                                            }
                                        }
                                        $data['spot_id'] = $spot->discodes_id;
                                        $data['spot_name'] = $spot->name;
                                        MMail::spot_send($form->email, $data, $spot->lang);
                                    }
                                }
                                $txt = $this->renderPartial('/widget/success_email', array(), true);
                            }

                        }
                        if (!isset($txt[1])) {
                            $txt = $this->renderPartial('/widget/spot/' . $spot->spot_type->pattern,
                                array(
                                    'form' => $form,
                                ),
                                true);
                        }
                        break;
                    default:
                        $txt = $this->renderPartial('/widget/spot/' . $spot->spot_type->pattern,
                            array(
                                'data' => $spot,
                                'content' => $content,
                            ),
                            true);

                        break;

                }
                $this->render('view', array(
                    'txt' => $txt,
                    'spot' => $spot,
                    'content' => $content,
                ));

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
        if ($spot and $spot->spot_type->pattern == 'personal') {
            $content = SpotModel::model()->findByAttributes(array('spot_id' => $spot->discodes_id, 'spot_type_id' => $spot->spot_type_id));
            if (isset($content['razreshit-skachivat-vizitku_3'][0])) {

                $data = $content['kontaktyi_3'] + $content['sotsseti_3'] + $content['opisanie_3'];

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
        } else $this->redirect('/');

    }
}