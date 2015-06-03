<?php

class SpotController extends MController
{
    // Список отображаемых картинок
    public function getImageType()
    {
        return array('jpeg' => 'jpeg', 'jpg' => 'jpg', 'png' => 'png', 'gif' => 'gif');
    }

    // Действие по умолчанию - редикт на мобильную версию
    public function actionIndex()
    {
        if (Yii::app()->request->getQuery('url')) {
            $url = Yii::app()->request->getQuery('url');
            $redirect_url = substr(Yii::app()->request->getBaseUrl(true), 7);
            $this->redirect('http://m.'.$redirect_url.'/' . $url);
        }
    }

    // Загрузка файлов в спот
    public function actionUpload()
    {
        $answer = array(
            'error' => 'yes',
            'content' => '',
            'key' => ''
        );

        $discodes = (isset($_SERVER['HTTP_X_DISCODES']) ? $_SERVER['HTTP_X_DISCODES'] : false);
        $file = (isset($_SERVER['HTTP_X_FILE_NAME']) ? $_SERVER['HTTP_X_FILE_NAME'] : false);

        if (!$file or !$discodes)
            MHttp::getJsonAndExit($answer);

        $fileType = strtolower(substr(strrchr($file, '.'), 1));
        $file = md5(time() . $discodes) . '_' . $file;

        $patch = Yii::getPathOfAlias('webroot.uploads.spot.') . '/';
        $file_name = $patch . $file;

        if (!file_put_contents($file_name, file_get_contents('php://input'))) {
            MHttp::getJsonAndExit($answer);
        }

        $images = $this->getImageType();
        if (isset($images[$fileType])) {
            $type = 'image';
            $image = new CImageHandler();
            $image->load($file_name);
            if ($image->thumb(300, false, true))
                $image->save($patch . 'tmb_' . $file);
        } else
            $type = 'obj';

        $spot = Spot::getSpot(array('discodes_id' => $discodes));
        if (!$spot)
            MHttp::getJsonAndExit($answer);

        $spotContent = SpotContent::getSpotContent($spot);
        if (!$spotContent)
            $spotContent = SpotContent::initPersonal($spot);

        $content = $spotContent->content;
        $content['keys'][$content['counter']] = $type;
        $answer['key'] = $content['counter'];
        $content['data'][$answer['key']] = $file;
        $content['counter'] = $content['counter'] + 1;
        $spotContent->content = $content;
        $spotContent->save();

        $answer['content'] = $this->renderPartial('//spot/personal/new_' . $type,
            array(
                'content' => $file,
                'key' => $answer['key'],
            ),
            true
        );
        $answer['key'] = $answer['key'];
        $answer['error'] = "no";

        echo json_encode($answer);
    }

    // Страница управления спотами
    public function actionList()
    {
        $this->layout = '//layouts/spots';

        $yandex_order = Yii::app()->request->getParam('orderN', false);
        if ($yandex_order) $this->redirect('/spot/list/');

        $user_id = Yii::app()->user->id;
        if (!$user_id) MHttp::setAccess();

        $user = User::model()->findByPk($user_id);
        if ($user->status == User::STATUS_NOACTIVE)  $this->redirect('/');

        $curent_discodes = 0;
        $curent_views = 'spot';
        $spots = Spot::getActiveByUserId(Yii::app()->user->id, true);
        if ($spots){
            $curent_discodes = Spot::curentSpot($spots[0]->discodes_id);
            $curent_views = Spot::curentViews($curent_views);
            
            if (SpotTroika::isBlockedCard($curent_discodes))
                $curent_views = Spot::curentViews('transport', true);

            $this->renderWithMobile(
                '//spot/body',
                array(
                    'spots' => $spots,
                    'curent_discodes' => $curent_discodes,
                    'curent_views' => $curent_views,
                ),
                '//mobile/spot/list'
            );
        } 
        else {
            $this->renderWithMobile(
                '//spot/no_spots',
                array(
                    'spots' => array(),
                    'curent_discodes' => false,
                    'curent_views' => false,
                ),
                '//mobile/spot/list'
            );
        }
    }

    // Просмотр содержимого спота
    public function actionView()
    {
        if (!Yii::app()->request->isPostRequest)
            $this->viewMobile();

        $answer = array(
            'error' => 'yes',
            'content' => ''
        );

        $data = MHttp::validateRequest();
        if (!isset($data['discodes'])) MHttp::getJsonAndExit($answer);

        $spot = Spot::model()->findByPk((int)$data['discodes']);
        if (!$spot or $spot->user_id != Yii::app()->user->id)
            MHttp::getJsonAndExit($answer);

        $wallet = PaymentWallet::model()->findByAttributes(
            array('discodes_id'=>$spot->discodes_id));

        Spot::curentSpot($spot->discodes_id, true);
        Spot::curentViews('spot', true);

        $spotContent = SpotContent::getSpotContent($spot);
        if (!$spotContent) $spotContent = SpotContent::initPersonal($spot);

        $content = $spotContent->content;
        $content_keys = $content['keys'];
        
        $answer['content'] = $this->renderPartialWithMobile(
            '//spot/content',
            array(
                'spot' => $spot,
                'wallet' => $wallet,
                'spotContent' => $spotContent,
                'content_keys' => $content_keys,
                'spotNets' => $spot->getBindedNets(),
            ),
            true,
            '//mobile/spot/content'
        );

        $answer['pass'] = '';
        if (!empty($spot->pass))
            $answer['pass'] = $spot->pass;
        $answer['error'] = "no";

        echo json_encode($answer);
    }


    // Добавление нового спота
    public function actionAdd()
    {
        $answer = array(
            'error' => 'yes',
            'content' => '',
            'discodes' => 0,
        );
        $data = MHttp::validateRequest();

        if (!isset($data['code'])) MHttp::getJsonAndExit($answer);

        $spot = Spot::model()->findByAttributes(
            array(
                'code' => $data['code'],
                'status' => Spot::STATUS_ACTIVATED,
            )
        );
        if (!$spot) MHttp::getJsonAndExit($answer);

        $spot->status = Spot::STATUS_REGISTERED;
        $spot->lang = Lang::getCurrentLang();
        $spot->user_id = Yii::app()->user->id;

        if (isset($data['name'])) $spot->name = $data['name'];
        $spot->type = Spot::TYPE_FULL;

        if (!$spot->save())
            MHttp::getJsonAndExit($answer);

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

        $answer['content'] = $this->renderPartial('//spot/block/sidebar_spot',
            array('spot' => $spot),
            true
        );
        $answer['discodes'] = $spot->discodes_id;
        $answer['error'] = "no";

        echo json_encode($answer);
    }

    // Удаление спота
    public function actionRemove()
    {
        $answer = array('error' => 'yes');
        $data = MHttp::validateRequest();

        if (!isset($data['discodes'])) MHttp::getJsonAndExit($answer);

        $spot = Spot::model()->findByPk($data['discodes']);
        if (!$spot) MHttp::getJsonAndExit($answer);

        $spot->status = Spot::STATUS_REMOVED_USER;
        if ($spot->save()) $answer['error'] = "no";

        echo json_encode($answer);
    }

    // Очистка спота
    public function actionClean()
    {
        $answer = array('error' => 'yes');
        $data = MHttp::validateRequest();

        if (!isset($data['discodes'])) MHttp::getJsonAndExit($answer);

        $spot = Spot::model()->findByPk($data['discodes']);
        if (!$spot) MHttp::getJsonAndExit($answer);

        $spotContent = SpotContent::getSpotContent($spot);
        $spotContent = SpotContent::initPersonal($spot, $spotContent);

        if ($spotContent->save()) $answer['error'] = "no";

        echo json_encode($answer);
    }

    //Делаем спот невидимым
    public function actionInvisible()
    {
        $answer = array(
            'error' => 'yes',
        );
        $data = MHttp::validateRequest();

        if (!isset($data['discodes'])) MHttp::getJsonAndExit($answer);

        $spot = Spot::model()->findByPk($data['discodes']);
        if (!$spot) MHttp::getJsonAndExit($answer);

        if ($spot->status == Spot::STATUS_INVISIBLE)
            $spot->status = Spot::STATUS_REGISTERED;
        else $spot->status = Spot::STATUS_INVISIBLE;

        if ($spot->save()) {
            $answer['status'] = $spot->status;
            $answer['error'] = "no";
        }

        echo json_encode($answer);
    }

