<?php

class WalletController extends MController
{
    public $layout = '//corp/layouts/all';

    //Список кошельков
    public function actionIndex()
    {
        if (Yii::app()->user->isGuest) $this->setAccess();

        $user = User::model()->findByPk(Yii::app()->user->id);

        if ($user)
        {
            if ($user->status == User::STATUS_BANNED) $this->setAccess();

            $wallets = PaymentWallet::model()->findAllByAttributes(
                array('user_id'=>$user->id), 
                array('order'=>'creation_date asc')
            );

            $this->render('index', array(
                'wallets' => $wallets,
            ));
        }
    }

    // Просмотр кошелька
    public function actionGetView()
    {
        $data = $this->validateRequest();
        $answer = array();

        $answer['error'] = "yes";
        $answer['content'] = "";

        if (isset($data['wallet_id']))
        {
            $wallet = PaymentWallet::model()->findByPk($data['wallet_id']);

            if ($wallet and Yii::app()->user->id == $wallet->user_id)
            {
                $logs = PaymentLog::getListByWalletId($data['wallet_id']);
                $actions = WalletLoyalty::getByWalletId($data['wallet_id']);
                $sms_info = SmsInfo::getByWalletId($data['wallet_id'], Yii::app()->user->id);

                $cards = array();
                if ($logs)
                {
                   foreach ($logs as $log) 
                    {
                        $cards[$log->card_pan] = $log->history_id;
                    } 
                }

                $auto = PaymentAuto::model()->findByAttributes(
                    array('wallet_id' => $wallet->id)
                );

                $answer['content'] = $this->renderPartial('//corp/wallet/block/wallet_view', array(
                    'wallet' => $wallet,
                    'actions' => $actions,
                    'cards' => $cards,
                    'auto' => $auto,
                    'sms_info' => $sms_info,
                    ), true);
                $answer['error'] = "no";
            }
        }
        echo json_encode($answer);
    }
    
    //Список акций
    public function actionOffers()
    {
        
        $this->render('offers', array('actions'=>Loyalty::getAllLoyalties()));
    }

    public function actionGetHistory()
    {
        $data = $this->validateRequest();
        $answer = array();
        $answer['error'] = "yes";
        if (isset($data['wallet_id']))
        {
            $wallet = PaymentWallet::model()->findByPk($data['wallet_id']);
            if ($wallet and Yii::app()->user->id == $wallet->user_id)
            {
                $page = 1;
                if (isset($data['page']) and $data['page'] > 1)
                    $page = $data['page'];

                $filterDate = ''; 
                if (isset($data['date']) and CDateTimeParser::parse($data['date'],'dd.MM.yyyy'))
                    $filterDate = $data['date'];

                $filterTerm = '';
                if (isset($data['term']) && $data['term'])
                    $filterTerm = $data['term'];

                $answer = PaymentHistory::getListByParams($wallet->id, $page);
                // $answer['content'] = $this->renderPartial('//corp/wallet/block/history', array(
                //     'wallet' => $wallet,
                //     'history' => $history_list['history'],
                //     'pagination' => $history_list['pagination'],
                //     'filter' => $history_list['filter'],
                //     ), true);
                $answer['error'] = "no";
            }
        }
    
        echo json_encode($answer);
    }

    public function actionGetActions()
    {
        $data = $this->validateRequest();
        $answer = array();
        $answer['error'] = "yes";
        if (isset($data['id']))
        {
            $wallet = PaymentWallet::model()->findByPk($data['id']);
            if ($wallet and Yii::app()->user->id == $wallet->user_id)
            {
                $page = 1;
                if (isset($data['page']) and $data['page'] > 1)
                    $page = $data['page'];

                $status = WalletLoyalty::STATUS_ALL;
                if (isset($data['status']))
                    $status = $data['status'];

                $search = '';
                if (!empty($data['search']))
                    $search = $data['search'];

                $actions = WalletLoyalty::getByWalletId($data['id'], $status, $page, $search);
                $answer['content'] = $this->renderPartial('//corp/wallet/block/loyalty', array(
                    'wallet' => $wallet,
                    'actions' => $actions,
                    ), true);
                $answer['error'] = "no";
            }
        }
    
        echo json_encode($answer);
    }
    
