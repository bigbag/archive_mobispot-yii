<?php

class SiteController extends MController
{

    public function actionIndex()
    {
        $this->layout = '//layouts/all';

        $resolution = $this->getResolution();
        $this->render('index', array('resolution' => $resolution));
    }

    public function actionError()
    {
        $this->layout = '//layouts/error';
        if (!Yii::app()->errorHandler->error)
            $this->setBadRequest();

        $error = Yii::app()->errorHandler->error;

        if (Yii::app()->request->isPostRequest)
            echo $error['message'];
        else
            $this->render('error', $error);
    }

    public function actionUpload()
    {
        $answer = array(
            'error' => "yes",
        );

        if (empty($_FILES))
            $this->getJsonAndExit($answer);

        $maxSize = Yii::app()->par->load('ImageSize');
        $action = Yii::app()->request->getParam('action');

        $tempFile = $_FILES['Filedata']['tmp_name'];
        $user_id = Yii::app()->request->getParam('user_id', 0);

        $fileParts = pathinfo($_FILES['Filedata']['name']);
        $fileName = $action . '_' . md5(time() . $fileParts['basename']);
        $targetFileName = $fileName . '.jpg';

        if (filesize($tempFile) > $maxSize * 1024)
        {
            $answer['error'] = Yii::t('images', 'Maximum file size ') . ($maxSize * 1024) . ' byte.';
            $this->getJsonAndExit($answer);
        }

        $targetPath = Yii::getPathOfAlias('webroot.uploads.images.') . '/';

        $image = new CImageHandler();
        $image->load($tempFile);

        if (!$image->thumb(50, 50, true))
        {
            $answer['error'] = Yii::t('images', 'The uploaded file is not an image');
            $this->getJsonAndExit($answer);
        }

        $image->save($targetPath . 'tmb_' . $fileName . '.jpg');
        $image->reload();
        $image->thumb(260, 300, true);
        $image->save($targetPath . $fileName . '.jpg');
        $answer['file'] = $targetFileName;
        $answer['error'] = 'no';

        echo json_encode($answer);
    }

}