    // Переименовываем спот
    public function actionRename()
    {
        $answer = array(
            'error' => 'yes',
            'name' => '',
            'content' => ''
        );
        $data = MHttp::validateRequest();

        if (!isset($data['name']) or !isset($data['discodes']))
            MHttp::getJsonAndExit($answer);

        $spot = Spot::model()->findByPk($data['discodes']);
        if (!$spot)
            MHttp::getJsonAndExit($answer);

        $spot->name = CHtml::encode($data['name']);
        if (!$spot->save(false)) MHttp::getJsonAndExit($answer);

        $wallet = PaymentWallet::model()->findByAttributes(
                array('discodes_id' => $data['discodes'])
        );
        if ($wallet) {
            $wallet->name = $spot->name;
            $wallet->save(false);
        }
        $answer['error'] = "no";
        $answer['content'] = Yii::t('user', "The information has been saved successfully");

        echo json_encode($answer);
    }

    //Задать пароль на спот
    public function actionSetSpotPass()
    {
        $answer = array(
            'error' => 'yes',
        );
        $data = MHttp::validateRequest();

        if (!isset($data['discodes']) or !isset($data['pass']))
            MHttp::getJsonAndExit($answer);

        $spot = Spot::model()->findByPk($data['discodes']);
        if (!$spot) MHttp::getJsonAndExit($answer);

        if (empty($data['pass'])) $spot->pass = null;
        else $spot->pass = $data['pass'];

        if ($spot->save(false)) {
            $whitelist = SpotBlock::model()->findAllByAttributes(array('discodes_id' => $spot->discodes_id, 'whitelist' => true));
            for ($i = 0; $i < count($whitelist); $i++)
                $whitelist[$i]->delete();

            $answer['error'] = "no";
            $answer['saved'] = Yii::t('spot', 'Saved');
        }

        echo json_encode($answer);
    }

    //Сохраняем порядок блоков в споте
    public function actionSaveOrder()
    {
        $answer = array(
            'error' => 'yes',
        );
        $data = MHttp::validateRequest();

        if (!isset($data['discodes']) or !isset($data['keys']))
            MHttp::getJsonAndExit($answer);

        $spot = Spot::getSpot(array('discodes_id' => $data['discodes']));
        if (!$spot) MHttp::getJsonAndExit($answer);

        $spotContent = SpotContent::getSpotContent($spot);
        if (!$spotContent) MHttp::getJsonAndExit($answer);

        $content = $spotContent->content;
        $newkeys = array();
        foreach ($data['keys'] as $answer['key']) {
            if (isset($content['keys'][$answer['key']])) {
                $newkeys[$answer['key']] = $content['keys'][$answer['key']];
            }
        }
        $content['keys'] = $newkeys;
        $spotContent->content = $content;

        if ($spotContent->save()) $answer['error'] = "no";

        echo json_encode($answer);
    }

    // Добавление блока в спот
    public function actionSpotAddContent()
    {
        $answer = array(
            'error' => 'yes',
            'content' => '',
            'key' => ''
        );
        $data = MHttp::validateRequest();

        if (!isset($data['content']) or !isset($data['discodes']))
            MHttp::getJsonAndExit($answer);

        $spot = Spot::getSpot(array('discodes_id' => $data['discodes']));
        $spotContent = SpotContent::getSpotContent($spot);
        if (!$spotContent) $spotContent = SpotContent::initPersonal($spot);

        $content = $spotContent->content;
        $content['keys'][$content['counter']] = 'text';
        $answer['key'] = $content['counter'];
        $content['data'][$answer['key']] = $data['content'];
        $content['counter'] = $content['counter'] + 1;
        $spotContent->content = $content;
        $spotContent->save();

        $answer['content'] = $this->renderPartial('//spot/personal/new_text',
            array(
                'content' => $data['content'],
                'key' => $answer['key'],
            ),
            true
        );
        $answer['error'] = "no";

        echo json_encode($answer);
    }

    // Изменение атрибутов спота - приватность и возможность скачать визитку
    public function actionSpotAtributeSave()
    {
        $answer = array('error' => 'yes');
        $data = MHttp::validateRequest();

        if (isset($data['discodes']))
            MHttp::getJsonAndExit($answer);

        $spot = Spot::getSpot(array('discodes_id' => $data['discodes']));
        if (!$spot) MHttp::getJsonAndExit($answer);

        $spotContent = SpotContent::getSpotContent($spot);
        if (!$spotContent) $spotContent = SpotContent::initPersonal($spot);

        $content = $spotContent->content;
        $content['private'] = $data['private'];
        $content['vcard'] = $data['vcard'];
        $spotContent->content = $content;

        if ($spotContent->save())
            $answer['error'] = "no";

        echo json_encode($answer);
    }

    // Удаление блока из спота
    public function actionSpotRemoveContent()
    {
        $answer = array(
            'error' => 'yes',
            'content' => '',
            'netDown' => '',
        );
        $data = MHttp::validateRequest();

        if (!isset($data['discodes']) or !isset($data['key']))
            MHttp::getJsonAndExit($answer);

        $spot = Spot::getSpot(array('discodes_id' => $data['discodes']));
        if (!$spot) MHttp::getJsonAndExit($answer);

        $spotContent = SpotContent::getSpotContent($spot);
        if (!$spotContent) MHttp::getJsonAndExit($answer);

        $content = $spotContent->content;
        if ($content['keys'][$data['key']] == 'socnet')
            $link = $content['data'][$data['key']];
        elseif ($content['keys'][$data['key']] == 'content')
            $link = $content['data'][$data['key']]['binded_link'];
        elseif ($content['keys'][$data['key']] != 'text') {
            $patch = Yii::getPathOfAlias('webroot.uploads.spot.') . '/';
            @unlink($patch . $content['data'][$data['key']]);
            @unlink($patch . 'tmb_' . $content['data'][$data['key']]);
        }

        unset($content['keys'][$data['key']]);
        unset($content['data'][$data['key']]);
        $spotContent->content = $content;
        if ($spotContent->save()) {
            $keys = array();
            foreach ($content['keys'] as $answer['key'] => $value) {
                $keys[] = $answer['key'];
            }

            $answer['keys'] = $keys;
            $answer['error'] = "no";
        }

        if (!empty($link) and "no" == $answer['error'])
            $answer['netDown'] = $spot->getNetDown($link);

        echo json_encode($answer);
    }

    // Сохранение содержимого блока
    public function actionSpotSaveContent()
    {
        $answer = array(
            'error' => 'yes',
            'content' => '',
        );
        $data = MHttp::validateRequest();

        if (!isset($data['discodes']) or !isset($data['key']))
            MHttp::getJsonAndExit($answer);

        $spot = Spot::getSpot(array('discodes_id' => $data['discodes']));
        if (!$spot) MHttp::getJsonAndExit($answer);

        $spotContent = SpotContent::getSpotContent($spot);
        if (!$spotContent) MHttp::getJsonAndExit($answer);

        $content = $spotContent->content;
        $content['data'][$data['key']] = $data['content_new'];

        $spotContent->content = $content;
        if ($spotContent->save()) {
            $answer['content'] = $this->renderPartial('//spot/personal/new_text',
                array(
                    'content' => $data['content_new'],
                    'key' => $data['key'],
                ),
                true
            );
            $answer['error'] = "no";
        }

        echo json_encode($answer);
    }

