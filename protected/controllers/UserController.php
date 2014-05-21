<?php

class UserController extends MController
{

    public $defaultAction = 'profile';

    // Вывод профиля
    public function actionProfile()
    {
        if (!Yii::app()->user->id)
            $this->setAccess();

        $user = User::model()->findByPk(Yii::app()->user->id);
        $profile = UserProfile::model()->findByPk(Yii::app()->user->id);

        if (!$profile)
        {
            $profile = new UserProfile;
            $profile->user_id = $user->id;
            $profile->sex = UserProfile::SEX_UNKNOWN;
            $profile->save();
        }

        if (Yii::app()->request->getParam('UserProfile'))
        {
            $profile->attributes = Yii::app()->request->getParam('UserProfile');

            if ($profile->validate())
            {
                $profile->save();
                $this->refresh();
            }
        }

        $socnet = array();
        if ($user)
        {
            $userTokens = SocToken::model()->findAllByAttributes(array(
                'user_id' => $user->id,
                'allow_login' => true
            ));

            foreach ($userTokens as $net)
            {
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
        $data = $this->validateRequest();

        if (!isset($data['id']))
            $this->getJsonAndExit($answer);

        $profile = UserProfile::model()->findByPk((int) $data['id']);
        $profile->attributes = $data;

        if ($profile->save())
        {
            $answer['error'] = 'no';
            $answer['content'] = Yii::t('user', "The information has been saved successfully");
        }

        echo json_encode($answer);
    }

    // Страница управления персональными спотами
    public function actionPersonal()
    {
        $this->layout = '//layouts/spots';
        $user_id = Yii::app()->user->id;
        $open_discodes = Yii::app()->request->getQuery('discodes');
        $open_key = Yii::app()->request->getQuery('key');

        if (!$user_id)
            $this->setAccess();

        $user = User::model()->findByPk($user_id);
        if ($user->status == User::STATUS_NOACTIVE)
            $this->redirect('/');

        $dataProvider = new CActiveDataProvider(
                Spot::model()->personal()->used()->selectUser($user_id), array(
            'pagination' => array(
                'pageSize' => 100,
            ),
            'sort' => array('defaultOrder' => 'registered_date asc'),
        ));

        $this->render('personal', array(
            'dataProvider' => $dataProvider,
            'spot_type_all' => SpotType::getSpotTypeArray(),
            'open_discodes' => $open_discodes,
            'open_key'=> $open_key,
        ));
    }

    //Определяем ид спота загружаемого по умолчанию
    public function getDefaultSpot($default)
    {
        $default_discodes = $default;
        if (isset(Yii::app()->request->cookies['default_discodes']))
            $default_discodes = Yii::app()->request->cookies['default_discodes']->value;
        return $default_discodes;
    }

    // Страница управления спотами
    public function actionSpots()
    {
        $this->layout = '//layouts/spots';

        $user_id = Yii::app()->user->id;
        if (!$user_id) $this->setAccess();

        $user = User::model()->findByPk($user_id);
        if ($user->status == User::STATUS_NOACTIVE)  $this->redirect('/');

        $default_discodes = 0;
        $spots = Spot::getActiveByUserId(Yii::app()->user->id, true);
        if ($spots)
           $default_discodes = $this->getDefaultSpot($spots[0]->discodes_id);

        $this->render('//spot/list', array(
            'spots' => $spots,
            'default_discodes' => $default_discodes,
        ));
    }

    public function actionBindSocLogin()
    {
        $serviceName = Yii::app()->request->getQuery('service');
        $discodes = Yii::app()->request->getQuery('discodes');
        $synch = Yii::app()->request->getQuery('synch');

        if (!isset($discodes))
            $discodes = '';
        if (!isset($serviceName))
            $this->setNotFound();
        if (!Yii::app()->user->id)
            $this->setAccess();

        if (isset($synch) and $synch == 'true' and !empty($discodes))
        {
            Yii::app()->session[$serviceName . '_synch_data'] = array(
                'discodes'=> $discodes,
                'key' => $key = Yii::app()->request->getQuery('key'),
                'newField' => Yii::app()->request->getQuery('newField'),
                'link' => Yii::app()->request->getQuery('link'),
            );
        }

        $atributes = User::getSocInfo($serviceName);
        if (!$atributes) $this->setAccess();

        SocToken::setToken($atributes);
        SocInfo::setLogged($atributes);

        if (!empty(Yii::app()->session[$serviceName . '_synch_data']))
        {
            $data = Yii::app()->session[$serviceName . '_synch_data'];
            $data['link'] = urlencode($data['link']);
            unset(Yii::app()->session[$serviceName . '_synch_data']);
            $this->redirect('/spot/bindedContent?service=' . $serviceName . SocInfo::toGetParams($data, '&'));
        }
    }

    //подключение акции, требующей жетона соцсети
    public function actionCheckLike()
    {
        $data = $this->validateRequest();
        $answer = array(
            'error' => 'yes',
            'message_error' => 'yes',
            'message' => '',
            'checked' => false,
            'isSocLogged' => false,
        );
        $link = '';

        if (!Yii::app()->user->id)
            $this->setAccess();

        if (empty($data['id']) or empty($data['discodes']))
            $this->getJsonAndExit($answer);

        $action = Loyalty::model()->findByPk($data['id']);
        $link = $action->getLink();

        $service = SocInfo::getNameBySharingType($action->sharing_type);
        $answer['service'] = $service;

        $criteria = new CDbCriteria;
        $criteria->compare('loyalty_id', $action->id);
        $criteria->compare('wallet.user_id', Yii::app()->user->id);

        /*
        $userActions = WalletLoyalty::model()->with('wallet')->findAll($criteria);
        $count = 0;

        foreach ($userActions as $userAction)
        {
            if (!empty($userAction->part_count))
                $count += $userAction->part_count;
        }

        if ($action->part_limit and $count >= $action->part_limit)
        {
            $answer['isSocLogged'] = true; //чтобы не запускать авторизацию
            $answer['message_error'] = 'yes';
            $answer['message'] = Yii::t('wallet', 'Вы уже поучаствовали в этой акции!');
            $this->getJsonAndExit($answer);
        }
        */

        $answer['error'] = "no";
        $socInfo = new SocInfo;
        if (!$socInfo->isLoggegOn($service, false)){
            $this->getJsonAndExit($answer);
        }

        $answer['isSocLogged'] = true;
        $socToken = SocToken::model()->findByAttributes(array(
            'user_id' => Yii::app()->user->id,
            'type' => SocInfo::getTokenBySharingType($action->sharing_type),
        ));
        $wallet = PaymentWallet::getActivByDiscodesId($data['discodes']);

        if (!$socToken or !$link or !$wallet)
            $this->getJsonAndExit($answer);

        $answer['checked'] = $socInfo->checkSharing($service, $action->sharing_type, $link);
        if (!$answer['checked'])
        {
            $answer['message'] = $action->getPromoMessage();
            $this->getJsonAndExit($answer);
        }

        $wl = WalletLoyalty::model()->findByAttributes(array(
            'wallet_id' => $wallet->id,
            'loyalty_id' => $action->id,
        ));

        if (!$wl)
        {
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

        $answer['content'] = $this->renderPartial('//spot/coupon', array('coupon' => $coupon), true);
        $answer['message_error'] = 'no';
        $answer['message'] = Yii::t('spot', 'Вы участвуете в акции');


        echo json_encode($answer);
    }

    public function actionDisableLoyalty()
    {
        $data = $this->validateRequest();
        $answer = array('error' => "yes");

        if (!Yii::app()->user->id)
            $this->setAccess();

        if (empty($data['id']) or empty($data['discodes']))
            $this->getJsonAndExit($answer);

        $action = Loyalty::model()->findByPk($data['id']);
        $wallet = PaymentWallet::getActivByDiscodesId($data['discodes']);

        if (!$action or !$wallet)
            $this->getJsonAndExit($answer);

        $wl = WalletLoyalty::model()->findByAttributes(array(
            'wallet_id' => $wallet->id,
            'loyalty_id' => $action->id,
        ));

        if (!$wl)
            $this->getJsonAndExit($answer);

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

        $answer['content'] = $this->renderPartial('//spot/coupon', array('coupon' => $coupon), true);
        $answer['error'] = "no";

        echo json_encode($answer);
    }
}