    public function actionGetAllActions()
    {
        $data = $this->validateRequest();
        $answer = array();
        $answer['error'] = "yes";

        $page = 1;
        if (isset($data['page']) && $data['page'] > 1)
            $page = $data['page'];

        $status = WalletLoyalty::STATUS_ALL;
        if (isset($data['status']))
            $status = $data['status'];

        $search = '';
        if (!empty($data['search']))
            $search = $data['search'];

        $actions = Loyalty::getAllLoyalties($status, $page, $search);
        $answer['content'] = $this->renderPartial('//corp/wallet/block/offers_tbody', array(
            'actions' => $actions,
            ), true);
        $answer['error'] = "no";
    
        echo json_encode($answer);
    }
    
    //Сохранение телефонного номера и подключение sms, если не подключены
    public function actionSavePhone()
    {
        $data = $this->validateRequest();
        $answer = array();
        $answer['error'] = "yes";
        $answer['content'] = '';


        if (isset($data['phone']) and isset($data['wallet_id']))
        {
            $all_wallets = (isset($data['all_wallets']))?$data['all_wallets']:0;
            $user_id = Yii::app()->user->id;

            if ($all_wallets == 0) 
            {
                $wallet = PaymentWallet::model()->findByPk($data['wallet_id']);
                if (!$wallet) $this->setBadRequest();

                $sms_info = SmsInfo::model()->findByAttributes(
                    array('wallet_id'=>$wallet->id)
                );
                if (!$sms_info) 
                {
                    $sms_info = new SmsInfo;
                    $sms_info->wallet_id = $wallet->id;
                    $sms_info->user_id = $user_id;
                }
                $sms_info->phone = $data['phone'];
                $sms_info->status = SmsInfo::STATUS_ON;
                if ($sms_info->save()) 
                {
                    $answer['error'] = "no";
                    $answer['content'] = 'Sms информирование включено';
                }
            }
            else
            {
                SmsInfo::model()->deleteAllByAttributes(
                    array('user_id'=>$user_id)
                );
                $wallets = PaymentWallet::model()->findAllByAttributes(
                    array('user_id'=>$user_id));

                foreach ($wallets as $wallet) {
                    $sms_info = new SmsInfo;
                    $sms_info->wallet_id = $wallet->id;
                    $sms_info->user_id = $user_id;
                    $sms_info->phone = $data['phone'];
                    $sms_info->status = SmsInfo::STATUS_ON;
                    $sms_info->save();
                }

                $answer['error'] = "no";
                $answer['content'] = 'Sms информирование включено';
            }

            // if (empty($data['all_wallets']))
            // {
            //     //для текущего кошелька
            //     $wallet = PaymentWallet::model()->with('sms_info')->findByPk($data['id']);
            //     if ($wallet and Yii::app()->user->id == $wallet->user_id)
            //     {
            //         $sms_info = $wallet->sms_info;
            //         if (!$sms_info)
            //             $sms_info = new SmsInfo;
            //         $sms_info->wallet_id = $wallet->id;
            //         $sms_info->user_id = $wallet->user_id;
            //         $sms_info->phone = $data['phone'];
            //         if ($data['phone'])
            //             $sms_info->status = SmsInfo::STATUS_ON;
            //         else
            //             $sms_info->status = SmsInfo::STATUS_OFF;

            //         if ($sms_info->save())
            //             $answer['error'] = 'no';
            //     }
            // }
            // else
            // {
            //     //для всех кошельков
            //     $sms_infos = SmsInfo::model()->findAllByAttributes(
            //         array(
            //             'user_id' => Yii::app()->user->id
            //         )
            //     );
            //     foreach($sms_infos as $sub)
            //     {
            //         if ($data['phone'])
            //             $sub->status = SmsInfo::STATUS_ON;
            //         else
            //             $sub->status = SmsInfo::STATUS_OFF;
            //         $sub->phone = $data['phone'];
            //         $sub->save();
            //     }
            //     $answer['error'] = 'no';
            // }
        }
        
        echo json_encode($answer);
    }

    //Отключаем sms информирование
    public function actionRemovePhone()
    {
        $data = $this->validateRequest();
        $answer = array();
        $result = False;
        $answer['error'] = "yes";
        $answer['content'] = '';

        if (isset($data['phone']) and isset($data['wallet_id']))
        {
            $user_id = Yii::app()->user->id;
            $all_wallets = (isset($data['all_wallets']))?$data['all_wallets']:0;

            if ($all_wallets == 0) 
            {
                $sms_info = SmsInfo::model()->findByAttributes(
                    array(
                        'wallet_id'=>$data['wallet_id'],
                        'user_id'=>$user_id
                    )
                );
                if (!$sms_info)  $this->setNotFound();
                if ($sms_info->delete()) $result = True;
            }
            else 
            {
                SmsInfo::model()->deleteAllByAttributes(
                    array('user_id'=>$user_id)
                );
                $result = True;
                
            } 
            if ($result)
            {
                $answer['error'] = "no";
                $answer['content'] = 'Sms информирование отключено';
            }

        }
        echo json_encode($answer);
    }