    // Отображение настроек
    public function actionSettings()
    {
        $answer = array(
            'error' => 'yes',
            'content' => ''
        );
        $data = MHttp::validateRequest();

        if (empty($data['discodes']) or Yii::app()->user->isGuest)
            MHttp::getJsonAndExit($answer);

        $wallet = PaymentWallet::model()->findByAttributes(
            array(
                'discodes_id' => (int)$data['discodes'],
                'user_id' => Yii::app()->user->id,
            )
        );

        $spot = Spot::model()->findByAttributes(
            array(
                'discodes_id' => (int)$data['discodes'],
                'user_id' => Yii::app()->user->id,
            )
        );
        if (!$spot) MHttp::getJsonAndExit($answer);
        
        $phones = SpotPhone::model()->findAllByAttributes(array('discodes_id' => $spot->discodes_id));
        
        $school_extended_address = false;
        if (count($phones) and $phones[0]->school_sms)
            $school_extended_address = $spot->getHomeAddress();

        $answer['content'] = $this->renderPartialWithMobile(
            '//spot/settings',
            array(
                'wallet' => $wallet,
                'spot' => $spot,
                'phones' => $phones,
                'school_extended_address' => $school_extended_address,
            ),
            true,
            '//mobile/spot/settings'
        );
        $answer['error'] = 'no';
        echo json_encode($answer);
    }

    public function getYMRedirectUrl($discodes_id)
    {  
        $host = substr(Yii::app()->request->getBaseUrl(true), 7);
        $host = 'http://mobispot.com';
        return $host
            . '/spot/addYMToken?spot='
            . $discodes_id;
    }

    // Перенаправление пользователя на yandex для привязки кошелька
    public function actionAddYMWallet()
    {   
        $discodes_id = Yii::app()->request->getParam('spot');
        if (!$discodes_id ) $this->redirect('/spot/list/');

        $url = Yii::app()->params['api']['internal']
            . '/api/internal/yandex/get_auth_url/'
            . $discodes_id
            . '?url='
            . rawurlencode($this->getYMRedirectUrl($discodes_id));
        $result = CJSON::decode(MHttp::setCurlRequest($url), true);
        if ($result['error'] != 0) $this->redirect('/spot/list/');

        $this->redirect($result['url']);
    }

    // Запрос ко внутреннему апи для получения токена
    public function actionAddYMToken()
    {   

        $error = Yii::app()->request->getParam('error');
        $discodes_id = Yii::app()->request->getParam('spot');
        $code = Yii::app()->request->getParam('code');
        if (!$discodes_id or !$code or $error) $this->redirect('/spot/list/');

        $url = Yii::app()->params['api']['internal']
            . '/api/internal/yandex/get_token/'
            . $discodes_id
            . '/'
            . $code
            . '?url='
            . rawurlencode($this->getYMRedirectUrl($discodes_id));
        $result = CJSON::decode(MHttp::setCurlRequest($url), true);
        
        $this->redirect('/spot/list/');
    }


    // Отображение кошелька
    public function actionWallet()
    {
        $answer = array(
            'error' => 'yes',
            'content' => ''
        );
        $data = MHttp::validateRequest();

        if (empty($data['discodes']) or Yii::app()->user->isGuest)
            MHttp::getJsonAndExit($answer);
        $wallet = PaymentWallet::model()->findByAttributes(
            array(
                'discodes_id' => (int)$data['discodes'],
                'user_id' => Yii::app()->user->id,
            )
        );
        if (!$wallet) MHttp::getJsonAndExit($answer);
        $spot = Spot::model()->findByAttributes(
            array(
                'discodes_id' => (int)$data['discodes'],
                'user_id' => Yii::app()->user->id,
            )
        );
        if (!$spot) MHttp::getJsonAndExit($answer);

        $history = Report::model()->findAllByAttributes(
            array(
                'payment_id' => $wallet->payment_id,
                'type' => Report::TYPE_PAYMENT,
            ),
            array(
                'order' => 'creation_date desc',
                'limit' => Report::MAX_RECORD)
        );

        Spot::curentViews('wallet', true);
        $answer['content'] = $this->renderPartialWithMobile(
            '//spot/wallet',
            array(
                'wallet' => $wallet,
                'spot' => $spot,
                'history'=> $history,
            ),
            true,
            '//mobile/spot/wallet'
        );
        $answer['error'] = 'no';
        echo json_encode($answer);
    }

    // Выводим список привязанных карт
    public function actionListCard()
    {
        $data = MHttp::validateRequest();
        $answer = array(
            'error' => 'yes',
            'cards' => array(),
            'cards_count' => 0,
            'linking_card' => 0,
        );

        if (!isset($data['id'])) MHttp::getJsonAndExit($answer);

        $cards = PaymentCard::model()->findAllByAttributes(
            array(
                'wallet_id' => (int)$data['id'],
            ),
            array(
                'order' => 'id desc',
                'limit' => PaymentCard::MAX_CARDS_VIEW)
        );
        foreach ($cards as $card) {
            $answer['cards'][$card->id] = $card->getJson();
        }
        $answer['cards_count'] = count($cards);

        $linking_card = PaymentHistory::model()->findByAttributes(
            array(
                'wallet_id' => (int)$data['id'],
                'status' => PaymentHistory::STATUS_IN_PROGRESS,
                'type' => PaymentHistory::TYPE_SYSTEM,
            )
        );
        $answer['linking_card'] = count($linking_card);

        $answer['error'] = 'no';

        echo json_encode($answer);
    }

    // Блокировка кошелька
    public function actionBlockedWallet()
    {
        $data = MHttp::validateRequest();
        $answer = array(
            'error' => 'yes',
            'status' => '',
        );

        if (!isset($data['id'])) MHttp::getJsonAndExit($answer);

        $wallet = PaymentWallet::model()->findByAttributes(
            array(
                'id' => $data['id'],
                'user_id' => Yii::app()->user->id,
            )
        );

        if (!$wallet) MHttp::getJsonAndExit($answer);

        if ($wallet->status == PaymentWallet::STATUS_ACTIVE)
            $wallet->status = PaymentWallet::STATUS_BANNED;
        else $wallet->status = PaymentWallet::STATUS_ACTIVE;

        if ($wallet->save()) {
            $answer['error'] = 'no';
            $answer['status'] = $wallet->status;
        }
        echo json_encode($answer);
    }

    // Запрос к yandex api на получение параметров для привязки карты
    public function getLinkingParams($discodes_id)
    {
        $url =
            Yii::app()->params['api']['internal']
            . '/api/internal/yandex/linking/'
            . $discodes_id
            . '?url='
            . rawurlencode($this->spotUrl($discodes_id));

        return CJSON::decode(MHttp::setCurlRequest($url), true);
    }

    // Страница с пользовательским соглашение для привязки карты
    public function actionCardOfert()
    {
        $this->layout = '//layouts/singl';

        $discodes_id = Yii::app()->request->getParam('id', false);
        if (!$discodes_id or !Yii::app()->user->id) MHttp::setNotFound();

        $discodes_id = (int)$discodes_id;
        $wallet = PaymentWallet::model()->findByAttributes(
            array(
                'discodes_id' => $discodes_id,
                'user_id' => Yii::app()->user->id,
            )
        );
        if (!$wallet) MHttp::setNotFound();

        $linking = $this->getLinkingParams($discodes_id);
        $this->render('card_ofert', array('linking'=>$linking));
    }

    // Смена статуса карты на платежную
    public function actionSetPaymentCard()
    {
        $data = MHttp::validateRequest();
        $answer = array('error' => 'yes',);

        $card = PaymentCard::model()->findByPk((int)$data['card_id']);
        if (!$card) MHttp::getJsonAndExit($answer);

        $old_payment_card = PaymentCard::model()->findByAttributes(
            array(
                'wallet_id' => $card->wallet_id,
                'status' => PaymentCard::STATUS_PAYMENT,
            )
        );
        
        if ($old_payment_card and $old_payment_card->id == $card->id)
            MHttp::getJsonAndExit($answer);

        $card->status = PaymentCard::STATUS_PAYMENT;
        if ($card->save()){
            if ($old_payment_card){
                $old_payment_card->status = PaymentCard::STATUS_ARCHIV;
                $old_payment_card->save();
            }
            $answer['error'] = 'no';
        }

        $wallet = PaymentWallet::model()->findByPk($card->wallet_id);
        $wallet->blacklist = PaymentWallet::STATUS_ACTIVE;
        $wallet->save();

        echo json_encode($answer);
    }

