<?php

class AjaxController extends MController {

  public function actions() {
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

  public function actionSetQuestion() {
    if (Yii::app()->request->isAjaxRequest) {
      $error = "yes";
      $data = $this->getJson();

      if (count($data) == 3) {
        $form = new QuestionForm();
        $form->attributes = $data;
        if ($form->validate()) {
          MMail::faq_question(Yii::app()->par->load('generalEmail'), $form, $this->getLang());
          $error = "no";
        }
      }
      echo json_encode(array('error' => $error));
    }
  }

  public function actionSetLang() {
    if (isset($_POST['lang'])) {
      $lang = $_POST['lang'];
      Yii::app()->request->cookies['lang'] = new CHttpCookie('lang', $lang);

      if (!isset(Yii::app()->user->id)) {
        $user = User::model()->findByPk(Yii::app()->user->id);
        if (isset($user)) {
          $user->lang = $lang;
          $user->save();
        }
      }
      echo true;
    }
  }

  public function actionLogin() {
    if (Yii::app()->request->isAjaxRequest) {
      $error = "yes";
      #$data = $this->getJson();

      if (isset($_POST['token']) and $_POST['token'] == Yii::app()->request->csrfToken) {
        if (isset($_POST['email']) and isset($_POST['password'])) {
          $form = new LoginForm;
          $form->email = $_POST['email'];
          $form->password = $_POST['password'];
          if ($form->validate()) {
            $identity = new UserIdentity($form->email, $form->password);
            $identity->authenticate();
            $this->lastVisit();
            Yii::app()->user->login($identity);
            $error = "no";
          }
        }
        // if (isset(Yii::app()->session['login_error_count'])) {
        //     $login_error_count = Yii::app()->session['login_error_count'];
        // } else $login_error_count = 0;
        // if ($login_error_count > 2) {
        //     $error = 'login_error_count';
        // } else {
        //     $form = new LoginForm;
        //     if (isset($data['email']) and isset($data['password'])) {
        //         $form->attributes = $data;
        //         if ($form->validate()) {
        //             $identity = new UserIdentity($form->email, $form->password);
        //             $identity->authenticate();
        //             $this->lastVisit();
        //             Yii::app()->user->login($identity);
        //             unset(Yii::app()->session['login_error_count']);
        //             $error = "no";
        //         }
        //         else Yii::app()->session['login_error_count'] = $login_error_count + 1;
        //     }
        // }
      }
      echo json_encode(array('error' => $error));
    }
  }

  public function actionLoginCaptcha() {
    if (Yii::app()->request->isAjaxRequest) {
      $error = "yes";
      $data = $this->getJson();

      if (isset($data['token']) and $data['token'] == Yii::app()->request->csrfToken) {
        $form = new LoginCaptchaForm();

        $form->attributes = $data;
        if ($form->validate()) {
          $identity = new UserIdentity($form->email, $form->password);
          $identity->authenticate();
          Yii::app()->user->login($identity);
          $this->lastVisit();
          unset(Yii::app()->session['login_error_count']);
          $error = "no";
        }
      }
      echo json_encode(array('error' => $error));
    }
  }

  public function actionGetCaptcha() {
    if (Yii::app()->request->isAjaxRequest) {
      $error = "yes";
      $content = "";

      $data = $this->getJson();
      if (isset($data['content'])) {
        $content = $this->renderPartial('/user/block/captcha', array(), true
        );
        $error = "no";
      }
      echo json_encode(array('error' => $error, 'content' => $content));
    }
  }

  public function actionModal() {
    if (Yii::app()->request->isAjaxRequest) {
      $error = "yes";
      $content = "";

      $data = $this->getJson();

      if (isset($data['content'])) {
        if (isset($data['discodes'])) {
          $discodes = $data['discodes'];
          $spot = Spot::model()->findByPk($data['discodes']);
        }
        else
          $spot = false;

        $content = $this->renderPartial('//modal/' . $data['content'], array(
            'spot' => $spot,
                ), true
        );
        $error = "no";
      }

      echo json_encode(array('error' => $error, 'content' => $content));
    }
  }

  public function actionGetContent() {
    if (Yii::app()->request->isAjaxRequest and isset($_POST['content']) and isset($_POST['discodes_id'])) {

      $data = array();
      $data['name'] = (isset($_POST['name'])) ? $_POST['name'] : '';
      $data['link'] = (isset($_POST['link'])) ? $_POST['link'] : '';
      $data['file'] = (isset($_POST['file'])) ? $_POST['file'] : '';
      $data['file_view'] = (isset($_POST['file_view'])) ? $_POST['file_view'] : '';

      $txt = $this->renderPartial('//widget/spot/' . $_POST['content'], array(
          'discodes_id' => (int) $_POST['discodes_id'],
          'data' => $data,
              ), true);
      echo $txt;
    }
  }

  public function actionLogout() {
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

  public function actionRecovery() {
    if (Yii::app()->request->isAjaxRequest) {
      $error = "yes";
      $data = $this->getJson();

      if (isset($data['token']) and $data['token'] == Yii::app()->request->csrfToken) {
        $form = new RecoveryForm;
        if (isset($data['email'])) {
          $form->email = $data['email'];
          if ($form->validate()) {
            $user = User::model()->findByAttributes(array('email' => $form->email));
            MMail::recovery($user->email, $user->activkey, $this->getLang());

            $error = "no";
          }
        }
      }
      echo json_encode(array('error' => $error));
    }
  }

  public function actionRegistration() {
    if (Yii::app()->request->isAjaxRequest) {
      $error = "yes";
      $data = $this->getJson();

      if (isset($data['token']) and $data['token'] == Yii::app()->request->csrfToken and (empty($data['name']))) {

        $model = new RegistrationForm;

        if (isset($data['email']) and isset($data['password'])) {
          $model->attributes = $data;

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
                $spot->lang = $this->getLang;
                $spot->status = Spot::STATUS_REGISTERED;
                $spot->save();

                MMail::activation($model->email, $model->activkey, $this->getLang());
                $error = "no";
              }
            }
          }
        }
        $error = 'yes';
      }
      echo json_encode(array('error' => $error));
    }
  }

  public function actionSpotRename() {
    $error = "yes";
    $discodes = "";
    $name = "";
    $data = $this->getJson();

    if (isset($data['name']) and isset($data['discodes'])) {
      $spot = Spot::model()->findByPk($data['discodes']);
      if ($spot) {
        $spot->name = CHtml::encode($data['name']);
        if ($spot->save()) {
          $discodes = $data['discodes'];
          $name = mb_substr($spot->name, 0, 45, 'utf-8');
          $error = "no";
        }
      }
      echo json_encode(array('error' => $error, 'discodes' => $discodes, 'name' => $name));
    }
  }

  public function actionSpotRetype() {
    $error = "yes";
    $discodes = "";
    $type = "";
    $type_id = "";
    $data = $this->getJson();

    if (isset($data['type_id']) and isset($data['discodes'])) {
      $spot = Spot::model()->findByPk($data['discodes']);
      $spot_type_id = $data['type_id'];
      if ($spot) {
        $spot->spot_type_id = $spot_type_id;
        if ($spot->save()) {
          $all_type = SpotType::getSpotTypeArray();

          $discodes = $spot->discodes_id;
          $type_id = $spot_type_id;
          $type = $all_type[$spot_type_id];
          $error = "no";
        }
      }
      echo json_encode(array('error' => $error, 'discodes' => $discodes, 'type' => $type));
    }
  }

  public function actionSpotRemove() {
    $error = "yes";
    $discodes = "";
    $data = $this->getJson();

    if (isset($data['discodes'])) {
      $spot = Spot::model()->findByPk($data['discodes']);
      if ($spot) {
        $spot->status = Spot::STATUS_REMOVED_USER;
        if ($spot->save()) {
          $discodes = $data['discodes'];
          $error = "no";
        }
      }
      echo json_encode(array('error' => $error, 'discodes' => $discodes));
    }
  }

  public function actionSpotCopy() {
    $error = "yes";
    $name = "";
    $type = "";
    $discodes = "";
    $data = $this->getJson();

    if (isset($data['discodes_from']) and isset($data['discodes_to'])) {
      $spot_id_from = $data['discodes_from'];
      $spot_id_to = trim($data['discodes_to']);

      $spot_from = Spot::model()->findByAttributes(
              array(
                  'discodes_id' => $spot_id_from,
                  'user_id' => Yii::app()->user->id
      ));
      $spot_to = Spot::model()->findByAttributes(
              array(
                  'discodes_id' => $spot_id_to,
                  'user_id' => Yii::app()->user->id
      ));
      if ($spot_from and $spot_to) {
        $spot_to->name = $spot_from->name;
        $spot_to->spot_type_id = $spot_from->spot_type_id;
        $spot_to->status = Spot::STATUS_CLONES;
        if ($spot_to->save()) {
          $to = SpotModel::model()->findAllByAttributes(array('spot_id' => $spot_id_to));
          foreach ($to as $row) {
            $row->delete();
          }
          $from = SpotModel::model()->findAllByAttributes(array('spot_id' => $spot_id_from));
          foreach ($from as $row) {
            $to = new SpotModel();
            $to->attributes = $row->attributes;
            $to->spot_id = $spot_id_to;
            $to->initSoftAttributes(SpotLinkTypeField::getSpotFieldSlug($row->spot_type_id));

            $soft_field = SpotLinkTypeField::getSpotFieldSlug($row->spot_type_id);
            foreach ($soft_field as $slug) {
              $to->__set($slug, $row->__get($slug));
            }

            $to->save();
          }

          $type = $spot_to->spot_type->name;
          $name = $spot_to->name;
          $discodes = $spot_to->discodes_id;
          $error = "no";
        }
      }
      echo json_encode(array('error' => $error, 'discodes' => $discodes, 'name' => $name, 'type' => $type));
    }
  }

  public function actionSpotClear() {
    $error = "yes";
    $discodes = "";
    $data = $this->getJson();

    if (isset($data['discodes'])) {
      $spot = Spot::model()->findByPk($data['discodes']);
      if ($spot) {

        $content = SpotModel::model()->findByAttributes(array(
            'spot_id' => $data['discodes'],
            'spot_type_id' => $spot->spot_type_id,
            'lang' => $spot->lang,
        ));
        if (!isset($content) or $content->delete()) {
          UserPersonalField::model()->deleteByPk($discodes);
          $discodes = $data['discodes'];
          $error = "no";
        }
      }
      echo json_encode(array('error' => $error, 'discodes' => $discodes));
    }
  }

  public function actionSpotInvisible() {
    $error = "yes";
    $data = $this->getJson();

    if (isset($data['discodes'])) {
      $spot = Spot::model()->findByPk($data['discodes']);

      if ($spot) {
        if ($spot->status == Spot::STATUS_INVISIBLE)
          $spot->status = Spot::STATUS_REGISTERED;
        else
          $spot->status = Spot::STATUS_INVISIBLE;

        if ($spot->save()) {
          $error = "no";
        }
      }
      echo json_encode(array('error' => $error));
    }
  }

  public function actionSpotAdd() {
    $error = "yes";
    $data = $this->getJson();

    if (isset($data['code']) and isset($data['type'])) {
      $spot = Spot::model()->findByAttributes(array('code' => $data['code']));
      if ($spot) {
        $spot->status = Spot::STATUS_REGISTERED;
        $spot->lang = $this->getLang();
        $spot->user_id = Yii::app()->user->id;
        $spot->spot_type_id = $data['type'];
        if ($spot->save()) {
          $error = "no";
        }
      }
      echo json_encode(array('error' => $error));
    }
  }

  public function actionSpotView() {
    if (Yii::app()->request->isAjaxRequest) {
      $error = "yes";
      $content = "";

      $data = $this->getJson();
      if (isset($data['discodes'])) {
        $spot = Spot::model()->findByPk($data['discodes']);
        if ($spot) {
          $data = SpotModel::getContent($spot->lang, $spot->discodes_id, Yii::app()->user->id, $spot->spot_type_id);
          $content = $this->renderPartial('//widget/spot/' . $spot->spot_type->pattern, array(
              'data' => $spot,
              'content' => $data,
                  ), true);
          $error = "no";
        }
      }
      echo json_encode(array('error' => $error, 'content' => $content));
    }
  }

  public function actionSpotEdit() {
    if (isset($_POST['SpotModel']) and isset($_POST['SpotModel']['spot_id']) and isset($_POST['SpotModel']['spot_type_id'])) {

      $spot_id = $_POST['SpotModel']['spot_id'];
      $spot_type_id = ($_POST['SpotModel']['spot_type_id']);
      $spot = Spot::model()->findByPk($spot_id);

      $content = SpotModel::getContent($spot->lang, $spot_id, Yii::app()->user->id, $spot_type_id);
      if ($content) {
        $content = SpotModel::setField($content, $_POST['SpotModel']);

        if ($content->update()) {
          echo json_encode(array('discodes_id' => $content->spot_id));
        }
      }
    }
  }

  public function actionSpotFeedbackContent() {
    $error = "yes";
    $content = "";

    $data = $this->getJson();
    if (isset($data['discodes'])) {
      $spot = FeedbackContent::model()->findAllByAttributes(array('spot_id' => $data['discodes']));
      $content = $this->renderPartial('//widget/spot/feedback_content', array(
          'discodes_id' => $data['discodes'],
          'spot' => $spot,
              ), true);
      $error = "no";
      echo json_encode(array('error' => $error, 'content' => $content));
    }
  }

  public function actionSpotPersonalContent() {
    if (isset($_POST['discodes_id']) and isset($_POST['type_id'])) {
      $select_field = UserPersonalField::getField($_POST['discodes_id']);

      if (!$select_field)
        $select_field = false;

      $all_field = SpotPersonalField::getPersonalField((int) $_POST['type_id']);
      $txt = $this->renderPartial('//widget/spot/personal_field', array(
          'discodes_id' => (int) $_POST['discodes_id'],
          'all_field' => $all_field,
          'select_field' => $select_field,
          'type_id' => (int) $_POST['type_id'],
              ), true);
      echo $txt;
    }
  }

  public function actionSpotPersonalField() {
    if (isset($_POST['discodes_id']) and isset($_POST['Fields']) and isset($_POST['type_id'])) {

      $data = array();
      foreach ($_POST['Fields'] as $key => $value) {
        $data[] = $key;
      }

      UserPersonalField::setField($_POST['discodes_id'], $_POST['type_id'], $data);
      Yii::app()->cache->delete('spot_personal_field_' . $_POST['discodes_id']);
      echo true;
    }
  }

  public function actionSpotPersonalPhoto() {
    if (isset($_POST['user_id']) and isset($_POST['file_name'])) {
      $user_id = $_POST['user_id'];

      $photo = UserPersonalPhoto::getPhoto($user_id);
      if (count($photo) > 9)
        unset($photo[0]);
      $photo[] = $_POST['file_name'];
      echo UserPersonalPhoto::setPhoto($user_id, array_values($photo));
    }
  }

  public function actionSpotGetGallery() {
    if (isset($_POST['user_id'])) {
      $user_id = $_POST['user_id'];

      $text = $this->renderPartial('/widget/spot/personal_gallery', array(
          'photo' => UserPersonalPhoto::getPhoto($user_id),
          'user_id' => $user_id,
              ), true);
      echo $text;
    }
  }

  public function actionSpotRemovePhoto() {
    if (isset($_POST['user_id']) and isset($_POST['file'])) {
      #UserPersonalPhoto::removePhoto($_POST['user_id'], $_POST['file']);
      echo $_POST['file'];
    }
  }

  public function formatText($text, $font, $font_size, $width_text) {
    $data = array();

    $text = explode(' ', $text);
    $text_new = '';
    foreach ($text as $word) {
      $box = imagettfbbox($font_size, 0, $font, $text_new . ' ' . $word);
      if ($box[2] > $width_text - 10) {
        $text_new .= "\n" . $word;
      } else {
        $text_new .= " " . $word;
      }
    }
    $text_new = trim($text_new);
    $box = imagettfbbox($font_size, 0, $font, $text_new);

    $data['width'] = $box[2] - $box[1];
    $data['text'] = $text_new;
    return $data;
  }

  public function actionCouponGenerate() {
    if (isset($_POST['Coupon']) and isset($_POST['Coupon']['spot_id'])) {
      foreach ($_POST['Coupon'] as $key => $value) {
        ${$key} = $value;
      }

      $body_color = ($_POST['Coupon']['body_color']) ? '0x' . substr($_POST['Coupon']['body_color'], 1) : 0xFFFFFF;
      $text_color = ($_POST['Coupon']['text_color']) ? '0x' . substr($_POST['Coupon']['text_color'], 1) : 0x000000;

      $width = 300;
      $height = 200;
      $font = Yii::getPathOfAlias('webroot.fonts.') . '/helveticaneuecyr-roman-webfont.ttf';

      $image = imagecreatetruecolor($width, $height);
      imagefill($image, 0, 0, $body_color);

      if ($logo) {
        $logo_file = imagecreatefrompng(Yii::getPathOfAlias('webroot.uploads.spot.') . '/' . $logo);
        $logo_x = imagesx($logo_file);
        $logo_y = imagesy($logo_file);
        imagecopymerge($image, $logo_file, (imagesx($image) - $logo_x) / 2, 10, 0, 0, $logo_x, $logo_y, 100);
        //unlink(Yii::getPathOfAlias('webroot.uploads.spot.') . '/'.$logo);
      }

      if ($text) {
        $font_size = 12;

        $data = $this->formatText($text, $font, 12, 290);
        imagefttext($image, $font_size, 0, ($width - $data['width']) / 2, 100, $text_color, $font, $data['text']);
      }

      $time_text = '';
      if (!empty($hour_up))
        $time_text .= $hour_up;
      if (!empty($hour_up) and !empty($minute_up))
        $time_text .= ':';
      if (!empty($minute_up))
        $time_text .= $minute_up;
      if (!empty($hour_up) or !empty($minute_up) or !empty($hour_down) or !empty($minute_down))
        $time_text .= '-';
      if (!empty($hour_down))
        $time_text .= $hour_down;
      if (!empty($hour_down) and !empty($minute_down))
        $time_text .= ':';
      if (!empty($minute_down))
        $time_text .= $minute_down;


      $data = $this->formatText($time_text, $font, 10, 300);
      imagefttext($image, 10, 0, ($width - $data['width']) / 2, 190, $text_color, $font, $data['text']);

      $date_text = '';
      if (!empty($day_up))
        $date_text .= $day_up;
      if (!empty($month_up) and !empty($day_up))
        $date_text .= '.';
      if (!empty($month_up))
        $date_text .= $month_up;
      if (!empty($year_up) and !empty($month_up))
        $date_text .= '.';
      if (!empty($year_up))
        $date_text .= $year_up;
      if ((!empty($month_up) or !empty($day_up) or !empty($year_up)) and (!empty($month_down) or !empty($day_down) or !empty($year_down)))
        $date_text .= '-';
      if (!empty($day_down))
        $date_text .= $day_down;
      if (!empty($month_down) and !empty($day_down))
        $date_text .= '.';
      if (!empty($month_down))
        $date_text .= $month_down;
      if (!empty($year_down) and !empty($month_down))
        $date_text .= '.';
      if (!empty($year_down))
        $date_text .= $year_down;

      $data = $this->formatText($date_text, $font, 10, 300);
      imagefttext($image, 10, 0, ($width - $data['width']) / 2, 160, $text_color, $font, $data['text']);

      $file_path = Yii::getPathOfAlias('webroot.uploads.spot.') . '/';
      $file_name = $spot_id . '_' . time() . '_coupon.png';
      imagepng($image, $file_path . $file_name);
      echo json_encode(array('file' => $file_name));
    }
  }

}