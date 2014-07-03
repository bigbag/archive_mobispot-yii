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
                'returnHost' => Yii::app()->request->getQuery('return_host'),
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
            if (!empty($data['returnHost'])) {
                $this->redirect($data['returnHost'] . '/mobile' . '/spot/bindedContent?service=' . $serviceName . SocInfo::toGetParams($data, '&'), true, 302);
            } else
                $this->redirect('/spot/bindedContent?service=' . $serviceName . SocInfo::toGetParams($data, '&'));
        }
    }

    //подключение акции, требующей жетона соцсети
    public function actionCheckLike()
    {
        $data = MHttp::validateRequest();
        $answer = array(
            'error' => 'yes',
            'message_error' => 'yes',
            'message' => '',
            'checked' => false,
            'isSocLogged' => false,
        );
        $link = '';

        if (!Yii::app()->user->id)
            MHttp::setAccess();

        if (empty($data['id']) or empty($data['discodes']))
            MHttp::getJsonAndExit($answer);

        $action = Loyalty::model()->findByPk($data['id']);
        $link = $action->getLink();

        $service = SocInfo::getNameBySharingType($action->sharing_type);
        $answer['service'] = $service;

        $criteria = new CDbCriteria;
        $criteria->compare('loyalty_id', $action->id);
        $criteria->compare('wallet.user_id', Yii::app()->user->id);

        $answer['error'] = "no";
        $socInfo = new SocInfo;
        if (!$socInfo->isLoggegOn($service, false)){
            MHttp::getJsonAndExit($answer);
        }

        $answer['isSocLogged'] = true;
        $socToken = SocToken::model()->findByAttributes(array(
            'user_id' => Yii::app()->user->id,
            'type' => SocInfo::getTokenBySharingType($action->sharing_type),
        ));
        $wallet = PaymentWallet::getActivByDiscodesId($data['discodes']);

        if (!$socToken or !$link or !$wallet)
            MHttp::getJsonAndExit($answer);

        $answer['checked'] = $socInfo->checkSharing($action);
        if (!$answer['checked']) {
            $answer['message'] = $action->getPromoMessage();
            MHttp::getJsonAndExit($answer);
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
        $wl->checked = $answer['checked'];
        $wl->save();

        $coupon = array(
            'id' => $action->id,
            'name' => $action->name,
            'coupon_class' => $action->coupon_class,
            'img' => $action->img,
            'desc' => $action->desc,
            'soc_block' => $action->soc_block,
            'part' => true,
        );

        $answer['content'] = $this->renderPartial('//spot/block/coupon', array('coupon' => $coupon), true);
        $answer['message_error'] = 'no';
        $answer['message'] = Yii::t('spot', 'You are participating in the action');


        echo json_encode($answer);
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

        $answer['content'] = $this->renderPartial('//spot/block/coupon', array('coupon' => $coupon), true);
        $answer['error'] = "no";

        echo json_encode($answer);
    }
}