    // Удаление карты
    public function actionRemoveCard()
    {
        $data = MHttp::validateRequest();
        $answer = array('error' => 'yes',);

        $card = PaymentCard::model()->findByPk((int)$data['card_id']);
        if (!$card) MHttp::getJsonAndExit($answer);

        if ($card->delete()){
            $answer['error'] = 'no';

            $cards = PaymentCard::model()->findAllByAttributes(
                array('wallet_id'=>$card->wallet_id)
            );
            if (!$cards) {
                $wallet = PaymentWallet::model()->findByPk($card->wallet_id);
                $wallet->blacklist = PaymentWallet::STATUS_NOACTIVE;
                $wallet->save();
            }
        }

        echo json_encode($answer);
    }

    // Отображение купонов
    public function actionCoupons()
    {
        $answer = array(
            'error' => 'yes',
            'content' => ''
        );
        $data = MHttp::validateRequest();

        if (empty($data['discodes']) or Yii::app()->user->isGuest)
            MHttp::getJsonAndExit($answer);

        $spot = Spot::model()->findByAttributes(
            array(
                'discodes_id' => (int)$data['discodes'],
                'user_id' => Yii::app()->user->id,
            )
        );
        if (!$spot) MHttp::getJsonAndExit($answer);

        $wallet = PaymentWallet::model()->findByAttributes(
        array(
                'discodes_id' => (int)$data['discodes'],
                'user_id' => Yii::app()->user->id,
            )
        );

        Spot::curentViews('coupon', true);

        $couponsList = Loyalty::getCoupons($wallet->id, Loyalty::PAGE_ALL, '', 0, -1);
        $coupons = $couponsList['coupons'];
        $answer['content'] = $this->renderPartialWithMobile(
            '//spot/coupons',
            array(
                'coupons' => $coupons,
                'wallet' => $wallet,
                'spot' => $spot,
            ),
            true,
            '//mobile/spot/coupons'
        );

        $answer['error'] = 'no';

        echo json_encode($answer);
    }
    
    // Отображение вкладки Транспорт
    public function actionTransport()
    {
        $answer = array(
            'error' => 'yes',
            'content' => ''
        );
        $data = MHttp::validateRequest();

        if (empty($data['discodes']) or Yii::app()->user->isGuest)
            MHttp::getJsonAndExit($answer);

        $spot = Spot::model()->findByAttributes(
            array(
                'discodes_id' => (int)$data['discodes'],
                'user_id' => Yii::app()->user->id,
            )
        );
        if (!$spot) MHttp::getJsonAndExit($answer);    
        
        $wallet = PaymentWallet::model()->findByAttributes(
            array('discodes_id'=>$spot->discodes_id));
        
        $troika = false;
        
        if ($wallet) {
            $troika = SpotTroika::getCard($wallet->hard_id);
        }
        
        Spot::curentSpot($spot->discodes_id, true);
        Spot::curentViews('transport', true);
        
        $answer['content'] = $this->renderPartial(
            '//spot/transport',
            array(
                'spot' => $spot, 
                'wallet'=>$wallet,
                'troika'=>$troika
            ),
            true
        );

        $answer['error'] = 'no';
        
        echo json_encode($answer);    
    }

    //список купонов
    public function actionListCoupons()
    {
        $answer = array(
            'error' => 'yes',
            'content' => '',
            'count' => 0,
            'offset' => 0,
            'countAll' => 0,
        );

        $data = MHttp::validateRequest();
        if (empty($data['discodes']) or Yii::app()->user->isGuest
            or empty($data['page']) or !isset($data['phrase']))
            MHttp::getJsonAndExit($answer);

        $spot = Spot::model()->findByAttributes(
            array(
                'discodes_id' => (int)$data['discodes'],
                'user_id' => Yii::app()->user->id,
            )
        );
        if (!$spot) MHttp::getJsonAndExit($answer);

        $wallet = PaymentWallet::model()->findByAttributes(
        array(
                'discodes_id' => (int)$data['discodes'],
                'user_id' => Yii::app()->user->id,
            )
        );
        $offset = 0;
        if (!empty($data['offset']))
            $offset = $data['offset'];

        $couponsList = Loyalty::getCoupons($wallet->id, $data['page'], $data['phrase'], $offset);
        $coupons = $couponsList['coupons'];
        $answer['count'] = $couponsList['count'];
        $answer['offset'] = $couponsList['offset'];
        $answer['count_all'] = $couponsList['countAll'];

        $answer['content'] = $this->renderPartial(
            '//mobile/spot/list_coupons',
            array(
                'coupons' => $coupons,
             ),
            true
        );

        $answer['error'] = 'no';

        echo json_encode($answer);
    }

    //Привязка соцсетей через кнопку
    public function actionBindSocial()
    {
        $data = MHttp::validateRequest();
        $answer = array(
            'error' => 'yes',
            'content' => '',
            'socnet' => 'no',
            'loggedIn' => false,
            'linkCorrect' => Yii::t('eauth', "This account doesn't exist:"),
        );
        $needSave = false;

        if (!isset($data['discodes']) or !isset($data['key']))
            MHttp::getJsonAndExit($answer);

        $spot = Spot::getSpot(array('discodes_id' => $data['discodes']));
        if (!$spot) MHttp::getJsonAndExit($answer);

        $spotContent = SpotContent::getSpotContent($spot);
        if (!$spotContent)
            $spotContent = SpotContent::initPersonal($spot);

        $socInfo = new SocInfo;
        $socNet = $socInfo->getNetByLink($spotContent->content['data'][$data['key']]);

        if (empty($socNet['name']))
            MHttp::getJsonAndExit($answer);

        $answer['socnet'] = $socNet['name'];
        $content = $spotContent->content;

        $answer['loggedIn'] = $socInfo->isLoggegOn($answer['socnet']);
        if (!$answer['loggedIn']) {
            $answer['error'] = "no";
            MHttp::getJsonAndExit($answer);
        }
        $needSave = $socInfo->contentNeedSave($spotContent->content['data'][$data['key']]);

        if ($needSave) {
            $userDetail = $socInfo->getSocInfo($socNet['name'], $spotContent->content['data'][$data['key']], $data['discodes'], $data['key']);
            if (empty($userDetail['error'])) {
                $answer['linkCorrect'] = 'ok';
                $userDetail['binded_link'] = $spotContent->content['data'][$data['key']];
                $content['keys'][$data['key']] = 'content';
                $content['data'][$data['key']] = $userDetail;
                $spotContent->content = $content;
            } elseif ($userDetail['error'] == 'User not logged in') {
                $answer['loggedIn'] = false;
                Yii::app()->session['bind_discodes'] = $data['discodes'];
                Yii::app()->session['bind_key'] = $data['key'];
            } else
                $answer['linkCorrect'] = $userDetail['error'];
        } else {
            $answer['linkCorrect'] = $socInfo->isLinkCorrect($spotContent->content['data'][$data['key']], $data['discodes'], $data['key']);
            if ($answer['linkCorrect'] == 'ok') {
                $content['keys'][$data['key']] = 'socnet';
                $content['data'][$data['key']] = $socInfo->getBindedLink($content['data'][$data['key']], $socNet['name'], $spot->discodes_id, $data['key']);
                $spotContent->content = $content;
            }
        }

        if ($answer['linkCorrect'] == 'ok' and $spotContent->save()) {
            $socInfo = new SocInfo;
            $render_data = array(
                'key' => $data['key'],
            );

            $render_data['content'] = ($needSave)?
                ($content['data'][$data['key']])
                :($socInfo->getNetData($content['data'][$data['key']], $spot->discodes_id, $data['key'], $dinamic = true));

            $answer['content'] = $this->renderPartial(
                '//spot/personal/new_content',
                $render_data,
                true
            );
            Yii::app()->session[$answer['socnet'] . '_BindByPaste'] = true;
        }

        $answer['error'] = "no";

        echo json_encode($answer);
    }

