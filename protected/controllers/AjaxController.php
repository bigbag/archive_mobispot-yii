<?php

class AjaxController extends MController
{
    public function filters()
    {
        return array(
            'ajaxOnly',
        );
    }

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

    public function actionLogin()
    {
        if (Yii::app()->request->isAjaxRequest and isset($_POST['token'])) {
            if ($_POST['token'] == Yii::app()->request->csrfToken) {
                if (isset(Yii::app()->session['login_error_count'])) {
                    $login_error_count = Yii::app()->session['login_error_count'];
                } else $login_error_count = 0;

                if ($login_error_count > 2) {
                    echo 'login_error_count';
                } else {
                    $form = new LoginForm;
                    if (isset($_POST['LoginForm'])) {
                        $form->attributes = $_POST['LoginForm'];
                        $form->rememberMe = true;
                        if ($form->validate()) {
                            $identity = new UserIdentity($form->email, $form->password);
                            $identity->authenticate();
                            $this->lastVisit();
                            unset(Yii::app()->session['login_error_count']);
                            echo true;
                        } else {
                            if ($form->getErrors()) {
                                Yii::app()->session['login_error_count'] = $login_error_count + 1;
                                echo false;
                            }
                        }
                    } else echo false;
                }
            }
        }
    }

    public function actionLoginCaptcha()
    {
        if (Yii::app()->request->isAjaxRequest and isset($_POST['token'])) {
            if ($_POST['token'] == Yii::app()->request->csrfToken) {
                $form = new LoginCaptchaForm();
                if (isset($_POST['LoginCaptchaForm'])) {
                    $form->attributes = $_POST['LoginCaptchaForm'];
                    if ($form->rememberMe == 'on') $form->rememberMe = 1;
                    else $form->rememberMe = 0;
                    if ($form->validate()) {
                        $identity = new UserIdentity($form->email, $form->password);
                        $identity->authenticate();
                        $this->lastVisit();
                        unset(Yii::app()->session['login_error_count']);
                        echo true;
                    } else {
                        //echo json_encode(array('error' => $form->getErrors()));
                        echo false;
                    }
                }
            }
        }
    }


    public function actionLogout()
    {
        if (Yii::app()->request->isAjaxRequest) {
            if (!(Yii::app()->user->isGuest)) {
                Yii::app()->cache->get('user_' . Yii::app()->user->id);
                Yii::app()->user->logout();
                unset(Yii::app()->request->cookies['YII_CSRF_TOKEN']);
                echo true;
            }
            echo false;
        }
    }

    public function actionRecovery()
    {
        if (Yii::app()->request->isAjaxRequest and isset($_POST['token'])) {
            if ($_POST['token'] == Yii::app()->request->csrfToken) {
                $form = new RecoveryForm;
                if (isset($_POST['email'])) {
                    $form->email = $_POST['email'];
                    if ($form->validate()) {
                        $user = User::model()->findByAttributes(array('email' => $form->email));
                        MMail::recovery($user->email, $user->activkey);

                        echo true;
                    } else echo false;
                }
            }
        }
    }

    public function actionRegistration()
    {
        if (Yii::app()->request->isAjaxRequest and isset($_POST['token'])) {
            if ($_POST['token'] == Yii::app()->request->csrfToken) {
                if (isset(Yii::app()->session['registration_error_count'])) {
                    $registration_error_count = Yii::app()->session['registration_error_count'];
                } else $registration_error_count = 0;

                if ($registration_error_count == 0) $model = new RegistrationForm;
                else $model = new RegistrationCaptchaForm;

                if (isset($_POST['RegistrationForm'])) {
                    $model->attributes = $_POST['RegistrationForm'];
                    if ($model->validate()) {
                        if (!empty($model->password) && $model->password == $model->verifyPassword) {
                            $model->activkey = sha1(microtime() . $model->password);
                            $model->password = Yii::app()->hasher->hashPassword($model->password);
                            $model->verifyPassword = $model->password;

                            if ($model->save()) {
                                $spot = Spot::model()->findByAttributes(array(
                                    'code' => $model->activ_code,
                                    'status' => Spot::STATUS_ACTIVATED,
                                ));

                                $spot->user_id = $model->id;
                                $spot->status = Spot::STATUS_REGISTERED;
                                $spot->save();

                                MMail::activation($model->email, $model->activkey);
                                echo true;
                            }
                            unset(Yii::app()->session['registration_error_count']);
                        }
                    } else {
                        Yii::app()->session['registration_error_count'] = $registration_error_count + 1;
                        echo json_encode(array('error' => $model->getErrors()));
                    }
                }
            }
        }
    }

