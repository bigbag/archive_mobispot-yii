<?php

class UserController extends MController
{
    public $defaultAction = 'profile';

    // Вывод профиля
    public function actionProfile()
    {
        if (!Yii::app()->user->id)
            MHttp::setAccess();

        $user = User::model()->findByPk(Yii::app()->user->id);
        $profile = UserProfile::model()->findByPk(Yii::app()->user->id);

        if (!$profile) {
            $profile = new UserProfile;
            $profile->user_id = $user->id;
            $profile->sex = UserProfile::SEX_UNKNOWN;
            $profile->save();
        }

        if (Yii::app()->request->getParam('UserProfile')) {
            $profile->attributes = Yii::app()->request->getParam('UserProfile');

            if ($profile->validate()) {
                $profile->save();
                $this->refresh();
            }
        }

        $socnet = array();
        if ($user) {
            $userTokens = SocToken::model()->findAllByAttributes(array(
                'user_id' => $user->id,
                'allow_login' => true
            ));

            foreach ($userTokens as $net) {
                $socnet[$net->getType()] = 1;
            }
        }

        $this->render('profile', array(
            'profile' => $profile,
            'user' => $user,
            'socnet' => $socnet,
        ));
    }

    // Обновление профиля
    public function actionEditProfile()
    {
        $answer = array(
            'error' => 'yes',
            'content' => ''
        );
        $data = MHttp::validateRequest();

        if (!isset($data['id']))
            MHttp::getJsonAndExit($answer);

        $profile = UserProfile::model()->findByPk((int) $data['id']);
        $profile->attributes = $data;

        if ($profile->save()) {
            $answer['error'] = 'no';
            $answer['content'] = Yii::t('user', "The information has been saved successfully");
        }

        echo json_encode($answer);
    }

    public function actionBindSocLogin()
    {
        $serviceName = Yii::app()->request->getQuery('service');
        $discodes = Yii::app()->request->getQuery('discodes');
        $synch = Yii::app()->request->getQuery('synch');
        $checkLike = Yii::app()->request->getQuery('chek_like');
        $login_only = Yii::app()->request->getQuery('loginonly');

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
        } elseif (isset($checkLike)) {
            Yii::app()->session[$serviceName . '_loyalty_data'] = array(
                'discodes'=> $discodes,
                'loyalty_id'=>$checkLike,
            );
        } elseif (isset($login_only)) {
            Yii::app()->session[$serviceName . '_login_only'] = true;
        }

        $atributes = User::getSocInfo($serviceName);
        if (!$atributes) MHttp::setAccess();

        SocToken::setToken($atributes);
        SocInfo::setLogged($atributes);