    // //Привязка через плашку
    public function actionBindByPanel()
    {
        $data = MHttp::validateRequest();
        $answer = array (
            'error' => 'yes',
            'content' => '',
            'socnet' => 'no',
            'loggedIn' => false,
            'linkCorrect' => Yii::t('eauth', "This account doesn't exist"),
            'profileHint' => '',
            'key' => false,
        );
        $needSave = false;

        if (!isset($data['spot']) or empty($data['spot']['discodes']) or !isset($data['netName']))
            MHttp::getJsonAndExit($answer);

        $discodes_id = $data['spot']['discodes'];
        $spot = Spot::getSpot(array('discodes_id' => $discodes_id));
        $answer['socnet'] = $data['netName'];

        if (!$spot)
            MHttp::getJsonAndExit($answer);

        $answer['error'] = 'no';
        $socInfo = new SocInfo;
        $socNet = $socInfo->getNetByName($answer['socnet']);

        if (isset($socNet['needAuth']) and !$socNet['needAuth'] and !empty($socNet['profileHint']) and empty($data['link'])) {
            $answer['profileHint'] = $socNet['profileHint'];
            MHttp::getJsonAndExit($answer);
        }

        if (!empty($data['link'])) {
            $socNet = $socInfo->getNetByLink($data['link']);
            $needSave = $socInfo->contentNeedSave($data['link']);
        } else
            $socNet = $socInfo->getNetByName($answer['socnet']);

        if (!empty($socNet['name']) and ($socInfo->isLoggegOn($answer['socnet']) || (!empty($data['link']) and !$socNet['needAuth']))) {
            //авторизован через соцсеть, либо сеть не требует авторизации и есть привязываемая ссылка
            $answer['loggedIn'] = true;
            $answer['socnet'] = $socNet['name'];
            $spotContent = SpotContent::getSpotContent($spot);
            if (!$spotContent)
                $spotContent = SpotContent::initPersonal($spot);


            $content = $spotContent->content;
            if ($needSave && !empty($data['link'])) {
                $userDetail = $socInfo->getSocInfo($answer['socnet'], $data['link'], $discodes_id, null);
                if (empty($userDetail['error'])) {
                    $userDetail['binded_link'] = $data['link'];
                    $content['keys'][$content['counter']] = 'content';
                    $content['data'][$content['counter']] = $userDetail;
                    $answer['key'] = $content['counter'];
                    $content['counter'] = $content['counter'] + 1;
                    $spotContent->content = $content;
                    $spotContent->save();

                    $answer['linkCorrect'] = 'ok';
                    Yii::app()->session[$answer['socnet'] . '_BindByPaste'] = true;

                    $answer['content'] = $this->renderPartialWithMobile(
                        '//spot/personal/new_content',
                        array(
                            'content' => $content['data'][$answer['key']],
                            'key' => $answer['key'],
                        ),
                        true,
                        '//mobile/spot/personal/new_content'
                        );
                } else
                    $answer['linkCorrect'] = $userDetail['error'];
            } else {
                if (!empty($data['link']))
                    $answer['linkCorrect'] = $socInfo->isLinkCorrect($data['link'], $discodes_id, null);
                else
                    $answer['linkCorrect'] = 'ok';

                if ($answer['linkCorrect'] == 'ok') {
                    $content['keys'][$content['counter']] = 'socnet';

                    if (!empty($data['link']))
                        $content['data'][$content['counter']] = $socInfo->getBindedLink($data['link'], $answer['socnet'], $spot->discodes_id, $content['counter']);
                    else
                        $content['data'][$content['counter']] = Yii::app()->session[$answer['socnet'] . '_profile_url'];

                    $answer['key'] = $content['counter'];
                    $content['counter'] = $content['counter'] + 1;
                    $spotContent->content = $content;
                    $spotContent->save();
                    Yii::app()->session[$answer['socnet'] . '_BindByPaste'] = true;

                    $socContent = $socInfo->getNetData($content['data'][$answer['key']], $discodes_id, $answer['key'], true);
                    $answer['content'] = $this->renderPartialWithMobile(
                        '//spot/personal/new_socnet',
                        array(
                            'content' => $content['data'][$answer['key']],
                            'key' => $answer['key'],
                            'socContent' => $socContent,
                        ),
                        true,
                        '//mobile/spot/personal/new_content'
                    );
                }
            }

        } else
            $answer['linkCorrect'] == 'ok';

        echo json_encode($answer);
    }

    public function actionBindedContent()
    {
        $answer = array(
            'error' => 'yes',
            'content' => '',
            'linkCorrect' => Yii::t('eauth', "This account doesn't exist:"),
            'loggedIn' => false,
            'newField' => false,
            'key' => false,
        );
        $target = '/spot/list';

        if (Yii::app()->request->isPostRequest)
            $data = MHttp::validateRequest();
        else {
            $data = array('bindNet' => array(
                        'name'=>Yii::app()->request->getQuery('service'),
                        'discodes'=>Yii::app()->request->getQuery('discodes'),
                        'key'=>Yii::app()->request->getQuery('key'),
                        'newField'=>Yii::app()->request->getQuery('newField'),
                        'link'=>Yii::app()->request->getQuery('link'),
                    ));
        }

        $needSave = false;

        if (!isset($data['bindNet']) or empty($data['bindNet']['name']) or empty($data['bindNet']['discodes']))
            $this->setBadReques();

        $socInfo = new SocInfo;
        $answer['socnet'] = $socInfo->mergeMobile($data['bindNet']['name']);
        $discodes_id = $data['bindNet']['discodes'];

        if (!empty(Yii::app()->session[$answer['socnet'] . '_id']))
            $answer['loggedIn'] = true;

        $spot = Spot::getSpot(array('discodes_id' => $discodes_id));
        if (!$spot)
            MHttp::getJsonOrRedirect($answer, $target);

        if (MHttp::isHostMobile())
            $target = '/spot/view/' . $spot->url;

        if (!empty($data['bindNet']['key']) && $answer['loggedIn']) {
            //привязка через кнопку
            $answer['key'] = $data['bindNet']['key'];

            if ($spot) {
                $spotContent = SpotContent::getSpotContent($spot);
                if (!$spotContent)
                    $spotContent = SpotContent::initPersonal($spot);

                if ($spotContent) {
                    $socNet = $socInfo->getNetByName($answer['socnet']);

                    if (!empty($socNet['name'])) {
                        $content = $spotContent->content;
                        $needSave = $socInfo->contentNeedSave($spotContent->content['data'][$answer['key']]);

                        if ($needSave) {
                            $userDetail = $socInfo->getSocInfo($socNet['name'], $spotContent->content['data'][$answer['key']], $discodes_id, $answer['key']);
                            if (empty($userDetail['error'])) {
                                $userDetail['binded_link'] = $spotContent->content['data'][$answer['key']];
                                $content['keys'][$answer['key']] = 'content';
                                $content['data'][$answer['key']] = $userDetail;
                                $spotContent->content = $content;

                                $answer['linkCorrect'] = 'ok';
                            } else
                                $answer['linkCorrect'] = $userDetail['error'];
                        } else {
                            $answer['linkCorrect'] = $socInfo->isLinkCorrect($spotContent->content['data'][$answer['key']], $discodes_id, $answer['key']);
                            if ($answer['linkCorrect'] == 'ok') {
                                $content['keys'][$answer['key']] = 'socnet';
                                $content['data'][$answer['key']] = $socInfo->getBindedLink($content['data'][$answer['key']], $answer['socnet'], $spot->discodes_id, $answer['key']);
                                $spotContent->content = $content;
                            }
                        }
                        if ($answer['linkCorrect'] == 'ok') {
                            if ($spotContent->save()) {
                                if ($needSave)
                                    $answer['content'] = $this->renderPartial('//spot/personal/new_content',
                                        array(
                                            'content' => $content['data'][$answer['key']],
                                            'key' => $answer['key'],
                                        ),
                                        true
                                    );
                                else {
                                    $socContent = $socInfo->getNetData($content['data'][$answer['key']], $discodes_id, $answer['key'], true);
                                    $answer['content'] = $this->renderPartial('//spot/personal/new_socnet',
                                        array(
                                            'content' => $content['data'][$answer['key']],
                                            'key' => $answer['key'],
                                            'socContent' => $socContent,
                                        ),
                                        true
                                    );
                                }
                                Yii::app()->session[$answer['socnet'] . '_BindByPaste'] = true;
                            }
                        }
                        //$answer['error'] = "no";
                    }
                }
            }
        } elseif (!empty($data['bindNet']['newField']) && $answer['loggedIn']) {
            //привязка через плашку
            $answer['newField'] = true;

            if (!$spot)
                MHttp::getJsonOrRedirect($answer, $target);

            $socNet = $socInfo->getNetByName($answer['socnet']);
            if (!empty($data['bindNet']['link'])) {
                $socNet = $socInfo->getNetByLink($data['bindNet']['link']);
                $needSave = $socInfo->contentNeedSave($data['bindNet']['link']);
            } else
                $socNet = $socInfo->getNetByName($answer['socnet']);

            if (empty($socNet['name']) or empty(Yii::app()->session[$answer['socnet'] . '_profile_url']))
                MHttp::getJsonOrRedirect($answer, $target);

            $answer['socnet'] = $socNet['name'];
            $spotContent = SpotContent::getSpotContent($spot);
            if (!$spotContent)
                $spotContent = SpotContent::initPersonal($spot);

            $content = $spotContent->content;

            if ($needSave && !empty($data['bindNet']['link'])) {
                $userDetail = $socInfo->getSocInfo($answer['socnet'], $data['bindNet']['link'], $discodes_id, null);
                if (!empty($userDetail['error'])) {
                    $answer['linkCorrect'] = $userDetail['error'];
                    MHttp::getJsonOrRedirect($answer, $target);
                }

                $userDetail['binded_link'] = $data['bindNet']['link'];
                $content['keys'][$content['counter']] = 'content';
                $content['data'][$content['counter']] = $userDetail;
                $answer['key'] = $content['counter'];
                $content['counter'] = $content['counter'] + 1;
                $spotContent->content = $content;
                $spotContent->save();

                $answer['linkCorrect'] = 'ok';
                Yii::app()->session[$answer['socnet'] . '_BindByPaste'] = true;
                $answer['content'] = $this->renderPartialWithMobile(
                    '//spot/personal/new_content',
                    array(
                        'content' => $content['data'][$answer['key']],
                        'key' => $answer['key'],
                    ),
                    true,
                    '//mobile/spot/personal/new_content'
                );

            } else {
                if (!empty($data['bindNet']['link']))
                    $answer['linkCorrect'] = $socInfo->isLinkCorrect($data['bindNet']['link'], $discodes_id);
                else
                    $answer['linkCorrect'] = 'ok';

                if ($answer['linkCorrect'] == 'ok') {
                    $content['keys'][$content['counter']] = 'socnet';
                    if (!empty($data['bindNet']['link']))
                        $content['data'][$content['counter']] = $socInfo->getBindedLink($data['bindNet']['link'], $answer['socnet'], $spot->discodes_id, $content['counter']);
                    else
                        $content['data'][$content['counter']] = Yii::app()->session[$answer['socnet'] . '_profile_url'];
                    $answer['key'] = $content['counter'];
                    $content['counter'] = $content['counter'] + 1;
                    $spotContent->content = $content;
                    $spotContent->save();

                    Yii::app()->session[$answer['socnet'] . '_BindByPaste'] = true;

                    $socContent = $socInfo->getNetData($content['data'][$answer['key']], $discodes_id, $answer['key'], true);
                    $answer['content'] = $this->renderPartialWithMobile(
                        '//spot/personal/new_socnet',
                        array(
                            'content' => $content['data'][$answer['key']],
                            'key' => $answer['key'],
                            'socContent' => $socContent,
                            ),
                        true,
                        '//mobile/spot/personal/new_content'
                    );
                }
            }
        }
        if(Yii::app()->request->isPostRequest)
            echo json_encode($answer);
        elseif (MHttp::isHostMobile())
            $this->redirect('/spot/view/' . $spot->url . '?key=' . $answer['key']);
        else
            $this->redirect('/spot/list?discodes=' . $data['bindNet']['discodes'] . '&key=' . $answer['key']);
    }

