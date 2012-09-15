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


    public function actionIndex()
    {
        if (Yii::app()->user->id) {
            $user_id = Yii::app()->user->id;


            if (isset($_POST['discodes_id']) and isset($_POST['spot_type'])) {
                Spot::model()->updateByPk((int)$_POST['discodes_id'], array('spot_type_id' => (int)$_POST['spot_type']));
                User::model()->updateByPk($user_id, array('status' => User::STATUS_VALID));
            }

            $user = User::model()->findByPk($user_id);

            if ($user->status == User::STATUS_ACTIVE and $user->type != User::TYPE_ADMIN) {
                $spot = Spot::model()->findByAttributes(array('user_id' => $user_id));
                $spot_type = SpotType::getSpotTypeArray();
                $this->render('index', array(
                    'first' => true,
                    'spot_type' => $spot_type,
                    'spot' => $spot,
                    'user' => $user,
                ));
            } else {
                $criteria = new CDbCriteria;
                $criteria->compare('user_id', $user_id);
                $dataProvider = new CActiveDataProvider(Spot::model()->used(),
                    array(
                        'criteria' => $criteria,
                        'pagination' => array(
                            'pageSize' => 4,
                        ),
                        'sort' => array('defaultOrder' => 'registered_date desc',),
                    ));
                $this->render('index', array(
                    'first' => false,
                    'dataProvider' => $dataProvider,
                    'user' => $user,
                ));
            }
        } else {
            $this->render('index');
        }
    }


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
            $user_id = 0;
            if ($_POST['user_id']) $user_id = $_POST['user_id'];

            $fileParts = pathinfo($_FILES['Filedata']['name']);

            $fileName = $action . '_' . md5(time() . $fileParts['basename']);
            $targetFileName = $fileName . '.jpg';

            if (filesize($tempFile) < $maxSize * 1024) {
                $targetPath = Yii::getPathOfAlias('webroot.uploads.images.') . '/';

                $image = new CImageHandler();
                $image->load($tempFile);
                if ($image->thumb(50, 50, true)) {
                    $image->save($targetPath . 'tmb_' . $fileName . '.jpg');
                    $image->reload();
                    $image->thumb(260, 300, true);
                    $image->save($targetPath . $fileName . '.jpg');

                    $personal_photo = Yii::app()->cache->get('personal_photo_' . $user_id);

                    if ($personal_photo !== false) {
                        @unlink($targetPath . $personal_photo);
                        @unlink($targetPath . 'tmb_' . $personal_photo);
                    }
                    Yii::app()->cache->set('personal_photo_' . $user_id, $targetFileName, 3600);

                    echo json_encode(array('file' => $targetFileName));

                } else echo json_encode(array('error' => Yii::t('images', 'Загруженный файл не является изображением.')));
            } else echo json_encode(array('error' => Yii::t('images', 'Максимальный размер файла ') . $maxSize * 1024 . ' байт.'));
        }
    }
}