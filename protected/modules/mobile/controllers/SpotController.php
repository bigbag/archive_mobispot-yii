<?php

class SpotController extends MController
{
    public $layout = '//layouts/mobile';

    public function actionIndex()
    {
        if (Yii::app()->request->getQuery('url', 0)) {
            $url = Yii::app()->request->getQuery('url', 0);
            $spot = Spot::model()->used()->findByAttributes(array('url' => $url));
            if ($spot) {
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
                                    MMail::spot_feedback($spot->user->email, $params);

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

                            if ($form->validate()){

                                if (!empty($content->fayl_10)){
                                    $file = $content->fayl_10;
                                    if (isset($file[1])){
                                        $data['spot_id'] = $spot->discodes_id;
                                        $data['spot_name'] = $spot->name;
                                        $data['files'] = $file;
                                        MMail::spot_send($form->email, $data);
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

            } else
                throw new CHttpException(404, 'The requested page does not exist.');
        } else throw new CHttpException(404, 'The requested page does not exist.');
    }

    public function actionSuccess()
    {
        $this->render('success', array(

        ));
    }
}