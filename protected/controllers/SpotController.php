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
        if (Yii::app()->request->getQuery('url'))
        {
            $url = Yii::app()->request->getQuery('url');
            $this->redirect('http://m.tmp.mobispot.com/' . $url);
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
            $this->getJsonAndExit($answer);

        $fileType = strtolower(substr(strrchr($file, '.'), 1));
        $file = md5(time() . $discodes) . '_' . $file;

        $patch = Yii::getPathOfAlias('webroot.uploads.spot.') . '/';
        $file_name = $patch . $file;

        if (!file_put_contents($file_name, file_get_contents('php://input')))
        {
            $this->getJsonAndExit($answer);
        }

        $images = $this->getImageType();
        if (isset($images[$fileType]))
        {
            $type = 'image';
            $image = new CImageHandler();
            $image->load($file_name);
            if ($image->thumb(300, false, true))
                $image->save($patch . 'tmb_' . $file);
        }
        else
            $type = 'obj';

        $spot = Spot::getSpot(array('discodes_id' => $discodes));
        if (!$spot)
            $this->getJsonAndExit($answer);

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

    // Просмотр содержимого спота
    public function actionSpotView()
    {
        $answer = array(
            'error' => 'yes',
            'content' => ''
        );
        $data = $this->validateRequest();

        if (!isset($data['discodes']))
            $this->getJsonAndExit($answer);

        $spot = Spot::model()->findByPk($data['discodes']);
        if (!$spot)
            $this->getJsonAndExit($answer);

        $spotContent = SpotContent::getSpotContent($spot);
        if (!$spotContent)
            $spotContent = SpotContent::initPersonal($spot);

        $content = $spotContent->content;
        $content_keys = $content['keys'];

        $sms_info = false;
        $wallet = PaymentWallet::model()->findByAttributes(
        array(
            'discodes_id' => $data['discodes'],
            'user_id' => Yii::app()->user->id,
            )
        );
        $answer['content'] = $this->renderPartial('//spot/' . $spot->spot_type->key,
            array(
                'spot' => $spot,
                'spotContent' => $spotContent,
                'content_keys' => $content_keys,
                'wallet' => $wallet,
                'sms_info' => $sms_info,
            ),
            true
        );

        $answer['pass'] = '';
        if (!empty($spot->pass))
            $answer['pass'] = $spot->pass;
        $answer['error'] = "no";

        echo json_encode($answer);
    }

    public function actionCoupons()
    {
        $answer = array(
            'error' => 'yes',
            'content' => ''
        );
        $data = $this->validateRequest();

        if (!isset($data['discodes']) or !Yii::app()->user->id)
            $this->getJsonAndExit($answer);

        $wallet = PaymentWallet::model()->findByAttributes(
        array(
                'discodes_id' => $data['discodes'],
                'user_id' => Yii::app()->user->id,
                'status' => PaymentWallet::STATUS_ACTIVE,
            )
        );

        if ($wallet)
        {
            $coupons = Loyalty::getCoupons($wallet->id);
            $answer['content'] = $this->renderPartial(
                    '//spot/coupons', array('coupons' => $coupons), true
            );
        }
        else
            $answer['content'] = $this->renderPartial('//spot/no_wallet', array(), true);

        $answer['error'] = 'no';

        echo json_encode($answer);
    }


    //подгрузка кошелька после открытия спота
    public function actionWallet()
    {
        $answer = array(
            'error' => 'yes',
            'content' => ''
        );
        $data = $this->validateRequest();

        if (empty($data['discodes']) or Yii::app()->user->isGuest)
            $this->getJsonAndExit($answer);

        $wallet = PaymentWallet::model()->findByAttributes(
            array(
                'discodes_id' => $data['discodes'],
                'user_id' => Yii::app()->user->id,
            )
        );

        if (!$wallet)
        {
            $answer['content'] = str_replace('id="coupons-block"', 'id="wallet-block"', $this->renderPartial('//spot/no_wallet', array(), true));
            $this->getJsonAndExit($answer);
        }

        $logs = PaymentLog::getListByWalletId($wallet->id);
        $actions = WalletLoyalty::getByWalletId($wallet->id);
        $sms_info = false;

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

        $answer['content'] = $this->renderPartial('//spot/wallet',
            array(
                'wallet' => $wallet,
                'actions' => $actions,
                'cards' => $cards,
                'auto' => $auto,
                'sms_info' => $sms_info,
            ),
            true
        );
        $answer['error'] = 'no';

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
        $data = $this->validateRequest();

        if (!isset($data['content']) or !isset($data['user']) or !isset($data['discodes']))
        {
            $this->getJsonAndExit($answer);
        }

        $spot = Spot::getSpot(array('discodes_id' => $data['discodes']));
        $spotContent = SpotContent::getSpotContent($spot);

        if (!$spotContent)
            $spotContent = SpotContent::initPersonal($spot);

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
        $data = $this->validateRequest();

        if (isset($data['discodes']))
            $this->getJsonAndExit($answer);

        $spot = Spot::getSpot(array('discodes_id' => $data['discodes']));
        if (!$spot)
            $this->getJsonAndExit($answer);

        $spotContent = SpotContent::getSpotContent($spot);

        if (!$spotContent)
            $spotContent = SpotContent::initPersonal($spot);

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
            'content' => ''
        );
        $data = $this->validateRequest();

        if (!isset($data['discodes']) or !isset($data['key']))
            $this->getJsonAndExit($answer);

        $spot = Spot::getSpot(array('discodes_id' => $data['discodes']));
        if (!$spot)
            $this->getJsonAndExit($answer);

        $spotContent = SpotContent::getSpotContent($spot);
        if (!$spotContent)
            $this->getJsonAndExit($answer);

        $content = $spotContent->content;
        if ($content['keys'][$data['key']] != 'text')
        {
            $patch = Yii::getPathOfAlias('webroot.uploads.spot.') . '/';
            @unlink($patch . $content['data'][$data['key']]);
            @unlink($patch . 'tmb_' . $content['data'][$data['key']]);
        }

        unset($content['keys'][$data['key']]);
        unset($content['data'][$data['key']]);
        $spotContent->content = $content;
        if ($spotContent->save())
        {
            $keys = array();
            foreach ($content['keys'] as $answer['key'] => $value)
            {
                $keys[] = $answer['key'];
            }

            $answer['keys'] = $keys;
            $answer['error'] = "no";
        }
        echo json_encode($answer);
    }

    // Сохранение содержимого блока
    public function actionSpotSaveContent()
    {
        $answer = array(
            'error' => 'yes',
            'content' => '',
        );
        $data = $this->validateRequest();

        if (!isset($data['discodes']) or !isset($data['key']))
        {
            $this->getJsonAndExit($answer);
        }

        $spot = Spot::getSpot(array('discodes_id' => $data['discodes']));
        if (!$spot)
            $this->getJsonAndExit($answer);

        $spotContent = SpotContent::getSpotContent($spot);
        if (!$spotContent)
            $this->getJsonAndExit($answer);

        $content = $spotContent->content;
        $content['data'][$data['key']] = $data['content_new'];

        $spotContent->content = $content;
        if ($spotContent->save())
        {
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

    //Привязка соцсетей через кнопку
    public function actionBindSocial()
    {
        $data = $this->validateRequest();
        $answer = array(
            'error' => 'yes',
            'content' => '',
            'socnet' => 'no',
            'loggedIn' => false,
            'linkCorrect' => Yii::t('eauth', "This account doesn't exist:"),
        );
        $needSave = false;

        if (!isset($data['discodes']) or !isset($data['key']))
            $this->getJsonAndExit($answer);

        $spot = Spot::getSpot(array('discodes_id' => $data['discodes']));
        if (!$spot)
            $this->getJsonAndExit($answer);

        $spotContent = SpotContent::getSpotContent($spot);
        if (!$spotContent)
            $spotContent = SpotContent::initPersonal($spot);

        $socInfo = new SocInfo;
        $socNet = $socInfo->getNetByLink($spotContent->content['data'][$data['key']]);

        if (empty($socNet['name']))
            $this->getJsonAndExit($answer);

        $answer['socnet'] = $socNet['name'];
        $content = $spotContent->content;

        $answer['loggedIn'] = $socInfo->isLoggegOn($answer['socnet']);
        if (!$answer['loggedIn'])
        {
            $answer['error'] = "no";
            $this->getJsonAndExit($answer);
        }
        $needSave = $socInfo->contentNeedSave($spotContent->content['data'][$data['key']]);

        if ($needSave)
        {
            $userDetail = $socInfo->getSocInfo($socNet['name'], $spotContent->content['data'][$data['key']], $data['discodes'], $data['key']);
            if (empty($userDetail['error']))
            {
                $answer['linkCorrect'] = 'ok';
                $userDetail['binded_link'] = $spotContent->content['data'][$data['key']];
                $content['keys'][$data['key']] = 'content';
                $content['data'][$data['key']] = $userDetail;
                $spotContent->content = $content;
            }
            elseif ($userDetail['error'] == 'User not logged in')
            {
                $answer['loggedIn'] = false;
                Yii::app()->session['bind_discodes'] = $data['discodes'];
                Yii::app()->session['bind_key'] = $data['key'];
            }
            else
                $answer['linkCorrect'] = $userDetail['error'];
        }
        else
        {
            $answer['linkCorrect'] = $socInfo->isLinkCorrect($spotContent->content['data'][$data['key']], $data['discodes'], $data['key']);
            if ($answer['linkCorrect'] == 'ok')
            {
                $content['keys'][$data['key']] = 'socnet';
                $spotContent->content = $content;
            }
        }

        if ($answer['linkCorrect'] == 'ok' and $spotContent->save())
        {
            $socInfo = new SocInfo;
            $render_data = array(
                'key' => $data['key'],
            );

            $render_data['content'] = ($needSave)?
                ($content['data'][$data['key']])
                :($socInfo->getNetData($content['data'][$data['key']], $spot->discodes_id, $data['key'], $dinamyc = true));

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
        $data = $this->validateRequest();
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
            $this->getJsonAndExit($answer);

        $discodes_id = $data['spot']['discodes'];
        $spot = Spot::getSpot(array('discodes_id' => $discodes_id));
        $answer['socnet'] = $data['netName'];

        if (!$spot)
            $this->getJsonAndExit($answer);

        $answer['error'] = 'no';
        $socInfo = new SocInfo;
        $socNet = $socInfo->getNetByName($answer['socnet']);

        if (isset($socNet['needAuth']) and !$socNet['needAuth'] and !empty($socNet['profileHint']) and empty($data['link']))
        {
            $answer['profileHint'] = $socNet['profileHint'];
            $this->getJsonAndExit($answer);
        }

        if (!empty($data['link']))
        {
            $socNet = $socInfo->getNetByLink($data['link']);
            $needSave = $socInfo->contentNeedSave($data['link']);
        }
        else
            $socNet = $socInfo->getNetByName($answer['socnet']);

        if (!empty($socNet['name']) and ($socInfo->isLoggegOn($answer['socnet']) || (!empty($data['link']) and !$socNet['needAuth'])))
        {
            //авторизован через соцсеть, либо сеть не требует авторизации и есть привязываемая ссылка
            $answer['loggedIn'] = true;
            $answer['socnet'] = $socNet['name'];
            $spotContent = SpotContent::getSpotContent($spot);
            if (!$spotContent)
                $spotContent = SpotContent::initPersonal($spot);


            $content = $spotContent->content;
            if ($needSave && !empty($data['link']))
            {
                $userDetail = $socInfo->getSocInfo($answer['socnet'], $data['link'], $discodes_id, null);
                if (empty($userDetail['error']))
                {
                    $userDetail['binded_link'] = $data['link'];
                    $content['keys'][$content['counter']] = 'content';
                    $content['data'][$content['counter']] = $userDetail;
                    $answer['key'] = $content['counter'];
                    $content['counter'] = $content['counter'] + 1;
                    $spotContent->content = $content;
                    $spotContent->save();

                    $answer['linkCorrect'] = 'ok';
                    Yii::app()->session[$answer['socnet'] . '_BindByPaste'] = true;

                    $answer['content'] = $this->renderPartial('//spot/personal/new_content', array(
                        'content' => $content['data'][$answer['key']],
                        'key' => $answer['key'],
                            ), true);
                }
                else
                    $answer['linkCorrect'] = $userDetail['error'];
            }
            else
            {
                if (!empty($data['link']))
                    $answer['linkCorrect'] = $socInfo->isLinkCorrect($data['link'], $discodes_id, null);
                else
                    $answer['linkCorrect'] = 'ok';

                if ($answer['linkCorrect'] == 'ok')
                {
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
                    $answer['content'] = $this->renderPartial('//spot/personal/new_socnet',
                        array(
                            'content' => $content['data'][$answer['key']],
                            'key' => $answer['key'],
                            'socContent' => $socContent,
                        ),
                        true
                    );
                }
            }

        }
        else
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
        $target = '/user/personal';

        if (Yii::app()->request->isPostRequest)
            $data = $this->validateRequest();
        else
        {
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

        $answer['socnet'] = $data['bindNet']['name'];
        $discodes_id = $data['bindNet']['discodes'];

        if (!empty(Yii::app()->session[$answer['socnet'] . '_id']))
            $answer['loggedIn'] = true;

        if (!empty($data['bindNet']['key']) && $answer['loggedIn'])
        {
            //привязка через кнопку
            $answer['key'] = $data['bindNet']['key'];
            $spot = Spot::getSpot(array('discodes_id' => $discodes_id));
            if ($spot)
            {
                $spotContent = SpotContent::getSpotContent($spot);
                if (!$spotContent)
                    $spotContent = SpotContent::initPersonal($spot);

                if ($spotContent)
                {
                    $socInfo = new SocInfo;
                    $socNet = $socInfo->getNetByName($answer['socnet']);

                    if (!empty($socNet['name']))
                    {
                        $content = $spotContent->content;
                        $needSave = $socInfo->contentNeedSave($spotContent->content['data'][$answer['key']]);

                        if ($needSave)
                        {
                            $userDetail = $socInfo->getSocInfo($socNet['name'], $spotContent->content['data'][$answer['key']], $discodes_id, $answer['key']);
                            if (empty($userDetail['error']))
                            {
                                $userDetail['binded_link'] = $spotContent->content['data'][$answer['key']];
                                $content['keys'][$answer['key']] = 'content';
                                $content['data'][$answer['key']] = $userDetail;
                                $spotContent->content = $content;

                                $answer['linkCorrect'] = 'ok';
                            }
                            else
                                $answer['linkCorrect'] = $userDetail['error'];
                        }
                        else
                        {
                            $answer['linkCorrect'] = $socInfo->isLinkCorrect($spotContent->content['data'][$answer['key']], $discodes_id, $answer['key']);
                            if ($answer['linkCorrect'] == 'ok')
                            {
                                $content['keys'][$answer['key']] = 'socnet';
                                $spotContent->content = $content;
                            }
                        }
                        if ($answer['linkCorrect'] == 'ok')
                        {
                            if ($spotContent->save())
                            {
                                if ($needSave)
                                    $answer['content'] = $this->renderPartial('//spot/personal/new_content',
                                        array(
                                            'content' => $content['data'][$answer['key']],
                                            'key' => $answer['key'],
                                        ),
                                        true
                                    );
                                else
                                {
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
        }
        elseif (!empty($data['bindNet']['newField']) && $answer['loggedIn'])
        {
            //привязка через плашку
            $answer['newField'] = true;
            $spot = Spot::getSpot(array('discodes_id' => $discodes_id));

            if (!$spot)
                $this->getJsonOrRedirect($answer, $target);

            $socInfo = new SocInfo;
            $socNet = $socInfo->getNetByName($answer['socnet']);
            if (!empty($data['bindNet']['link']))
            {
                $socNet = $socInfo->getNetByLink($data['bindNet']['link']);
                $needSave = $socInfo->contentNeedSave($data['bindNet']['link']);
            }
            else
                $socNet = $socInfo->getNetByName($answer['socnet']);

            if (empty($socNet['name']) or empty(Yii::app()->session[$answer['socnet'] . '_profile_url']))
                $this->getJsonOrRedirect($answer, $target);

            $answer['socnet'] = $socNet['name'];
            $spotContent = SpotContent::getSpotContent($spot);
            if (!$spotContent)
                $spotContent = SpotContent::initPersonal($spot);

            $content = $spotContent->content;

            if ($needSave && !empty($data['bindNet']['link']))
            {
                $userDetail = $socInfo->getSocInfo($answer['socnet'], $data['bindNet']['link'], $discodes_id, null);
                if (!empty($userDetail['error']))
                {
                    $answer['linkCorrect'] = $userDetail['error'];
                    $this->getJsonOrRedirect($answer, $target);
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
                $answer['content'] = $this->renderPartial('//spot/personal/new_content',
                    array(
                        'content' => $content['data'][$answer['key']],
                        'key' => $answer['key'],
                    ),
                    true
                );

            }
            else
            {
                if (!empty($data['bindNet']['link']))
                    $answer['linkCorrect'] = $socInfo->isLinkCorrect($data['bindNet']['link'], $discodes_id);
                else
                    $answer['linkCorrect'] = 'ok';

                if ($answer['linkCorrect'] == 'ok')
                {
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
                    $answer['content'] = $this->renderPartial('//spot/personal/new_socnet', array(
                        'content' => $content['data'][$answer['key']],
                        'key' => $answer['key'],
                        'socContent' => $socContent,
                            ), true);
                }
            }
        }
        if(Yii::app()->request->isPostRequest)
            echo json_encode($answer);
        else
            $this->redirect('/user/personal?discodes=' . $data['bindNet']['discodes'] . '&key=' . $answer['key']);
    }

    public function actionSocNetContent()
    {
        $answer = array('error' => 'yes');
        $data = $this->validateRequest();

        if (!isset($data['discodes']) or !isset($data['key']))
            $this->getJsonAndExit($answer);

        $spot = Spot::getSpot(array('discodes_id' => $data['discodes']));
        if (!$spot)
            $this->getJsonAndExit($answer);

        $spotContent = SpotContent::getSpotContent($spot);
        if (!$spotContent)
            $spotContent = SpotContent::initPersonal($spot);

        if ($spotContent->content['keys'][$data['key']] != 'socnet')
            $this->getJsonAndExit($answer);

        $socInfo = new SocInfo;
        $socContent = $socInfo->getNetData($spotContent->content['data'][$data['key']], $data['discodes'], $data['key'], true);

        $answer['content'] = $this->renderPartial('//spot/personal/new_socnet',
            array(
                'content' => $spotContent->content['data'][$data['key']],
                'key' => $data['key'],
                'socContent' => $socContent,
            ),
            true
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
        $data = $this->validateRequest();
        $answer = array(
            'error' => 'yes',
            'content' => '',
        );

        if (!isset($data['discodes']) or !isset($data['key']))
            $this->getJsonAndExit($answer);

        $spot = Spot::getSpot(array('discodes_id' => $data['discodes']));
        if (!$spot)
            $this->getJsonAndExit($answer);

        $spotContent = SpotContent::getSpotContent($spot);
        if (!$spotContent)
            $spotContent = SpotContent::initPersonal($spot);

        $content = $spotContent->content;
        if ($content['keys'][$data['key']] == 'socnet')
        {
            $content['keys'][$data['key']] = 'text';
            $spotContent->content = $content;

            if (!$spotContent->save())
                $this->getJsonAndExit($answer);

            $answer['content'] = $this->renderPartial('//spot/personal/new_text',
                array(
                    'content' => $content['data'][$data['key']],
                    'key' => $data['key'],
                ),
                true
            );
            $answer['error'] = "no";
        }
        elseif ($content['keys'][$data['key']] == 'content')
        {
            $toDelete = array();
            if (!empty($content['data'][$data['key']]['last_img']) && strpos($content['data'][$data['key']]['last_img'], '/uploads/spot/') === 0)
                $toDelete[] = $content['data'][$data['key']]['last_img'];

            if (!empty($content['data'][$data['key']]['photo']) && strpos($content['data'][$data['key']]['photo'], '/uploads/spot/') === 0)
                $toDelete[] = $content['data'][$data['key']]['photo'];

            $content['keys'][$data['key']] = 'text';
            $content['data'][$data['key']] = $content['data'][$data['key']]['binded_link'];
            $spotContent->content = $content;

            if (!$spotContent->save())
                $this->getJsonAndExit($answer);

            foreach ($toDelete as $path)
            {
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

        echo json_encode($answer);
    }

    public function actionSocPatterns()
    {
        $socInfo = new SocInfo;
        $answer['socPatterns'] = $socInfo->getSocPatterns();

        echo json_encode($answer);
    }

    public function actionDetectSocNet()
    {
        $answer = array(
            'netName' => '',
            'iteration' => ''
        );
        $data = $this->validateRequest();

        if (!isset($data['link']) or !isset($data['iteration']))
            $this->getJsonAndExit($answer);

        $net = SocInfo::getNetByLink($data['link']);
        if (!empty($net['name']))
            $answer['netName'] = $net['name'];

        $answer['iteration'] = $data['iteration'];

        echo json_encode($answer);
    }

    // Добавление нового спота
    public function actionAddSpot()
    {
        $answer = array(
            'error' => 'yes',
            'content' => '',
        );
        $data = $this->validateRequest();

        if (!isset($data['code']))
            $this->getJsonAndExit($answer);

        $spot = Spot::model()->findByAttributes(array('code' => $data['code']));
        if (!$spot)
            $this->getJsonAndExit($answer);

        $spot->status = Spot::STATUS_REGISTERED;
        $spot->lang = $this->getLang();
        $spot->user_id = Yii::app()->user->id;

        if (isset($data['name']))
            $spot->name = $data['name'];
        $spot->spot_type_id = Spot::TYPE_PERSONAL;

        if (!$spot->save())
            $this->getJsonAndExit($answer);

        $wallet = PaymentWallet::model()->findByAttributes(
                array(
                    'discodes_id' => $spot->discodes_id,
                    'user_id' => 0,
                )
        );
        if ($wallet)
        {
            $wallet->status = PaymentWallet::STATUS_ACTIVE;
            $wallet->user_id = $spot->user_id;
            $wallet->save();
        }

        $answer['content'] = $this->renderPartial('//user/block/spots',
            array('data' => $spot),
            true
        );
        $answer['error'] = "no";

        echo json_encode($answer);
    }

    // Удаление спота
    public function actionRemoveSpot()
    {
        $answer = array(
            'error' => 'yes',
            'content' => '',
        );
        $data = $this->validateRequest();

        if (!isset($data['discodes']))
            $this->getJsonAndExit($answer);

        $spot = Spot::model()->findByPk($data['discodes']);
        if (!$spot)
            $this->getJsonAndExit($answer);

        $spot->status = Spot::STATUS_REMOVED_USER;
        if ($spot->save())
        {
            $answer['discodes'] = $spot->discodes_id;
            $answer['error'] = "no";
        }

        echo json_encode($answer);
    }

    // Очистка спота
    public function actionCleanSpot()
    {
        $answer = array(
            'error' => 'yes',
        );
        $data = $this->validateRequest();

        if (!isset($data['discodes']))
            $this->getJsonAndExit($answer);

        $spot = Spot::model()->findByPk($data['discodes']);
        if (!$spot)
            $this->getJsonAndExit($answer);

        $spotContent = SpotContent::getSpotContent($spot);
        $spotContent = SpotContent::initPersonal($spot, $spotContent);

        if ($spotContent->save())
            $answer['error'] = "no";

        echo json_encode($answer);
    }

    //Делаем спот невидимым
    public function actionInvisibleSpot()
    {
        $answer = array(
            'error' => 'yes',
        );
        $data = $this->validateRequest();

        if (!isset($data['discodes']))
            $this->getJsonAndExit($answer);

        $spot = Spot::model()->findByPk($data['discodes']);
        if (!$spot)
            $this->getJsonAndExit($answer);

        if ($spot->status == Spot::STATUS_INVISIBLE)
            $spot->status = Spot::STATUS_REGISTERED;
        else
            $spot->status = Spot::STATUS_INVISIBLE;

        if ($spot->save())
            $answer['error'] = "no";

        echo json_encode($answer);
    }

    //Переименовываем спот
    public function actionRenameSpot()
    {
        $answer = array(
            'error' => 'yes',
            'name' => ''
        );
        $data = $this->validateRequest();

        if (!isset($data['newName']) or !isset($data['discodes']))
        {
            $this->getJsonAndExit($answer);
        }
        $spot = Spot::model()->findByPk($data['discodes']);
        if (!$spot)
            $this->getJsonAndExit($answer);

        $spot->name = CHtml::encode($data['newName']);
        if (!$spot->save(false))
            $this->getJsonAndExit($answer);

        $answer['name'] = mb_substr($spot->name, 0, 45, 'utf-8');
        $answer['error'] = "no";

        $wallet = PaymentWallet::model()->findByAttributes(
                array(
                    'discodes_id' => $data['discodes']
                )
        );
        if ($wallet)
        {
            $wallet->name = $spot->name;
            $wallet->save(false);
        }

        echo json_encode($answer);
    }

    //Задать пароль на спот
    public function actionSetSpotPass()
    {
        $answer = array(
            'error' => 'yes',
        );
        $data = $this->validateRequest();

        if (!isset($data['discodes']) or !isset($data['pass']))
            $this->getJsonAndExit($answer);

        $spot = Spot::model()->findByPk($data['discodes']);
        if (!$spot)
            $this->getJsonAndExit($answer);

        if (empty($data['pass']))
            $spot->pass = null;
        else
            $spot->pass = $data['pass'];
        if ($spot->save(false))
        {
            $whitelist = SpotBlock::model()->findAllByAttributes(array('discodes_id' => $spot->discodes_id, 'whitelist' => true));
            for ($i = 0; $i < count($whitelist); $i++)
                $whitelist[$i]->delete();

            $answer['error'] = "no";
            $answer['saved'] = Yii::t('spot', 'Saved!');
        }

        echo json_encode($answer);
    }

    //Сохраняем
    public function actionSaveOrder()
    {
        $answer = array(
            'error' => 'yes',
        );
        $data = $this->validateRequest();

        if (!isset($data['discodes']) or !isset($data['keys']))
            $this->getJsonAndExit($answer);

        $spot = Spot::getSpot(array('discodes_id' => $data['discodes']));
        if (!$spot)
            $this->getJsonAndExit($answer);

        $spotContent = SpotContent::getSpotContent($spot);
        if (!$spotContent)
            $this->getJsonAndExit($answer);


        $content = $spotContent->content;
        $newkeys = array();
        foreach ($data['keys'] as $answer['key'])
        {
            if (isset($content['keys'][$answer['key']]))
            {
                $newkeys[$answer['key']] = $content['keys'][$answer['key']];
            }
        }
        $content['keys'] = $newkeys;
        $spotContent->content = $content;

        if ($spotContent->save())
            $answer['error'] = "no";

        echo json_encode($answer);
    }

}
