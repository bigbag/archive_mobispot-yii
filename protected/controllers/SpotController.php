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

    //Определяем ид спота загружаемого по умолчанию
    public function getCurentSpot($curent)
    {
        $curent_discodes = $curent;
        if (isset(Yii::app()->request->cookies['spot_curent_discodes']))
            $curent_discodes = Yii::app()->request->cookies['spot_curent_discodes']->value;
        return $curent_discodes;
    }

    //Определяем вкладку таба открытую в последний раз
    public function getCurentViews($curent)
    {
        $curent_views = $curent;
        if (isset(Yii::app()->request->cookies['spot_curent_views']))
            $curent_views = Yii::app()->request->cookies['spot_curent_views']->value;
        return $curent_views;
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
        if ($spots)
           $curent_discodes = $this->getCurentSpot($spots[0]->discodes_id);
            $curent_views = $this->getCurentViews($curent_views);

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
        if (!$spot) MHttp::getJsonAndExit($answer);

        $wallet = PaymentWallet::model()->findByAttributes(
            array('discodes_id'=>$spot->discodes_id));

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
            'name' => ''
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

        $answer['content'] = $this->renderPartialWithMobile(
            '//spot/settings',
            array(
                'wallet' => $wallet,
                'spot' => $spot,
            ),
            true,
            '//mobile/spot/settings'
        );
        $answer['error'] = 'no';
        echo json_encode($answer);
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

        if (!$spot) MHttp::getJsonAndExit($answer);

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
        $url = Yii::app()->params['internal_api'] . '/api/internal/yandex/linking/';
        $url .= $discodes_id . '?url=' . rawurlencode(Yii::app()->params['siteUrl']. '/spot/list/');
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

        if ($this->isHostMobile() and !empty(Yii::app()->params['mobile_host'])) {
            $spot = Spot::getSpot(array('discodes_id' => $discodes_id));

            if ($spot){
                $url = 'http://' . Yii::app()->params['mobile_host'] . '/spot/view/' . $spot->url;
            }
        }
        $linking = $this->getLinkingParams($discodes_id);
        $this->render('card_ofert', array('linking'=>$linking));
    }

    // Смена статуса карты на платежный
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

        $card->status = PaymentCard::STATUS_PAYMENT;
        if ($card->save()){
            if ($old_payment_card){
                $old_payment_card->status = PaymentCard::STATUS_ARCHIV;
                $old_payment_card->save();
            }
            $answer['error'] = 'no';
        }

        echo json_encode($answer);
    }

    // Смена статуса карты на платежный
    public function actionRemoveCard()
    {
        $data = MHttp::validateRequest();
        $answer = array('error' => 'yes',);

        $card = PaymentCard::model()->findByPk((int)$data['card_id']);
        if (!$card) MHttp::getJsonAndExit($answer);

        if ($card->delete()){
            $answer['error'] = 'no';
        }

        echo json_encode($answer);
    }

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

        $coupons = Loyalty::getCoupons($wallet->id);
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

    //список купонов
    public function actionListCoupons()
    {
        $answer = array(
            'error' => 'yes',
            'content' => ''
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

        $coupons = Loyalty::getCoupons($wallet->id, $data['page'], $data['phrase']);

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
                        $content['data'][$content['counter']] = $data['link'];
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

        if ($this->isHostMobile())
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
                        $content['data'][$content['counter']] = $data['bindNet']['link'];
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
        elseif ($this->isHostMobile())
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
        $key = Yii::app()->request->getQuery('key', 0);
        if (!$url)
            $this->setNotFound();

        $spot = Spot::model()->findByAttributes(array('url' => $url, 'user_id'=>Yii::app()->user->id));

        if (!$spot)
            $this->setNotFound();

        if (!$this->isHostMobile())
            $this->redirect(MHttp::desktopHost() . '/spot/list/?discodes=' . $spot->discodes_id);

        $curent_views = $this->getCurentViews('spot');

        $this->layout = self::MOBILE_LAYOUT;
        $this->render('/mobile/spot/personal', array(
            'spot' => $spot,
            'curent_views' => $curent_views,
            'to_key' => $key,
        ));

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
}
