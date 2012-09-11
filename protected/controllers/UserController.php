<?php

class UserController extends MController
{
    public $defaultAction = 'profile';

    public function actionProfile()
    {
        if (!Yii::app()->user->id) {
            $this->setAccess();
        } else {
            $user = User::model()->findByPk(Yii::app()->user->id);
            $profile = UserProfile::model()->findByPk(Yii::app()->user->id);

            $user_id = Yii::app()->user->id;
            $personal_photo = Yii::app()->cache->get('personal_photo_' . $user_id);

            if ($personal_photo === false) {
                if (!empty($profile->photo)) Yii::app()->cache->set('personal_photo_' . $user_id, $profile->photo, 3600);
            } else $profile->photo = Yii::app()->cache->get('personal_photo_' . $user_id);

            if (isset($_POST['UserProfile'])) {
                    $profile->attributes = $_POST['UserProfile'];
                    $sex = $profile->sex;
                    if (isset($sex[1])) $profile->sex = UserProfile::SEX_UNKNOWN;
                    if ($profile->validate()) {
                        $profile->save();
                        Yii::app()->cache->delete('personal_photo_' . $user_id);
                        $this->refresh();
                    }
            }
            $this->render('profile', array(
                'profile' => $profile,
            ));
        }
    }

    public function actionAccount()
    {
        if (!Yii::app()->user->id) {
            $this->setAccess();
        } else {
            $user_id = Yii::app()->user->id;
            $user = User::model()->findByPk($user_id);

            if ($user->status == User::STATUS_ACTIVE) $this->redirect('/');

            $criteria = new CDbCriteria;
            $criteria->compare('user_id', $user_id);
            $dataProvider = new CActiveDataProvider(Spot::model()->used(),
                array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => 100,
                    ),
                    'sort' => array('defaultOrder' => 'registered_date desc'),
                ));

            $this->render('account', array(
                'dataProvider' => $dataProvider,
                'spot_type_all' => SpotType::getSpotTypeArray(),
            ));
        }
    }

    public function actionUploadFile()
    {
        if (!empty($_FILES)) {
            $spot_id = $_POST['spot_id'];

            $tempFile = $_FILES['Filedata']['tmp_name'];
            $targetPath = Yii::getPathOfAlias('webroot.uploads.spot.') . '/';
            $targetFileName = $spot_id . '_' . time() . '_' . $_FILES['Filedata']['name'];
            $targetFile = rtrim($targetPath, '/') . '/' . $targetFileName;

            move_uploaded_file($tempFile, $targetFile);

            echo json_encode(array('file' => $targetFileName));
        }
    }

    public function actionUploadCouponLogo()
    {
        if (!empty($_FILES)) {

            $spot_id = $_POST['spot_id'];
            $tempFile = $_FILES['Filedata']['tmp_name'];

            $targetPath = Yii::getPathOfAlias('webroot.uploads.spot.') . '/';
            $targetFileName = $spot_id . '_' . time(). '.png';
            $targetFile = rtrim($targetPath, '/') . '/' . $targetFileName;

                $image = new CImageHandler();
                $image->load($tempFile);
                if ($image->thumb(70, 70, true)) {
                    $image->save($targetFile, 3);
                    echo json_encode(array('file' => $targetFileName));

                } else echo json_encode(array('error' => Yii::t('images', 'Загруженный файл не является изображением.')));
        }
    }
}