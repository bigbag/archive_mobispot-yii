<?php

class ServiceController extends MController
{
    //Выход
    public function actionLogout()
    {
        if (!Yii::app()->request->isPostRequest) {
            Yii::app()->user->logout();
            $this->redirect("/");
        }

        if (!(Yii::app()->user->isGuest)) {
            Yii::app()->cache->get('user_' . Yii::app()->user->id);
            Yii::app()->user->logout();
            unset(Yii::app()->request->cookies['YII_CSRF_TOKEN']);
        }
    }

    public function actionSocial()
    {
        $serviceName = Yii::app()->request->getQuery('service');
        $returnTo = Yii::app()->request->getQuery('return_to');
        $redirect = '/';

        if(!empty($returnTo)) {
            $returnTo = urldecode($returnTo);
            $redirect = $returnTo;
        }

        if (!isset($serviceName))
            $this->redirect($redirect);

        $atributes = User::getSocInfo($serviceName);
        if (!$atributes)
            $this->redirect($redirect);

        $result = User::socialCheck($serviceName, $atributes['id']);
        if ($result['user'] and !$result['token']->allow_login)
            $this->redirect($redirect);

        if (!$result['user'])
            $this->redirect('/service/socialReg');

        User::autoLogin($result['user']);
        User::clearCacheSocInfo();
        if(!empty($returnTo))
            $this->redirect($returnTo);
        else
            $this->redirect('/spot/list');
    }

    public function actionLogin()
    {
        $data = MHttp::validateRequest();
        $answer = array(
            'error' => "yes",
            "content" => Yii::t('user', "Check your email and password")
        );

        if (!isset($data['email']) or !isset($data['password']))
            MHttp::setBadRequest();

        $form = new LoginForm;
        $form->attributes = $data;
        if (!$form->validate())
            MHttp::getJsonAndExit($answer);

        User::autoLogin($form);
        $answer['error'] = "no";

        echo json_encode($answer);
    }

    //логин в соцсети
    public function actionSocLogin()
    {
        $serviceName = Yii::app()->request->getQuery('service');
        $discodes = Yii::app()->request->getQuery('discodes');
        $synch = Yii::app()->request->getQuery('synch');

        if (!isset($discodes))
            $discodes = '';
        if (!isset($serviceName))
            MHttp::setNotFound();
        if (!Yii::app()->user->id)
            MHttp::setAccess();

        if (isset($synch) and $synch == 'true' and !empty($discodes)) {
            Yii::app()->session[$serviceName . '_synch_data'] = array(
                'discodes'=> $discodes,
                'key' => $key = Yii::app()->request->getQuery('key'),
                'newField' => Yii::app()->request->getQuery('newField'),
                'link' => Yii::app()->request->getQuery('link'),
            );
        }

        $atributes = User::getSocInfo($serviceName);
        if (!$atributes) MHttp::setAccess();

        SocToken::setToken($atributes);
        SocInfo::setLogged($atributes);

        if (!empty(Yii::app()->session[$serviceName . '_synch_data'])) {
            $data = Yii::app()->session[$serviceName . '_synch_data'];
            $data['link'] = urlencode($data['link']);
            unset(Yii::app()->session[$serviceName . '_synch_data']);
            $host = '';

            $this->redirect('/spot/bindedContent?service=' . $serviceName . SocInfo::toGetParams($data, '&'));
        }
    }

    //Регистрация
    public function actionRegistration()
    {
        $data = MHttp::validateRequest();
        $answer = array(
            'error' => "yes",
            "content" => Yii::t('user', "You've made a mistake in spot activation code.")
        );

        if (!isset($data['email']) or !isset($data['password']))
            MHttp::setBadRequest();

        $model = new RegistrationForm;
        $model->attributes = $data;
        if (!$model->validate()) {
            $validate_errors = $model->getErrors();
            if (isset($validate_errors['activ_code'])) {
                $answer['content'] = Yii::t('user', "Wrong activation code");
                $answer['error'] = 'code';
            } elseif (isset($validate_errors['email'])) {
                $answer['content'] = Yii::t('user', "This email has been already used");
                $answer['error'] = 'email';
            } else
                $answer['content'] = Yii::t('user', "Password is too short (minimum is 5 characters).");

            MHttp::getJsonAndExit($answer);
        }

        $model->password = Yii::app()->hasher->hashPassword($model->password);
        if (!$model->save())
            MHttp::getJsonAndExit($answer);

        $socInfo = User::getCacheSocInfo();
        $socInfo['user_id'] = $model->id;

        if ($socInfo)
            SocToken::setToken($socInfo);

        $spot = Spot::getActivatedSpot($data['activ_code']);
        $spot->user_id = $model->id;
        $spot->lang = $this->getLang();
        $spot->status = Spot::STATUS_REGISTERED;
        $spot->save();

        $wallet = PaymentWallet::model()->findByAttributes(
                array(
                    'discodes_id' => $spot->discodes_id,
                    'user_id' => 0,
                )
        );
        if ($wallet) {
            $wallet->status = PaymentWallet::STATUS_ACTIVE;
            $wallet->user_id = $spot->user_id;
            $wallet->save();
        }

        MMail::activation($model->email, $model->activkey, $this->getLang());
        $answer['content'] = Yii::t('user', "You and your first spot have been registred successfully. Please check your inbox to confirm registration.");
        $answer['error'] = "no";
        echo json_encode($answer);
    }
}
