<?php

class WalletController extends MController
{
    public $layout = '//corp/layouts/all';

    //Список кошельков
    public function actionIndex()
    {
        if (Yii::app()->user->isGuest) $this->setAccess();

        $user = User::getById(Yii::app()->user->id);

        if ($user)
        {
            if ($user->status == User::STATUS_BANNED) $this->setAccess();

            $dataProvider = new CActiveDataProvider(
                PaymentWallet::model()->selectUser($user->id), array(
                'pagination' => array(
                    'pageSize' => 100,
                ),
                'sort' => array('defaultOrder' => 'creation_date asc'),
            ));

            $this->render('index', array(
                'dataProvider' => $dataProvider,
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
                $historyList = PaymentHistory::getListWithPagination($data['wallet_id']);
                $history = $historyList['history'];
                $logs = PaymentLog::getListByWalletId($data['wallet_id']);
                $actions = WalletLoyalty::getLoyaltiesByWalletId($data['wallet_id']);
                $smsInfo = SmsInfo::getSmsInfoForWallet($data['wallet_id']);

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
                    'history' => $history,
                    'pagination' => $historyList['pagination'],
                    'actions' => $actions,
                    'filter' => $historyList['filter'],
                    'cards' => $cards,
                    'auto' => $auto,
                    'limit_autopayment' => PaymentAuto::LIMIT,
                    'smsInfo' => $smsInfo,
                    ), true);
                $answer['error'] = "no";
            }
        }
        echo json_encode($answer);
    }
    
    //Список акций
    public function actionOffers()
    {
        
        $this->render('offers', array('actions'=>WalletLoyalty::getAllLoyalties()));
    }

    public function actionGetHistory()
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
                if (isset($data['page']) && $data['page'] > 1)
                    $page = $data['page'];
                $filterDate = ''; 
                if (isset($data['date']) && preg_match("~^[0-9]{2}.[0-9]{2}.[0-9]{4}$~", $data['date']))
                    $filterDate = $data['date'];
                $filterTerm = '';
                if (isset($data['term']) && $data['term'])
                    $filterTerm = $data['term'];
                $historyList = PaymentHistory::getListWithPagination($data['id'], $page, $filterDate, $filterTerm);
                $answer['content'] = $this->renderPartial('//corp/wallet/block/history', array(
                    'wallet' => $wallet,
                    'history' => $historyList['history'],
                    'pagination' => $historyList['pagination'],
                    'filter' => $historyList['filter'],
                    ), true);
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
                if (isset($data['page']) && $data['page'] > 1)
                    $page = $data['page'];
                $status = WalletLoyalty::STATUS_ALL;
                if (isset($data['status']))
                    $status = $data['status'];
                $search = '';
                if (!empty($data['search']))
                    $search = $data['search'];
                $actions = WalletLoyalty::getLoyaltiesByWalletId($data['id'], $status, $page, $search);
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
    
    //сохранение телефонного номера и подключение sms, если не подключены
    public function actionSavePhone()
    {
        $data = $this->validateRequest();
        $answer = array();
        $answer['error'] = "yes";
        if (preg_match("~^[+][0-9]$~", $data['phone']))
            $data['phone'] = '';

        if (isset($data['id']) && isset($data['phone']) && (preg_match("~^[+][0-9]{11}$~", $data['phone']) || '' == $data['phone']))
        {
            if (empty($data['all_wallets']))
            {
                //для текущего кошелька
                $wallet = PaymentWallet::model()->with('smsInfo')->findByPk($data['id']);
                if ($wallet and Yii::app()->user->id == $wallet->user_id)
                {
                    $smsInfo = $wallet->smsInfo;
                    if (!$smsInfo)
                        $smsInfo = new SmsInfo;
                    $smsInfo->wallet_id = $wallet->id;
                    $smsInfo->user_id = $wallet->user_id;
                    $smsInfo->phone = $data['phone'];
                    if ($data['phone'])
                        $smsInfo->active = true;
                    else
                        $smsInfo->active = false;

                    if ($smsInfo->save())
                        $answer['error'] = 'no';
                }
            }
            else
            {
                //для всех кошельков
                $smsInfos = SmsInfo::model()->findAllByAttributes(array('user_id' => Yii::app()->user->id));
                foreach($smsInfos as $sub)
                {
                    if ($data['phone'])
                        $sub->active = true;
                    else
                        $sub->active = false;
                    $sub->phone = $data['phone'];
                    $sub->save();
                }
                $answer['error'] = 'no';
            }
        }
        
        echo json_encode($answer);
    }
  
    //отмена sms-информирования
    public function actionCancelSms()
    {
        $data = $this->validateRequest();
        $answer = array();
        $answer['error'] = "yes";

        if (isset($data['id']))
        {
            $wallet = PaymentWallet::model()->findByPk($data['id']);
            if ($wallet and Yii::app()->user->id == $wallet->user_id)
            {
                $smsInfo = $wallet->smsInfo;
                if ($smsInfo)
                {
                    $smsInfo->active = false;
                    $smsInfo->save();
                }

                $answer['error'] = 'no';
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
                $userWallets = PaymentWallet::model()->with('smsInfo')->findAllByAttributes(array('user_id' => Yii::app()->user->id));
                foreach($userWallets as $wallet)
                {
                    $smsInfo = $wallet->smsInfo;
                    if (!$smsInfo)
                        $smsInfo = new SmsInfo;
                    $smsInfo->wallet_id = $wallet->id;
                    $smsInfo->user_id = $wallet->user_id;
                    $smsInfo->phone = $data['phone'];
                    $smsInfo->active = true;
                    $smsInfo->save();
                }
            }
            else
            {
                //отключить
                $smsInfos = SmsInfo::model()->findAllByAttributes(array('user_id' => Yii::app()->user->id));
                foreach($smsInfos as $sub)
                {
                    if ($sub->wallet_id != $data['id'])
                    {
                        $sub->active = false;
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

        if (isset($data['amount']) and ($data['amount'] > 99))
        {
            $amount = (int) $data['amount'];

            $wallet = PaymentWallet::model()->findByPk($data['wallet']);
            if ($wallet)
            {
                $delta = 1000 - $wallet->balance;
                if ($delta - $amount >= 0)
                {

                    $history = new PaymentHistory;
                    $history->user_id = Yii::app()->user->id;
                    $history->wallet_id = $data['wallet'];
                    $history->amount = $data['amount'];

                    if ($history->save())
                    {

                        $payment = Yii::app()->ut;
                        $token = sha1(Yii::app()->request->csrfToken);

                        $order = array();
                        $order['shopId'] = $payment->shopId;
                        $order['customerId'] = $data['wallet'];
                        $order['orderId'] = $history->id;
                        $order['amount'] = $data['amount'];
                        $order['signature'] = $payment->getPaySign($order);
                        $order['return_ok'] = $this->createAbsoluteUrl('/wallet/payUniteller') . '?result=success&token=' . $token;
                        $order['return_error'] = $this->createAbsoluteUrl('/wallet/payUniteller') . '?result=error&token=' . $token;
                        
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
        Yii::app()->request->redirect('/wallet/');
    }
    
    public function actionCheckLike()
    {
        if (Yii::app()->user->isGuest) 
            $this->setAccess();
        $message = '';
        
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
        
        if (!empty($page_id))
        {
            $like = SocContentBase::makeRequest('https://graph.facebook.com/me/likes/'.$page_id.'?&access_token='.$socToken->user_token);
            if (empty($page))
                $page = SocContentBase::makeRequest('https://graph.facebook.com/'.$page_id.'?&access_token='.$socToken->user_token);

            if (!empty($like['data']))
            {
                $message .= 'Вы лайкнули страницу: '.(empty($page['link'])?$page_id:$page['link']).'<br/>';
            }
            else
                $message .= 'Вы не лайкали эту страницу: '.(empty($page['link'])?$page_id:$page['link']).'<br/>';
        }
        else
            $message .= 'Страница Facebook не найдена';
                
        $this->render('checkLike', array('message'=>$message));
    }
}