    public function actionSpotRename()
    {
        if (isset($_POST['name']) and isset($_POST['discodes_id'])) {
            $spot = Spot::model()->findByPk((int)$_POST['discodes_id']);
            if ($spot) {
                $spot->name = CHtml::encode($_POST['name']);
                if ($spot->save()) {
                    echo json_encode(array('discodes_id' => $spot->discodes_id, 'name' => mb_substr($spot->name, 0, 45, 'utf-8')));
                }
            }
        }
    }

    public function actionSpotRetype()
    {
        if (isset($_POST['Spot']) and isset($_POST['Spot']['spot_type_id']) and isset($_POST['discodes_id'])) {
            $spot = Spot::model()->findByPk((int)$_POST['discodes_id']);
            $spot_type_id = (int)$_POST['Spot']['spot_type_id'];
            if ($spot) {
                $spot->spot_type_id = $spot_type_id;
                if ($spot->save()) {
                    $all_type = SpotType::getSpotTypeAllArray();
                    echo json_encode(array('discodes_id' => $spot->discodes_id, 'spot_type' => $all_type[$spot_type_id]));
                }
            }
        }
    }

    public function actionSpotRemove()
    {
        if (isset($_POST['discodes_id'])) {
            $spot = Spot::model()->findByPk((int)$_POST['discodes_id']);
            if ($spot) {
                $spot->status = Spot::STATUS_REMOVED_USER;
                if ($spot->save()) {
                    echo json_encode(array('discodes_id' => $spot->discodes_id));
                }
            }
        }
    }

    public function actionSpotAdd()
    {
        if (isset($_POST['code'])) {
            if (!isset($_POST['type'])) {
                $spot = Spot::model()->findByAttributes(array('code' => $_POST['code'], 'status' => Spot::STATUS_ACTIVATED));
                if ($spot) {
                    echo $spot->type;
                } else echo false;
            } else {
                $spot = Spot::model()->findByAttributes(array('code' => $_POST['code']));
                $spot->status = Spot::STATUS_REGISTERED;
                $spot->user_id = Yii::app()->user->id;
                $spot->spot_type_id = (int)$_POST['type'];
                if ($spot->save()) {
                    $txt = $this->renderPartial('/user/block/_spots_list',
                        array(
                            'data' => $spot,
                        ),
                        true);
                    echo '<div class="items">' . $txt . '</div>';
                }
            }
        }
    }

    public function actionSpotView()
    {
        if (isset($_POST['discodes_id'])) {
            $spot = Spot::model()->findByPk((int)$_POST['discodes_id']);
            if ($spot) {
                $content = SpotModel::getContent('1', $spot->discodes_id, Yii::app()->user->id, $spot->spot_type_id);
                $txt = $this->renderPartial('/widget/spot/' . $spot->spot_type->pattern,
                    array(
                        'data' => $spot,
                        'content' => $content,
                    ),
                    true);
                echo $txt;
            }
        }
    }

    public function actionSpotEdit()
    {
        if (isset($_POST['SpotModel']) and isset($_POST['SpotModel']['spot_id']) and isset($_POST['SpotModel']['spot_type_id'])) {

            $spot_id = ($_POST['SpotModel']['spot_id']);
            $spot_type_id = ($_POST['SpotModel']['spot_type_id']);

            $content = SpotModel::getContent('1', $spot_id, Yii::app()->user->id, $spot_type_id);
            if ($content) {
                $content = SpotModel::setField($content, $_POST['SpotModel']);

                if ($content->update()) {
                    echo json_encode(array('discodes_id' => $content->spot_id));
                }
            }
        }
    }

}