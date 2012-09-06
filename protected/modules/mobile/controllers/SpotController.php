<?php

class SpotController extends MController
{
    public $layout = '//layouts/mobile';

    public function actionIndex()
    {
        if (Yii::app()->request->getQuery('url', 0)) {
            $url = Yii::app()->request->getQuery('url', 0);
            $spot = Spot::model()->findByAttributes(array('url' => $url));
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
                            $flag = $content->getAttributes();
                            if ($flag['imya_9'] == 1 and empty($_POST['FeedbackContent']['name'])) $error = true;
                            if ($flag['email_9'] == 1 and empty($_POST['FeedbackContent']['email'])) $error = true;
                            if ($flag['telefon_9'] == 1 and empty($_POST['FeedbackContent']['phone'])) $error = true;
                            if ($flag['kommentariy_9'] == 1 and empty($_POST['FeedbackContent']['comment'])) $error = true;

                            $feedback->attributes = $_POST['FeedbackContent'];
                            $feedback->spot_id = $spot->discodes_id;
                            if (!$error and $feedback->validate()) {
                                if ($feedback->save()){
                                    $params['spot_name'] = $spot->name;
                                    $params['name'] = $feedback->name;
                                    $params['email'] = $feedback->email;
                                    $params['phone'] = $feedback->phone;
                                    $params['comment'] = $feedback->comment;
                                    MMail::spot_feedback($spot->user->email, $params);

                                    $this->render('success', array(

                                    ));
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
}