    public function actionSocNetContent()
    {
        $answer = array('error' => 'yes');
        $data = MHttp::validateRequest();

        if (!isset($data['discodes']) or !isset($data['key']))
            MHttp::getJsonAndExit($answer);

        $spot = Spot::getSpot(array('discodes_id' => $data['discodes']));
        if (!$spot)
            MHttp::getJsonAndExit($answer);

        $spotContent = SpotContent::getSpotContent($spot);
        if (!$spotContent)
            $spotContent = SpotContent::initPersonal($spot);

        if (!isset($spotContent->content['keys'][$data['key']]))
            MHttp::getJsonAndExit($answer);
        if ($spotContent->content['keys'][$data['key']] != 'socnet')
            MHttp::getJsonAndExit($answer);

        $socInfo = new SocInfo;
        $socContent = $socInfo->getNetData($spotContent->content['data'][$data['key']], $data['discodes'], $data['key'], true);

        $answer['content'] = $this->renderPartialWithMobile(
            '//spot/personal/new_socnet',
            array(
                'content' => $spotContent->content['data'][$data['key']],
                'key' => $data['key'],
                'socContent' => $socContent,
            ),
            true,
            '//mobile/spot/personal/new_content'
        );

        $answer['key'] = $data['key'];
        $answer['error'] = 'no';

        if (isset($data['lastKey']))
            $answer['lastKey'] = $data['lastKey'];

        echo json_encode($answer);
    }

    //Отвязка соцсети
    public function actionUnBindSocial()
    {
        $data = MHttp::validateRequest();
        $answer = array(
            'error' => 'yes',
            'content' => '',
            'netDown' => '',
        );

        if (!isset($data['discodes']) or !isset($data['key']))
            MHttp::getJsonAndExit($answer);

        $spot = Spot::getSpot(array('discodes_id' => $data['discodes']));
        if (!$spot)
            MHttp::getJsonAndExit($answer);

        $spotContent = SpotContent::getSpotContent($spot);
        if (!$spotContent)
            $spotContent = SpotContent::initPersonal($spot);

        $content = $spotContent->content;
        if ($content['keys'][$data['key']] == 'socnet') {
            $link = $content['data'][$data['key']];
            $content['keys'][$data['key']] = 'text';
            $spotContent->content = $content;

            if (!$spotContent->save())
                MHttp::getJsonAndExit($answer);

            $answer['content'] = $this->renderPartial('//spot/personal/new_text',
                array(
                    'content' => $content['data'][$data['key']],
                    'key' => $data['key'],
                ),
                true
            );
            $answer['error'] = "no";
        } elseif ($content['keys'][$data['key']] == 'content') {
            $toDelete = array();
            $link = $content['data'][$data['key']]['binded_link'];

            if (!empty($content['data'][$data['key']]['last_img']) && strpos($content['data'][$data['key']]['last_img'], '/uploads/spot/') === 0)
                $toDelete[] = $content['data'][$data['key']]['last_img'];

            if (!empty($content['data'][$data['key']]['photo']) && strpos($content['data'][$data['key']]['photo'], '/uploads/spot/') === 0)
                $toDelete[] = $content['data'][$data['key']]['photo'];

            $content['keys'][$data['key']] = 'text';
            $content['data'][$data['key']] = $content['data'][$data['key']]['binded_link'];
            $spotContent->content = $content;

            if (!$spotContent->save())
                MHttp::getJsonAndExit($answer);

            foreach ($toDelete as $path) {
                $path = substr($path, (strpos($path, '/uploads/spot/') + 14));
                $path = Yii::getPathOfAlias('webroot.uploads.spot.') . '/' . $path;
                if (file_exists($path))
                    unlink($path);
            }
            $answer['content'] = $this->renderPartial('//spot/personal/new_text',
                array(
                    'content' => $content['data'][$data['key']],
                    'key' => $data['key'],
                ),
                true
            );
            $answer['error'] = "no";
        }

        if (!empty($link) and "no" == $answer['error'])
            $answer['netDown'] = $spot->getNetDown($link);

        echo json_encode($answer);
    }

    public function actionSocPatterns()
    {
        $socInfo = new SocInfo;
        $answer['soc_patterns'] = $socInfo->getSocPatterns();

        echo json_encode($answer);
    }

