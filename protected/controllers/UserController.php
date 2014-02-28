<?php

class UserController extends MController
{

    public $defaultAction = 'profile';

    // Вывод профиля
    public function actionProfile()
    {
        if (!Yii::app()->user->id)
        {
            $this->setAccess();
        }
        else
        {
            $user = User::model()->findByPk(Yii::app()->user->id);
            $profile = UserProfile::model()->findByPk(Yii::app()->user->id);

            if (!$profile)
            {
                $profile = new UserProfile;
                $profile->user_id = $user->id;
                $profile->sex = UserProfile::SEX_UNKNOWN;
                $profile->save();
            }
            
            $userProfile = Yii::app()->request->getParam('UserProfile');

            if (isset($userProfile))
            {
                $profile->attributes = $_POST['UserProfile'];

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
                    'allow_login' => true,
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
    }

    // Обновление профиля
    public function actionEditProfile()
    {

        $data = $this->validateRequest();
        $answer = array();
        $answer['error'] = 'yes';
        $answer['content'] = '';

        if (isset($data['id']))
        {
            $profile = UserProfile::model()->findByPk((int)$data['id']);
            $profile->attributes = $data;

            if ($profile->save())
            {
                $answer['error'] = 'no';
                $answer['content'] = Yii::t('user', "The information has been saved successfully");
            }

        }

        echo json_encode($answer);

    }

    // Страница управления персональными спотами
    public function actionPersonal()
    {
        $this->layout = '//layouts/spots';

        $defDiscodes = '';
        $defKey = '';
        $message = '';
        $open_spot_id = 0;

        if (Yii::app()->request->getQuery('id', 0))
        {
            $open_spot_id = Yii::app()->request->getQuery('id', 0);
        }

        if (!Yii::app()->user->id)
        {
            $this->setAccess();
        }
        else
        {
            $user_id = Yii::app()->user->id;
            $user = User::model()->findByPk($user_id);

            if ($user->status == User::STATUS_NOACTIVE)
            {
                $this->redirect('/');
            }

            $dataProvider = new CActiveDataProvider(
                    Spot::model()->personal()->used()->selectUser($user_id), array(
                'pagination' => array(
                    'pageSize' => 100,
                ),
                'sort' => array('defaultOrder' => 'registered_date asc'),
            ));

            $this->render('personal', array(
                'open_spot_id' => $open_spot_id,
                'dataProvider' => $dataProvider,
                'spot_type_all' => SpotType::getSpotTypeArray(),
                'defDiscodes' => $defDiscodes,
                'defKey' => $defKey,
                'message' => $message,
            ));
        }
    }

  
    public function actionBindSocLogin()
    {
        $service = Yii::app()->request->getQuery('service');
        $discodes = Yii::app()->request->getQuery('discodes');

        if (!isset($discodes)) $discodes = '';

        if (!isset($service))
            $this->setNotFound();
        
        if (!Yii::app()->user->id)
            $this->setAccess();

        $tech = Yii::app()->request->getParam('tech');

        if (($service == 'instagram') && isset($tech) && ($tech == Yii::app()->eauth->services['instagram']['client_id']))
        {
            Yii::app()->session['instagram_tech'] = $tech;
        }
        $authIdentity = Yii::app()->eauth->getIdentity($service);
        $authIdentity->redirectUrl = Yii::app()->user->returnUrl;
        $authIdentity->cancelUrl = $this->createAbsoluteUrl('user/personal/' . $discodes);

        if ($authIdentity->authenticate())
        {
            $identity = new ServiceUserIdentity($authIdentity);

            if ($identity->authenticate())
            {
                Yii::app()->session[$service] = 'auth';
                Yii::app()->session[$service . '_id'] = $identity->getId();
                Yii::app()->session[$service . '_profile_url'] = $identity->getProfileUrl();
            }
            else
            {
                $authIdentity->cancel();
            }
        }
    }
    
    //подключение акции, требующей жетона соцсети
    public function actionCheckLike()
    {
        $data = $this->validateRequest();
        $answer = array();
        $answer['error'] = "yes";
        $answer['isSocLogged'] = false;
        $link = '';
            
        if (!Yii::app()->user->id)
        {
            $this->setAccess();
        }

        if (!empty($data['id']) && !empty($data['discodes']))
        {
            $action = Loyalty::model()->findByPk($data['id']);
            if ($action and strpos($action->desc, '<a ng-click="checkLike('.$action->id.')">') !== false)
            {
                $link = substr($action->desc, (strpos($action->desc, '<a ng-click="checkLike('.$action->id.')">') + strlen('<a ng-click="checkLike('.$action->id.')">')));
                if (strpos($link, '</a>') > 0)
                    $link = substr($link, 0, strpos($link, '</a>'));
            }
            
            $service = SocInfo::getNameBySharingType($action->sharing_type);
            $answer['service'] = $service;
            
            $criteria = new CDbCriteria;
            $criteria->compare('loyalty_id', $action->id);
            $criteria->compare('wallet.user_id', Yii::app()->user->id);
            
            $userActions = WalletLoyalty::model()->with('wallet')->findAll($criteria);
            $count = 0;
            
            foreach($userActions as $userAction)
            {
                if (!empty($userAction->part_count))
                    $count += $userAction->part_count;
            }
            
            if ($action->part_limit && $count >= $action->part_limit)
            {
                $answer['isSocLogged'] = true; //чтобы не запускать авторизацию
                $answer['message_error'] = 'yes';
                $answer['message'] = Yii::t('wallet', 'Вы уже поучаствовали в этой акции!');
            }
            else
            {
                $socInfo = new SocInfo;
                
                if ($socInfo->isLoggegOn($service, false))
                {
                    $answer['isSocLogged'] = true;
                    
                    $socToken=SocToken::model()->findByAttributes(array(
                        'user_id'=>Yii::app()->user->id,
                        'type'=>SocInfo::getTokenBySharingType($action->sharing_type),
                    ));
                    
                    $wallet = PaymentWallet::model()->findByAttributes(
                        array(
                            'discodes_id' => $data['discodes'],
                            'user_id' => Yii::app()->user->id,
                            'status' => PaymentWallet::STATUS_ACTIVE,
                        )
                    );
                    
                    if ($socToken and $link and $wallet)
                    {
                        $likesStack = LikesStack::model()->findByAttributes(array(
                            'token_id' => $socToken->id,
                            'loyalty_id' => $action->id,
                        ));

                        if (!$likesStack)
                        {
                            $likesStack = new LikesStack;
                            $likesStack->token_id = $socToken->id;
                            $likesStack->loyalty_id = $action->id;
                            $likesStack->save();
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
                            $wl->bonus_count = $action->bonus_count;
                            $wl->save();
                        }
                        
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
                        $answer['message'] = Yii::t('wallet', 'Вы участвуете в акции');
                    }
                }
            }
            
            $answer['error'] = "no";
        }

        echo json_encode($answer);
    }
    
    public function actionDisableLoyalty()
    {
        $data = $this->validateRequest();
        $answer = array();
        $answer['error'] = "yes";
        
        if (!Yii::app()->user->id)
        {
            $this->setAccess();
        }
        
        if (!empty($data['id']) && !empty($data['discodes']))
        {
            $action = Loyalty::model()->findByPk($data['id']);
            $wallet = PaymentWallet::model()->findByAttributes(
                array(
                    'discodes_id' => $data['discodes'],
                    'user_id' => Yii::app()->user->id,
                    'status' => PaymentWallet::STATUS_ACTIVE,
                )
            );
            if ($action and $wallet)
            {
                $wl = WalletLoyalty::model()->findByAttributes(array(
                    'wallet_id' => $wallet->id,
                    'loyalty_id' => $action->id,
                ));
                
                if ($wl)
                {
                    $wl->delete();
 
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
                }
            }
        }
        
        echo json_encode($answer);
    }
}