    //включение/отключение sms для всех кошельков пользователя
    public function actionSmsAllWallets()
    {
        $data = $this->validateRequest();
        $answer = array();
        $answer['error'] = "yes";

        if (isset($data['id']) && isset($data['phone']) && isset($data['enable']) && preg_match("~^[+][0-9]{11}$~", $data['phone']))
        {
            if ($data['enable'])
            {
                //подключить для всех
                $userWallets = PaymentWallet::model()->with('sms_info')->findAllByAttributes(array('user_id' => Yii::app()->user->id));
                foreach($userWallets as $wallet)
                {
                    $sms_info = $wallet->sms_info;
                    if (!$sms_info)
                        $sms_info = new SmsInfo;
                    $sms_info->wallet_id = $wallet->id;
                    $sms_info->user_id = $wallet->user_id;
                    $sms_info->phone = $data['phone'];
                    $sms_info->status = SmsInfo::STATUS_ON;
                    $sms_info->save();
                }
            }
            else
            {
                //отключить
                $sms_infos = SmsInfo::model()->findAllByAttributes(array('user_id' => Yii::app()->user->id));
                foreach($sms_infos as $sub)
                {
                    if ($sub->wallet_id != $data['id'])
                    {
                        $sub->status = SmsInfo::STATUS_OFF;
                        $sub->save();
                    }
                }
            }
            
            $answer['error'] = 'no';
        }
        
        echo json_encode($answer);
    }
    
     // Блокировка кошелька
    public function actionBlockWallet()
    {
        $data = $this->validateRequest();
        $answer = array();
        $answer['error'] = "yes";
        $answer['content'] = "";

        if (isset($data['id']))
        {
            $wallet = PaymentWallet::model()->findByPk($data['id']);
            if ($wallet->status == PaymentWallet::STATUS_BANNED)
            {
                $wallet->status = PaymentWallet::STATUS_ACTIVE;
                $answer['content'] = 'Заблокировать';
            }
            else if ($wallet->status == PaymentWallet::STATUS_ACTIVE)
            {
                $wallet->status = PaymentWallet::STATUS_BANNED;
                $answer['content'] = 'Разблокировать';
            }
            $wallet->save(false);
            $answer['error'] = "no";
            $answer['status'] = $wallet->status;
        }

        echo json_encode($answer);
    }

    // Добавление нового кошелька
    public function actionAddWallet()
    {
        $data = $this->validateRequest();

        $answer = array();
        $answer['error'] = "yes";
        $answer['content'] = "";

        if (isset($data['code']) and isset($data['name']))
        {
            $spot = Spot::model()->findByAttributes(array('code' => $data['code']));
            if ($spot)
            {
                $wallet = PaymentWallet::model()->findByAttributes(
                    array(
                        'discodes_id' => $spot->discodes_id,
                        'user_id' => 0,
                    )
                );
                if ($wallet)
                {
                    $wallet->status = PaymentWallet::STATUS_ACTIVE;
                    $wallet->user_id = Yii::app()->user->id;
                    $wallet->name = trim($data['name']);

                    if ($wallet->save() and $spot->status == Spot::STATUS_ACTIVATED)
                    {
                        $spot->user_id = $wallet->user_id;
                        $spot->lang = $this->getLang();
                        $spot->status = Spot::STATUS_REGISTERED;
                        $spot->name = $wallet->name;
                        $spot->registered_date = date('Y-m-d H:i:s');
                        $spot->save(false);
                    }

                }

                $answer['content'] = $this->renderPartial('//corp/wallet/block/wallet', array(
                    'data' => $wallet,
                        ), true);
                $answer['error'] = "no";
            }
        }
        echo json_encode($answer);
    }

