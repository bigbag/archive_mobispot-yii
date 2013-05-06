<?php

class UserController extends MController {

  public $defaultAction='account';

  // Вывод профиля
  public function actionProfile() {
    if (!Yii::app()->user->id) {
      $this->setAccess();
    } else {
      $profile=UserProfile::model()->findByPk(Yii::app()->user->id);

      $user_id=Yii::app()->user->id;
      $personal_photo=Yii::app()->cache->get('personal_photo_'.$user_id);

      if ($personal_photo=false) {
        if (!empty($profile->photo))
          Yii::app()->cache->set('personal_photo_'.$user_id, $profile->photo, 3600);
      }
      else
        $profile->photo=Yii::app()->cache->get('personal_photo_'.$user_id);

      if (isset($_POST['UserProfile'])) {
        $profile->attributes=$_POST['UserProfile'];

        if ($profile->validate()) {
          $profile->save();
          Yii::app()->cache->delete('personal_photo_'.$user_id);
          $this->refresh();
        }
      }

      $this->render('profile', array(
          'profile'=>$profile,
      ));
    }
  }

  // Страница управления персональными спотами
  public function actionPersonal() {
    $this->layout='//layouts/spots';

    if (!Yii::app()->user->id) {
      $this->setAccess();
    } else {
      $user_id=Yii::app()->user->id;
      $user=User::model()->findByPk($user_id);

      if ($user->status==User::STATUS_ACTIVE)
        $this->redirect('/');

      $dataProvider=new CActiveDataProvider(
        Spot::model()->personal()->used()->selectUser($user_id),
        array(
          'pagination'=>array(
              'pageSize'=>100,
          ),
          'sort'=>array('defaultOrder'=>'registered_date desc'),
      ));

      $this->render('personal', array(
          'dataProvider'=>$dataProvider,
          'spot_type_all'=>SpotType::getSpotTypeArray(),
      ));
    }
  }

  public function actionUploadFile() {
    if (!empty($_FILES)) {
      $spot_id=$_POST['spot_id'];

      $tempFile=$_FILES['Filedata']['tmp_name'];
      $targetPath=Yii::getPathOfAlias('webroot.uploads.spot.').'/';
      $targetFileName=$spot_id.'_'.time().'_'.$_FILES['Filedata']['name'];
      $targetFile=rtrim($targetPath, '/').'/'.$targetFileName;

      move_uploaded_file($tempFile, $targetFile);

      echo json_encode(array('file'=>$targetFileName));
    }
  }

  public function actionUploadCouponLogo() {
    if (!empty($_FILES)) {

      $spot_id=$_POST['spot_id'];
      $tempFile=$_FILES['Filedata']['tmp_name'];

      $targetPath=Yii::getPathOfAlias('webroot.uploads.spot.').'/';
      $targetFileName=$spot_id.'_'.time().'.png';
      $targetFile=rtrim($targetPath, '/').'/'.$targetFileName;

      $image=new CImageHandler();
      $image->load($tempFile);
      if ($image->thumb(70, 70, true)) {
        $image->save($targetFile, 3);
        echo json_encode(array('file'=>$targetFileName));
      }
      else
        echo json_encode(array('error'=>Yii::t('images', 'Загруженный файл не является изображением.')));
    }
  }

  public function actionUpload() {
    if (!empty($_FILES)) {
      $action=$_POST['action'];
      $tempFile=$_FILES['Filedata']['tmp_name'];

      $fileParts=pathinfo($_FILES['Filedata']['name']);

      $fileName=$action.'_'.md5(time().$fileParts['basename']);
      $targetFileName=$fileName.'.jpg';

      $targetPath=Yii::getPathOfAlias('webroot.uploads.spot.').'/';

      $image=new CImageHandler();
      $image->load($tempFile);
      if ($image->thumb(400, 600, true)) {
        $image->save($targetPath.$fileName.'.jpg');
        echo json_encode(array('file'=>$targetFileName));
      }
      else
        echo json_encode(array('error'=>Yii::t('images', 'Загруженный файл не является изображением.')));
    }
  }

	public function actionSocLogin(){
		$service = Yii::app()->request->getQuery('service');
		$sinfo = new SocInfo;
		if (isset($service)) {
		
			$authIdentity = Yii::app()->eauth->getIdentity($service);
			$authIdentity->redirectUrl = Yii::app()->user->returnUrl;
			$authIdentity->cancelUrl = $this->createAbsoluteUrl('user/personal');
			
			if ($authIdentity->authenticate()) {
				$identity = new ServiceUserIdentity($authIdentity);

				if ($identity->authenticate()) {
					Yii::app()->session[$service] = 'auth';
					
					$authIdentity->redirect(array('user/personal'));
				}
				else {
					$authIdentity->cancel();
				}
			}
		}
		$this->redirect(array('user/personal'));		
	}
}