<?php

class SiteController extends MController {

  /**
   * Declares class-based actions.
   */
  public function actions() {
    return array(
        'captcha'=>array(
            'class'=>'application.extensions.kcaptcha.KCaptchaAction',
            'maxLength'=>6,
            'minLength'=>5,
            'foreColor'=>array(mt_rand(0, 200), mt_rand(0, 100), mt_rand(0, 100)),
            #'backColor'=>array(mt_rand(200, 210), mt_rand(210, 220), mt_rand(220, 230))
        ),
    );
  }

  public function actionIndex() {
    $this->layout='//layouts/slider';
    $this->render('index');
  }


  public function actionError() {
    if ($error=Yii::app()->errorHandler->error) {
      if (Yii::app()->request->isAjaxRequest)
        echo $error['message'];
      else
        $this->render('error', $error);
    }
  }

  public function actionUpload() {
    if (!empty($_FILES)) {
      $maxSize=Yii::app()->par->load('ImageSize');
      $action=$_POST['action'];
      $tempFile=$_FILES['Filedata']['tmp_name'];
      $user_id=0;
      if ($_POST['user_id'])
        $user_id=$_POST['user_id'];

      $fileParts=pathinfo($_FILES['Filedata']['name']);

      $fileName=$action.'_'.md5(time().$fileParts['basename']);
      $targetFileName=$fileName.'.jpg';

      if (filesize($tempFile) < $maxSize * 1024) {
        $targetPath=Yii::getPathOfAlias('webroot.uploads.images.').'/';

        $image=new CImageHandler();
        $image->load($tempFile);
        if ($image->thumb(50, 50, true)) {
          $image->save($targetPath.'tmb_'.$fileName.'.jpg');
          $image->reload();
          $image->thumb(260, 300, true);
          $image->save($targetPath.$fileName.'.jpg');

          $personal_photo=Yii::app()->cache->get('personal_photo_'.$user_id);

          if ($personal_photo !== false) {
            @unlink($targetPath.$personal_photo);
            @unlink($targetPath.'tmb_'.$personal_photo);
          }
          Yii::app()->cache->set('personal_photo_'.$user_id, $targetFileName, 3600);

          echo json_encode(array('file'=>$targetFileName));
        }
        else
          echo json_encode(array('error'=>Yii::t('images', 'Загруженный файл не является изображением.')));
      }
      else {
        $mess=Yii::t('images', 'Максимальный размер файла ');
        echo json_encode(array('error'=>$mess.($maxSize * 1024).' байт.'));
      }
    }
  }
}