    public function actionDetectSocNet()
    {
        $answer = array(
            'netName' => '',
            'iteration' => ''
        );
        $data = MHttp::validateRequest();

        if (!isset($data['link']) or !isset($data['iteration']))
            MHttp::getJsonAndExit($answer);

        $net = SocInfo::getNetByLink($data['link']);
        if (!empty($net['name']))
            $answer['netName'] = $net['name'];

        $answer['iteration'] = $data['iteration'];

        echo json_encode($answer);
    }

    public function viewMobile()
    {
        if (Yii::app()->user->isGuest)
            MHttp::setAccess();

        $url = Yii::app()->request->getQuery('url', 0);
        $scroll_key = (int)Yii::app()->request->getQuery('key', 0);
        if (!$url)
            MHttp::setNotFound();

        $spot = Spot::model()->findByAttributes(array('url' => $url, 'user_id'=>Yii::app()->user->id));

        if (!$spot)
            MHttp::setNotFound();

        if (!MHttp::isHostMobile())
            $this->redirect(MHttp::desktopHost() . '/spot/list/?discodes=' . $spot->discodes_id);

        $wallet = PaymentWallet::model()->findByAttributes(
            array('discodes_id'=>$spot->discodes_id));

        $curent_views = Spot::curentViews('spot');

        $this->layout = self::MOBILE_LAYOUT;
        $data = array(
            'spot' => $spot,
            'wallet' => $wallet,
            'curent_views' => $curent_views,
        );

        if (!empty($scroll_key)) {
            $data['scroll_key'] = $scroll_key;
            $curent_views = 'spot';
        }

        $this->render('/mobile/spot/personal', $data);

        Yii::app()->end();
    }

    public function actionAddSpot()
    {
        if (Yii::app()->user->isGuest)
            MHttp::setAccess();

        $this->layout = self::MOBILE_LAYOUT;
        $this->render('//mobile/spot/add_spot', array(
        ));
    }

    public function spotUrl($discodes_id = false)
    {
        $answer = Yii::app()->params['siteUrl']. '/spot/list/';

        if (!MHttp::isHostMobile() or empty(Yii::app()->params['mobileHost']))
            return $answer;

        $answer =
            'http://'
            . Yii::app()->params['mobileHost']
            . '/spot/list/';

        if ($discodes_id)
            $spot = Spot::getSpot(array('discodes_id' => $discodes_id));

        if (!empty($spot))
            $answer =
                'http://'
                . Yii::app()->params['mobileHost']
                . '/spot/view/'
                . $spot->url;

        return $answer;
    }
    
    //загрузка лого или фото для макета транспортной карты
    public function actionUploadImg()
    {
        $photo_width = 300;
        $photo_height = 300;
        
        $logo_width = 230;
        $logo_height = 60;
        
        $answer = array(
            'error' => 'yes',
        );
        
        $token = Yii::app()->request->getParam('token', false);
        $discodes_id = Yii::app()->request->getParam('discodes_id', false);
        $img_type = Yii::app()->request->getParam('img_type', false);
        
        if ($token != Yii::app()->request->csrfToken or !$discodes_id or !$img_type)
            MHttp::getJsonAndExit($answer);

        if (empty($_FILES['img']))
            MHttp::getJsonAndExit($answer);
            
        $img_attr = getimagesize($_FILES['img']['tmp_name']);
        
        if ($img_attr[2] > 3 or $img_attr[2] < 1)
            MHttp::getJsonAndExit($answer);
        
        /*
        $fileType = strtolower(substr(strrchr($_FILES['img']['name'], '.'), 1));
        $images = $this->getImageType();
        if (!isset($images[$fileType]))
            MHttp::getJsonAndExit($answer);
        */    
        $spot = Spot::model()->findByAttributes(
            array(
                'discodes_id' => (int)$discodes_id,
                'user_id' => Yii::app()->user->id,
            )
        );
        
        if (!$spot)
            MHttp::getJsonAndExit($answer);
            
        if ($img_type == 'transport_photo') {
            $filename = 'transport_photo_';
            $img_width = $photo_width;
            $img_height = $photo_height;
        }
        elseif ($img_type == 'transport_logo') {
            $filename = 'transport_logo_';
            $img_width = $logo_width;
            $img_height = $logo_height;
        }
        else
            MHttp::getJsonAndExit($answer);
            
        $filename .= $spot->discodes_id 
            . '_'. md5($spot->code);

        $filepath = Yii::getPathOfAlias('webroot.uploads.spot.') . '/' . $filename . '.jpg';

        //move_uploaded_file($_FILES['img']['tmp_name'], $filepath);
        
        MImg::cutToProportionJpg($_FILES['img']['tmp_name'], $filepath, $img_width, $img_height); 

        MImg::reduceToFrameJpg($filepath, $filepath, $img_width, $img_height);

        $answer['error'] = 'no';
        $answer['path'] = '/uploads/spot/' . $filename . '.jpg';
        
        echo json_encode($answer);
    }
    
    public function actionOrderTransportCard()
    {
        $answer = array(
            'error' => 'yes',
        );
        $data = MHttp::validateRequest();
        
        if (empty($data['email']) or empty($data['shipping_name']) or empty($data['phone']) or empty($data['address']) or empty($data['city']) or empty($data['zip']) or empty($data['discodes']) or !Yii::app()->user->id)
            MHttp::getJsonAndExit($answer);
            
        $spot = Spot::model()->findByAttributes(
            array(
                'discodes_id' => (int)$data['discodes'],
                'user_id' => Yii::app()->user->id,
            )
        );
        
        if (!$spot)
            MHttp::getJsonAndExit($answer);
 
        $user = User::model()->findByPk(Yii::app()->user->id);
        
        $card_type = TransportType::model()->findByPk($data['back']);
        if (!$card_type)
            MHttp::getJsonAndExit($answer);
        $data['back_img'] = $card_type->img;
        
        $photo_path = false;
        $logo_path = false;
        
        if (!empty($data['photo_croped']))
        {
            $photo = $data['photo_croped'];
            $photo = str_replace('data:image/png;base64,', '', $photo);
            $photo = str_replace(' ', '+', $photo);
            $photo_data = base64_decode($photo);
            $filepath = 
                Yii::getPathOfAlias('webroot.uploads.spot.') 
                . '/transport_photo_'
                . $spot->discodes_id 
                . '_' . md5($spot->code) 
                . '.png';

            if (file_put_contents($filepath, $photo_data))
                $photo_path = $filepath;
        }
         
        if (!empty($data['logo_croped']))
        {
            $logo = $data['logo_croped'];
            $logo = str_replace('data:image/png;base64,', '', $logo);
            $logo = str_replace(' ', '+', $logo);
            $logo_data = base64_decode($logo);
            $filepath = 
                Yii::getPathOfAlias('webroot.uploads.spot.') 
                . '/transport_logo_'
                . $spot->discodes_id 
                . '_' . md5($spot->code) 
                . '.png';

            if (file_put_contents($filepath, $logo_data))
            {
                $logo_path = $filepath;
                MImg::cutToProportionJpg($logo_path, $logo_path, MImg::LOGO_WIDTH, MImg::LOGO_HEIGHT);
            }
        }
       
        $data['front_img'] =  MImg::makeTransportCard($photo_path, $logo_path, $data['name'], $data['position']);
        
        MMail::transport_order($data['email'], $data, Lang::getCurrentLang());
        MMail::transport_order(Yii::app()->params['generalEmail'], $data, Lang::getCurrentLang());
        
        if (!empty($photo_path))
            unlink($photo_path);
        if (!empty($logo_path))
            unlink($logo_path);
        
        $answer['error'] = 'no';

        echo json_encode($answer);
    }
    
