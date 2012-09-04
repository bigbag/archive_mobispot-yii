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
                if (isset($_POST['password']) and Yii::app()->hasher->checkPassword($_POST['password'], $user->password)) {
                    $profile->attributes = $_POST['UserProfile'];
                    $sex = $profile->sex;
                    if (isset($sex[1])) $profile->sex = UserProfile::SEX_UNKNOWN;
                    if ($profile->validate()) {
                        $profile->save();
                        Yii::app()->cache->delete('personal_photo_' . $user_id);
                        $this->refresh();
                    }
                } else {
                    Yii::app()->user->setFlash('profile', Yii::t('profile', "Для изменения профиля вы должны вести свой пароль."));
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
}