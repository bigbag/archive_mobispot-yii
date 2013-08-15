<?php

class AjaxController extends MController
{

    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'application.extensions.kcaptcha.KCaptchaAction',
                'maxLength' => 6,
                'minLength' => 5,
                'foreColor' => array(
                    mt_rand(0, 100),
                    mt_rand(0, 100),
                    mt_rand(0, 100)
                )
            //'backColor'=>array(mt_rand(200, 210), mt_rand(210, 220), mt_rand(220, 230))
            )
        );
    }

    // Динамическая подгрузка блока с кодом
    public function actionGetBlock()
    {
        if (!Yii::app()->request->isPostRequest)
        {
            $this->setBadReques();
        }

        $error = "yes";
        $content = "";

        $data = $this->getJson();
        if (!isset($data['model']))
            $data['model'] = false;

        if (isset($data['content']))
        {
            $content = $this->renderPartial('//block/' . $data['content'], array(
                'model' => $data["model"]
                    ), true);
            $error = "no";
        }

        echo json_encode(array(
            'error' => $error,
            'content' => $content
        ));
    }

    public function formatText($text, $font, $font_size, $width_text)
    {
        $data = array();

        $text = explode(' ', $text);
        $text_new = '';
        foreach ($text as $word)
        {
            $box = imagettfbbox($font_size, 0, $font, $text_new . ' ' . $word);
            if ($box[2] > $width_text - 10)
            {
                $text_new .= "\n" . $word;
            }
            else
            {
                $text_new .= " " . $word;
            }
        }
        $text_ = trim($text_new);
        $box = imagettfbbox($font_size, 0, $font, $text_new);

        $data['width'] = $box[2] - $box[1];
        $data['text'] = $text_new;
        return $data;
    }
}