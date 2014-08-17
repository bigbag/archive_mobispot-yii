<?php

class SiteController extends MController
{
    const MIN_RESOLUTION = 1280;
    public $defaultResolution = 1280;

    public function getResolution()
    {
        $resolution = $this->defaultResolution;
        if (isset(Yii::app()->request->cookies['resolution'])) {
            $resolution = Yii::app()->request->cookies['resolution']->value;
            if ($resolution < self::MIN_RESOLUTION) $resolution = self::MIN_RESOLUTION;

        }
        return $resolution;
    }

    public function actionIndex()
    {
        $this->layout = '//layouts/general';

        $resolution = $this->getResolution();

        if (MHttp::isHostMobile() and !(Yii::app()->user->isGuest))
            //к списку спотов в моб.версии
            $this->redirect('spot/list');

        $this->renderWithMobile(
            'index',
            array(
                'resolution' => $resolution,
                ),
            '//mobile/spot/login'
        );
    }

    public function actionError()
    {
        $this->layout = '//layouts/all';
        if (!Yii::app()->errorHandler->error)
            MHttp::setBadRequest();

        $error = Yii::app()->errorHandler->error;

        if (Yii::app()->request->isPostRequest)
        {
            echo $error['message'];

        }

        if ((!empty(Yii::app()->session['open_login_form'] and Yii::app()->user->isGuest))
            or
            (isset($error['code']) and $error['code'] == '403')
        )
        {
            $error['openLoginForm'] = true;
            unset(Yii::app()->session['open_login_form']);
        }

        $this->render('error', $error);
    }

    public function actionUpload()
    {
        $answer = array(
            'error' => "yes",
        );

        if (empty($_FILES))
            MHttp::getJsonAndExit($answer);

        $maxSize = Yii::app()->params['imageSize'];
        $action = Yii::app()->request->getParam('action');

        $tempFile = $_FILES['Filedata']['tmp_name'];
        $user_id = Yii::app()->request->getParam('user_id', 0);

        $fileParts = pathinfo($_FILES['Filedata']['name']);
        $fileName = $action . '_' . md5(time() . $fileParts['basename']);
        $targetFileName = $fileName . '.jpg';

        if (filesize($tempFile) > $maxSize * 1024) {
            $answer['error'] = Yii::t('general', 'Maximum file size ') . ($maxSize * 1024) . ' byte.';
            MHttp::getJsonAndExit($answer);
        }

        $targetPath = Yii::getPathOfAlias('webroot.uploads.images.') . '/';

        $image = new CImageHandler();
        $image->load($tempFile);

        if (!$image->thumb(50, 50, true)) {
            $answer['error'] = Yii::t('general', 'The uploaded file is not an image');
            MHttp::getJsonAndExit($answer);
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
