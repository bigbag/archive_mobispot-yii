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

    // Отправка вопроса
    public function actionSendQuestion()
    {
        if (!Yii::app()->request->isPostRequest)
        {
            $this->setBadReques();
        }
        $error = "yes";
        $content = "";

        $data = $this->getJson();


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

    // public function actionCouponGenerate()
    // {
    //     if (isset($_POST['Coupon']) and isset($_POST['Coupon']['spot_id'])) {
    //         foreach ($_POST['Coupon'] as $key => $value) {
    //             ${$key} = $value;
    //         }
    //         $body_color = ($_POST['Coupon']['body_color']) ? '0x' . substr($_POST['Coupon']['body_color'], 1) : 0xFFFFFF;
    //         $text_color = ($_POST['Coupon']['text_color']) ? '0x' . substr($_POST['Coupon']['text_color'], 1) : 0x000000;
    //         $width  = 300;
    //         $height = 200;
    //         $font   = Yii::getPathOfAlias('webroot.fonts.') . '/helveticaneuecyr-roman-webfont.ttf';
    //         $image = imagecreatetruecolor($width, $height);
    //         imagefill($image, 0, 0, $body_color);
    //         if ($logo) {
    //             $logo_file = imagecreatefrompng(Yii::getPathOfAlias('webroot.uploads.spot.') . '/' . $logo);
    //             $logo_x    = imagesx($logo_file);
    //             $logo_y    = imagesy($logo_file);
    //             imagecopymerge($image, $logo_file, (imagesx($image) - $logo_x) / 2, 10, 0, 0, $logo_x, $logo_y, 100);
    //             //unlink(Yii::getPathOfAlias('webroot.uploads.spot.').'/'.$logo);
    //         }
    //         if ($text) {
    //             $font_size = 12;
    //             $data = $this->formatText($text, $font, 12, 290);
    //             imagefttext($image, $font_size, 0, ($width - $data['width']) / 2, 100, $text_color, $font, $data['text']);
    //         }
    //         $time_text = '';
    //         if (!empty($hour_up))
    //             $time_text .= $hour_up;
    //         if (!empty($hour_up) and !empty($minute_up))
    //             $time_text .= ':';
    //         if (!empty($minute_up))
    //             $time_text .= $minute_up;
    //         if (!empty($hour_up) or !empty($minute_up) or !empty($hour_down) or !empty($minute_down))
    //             $time_text .= '-';
    //         if (!empty($hour_down))
    //             $time_text .= $hour_down;
    //         if (!empty($hour_down) and !empty($minute_down))
    //             $time_text .= ':';
    //         if (!empty($minute_down))
    //             $time_text .= $minute_down;
    //         $data = $this->formatText($time_text, $font, 10, 300);
    //         imagefttext($image, 10, 0, ($width - $data['width']) / 2, 190, $text_color, $font, $data['text']);
    //         $date_text = '';
    //         if (!empty($day_up))
    //             $date_text .= $day_up;
    //         if (!empty($month_up) and !empty($day_up))
    //             $date_text .= '.';
    //         if (!empty($month_up))
    //             $date_text .= $month_up;
    //         if (!empty($year_up) and !empty($month_up))
    //             $date_text .= '.';
    //         if (!empty($year_up))
    //             $date_text .= $year_up;
    //         if ((!empty($month_up) or !empty($day_up) or !empty($year_up)) and (!empty($month_down) or !empty($day_down) or !empty($year_down)))
    //             $date_text .= '-';
    //         if (!empty($day_down))
    //             $date_text .= $day_down;
    //         if (!empty($month_down) and !empty($day_down))
    //             $date_text .= '.';
    //         if (!empty($month_down))
    //             $date_text .= $month_down;
    //         if (!empty($year_down) and !empty($month_down))
    //             $date_text .= '.';
    //         if (!empty($year_down))
    //             $date_text .= $year_down;
    //         $data = $this->formatText($date_text, $font, 10, 300);
    //         imagefttext($image, 10, 0, ($width - $data['width']) / 2, 160, $text_color, $font, $data['text']);
    //         $file_path = Yii::getPathOfAlias('webroot.uploads.spot.') . '/';
    //         $file_name = $spot_id . '_' . time() . '_coupon.png';
    //         imagepng($image, $file_path . $file_name);
    //         echo json_encode(array(
    //             'file' => $file_name
    //         ));
    //     }
    // }
}