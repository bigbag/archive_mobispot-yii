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
                'foreColor' => array(mt_rand(0, 100), mt_rand(0, 100), mt_rand(0, 100)),
                'backColor' => array(mt_rand(200, 210), mt_rand(210, 220), mt_rand(220, 230))
            ),
        );
    }

    public function actionGetCaptcha()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $text = $this->renderPartial('/user/block/captcha',
                array(

                ),
                true);
            echo $text;
        }
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

    public function actionGetContent()
    {
        if (Yii::app()->request->isAjaxRequest and isset($_POST['content']) and isset($_POST['discodes_id'])) {

            $data = array();
            $data['name'] = (isset($_POST['name']))?$_POST['name']:'';
            $data['link'] = (isset($_POST['link']))?$_POST['link']:'';
            $data['file'] = (isset($_POST['file']))?$_POST['file']:'';
            $data['file_view'] = (isset($_POST['file_view']))?$_POST['file_view']:'';

            $txt = $this->renderPartial('//widget/spot/'.$_POST['content'],
                array(
                    'discodes_id' => (int)$_POST['discodes_id'],
                    'data' => $data,
                ),
                true);
            echo $txt;

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

                    if (Yii::app()->request->cookies['service_name'] and Yii::app()->request->cookies['service_id']) {
                        $service_name = Yii::app()->request->cookies['service_name']->value;
                        $service_name = $service_name . '_id';
                        $model->{$service_name} = Yii::app()->request->cookies['service_id']->value;
                    }

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
                    $all_type = SpotType::getSpotTypeArray();
                    echo json_encode(
                        array(
                            'discodes_id' => $spot->discodes_id,
                            'spot_type' => $all_type[$spot_type_id],
                            'spot_type_id' => $spot_type_id,
                        ));
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

    public function actionSpotClear()
    {
        if (isset($_POST['discodes_id'])) {
            $spot_id = $_POST['discodes_id'];
            $spot = Spot::model()->findByPk($spot_id);
            if ($spot) {

                $content = SpotModel::model()->findByAttributes(array('spot_id' => $spot_id, 'spot_type_id' => $spot->spot_type_id));
                $content->delete();
                echo json_encode(array('discodes_id' => $spot->discodes_id));
            }
        }
    }

    public function actionSpotInvisible()
    {
        if (isset($_POST['discodes_id'])) {
            $spot_id = $_POST['discodes_id'];
            $spot = Spot::model()->findByPk($spot_id);

            if ($spot) {
                if ($spot->status == Spot::STATUS_INVISIBLE) $spot->status = Spot::STATUS_REGISTERED;
                else $spot->status = Spot::STATUS_INVISIBLE;
                $spot->save();
                echo json_encode(array('discodes_id' => $spot->discodes_id, 'status' => $spot->status));

            }
        }
    }


    public function actionSpotAdd()
    {
        if (isset($_POST['code'])) {
            if (!isset($_POST['type'])) {
                $spot = Spot::model()->findByAttributes(array('code' => $_POST['code'], 'status' => Spot::STATUS_ACTIVATED));
                if ($spot) {
                    echo true;
                }
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
                $txt = $this->renderPartial('//widget/spot/' . $spot->spot_type->pattern,
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
    
    public function actionSpotFeedbackContent(){
        if (isset($_POST['discodes_id'])) {
            $spot = FeedbackContent::model()->findAllByAttributes(array('spot_id' => (int)$_POST['discodes_id']));
            $txt = $this->renderPartial('//widget/spot/feedback_content',
                array(
                    'discodes_id' => (int)$_POST['discodes_id'],
                    'spot' => $spot,
                ),
                true);
            echo $txt;
        }
    }

    public function formatText($text, $font, $font_size, $width_text){
        $data = array();

        $text = explode(' ', $text);
        $text_new = '';
        foreach($text as $word){
            $box = imagettfbbox($font_size, 0, $font, $text_new.' '.$word);
            if($box[2] > $width_text){
                $text_new .= "\n".$word;
            } else {
                $text_new .= " ".$word;
            }
        }
        $text_new = trim($text_new);
        $box = imagettfbbox($font_size, 0, $font, $text_new);

        $data['width'] = $box[2] - $box[1];
        $data['text'] = $text_new;
        return $data;
    }

    public function actionCouponGenerate(){
        if (isset($_POST['Coupon']) and isset($_POST['Coupon']['spot_id'])) {
            foreach ($_POST['Coupon'] as $key=>$value){
                ${$key} = $value;
            }

            $body_color = ($_POST['Coupon']['body_color'])?'0x'.substr($_POST['Coupon']['body_color'],1):0xFFFFFF;
            $text_color = ($_POST['Coupon']['text_color'])?'0x'.substr($_POST['Coupon']['text_color'],1):0x000000;

            $width = 300;
            $height = 200;
            $font = Yii::getPathOfAlias('webroot.fonts.').'/helveticaneuecyr-roman-webfont.ttf';

            $image = imagecreatetruecolor($width, $height);
            imagefill($image, 0, 0, $body_color);

            if ($logo) {
                $logo_file = imagecreatefrompng(Yii::getPathOfAlias('webroot.uploads.spot.') . '/'.$logo);
                $logo_x = imagesx($logo_file);
                $logo_y = imagesy($logo_file);
                imagecopymerge($image, $logo_file, (imagesx($image) - $logo_x)/2, 10, 0, 0, $logo_x, $logo_y, 100);
            }

            if ($text) {
                $font_size = 12;
                $width_text = 100;

                $data = $this->formatText($text, $font, 12, $width_text);
                imagefttext($image, $font_size, 0, ($width - $data['width'])/2, 100, $text_color, $font, $data['text']);
            }

            $time_text = '';
            if (!empty($hour_up)) $time_text .= $hour_up;
            if (!empty($hour_up) and !empty($minute_up)) $time_text .= ':';
            if (!empty($minute_up)) $time_text .= $minute_up;
            if (!empty($hour_up) or !empty($minute_up) or!empty($hour_down) or !empty($minute_down)) $time_text .= '-';
            if (!empty($hour_down)) $time_text .= $hour_down;
            if (!empty($hour_down) and !empty($minute_down)) $time_text .= ':';
            if (!empty($minute_down)) $time_text .= $minute_down;


            $data = $this->formatText($time_text, $font, 10, 300);
            imagefttext($image, 10, 0, ($width - $data['width'])/2, 190, $text_color, $font, $data['text']);

            $date_text = '';
            if (!empty($day_up)) $date_text .= $day_up;
            if (!empty($month_up) and !empty($day_up)) $date_text .= '.';
            if (!empty($month_up)) $date_text .= $month_up;
            if (!empty($year_up) and !empty($month_up)) $date_text .= '.';
            if (!empty($year_up)) $date_text .= $year_up;
            if (!empty($month_up) or !empty($day_up) or !empty($year_up) or !empty($month_down) or !empty($day_down) or !empty($year_down)) $date_text .= '-';
            if (!empty($day_down)) $date_text .= $day_down;
            if (!empty($month_down) and !empty($day_down)) $date_text .= '.';
            if (!empty($month_down)) $date_text .= $month_down;
            if (!empty($year_down) and !empty($month_down)) $date_text .= '.';
            if (!empty($year_down)) $date_text .= $year_down;

            $data = $this->formatText($date_text, $font, 10, 300);
            imagefttext($image, 10, 0, ($width - $data['width'])/2, 160, $text_color, $font, $data['text']);

            $file_path = Yii::getPathOfAlias('webroot.uploads.spot.') . '/';
            $file_name =  $spot_id . '_' . time() . '_coupon.png';
            imagepng($image, $file_path.$file_name);
            echo json_encode(array('file' => $file_name));

        }
    }

}