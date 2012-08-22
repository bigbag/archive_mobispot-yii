<?php

class SiteController extends MController
{
    /**
     * Declares class-based actions.
     */
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

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        $this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact()
    {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                    "Reply-To: {$model->email}\r\n" .
                    "MIME-Version: 1.0\r\n" .
                    "Content-type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    public function actionUpload()
    {
        if (!empty($_FILES)) {
            $maxSize = Yii::app()->par->load('ImageSize');
            $action = $_POST['action'];

            $tempFile = $_FILES['Filedata']['tmp_name'];

            $fileParts = pathinfo($_FILES['Filedata']['name']);

            $fileName = $action . '_' . md5(time() . $fileParts['basename']);
            $targetFileName = $fileName . '.jpg';

            if (filesize($tempFile) < $maxSize * 1024) {
                $targetPath = Yii::getPathOfAlias('webroot.uploads.images.') . '/';

                $image = new CImageHandler();
                $image->load($tempFile);
                if ($image->thumb(95, 95, true)) {
                    $image->save($targetPath . 'tmb_' . $fileName . '.jpg');

                    $image->reload();
                    $image->thumb(300, 300, true);
                    $image->save($targetPath . $fileName . '.jpg');
                    echo $targetFileName;
                } else echo Yii::t('images', 'Загруженный файл не фявляется изображением.');

            } else echo Yii::t('images', 'Максимальный размер файла ') . $maxSize * 1024;
        }
    }

}