    public function actionOrderCustomCard()
    {
        $answer = array(
            'error' => 'yes',
        );
        $data = MHttp::validateRequest();
        
        if (empty($data['email']) or empty($data['shipping_name']) or empty($data['phone']) or empty($data['address']) or empty($data['city']) or empty($data['zip']))
            MHttp::getJsonAndExit($answer);
        
        $photo_path = false;
        $card = new CustomCard();
        $card->type = $data['type'];
        $card->save();
        
        if (!empty($data['photo_croped']))
        {
            $photo = $data['photo_croped'];
            $photo = str_replace('data:image/png;base64,', '', $photo);
            $photo = str_replace(' ', '+', $photo);
            $photo_data = base64_decode($photo);
            $filepath = 
                Yii::getPathOfAlias('webroot.uploads.custom_card.') 
                . '/photo_'
                . $card->id
                . '.png';

            if (file_put_contents($filepath, $photo_data)){
                $photo_path = $filepath;
            }
            else
                MHttp::getJsonAndExit($answer);
        }
         
        $data['front_img'] = MImg::makeGUUCard(
             $card, $photo_path, $data['name'], $data['position'], $data['department']);
        
        MMail::guu_card_order($data['email'], $data, Lang::getCurrentLang());
        MMail::guu_card_order(Yii::app()->params['generalEmail'], $data, Lang::getCurrentLang());
        
        if (!empty($photo_path))
            unlink($photo_path);
        
        $answer['number'] = CustomCard::getNextNum($data['type']);
        $answer['error'] = 'no';
        

        echo json_encode($answer);
    }
    
    public function actionListHistory()
    {
        $answer = array(
            'error' => 'yes',
            'content' => '',
            'empty_for_date' => false,
        );

        $data = MHttp::validateRequest();
        if (empty($data['discodes']) or Yii::app()->user->isGuest)
            MHttp::getJsonAndExit($answer);
        
        $wallet = PaymentWallet::model()->findByAttributes(
            array(
                'discodes_id' => (int)$data['discodes'],
                'user_id' => Yii::app()->user->id,
            )
        );
        if (!$wallet) MHttp::getJsonAndExit($answer);
        
        if (empty($data['date']) or !preg_match("~^[0-9]{2}.[0-9]{2}.[0-9]{4}$~", $data['date']))
            $data['date'] = false;
        
        if ($data['date']) {
            $date_history = mktime(0, 0, 0, substr($data['date'], 3, 2), substr($data['date'], 0, 2), substr($data['date'], 6, 4));
        
            $history = Report::listHistory($wallet->payment_id, $date_history);
        
            if (empty($history) or !strlen($history[0]->creation_date) or
                substr($history[0]->creation_date, strlen($history[0]->creation_date) - 10, 10) != date('d.m.Y', $date_history))
                $answer['empty_for_date'] = true;
        } else {
            $history = Report::model()->findAllByAttributes(
                array(
                    'payment_id' => $wallet->payment_id,
                    'type' => Report::TYPE_PAYMENT,
                ),
                array(
                    'order' => 'creation_date desc',
                    'limit' => Report::MAX_RECORD)
            );            
        }
        
        $answer['content'] = $this->renderPartial('//spot/block/list_history',
            array(
                'history'=> $history,
            ),
            true
        );
        $answer['error'] = 'no';
        
        echo json_encode($answer);
    }
    
    public function actionBlockTroika()
    {
        $answer = array('error' => 'yes');
        
        $data = MHttp::validateRequest();
        
         if (empty($data['discodes']))
            MHttp::getJsonAndExit($answer);
        
        $spot = Spot::model()->findByAttributes(
            array(
                'discodes_id' => (int)$data['discodes'],
                'user_id' => Yii::app()->user->id,
            )
        );
        if (!$spot)
            MHttp::getJsonAndExit($answer);
        
        $wallet = PaymentWallet::model()->findByAttributes(
            array('discodes_id'=>$spot->discodes_id));
            
        if (!$wallet)
            MHttp::getJsonAndExit($answer);
        
        if (!SpotTroika::lostCard($wallet->hard_id))
            MHttp::getJsonAndExit($answer);
        
        $answer = array('error' => 'no');
        
        $wallet->status = PaymentWallet::STATUS_BANNED;
        $wallet->save();

        $spot->status = Spot::STATUS_INVISIBLE;
        $spot->save();
        
        echo json_encode($answer);
    }
    
    public function actionAddPhone()
    {
        $answer = array(
            'error' => 'yes',
        );

        $data = MHttp::validateRequest();
        if (empty($data['discodes']) or empty($data['phone']))
            MHttp::getJsonAndExit($answer);
        
        $spot = Spot::model()->findByAttributes(
            array(
                'discodes_id' => (int)$data['discodes'],
                'user_id' => Yii::app()->user->id,
            )
        );
        if (!$spot)
            MHttp::getJsonAndExit($answer);
        
        $spotPhone = SpotPhone::model()->findByAttributes(array('phone'=>'7' . $data['phone'], 'discodes_id'=>$spot->discodes_id));
        
        if ($spotPhone)
            MHttp::getJsonAndExit($answer);
        
        $spotPhone = new SpotPhone();
        $spotPhone->phone = '7' . $data['phone'];
        $spotPhone->discodes_id = $spot->discodes_id;
        
        $settingPhone = SpotPhone::model()->findByAttributes(array('discodes_id'=>$spot->discodes_id));
        if ($settingPhone) {
            $spotPhone->school_sms = $settingPhone->school_sms;
        }
        
        $spotPhone->save();
            
        $answer['content'] = $this->renderPartial(
            '//spot/block/phone',
            array(
                'phone' => $spotPhone,
             ),
            true
        );
        $answer['error'] = 'no';
        
        echo json_encode($answer);
    }
    
    
    public function actionRemovePhone() 
    {
        $answer = array(
            'error' => 'yes',
        );
        $data = MHttp::validateRequest();
        if (empty($data['discodes']) or empty($data['phone']))
            MHttp::getJsonAndExit($answer);
        
        $spot = Spot::model()->findByAttributes(
            array(
                'discodes_id' => (int)$data['discodes'],
                'user_id' => Yii::app()->user->id,
            )
        );
        if (!$spot)
            MHttp::getJsonAndExit($answer);
        
        $spotPhone = SpotPhone::model()->findByAttributes(array('phone'=>$data['phone'], 'discodes_id'=>$spot->discodes_id));
        
        if (!$spotPhone)
            MHttp::getJsonAndExit($answer);
        
        if($spotPhone->delete())
            $answer['error'] = 'no';
        
        echo json_encode($answer);
    }
    
    public function actionActivateSchoollExtended()
    {
        $answer = array(
            'error' => 'yes',
            'content' => '',
        );
        $data = MHttp::validateRequest();
        if (empty($data['discodes']) or empty($data['address']))
            MHttp::getJsonAndExit($answer);
        
        $spot = Spot::model()->findByAttributes(
            array(
                'discodes_id' => (int)$data['discodes'],
                'user_id' => Yii::app()->user->id,
            )
        );
        if (!$spot)
            MHttp::getJsonAndExit($answer);
        
        $spotPhones = SpotPhone::model()->findAllByAttributes(array('discodes_id'=>$spot->discodes_id));
        
        if (empty($spotPhones))
            MHttp::getJsonAndExit($answer);
        
        if (!$spot->setMapPoint($data['address'], Spot::MAP_POINT_HOME))
            MHttp::getJsonAndExit($answer);
        
        foreach($spotPhones as $phone){
            $phone->school_sms = 1;
            $phone->save();
        }
        
        $answer['content'] = $this->renderPartial(
            '//spot/block/school_extended',
            array(
                'school_extended_address' => $data['address'],
             ),
            true
        );
        
        $answer['error'] = 'no';
        
        echo json_encode($answer);
    }
    
    public function actionRemoveSchoollExtended()
    {
        $answer = array(
            'error' => 'yes',
            'content' => '',
        );
        $data = MHttp::validateRequest();
        if (empty($data['discodes']))
            MHttp::getJsonAndExit($answer);
        
        $spot = Spot::model()->findByAttributes(
            array(
                'discodes_id' => (int)$data['discodes'],
                'user_id' => Yii::app()->user->id,
            )
        );
        if (!$spot)
            MHttp::getJsonAndExit($answer);
        
        $spotPhones = SpotPhone::model()->findAllByAttributes(array('discodes_id'=>$spot->discodes_id));
        
        if (empty($spotPhones))
            MHttp::getJsonAndExit($answer);
        
        foreach($spotPhones as $phone){
            $phone->school_sms = 0;
            $phone->save();
        }
        
        $answer['content'] = $this->renderPartial(
            '//spot/block/school_extended',
            array(
                'school_extended_address' => false,
             ),
            true
        );
        
        $answer['error'] = 'no';
        
        echo json_encode($answer);
    }
}