     // Включение и отключение автоплатежа
    public function actionRecurrent()
    {
        $data = $this->validateRequest();

        $answer = array();
        $answer['error'] = "yes";
        $answer['content'] = "";
        $answer['auto'] = "";

        if (isset($data['wallet_id']))
        {
            $recurrent = PaymentAuto::model()->findByAttributes(
                    array(
                        'wallet_id' => (int)$data['wallet_id'],
                    )
                );

            if ($recurrent and $recurrent->delete())
            {
                $answer['error'] = "no";
                $answer['content'] = 'Автопополнение выключено.';
            }
        }

        else  if (isset($data['amount']) and ($data['amount'] < 901))
        {
            $log = PaymentLog::model()->findByAttributes(
                    array(
                        'history_id' => (int)$data['history_id'],
                    )
                ); 
            if ($log)
            {
                $recurrent = PaymentAuto::model()->findByAttributes(
                    array(
                        'wallet_id' => $log->wallet_id,
                    )
                );
                if (!$recurrent)
                {
                    $recurrent = new PaymentAuto();
                    $recurrent->history_id = (int)$data['history_id'];
                    $recurrent->amount = (int) $data['amount'];
                    $recurrent->type = 0;//(int) $data['type'];        только TYPE_CEILING = 0
                    $recurrent->wallet_id = $log->wallet_id;
                    $recurrent->card_pan = $log->card_pan;

                    if ($recurrent->save())
                    {
                        $auto['pan'] = $recurrent->card_pan;

                        $delta = 4 * 60 * 60;
                        $recurrent->creation_date = date('H:i d.m.Y', strtotime($recurrent->creation_date) + $delta);

                        $auto['date'] = $recurrent->creation_date;
                        $auto['id'] = $recurrent->wallet_id;

                        $answer['auto'] = $auto;
                        $answer['error'] = 'no';
                        $answer['content'] = 'Автопополнение включено.';
                        $answer['system_class'] = 'm-card_' . PaymentLog::getSystemByPan($recurrent->card_pan);
                    } 
                }
            }
        }
        echo json_encode($answer);
    }

    // Формирование платежа
    public function actionAddSumm()
    {
        $data = $this->validateRequest();
        $answer = array();
        $answer['error'] = "yes";

        if (isset($data['wallet_id']) and isset($data['amount']) and ($data['amount'] > 99))
        {
            $amount = (int) $data['amount'];

            $wallet = PaymentWallet::model()->findByPk($data['wallet_id']);
            if ($wallet)
            {
                $delta = 1000 - $wallet->balance;
                if ($delta - $amount >= 0)
                {

                    $history = new PaymentHistory;
                    $history->user_id = Yii::app()->user->id;
                    $history->wallet_id = $wallet->id;
                    $history->amount = $data['amount'];

                    if ($history->save())
                    {
                        $url = explode("/", Yii::app()->getBaseUrl(true));

                        $payment = Yii::app()->ut;
                        $token = sha1(Yii::app()->request->csrfToken);

                        $order = array();
                        $order['shopId'] = $payment->shopId;
                        $order['customerId'] = $wallet->id;
                        $order['orderId'] = $history->id;
                        $order['amount'] = $data['amount'];
                        $order['signature'] = $payment->getPaySign($order);
                        $order['return_ok'] = 'http://corp.' . $url[2] . '/wallet/payUniteller?result=success&token=' . $token;
                        $order['return_error'] = 'http://corp.' . $url[2] . '/wallet/payUniteller?result=error&token=' . $token;
                        
                        $answer['content'] = $this->renderPartial('//corp/wallet/block/_bay_form',
                            array(
                                'order' => $order,
                            ), 
                            true
                        );
                        $answer['error'] = "no";
                    }
                }
            }
        }
        echo json_encode($answer);
    }

    // Обработка ответа о платеже
    public function actionPayUniteller()
    {
        if (Yii::app()->user->isGuest) $this->setAccess();
            
            $token = (int)Yii::app()->request->getParam('token', 0);
            $id = (int)Yii::app()->request->getParam('Order_ID', 0);

            if ($id)
            {
                $history = PaymentHistory::model()->findByAttributes(
                    array(
                        'id' => $id,
                        'status' => PaymentHistory::STATUS_NEW,
                    )
                );

                if ($history)
                {
                    $payment = Yii::app()->ut;
                    $info = $payment->getCheckData($id);

                    if (isset($info['status'])) $status = strtolower($info['status']); 
                    else $status = false;

                    if ($status == 'authorized' or $status == 'paid')
                    {
                        $history->status = PaymentHistory::STATUS_COMPLETE;
                        $wallet = PaymentWallet::model()->findByPk($history->wallet_id);
                        
                        if ($wallet)
                        {
                            $wallet->balance = $wallet->balance + $history->amount;
                            if ($wallet->save(false)) 
                                $history->type = PaymentHistory::TYPE_PLUS;
                        }
                    }
                    else 
                        $history->status = PaymentHistory::STATUS_FAILURE;

                    if (!$status) 
                        $history->status = PaymentHistory::STATUS_NEW;
  
                    $history->creation_date = date('Y-m-d H:i:s');
                    $history->save(false);
                }
            }
        $url = explode("/", Yii::app()->getBaseUrl(true));
        Yii::app()->request->redirect('http://corp.' . $url[2] . '/wallet/');
    }
    
