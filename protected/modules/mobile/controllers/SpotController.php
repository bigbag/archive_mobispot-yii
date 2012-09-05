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


                if ($spot->spot_type->pattern == 'file') {
                    $url = Yii::app()->request->getBaseUrl(true) . '/uploads/spot/' . $content->fayl_6;

                    header("Location: " . $url);
                } else {

                    $txt = $this->renderPartial('/widget/spot/' . $spot->spot_type->pattern,
                        array(
                            'data' => $spot,
                            'content' => $content,
                        ),
                        true);
                    $this->render('view', array(
                        'txt' => $txt,
                        'spot' => $spot,
                        'content' => $content,
                    ));

                }
            } else
                throw new CHttpException(404, 'The requested page does not exist.');
        } else throw new CHttpException(404, 'The requested page does not exist.');
    }
}