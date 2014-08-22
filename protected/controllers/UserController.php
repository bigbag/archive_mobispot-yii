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
        }

        $atributes = User::getSocInfo($serviceName);
        if (!$atributes) MHttp::setAccess();

        SocToken::setToken($atributes);
        SocInfo::setLogged($atributes);

        if (!empty(Yii::app()->session[$serviceName . '_synch_data'])) {
            $data = Yii::app()->session[$serviceName . '_synch_data'];
            $data['link'] = urlencode($data['link']);
            unset(Yii::app()->session[$serviceName . '_synch_data']);

            $this->redirect('/spot/bindedContent?service=' . $serviceName . SocInfo::toGetParams($data, '&'));
        } elseif(!empty(Yii::app()->session[$serviceName . '_loyalty_data'])) {
            $data = Yii::app()->session[$serviceName . '_loyalty_data'];
            unset(Yii::app()->session[$serviceName . '_loyalty_data']);
            $this->redirect('/user/checkLike' . SocInfo::toGetParams($data));
        }
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

        $answer = array(
            'error' => 'yes',
            'message_error' => 'yes',
            'message' => '',
            'checked' => false,
            'isSocLogged' => false,
            'sharing_logged' => false,
            'sharing_checked' => false,
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
            
        $wallet = PaymentWallet::getActivByDiscodesId($data['discodes']);
        
        for ($i=$ind; $i < count($sharings); $i++) {
        
            $answer['ind'] = $i;
            Yii::app()->session['check_loyalty_' . $action->id] = $i;
        
            $link = $sharings[$i]->link;

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
            $answer['isSocLogged'] = true;
            
            $socToken = SocToken::model()->findByAttributes(array(
                'user_id' => Yii::app()->user->id,
                'type' => SocInfo::getTokenBySharingType($sharings[$i]->sharing_type),
            ));

            if (!$socToken or !$link or !$wallet)
                MHttp::getJsonOrRedirect($answer, $target);
            
            if (MHttp::isHostMobile()) {
                $spot = Spot::getSpot(array('discodes_id' => $data['discodes']));
                if ($spot)
                    $target = '/spot/view/' . $spot->url;
            }

            $checked = $socInfo->checkLoyaltySharing($sharings[$i]);
            
            if (!$checked) {
                    $answer['content'] = $this->    renderPartialWithMobile(
                        '//spot/block/coupon_error',
                        array('condition'=>$sharings[$i]->desc, 'id_loyalty'=>$action->id),
                        true
                );
                
                $answer['message'] = $action->getPromoMessage();
                MHttp::getJsonOrRedirect($answer, $target);
            }
            
            if (isset($data['sharing_ind']) && $data['sharing_ind'] <= $i)
                $answer['sharing_checked'] = true;
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
        
        $wl->checked = true;
        $wl->save();
        $event = new PersonEvent;
        $event->addByUserLoyaltyId($wallet->user_id, $action->id);
        $answer['checked'] = true;

        $coupon = array(
            'id' => $action->id,
            'name' => $action->name,
            'coupon_class' => $action->coupon_class,
            'img' => $action->img,
            'desc' => $action->desc,
            'soc_block' => $action->soc_block,
            'part' => true,
        );

        $answer['content'] = $this->renderPartialWithMobile(
            '//spot/block/coupon',
            array('coupon' => $coupon),
            true,
            '//mobile/spot/coupon'
        );

        $answer['message_error'] = 'no';
        $answer['message'] = Yii::t('spot', 'You are participating in the action');

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
            
        $event = new PersonEvent;
        $event->removeByUserLoyaltyId($wallet->user_id, $action->id);
        $wl->checked = false;
        $wl->save();

        $coupon = array(
            'id' => $action->id,
            'name' => $action->name,
            'coupon_class' => $action->coupon_class,
            'img' => $action->img,
            'desc' => $action->desc,
            'soc_block' => $action->soc_block,
            'part' => false,
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
    
    
    public function actionGetAction()
    {
        $data = MHttp::validateRequest();
        $answer = array('error' => 'yes');    
        
        if (!Yii::app()->user->id)
            MHttp::setAccess();

        if (empty($data['id']) or empty($data['discodes']))
            MHttp::getJsonAndExit($answer);
            
        $action = Loyalty::model()->findByPk($data['id']);
        
        if (!$action)
            MHttp::getJsonAndExit($answer);
        
        $coupon = array(
            'id' => $action->id,
            'name' => $action->name,
            'coupon_class' => $action->coupon_class,
            'img' => $action->img,
            'desc' => $action->desc,
            'soc_block' => $action->soc_block,
            'part' => false,
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

    public function actionForgotPassword()
    {
        $this->layout = self::MOBILE_LAYOUT;
        $this->render('//mobile/spot/forgot', array());
    }
}