    //добавление жетона соцсети в стек - на проверку лайка 
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

        if (!empty($data['id']))
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
                    
                    if ($socToken and $link)
                    {
                        $likesStack = LikesStack::model()->findByAttributes(array(
                            'token_id' => $socToken->id,
                            'loyalty_id' => $action->id
                        ));

                        if (!$likesStack)
                        {
                            $likesStack = new LikesStack;
                            $likesStack->token_id = $socToken->id;
                            $likesStack->loyalty_id = $action->id;
                            $likesStack->save();
                        }
                        
                        $answer['message_error'] = 'no';
                        $answer['message'] = Yii::t('wallet', 'Вы участвуете в акции');
                    }
                }
            }
            
            $answer['error'] = "no";
        }

        echo json_encode($answer);
    }

    //Прототип проверки like
    public function actionCheckLikePrototype()
    {
        if (Yii::app()->user->isGuest) 
            $this->setAccess();
        $message = '<hr/>';
        
        $page_id = Yii::app()->request->getParam('page_id', 0);
        $url = Yii::app()->request->getParam('url', 0);
        $appToken = FacebookContent::getAppToken();
        
        if (empty($page_id) && empty($url))
            $this->setNotFound();
        elseif(empty($page_id) && !empty($url))
        {
            
            if (strpos($url, 'facebook.com/') !== false)
            {
                $page = SocContentBase::makeRequest('https://graph.facebook.com/' . FacebookContent::parseUsername($url).'?access_token='.$appToken);
                if (!empty($page['id']))
                    $page_id = $page['id'];
            }
        }
        
        $userToken = false;
        $socToken=SocToken::model()->findByAttributes(array(
            'user_id'=>Yii::app()->user->id,
            'type'=>1,
        ));
        
        /*
        if ($socToken && $socToken->token_expires > time())
        {
            $userToken = $socToken->user_token;
            
            
            $validation = self::makeRequest('https://graph.facebook.com/debug_token?input_token=' . $userToken . '&access_token=' . $appToken, array(), false);
            $validation = CJSON::decode($validation, true);
            if (!(isset($validation['data']) and isset($validation['data']['is_valid']) and ($validation['data']['is_valid'] == 'true')))
            {
                $userToken = false;
            }
        }
        */
        /*
        if (!$userToken)
        {
            $this->redirect(array('service/Soclogin?service=facebook'));
        
        }
        */
        
        if (empty($page))
            $page = SocContentBase::makeRequest('https://graph.facebook.com/'.$page_id.'?&access_token='.$socToken->user_token);

        if (!empty($page_id) && !empty($page) && !empty($page['id']) && !empty($page['link']))
        {
            $page['link'] = str_replace("http://", 'https://', $page['link']); 
            $like = SocContentBase::makeRequest('https://graph.facebook.com/me/likes/'.$page_id.'?&access_token='.$socToken->user_token);
 


            if (!empty($like['data']) && !empty($like['data'][0]) && !empty($like['data'][0]['id']))
            {
                $message .= 'Вы лайкнули страницу: '.$page['link'].'<hr/>';
            }
            else
                $message .= 'Вы не лайкали эту страницу: '.$page['link'].'<hr/>';
                
                
            //Шариннг страницы
            //$userFeed = self::makeRequest('https://graph.facebook.com/me/feed?access_token=' . $socToken->user_token);
            $shared = false;
            $query_url = 'https://graph.facebook.com/fql?q=SELECT+attachment+,created_time+,type+,description+FROM+stream+WHERE+source_id='
                                .$socToken->soc_id
                                .'+and+actor_id='
                                .$socToken->soc_id
                                .'+and+type=80'
                                .'+and+attachment.href=\''.$page['link'].'\'&access_token='
                                .$socToken->user_token;

            if (@fopen($query_url, 'r'))
            {
                $fql_query_result = file_get_contents($query_url);
                $userFeed = json_decode($fql_query_result, true);
                if (isset($userFeed['data']) && is_array($userFeed['data']) && count($userFeed['data']))
                {
                    foreach ($userFeed['data'] as $post)
                    {
                        if (isset($post['description']) && strpos($post['description'], 'shared a page') !== false)
                            $shared = true;
                    }
                }
            }
            
            if ($shared)
                $message .= 'Вы разшарили страницу: '.$page['link'].'<hr/>';
            else 
                $message .= 'Вы не разшарили страницу: '.$page['link'].'<hr/>';
        }
        else
            $message .= 'Страница Facebook не найдена';

        $this->render('checkLike', array('message'=>$message));
    }
}