        if (!empty(Yii::app()->session[$serviceName . '_synch_data'])) {
            $data = Yii::app()->session[$serviceName . '_synch_data'];
            $data['link'] = urlencode($data['link']);
            unset(Yii::app()->session[$serviceName . '_synch_data']);

            $this->redirect('/spot/bindedContent?service=' . $serviceName . MHttp::toGetParams($data, '&'));
        } elseif(!empty(Yii::app()->session[$serviceName . '_loyalty_data'])) {
            $data = Yii::app()->session[$serviceName . '_loyalty_data'];
            unset(Yii::app()->session[$serviceName . '_loyalty_data']);
            $this->redirect('/user/checkLike' . MHttp::toGetParams($data));
        } elseif(!empty(Yii::app()->session[$serviceName . '_login_only'])) {
            unset(Yii::app()->session[$serviceName . '_login_only']);
            $this->redirect('/spot/list');
        }
    }
    
    public function actionIsLoggedByService()
    {
       $data = MHttp::validateRequest();
       $answer = array('loggedIn' => false);
       if (empty($data['netName']))
           MHttp::setBadRequest();
       
       $socInfo = new SocInfo;
       $answer['socnet'] = $socInfo->mergeMobile($data['netName']);
       
        if (!empty(Yii::app()->session[$answer['socnet'] . '_id']))
            $answer['loggedIn'] = true;
        
        echo json_encode($answer);
    }

    //подключение акции, требующей жетона соцсети
    public function actionCheckLike()
    {
        if (Yii::app()->request->isPostRequest)
            $data = MHttp::validateRequest();
        else {
            $data = array(
                'discodes'=>Yii::app()->request->getQuery('discodes'),
                'id'=>Yii::app()->request->getQuery('loyalty_id'),
            );
        }
        $target = '/spot/list';

        if (MHttp::isHostMobile()) {
            $spot = Spot::getSpot(array('discodes_id' => $data['discodes']));
            if ($spot)
                $target = '/spot/view/' . $spot->url;
        }

        $answer = array(
            'error' => 'yes',
            'message' => '',
            'checked' => false,
            'isSocLogged' => false,
            'sharing_logged' => false,
            'ind' => 0,
        );
        $link = '';

        if (!Yii::app()->user->id)
            MHttp::setAccess();

        if (empty($data['id']) or empty($data['discodes']))
            MHttp::getJsonOrRedirect($answer, $target);

        $action = Loyalty::model()->findByPk($data['id']);
        if (!$action)
            MHttp::getJsonOrRedirect($answer, $target);

        $sharings = LoyaltySharing::model()->findAllByAttributes(
            array('loyalty_id' => $action->id));

        if (!$sharings)
            MHttp::getJsonOrRedirect($answer, $target);

        $ind = 0;
        if (!empty(Yii::app()->session['check_loyalty_' . $action->id]))
            $ind = Yii::app()->session['check_loyalty_' . $action->id];

        $wallet = PaymentWallet::model()->findByAttributes(array(
            'discodes_id' => $data['discodes'],
        ));
        
        if (!$wallet)
            MHttp::getJsonOrRedirect($answer, $target);

        for ($i=$ind; $i < count($sharings); $i++) {

            $answer['ind'] = $i;
            Yii::app()->session['check_loyalty_' . $action->id] = $i;

            $service = SocInfo::getNameBySharingType($sharings[$i]->sharing_type);
            $answer['service'] = $service;
            $answer['isSocLogged'] = false;

            $answer['error'] = "no";
            $socInfo = new SocInfo;
            if (!$socInfo->isLoggegOn($service, false)) {
                MHttp::getJsonOrRedirect($answer, $target);
            }

            $answer['isSocLogged'] = true;
            if (isset($data['sharing_ind']) && $data['sharing_ind'] <= $i)
                $answer['sharing_logged'] = true;

            if (!Yii::app()->request->isPostRequest and $i < count($sharings)-1) {
                $redirect_uri =
                    'http://'
                    + $_SERVER['HTTP_HOST']
                    + '/user/BindSocLogin?service='
                    + $service;

                  $this->redirect(
                    '/user/BindSocLogin?service=' . $service
                    . '&redirect_uri=' . urlencode($redirect_uri)
                    . '&discodes=' . $data['discodes']
                    . '&chek_like=' . $data['id']);
            }
        }

        $wl = WalletLoyalty::model()->findByAttributes(array(
            'wallet_id' => $wallet->id,
            'loyalty_id' => $action->id,
        ));

        if (!$wl) {
            $wl = new WalletLoyalty;
            $wl->wallet_id = $wallet->id;
            $wl->loyalty_id = $action->id;
            $wl->bonus_limit = $action->bonus_limit;
        }

        $wl->status = WalletLoyalty::STATUS_CONNECTING;
        $wl->errors = array();
        $wl->checked = array();
        $wl->save();

        foreach ($sharings as $sharing) {
            $socToken = SocToken::model()->findByAttributes(array(
                'user_id' => Yii::app()->user->id,
                'type' => SocInfo::getTokenBySharingType($sharing->sharing_type),
            ));

            $task = LikesStack::model()->findByAttributes(array('token_id'=>$socToken->id, 'sharing_id'=>$sharing->id, 'wl_id'=>$wl->id));

            if (!$task) {
                $task = new LikesStack();
                $task->token_id = $socToken->id;
                $task->sharing_id = $sharing->id;
                $task->wl_id = $wl->id;
                $task->save();
            }
        }

        $coupon = array(
            'id' => $action->id,
            'name' => $action->name,
            'coupon_class' => $action->coupon_class,
            'img' => $action->img,
            'desc' => $action->desc,
            'soc_block' => $action->soc_block,
            'status' => $wl->status,
        );

        $answer['content'] = $this->renderPartialWithMobile(
            '//spot/block/coupon',
            array('coupon' => $coupon),
            true,
            '//mobile/spot/coupon'
        );

        MHttp::getJsonOrRedirect($answer, $target);
    }

    public function actionDisableLoyalty()
    {
        $data = MHttp::validateRequest();
        $answer = array('error' => "yes");

        if (!Yii::app()->user->id)
            MHttp::setAccess();

        if (empty($data['id']) or empty($data['discodes']))
            MHttp::getJsonAndExit($answer);

        $action = Loyalty::model()->findByPk($data['id']);
        $wallet = PaymentWallet::getActivByDiscodesId($data['discodes']);

        if (!$action or !$wallet)
            MHttp::getJsonAndExit($answer);

        $wl = WalletLoyalty::model()->findByAttributes(array(
            'wallet_id' => $wallet->id,
            'loyalty_id' => $action->id,
        ));

        if (!$wl)
            MHttp::getJsonAndExit($answer);
            
        //запрет на отключение акции:
        if ($wl->status != 2)
            MHttp::getJsonAndExit($answer);

        $event = new PersonEvent;
        $event->removeByUserLoyaltyId($wallet->user_id, $action->id);

        $wl->status = WalletLoyalty::STATUS_OFF;
        $wl->checked = null;
        $wl->errors = null;
        $wl->save();

        $coupon = array(
            'id' => $action->id,
            'name' => $action->name,
            'coupon_class' => $action->coupon_class,
            'img' => $action->img,
            'desc' => $action->desc,
            'soc_block' => $action->soc_block,
            'status' => $wl->status,
            'errors' => $wl->errors,
        );

        $answer['content'] = $this->renderPartialWithMobile(
            '//spot/block/coupon',
            array('coupon' => $coupon),
            true,
            '//mobile/spot/coupon'
        );
        $answer['error'] = "no";

        echo json_encode($answer);
    }


    public function actionCheckLoyaltyConnection()
    {
        $data = MHttp::validateRequest();
        $answer = array('error' => 'yes', 'connected' => false);

        if (!Yii::app()->user->id)
            MHttp::setAccess();

        if (empty($data['id']) or empty($data['discodes']))
            MHttp::getJsonAndExit($answer);

        $action = Loyalty::model()->findByPk($data['id']);
        $wallet = PaymentWallet::getActivByDiscodesId($data['discodes']);

        if (!$action or !$wallet)
            MHttp::getJsonAndExit($answer);

        $wl = WalletLoyalty::model()->findByAttributes(array('wallet_id'=>$wallet->id, 'loyalty_id'=>$action->id));

        if (!$wl)
            MHttp::getJsonAndExit($answer);

        $answer['error'] = "no";

        if ($wl->status == WalletLoyalty::STATUS_CONNECTING)
            MHttp::getJsonAndExit($answer);

        $answer['connected'] = true;
        $coupon = array(
            'id' => $action->id,
            'name' => $action->name,
            'coupon_class' => $action->coupon_class,
            'img' => $action->img,
            'desc' => $action->desc,
            'soc_block' => $action->soc_block,
            'status' => $wl->status,
            'errors' => $wl->errors,
        );

        $answer['content'] = $this->renderPartialWithMobile(
            '//spot/block/coupon',
            array('coupon' => $coupon),
            true,
            '//mobile/spot/coupon'
        );

        echo json_encode($answer);
    }

    public function actionForgotPassword()
    {
        $this->layout = self::MOBILE_LAYOUT;
        $this->render('//mobile/spot/forgot', array());
    }
}
