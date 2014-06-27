<?php

class SpotController extends MController
{

    const BAN_TIME = 5;

    public $layout = '//layouts/m';

    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'application.extensions.kcaptcha.KCaptchaAction',
                'maxLength' => 6,
                'minLength' => 5,
                'foreColor' => array(mt_rand(0, 100), mt_rand(0, 100), mt_rand(0, 100)),
                'backColor' => array(mt_rand(200, 210), mt_rand(210, 220), mt_rand(220, 230))
            ),
        );
    }

    //Отображение спота на мобильном
    public function actionIndex()
    {
        if (Yii::app()->request->getQuery('url', 0)) {
            //шаблон отображения контента спота
            $this->layout = '//layouts/mobile';
            
            $url = Yii::app()->request->getQuery('url', 0);
            $spot = Spot::model()->mobil()->findByAttributes(array('url' => $url));

            if ($spot && !empty($spot->pass)) {
                $block = SpotBlock::model()->findByAttributes(array('token' => Yii::app()->request->csrfToken, 'discodes_id' => $spot->discodes_id, 'whitelist' => null));
                $whitelist = SpotBlock::model()->findByAttributes(array('token' => Yii::app()->request->csrfToken, 'discodes_id' => $spot->discodes_id, 'whitelist' => true));
                if ($block && !empty($block->blocked_until) && strtotime($block->blocked_until) < time()) {
                    //обнуление счетчика по окончанию бана
                    $block->blocked_until = null;
                    $block->fails = 0;
                    $block->save();
                }
            } else {
                $block = false;
                $whitelist = false;
            }

            if (isset(Yii::app()->session['spot_view_ban']) && (Yii::app()->session['spot_view_ban'] >= time())) {
                //забанен за перебор url'ов
                $this->redirect(array('error'));
            } elseif (!$spot) {
                //счетчик банов
                $this->setBanned();
            } elseif ($block && !empty($block->blocked_until) && strtotime($block->blocked_until) >= time()) {
                //забанен за перебор пароля
                $this->setAccess();
                //$this->redirect(array('error'));
            } elseif (!empty($spot->pass) && !(Yii::app()->request->getPost('pass')) && !$whitelist) {
                //отображение клавиатуры пароля
                $this->render('/widget/spot/pass');
            } elseif (!empty($spot->pass)
                    && (Yii::app()->request->getPost('pass'))
                    && (!(Yii::app()->request->getPost('token')) || Yii::app()->request->getPost('token') != Yii::app()->request->csrfToken)
                    )
            {
                //пришел пароль, но нет жетона
                $this->setBadRequest();
            } elseif (!empty($spot->pass)
                    && (Yii::app()->request->getPost('pass'))
                    && !(Yii::app()->request->getPost('pass') == $spot->pass)
                    )
            {
                //пришел неверный пароль
                if (!$block) {
                    $block = new SpotBlock;
                    $block->token = Yii::app()->request->csrfToken;
                    $block->discodes_id = $spot->discodes_id;
                    $block->fails = 0;
                }

                $block->fails = $block->fails + 1;
                $block->save();

                if ($block->fails >= 3) {
                    //бан
                    $block->blocked_until = date('Y-m-d H:i:s', (time() + 3*60*60));
                    $block->save();
                    $this->redirect(Yii::app()->request->requestUri);
                    $this->setAccess();
                } else
                    $this->render('/widget/spot/pass', array('wrongPass'=> Yii::app()->request->getPost('pass')));
            } else {
                //отображение спота
                if (isset(Yii::app()->session['spot_view_error_count'])) {
                    //сброс счетчика перебора url
                    Yii::app()->session['spot_view_error_count'] = 0;
                    Yii::app()->session['spot_view_ban'] = 0;
                }

                if (!empty($spot->pass)) {
                    //белый список - не запрашивать пароль спота
                    $newWhitelist = SpotBlock::model()->findByAttributes(array('token' => Yii::app()->request->csrfToken, 'discodes_id' => $spot->discodes_id));
                    if (!$newWhitelist) {
                        $newWhitelist = new SpotBlock;
                        $newWhitelist->token = Yii::app()->request->csrfToken;
                        $newWhitelist->discodes_id = $spot->discodes_id;
                    }
                    $newWhitelist->fails = 0;
                    $newWhitelist->blocked_until = date('Y-m-d H:i:s', (time() + 10*60*60));
                    $newWhitelist->whitelist = true;
                    $newWhitelist->save();
                }

                $spotContent = SpotContent::getSpotContent($spot);

                if (!$spotContent) {
                    $this->setNotFound();
                }

                $content = $spotContent['content'];

                $dataKeys = array_keys($content['keys']);
                $fileKeys = array_keys($content['keys'], 'file');

                if (count($dataKeys) == 0) {
                    $this->setNotFound();
                }

                if ($content['private'] == 0) {
                    //только файлы
                    if (count($fileKeys) == count($dataKeys)) {
                        $this->render('/widget/spot/send', array('content' => $content));
                    } else {
                        $url = $this->urlActivate($content['data'][$dataKeys[0]]);
                        $urlVal = new CUrlValidator;

                        //одна ссылка
                        if ((count($content['data']) == 1) and ($content['keys'][$dataKeys[0]] == 'text') and ($urlVal->validateValue($url))) {
                            $this->redirect($url);
                        }
                        //стандартное отображение
                        else {
                            $size = count($content['keys']);
                            for ($i = 0; $i < $size; $i++) {
                                if ($content['keys'][$dataKeys[$i]] == 'socnet') {
                                    $link = $content['data'][$dataKeys[$i]];
                                    $socInfo = new SocInfo;
                                    $socData = $socInfo->getNetData($link, $spot->discodes_id, $dataKeys[$i]);
                                    if (isset($socData['netName'])) {
                                        if(empty($socData['soc_url']))
                                            $socData['soc_url'] = $link;
                                        $content['data'][$dataKeys[$i]] = $socData;
                                    }
                                } elseif ($content['keys'][$dataKeys[$i]] == 'content') {
                                    $socInfo = new SocInfo;
                                    $net = $socInfo->getNetByLink($content['data'][$dataKeys[$i]]['binded_link']);
                                    if (!empty($content['data'][$dataKeys[$i]]['check_following'])
                                        && !empty(Yii::app()->session[$content['data'][$dataKeys[$i]]['check_following']])
                                        && !empty($content['data'][$dataKeys[$i]]['message_following']))
                                        $content['data'][$dataKeys[$i]]['invite'] = $content['data'][$dataKeys[$i]]['message_following'];
                                    else
                                        $content['data'][$dataKeys[$i]]['invite'] = $net['invite'];
                                    $content['data'][$dataKeys[$i]]['inviteClass'] = $net['inviteClass'];
                                    $content['data'][$dataKeys[$i]]['inviteValue'] = $net['inviteValue'];
                                    $content['data'][$dataKeys[$i]]['netName'] = $net['name'];
                                    if(empty($content['data'][$dataKeys[$i]]['soc_url']) && !empty($content['data'][$dataKeys[$i]]['binded_link']))
                                        $content['data'][$dataKeys[$i]]['soc_url'] = $content['data'][$dataKeys[$i]]['binded_link'];
                                }
                            }
                            $this->render('/widget/spot/personal', array('content' => $content));
                        }
                    }
                } else {
                    $baseUrl = $this->createAbsoluteUrl("");
                    if ((strpos($baseUrl, "http://") > 0) || (strpos($baseUrl, "http://") !== false)) {
                        $baseUrl = substr($baseUrl, (strpos($baseUrl, "http://") + 7));
                    }
                    if (strpos($baseUrl, "/") > 0) {
                        $baseUrl = substr($baseUrl, 0, strpos($baseUrl, "/"));
                    }
                    $baseUrl = "http://" . $baseUrl;
                    $this->redirect($baseUrl);
                }
            }
        } elseif (!(Yii::app()->user->isGuest)) {
            //к списку спотов в моб.версии
            $this->redirect('spot/list');
        } else {
            //форма логина
            $this->render('/spot/login');
        }
    }
    
    public function actionList()
    {
        if (Yii::app()->user->isGuest)
            $this->setAccess();

        $user = User::model()->findByPk(Yii::app()->user->id);
        if ($user->status == User::STATUS_NOACTIVE)
            $this->setAccess();

        $spots = Spot::getActiveByUserId(Yii::app()->user->id, true);

        $this->render('/spot/list', array(
            'spots' => $spots,
        ));
    }
    
    public function actionView()
    {
        if (Yii::app()->user->isGuest)
            $this->setAccess();
    
        $url = Yii::app()->request->getQuery('url', 0);
        if (!$url)
            $this->setNotFound();
            
        $spot = Spot::model()->findByAttributes(array('url' => $url, 'user_id'=>Yii::app()->user->id));
        
        if (!$spot)
            $this->setNotFound();
            
        $curent_views = $this->getCurentViews();
        
        $this->render('/spot/personal', array(
            'spot' => $spot,
            'curent_views' => $curent_views,
        ));
    }
    
    public function actionSpotContent()
    {
        $answer = array(
            'error' => 'yes',
            'content' => ''
        );

        $data = $this->validateRequest();
        if (!isset($data['discodes'])) $this->getJsonAndExit($answer);

        $spot = Spot::model()->findByPk((int)$data['discodes']);
        if (!$spot) $this->getJsonAndExit($answer);

        $wallet = PaymentWallet::model()->findByAttributes(
            array('discodes_id'=>$spot->discodes_id));

        $spotContent = SpotContent::getSpotContent($spot);
        if (!$spotContent) $spotContent = SpotContent::initPersonal($spot);

        $content = $spotContent->content;
        $content_keys = $content['keys'];

        $answer['content'] = $this->renderPartial('/spot/content',
            array(
                'spot' => $spot,
                'wallet' => $wallet,
                'spotContent' => $spotContent,
                'content_keys' => $content_keys,
                'spotNets' => $spot->getBindedNets(),
            ),
            true
        );

        $answer['pass'] = '';
        if (!empty($spot->pass))
            $answer['pass'] = $spot->pass;
        $answer['error'] = "no";

        echo json_encode($answer);
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

        if (!isset($spotContent->content['keys'][$data['key']]))
            $this->getJsonAndExit($answer);
        if ($spotContent->content['keys'][$data['key']] != 'socnet')
            $this->getJsonAndExit($answer);

        $socInfo = new SocInfo;
        $socContent = $socInfo->getNetData($spotContent->content['data'][$data['key']], $data['discodes'], $data['key'], true);

        $answer['content'] = $this->renderPartial('/spot/personal/new_content',
            array(
                'content' => $spotContent->content['data'][$data['key']],
                'key' => $data['key'],
                'socContent' => $socContent,
            ),
            true
        );

        $answer['key'] = $data['key'];
        $answer['error'] = 'no';

        echo json_encode($answer);
    }

    public function actionFollowSocial()
    {
        $data = $this->validateRequest();
        $answer = array();

        if (!empty($data['service']) && !empty($data['param'])) {
            $socInfo = new SocInfo;
            $answer['LoggedIn'] = false;

            if ($socInfo->isLoggegOn($data['service'], false)) {
                $answer['LoggedIn'] = true;
                $followResult = $socInfo->followSocial($data['service'], $data['param']);
                foreach($followResult as $fKey => $fValue)
                    $answer[$fKey] = $fValue;
                if (isset($answer['error']) && 'no' == $answer['error'])
                    Yii::app()->session[$data['service'] . '_follow_' . $data['param']] = true;
            }
        }

        echo json_encode($answer);
    }

    public function actionSocLogin()
    {
        $service = Yii::app()->request->getQuery('service');
        $returnUrl = Yii::app()->request->getQuery('return_url');
        if (empty($returnUrl) && !empty(Yii::app()->session['returnUrl']))
            $returnUrl = Yii::app()->session['returnUrl'];

        if (!empty($service) && !empty($returnUrl)) {
            $authIdentity = Yii::app()->eauth->getIdentity($service);
            $authIdentity->redirectUrl = $returnUrl;
            $authIdentity->cancelUrl = $returnUrl;

            if ($authIdentity->authenticate()) {
                $identity = new ServiceUserIdentity($authIdentity);

                if ($identity->authenticate()) {
                    Yii::app()->session[$service] = 'auth';
                    if (strpos($returnUrl, '&follow_param=') !== false) {
                        $followParam = substr($returnUrl, strpos($returnUrl, '&follow_param=') + strlen('&follow_param='));
                        if (strpos($followParam, '&') !== false)
                            $followParam = substr($followParam, 0, strpos($followParam, '&'));
                        $returnUrl = substr($returnUrl, 0, strpos($returnUrl, '&follow_param='));
                    } else
                        $followParam = Yii::app()->request->getQuery('follow_param');
                    if (!empty($followParam)) {
                        $socInfo = new SocInfo;
                        $followResult = $socInfo->followSocial($service, $followParam);
                        if (isset($followResult['error']) && 'no' == $followResult['error'])
                            Yii::app()->session[$service . '_follow_' . $followParam] = true;
                    }
                    unset(Yii::app()->session['returnUrl']);

                    $this->redirect('http://' . $returnUrl);
                } else {
                    $authIdentity->cancel();
                }
            }
        } else {
            $this->setNotFound();
        }
    }

    //Защита от перебора url
    public function setBanned()
    {
        if (!isset(Yii::app()->session['spot_view_error_count'])) {
            Yii::app()->session['spot_view_error_count'] = 0;
        }
        Yii::app()->session['spot_view_error_count'] = Yii::app()->session['spot_view_error_count'] + 1;

        if (Yii::app()->session['spot_view_error_count'] >= 5) {
            Yii::app()->session['spot_view_error_count'] = 0;
            Yii::app()->session['spot_view_ban'] = self::BAN_TIME * 60 + time();

            $this->setAccess();
        }
        $this->setNotFound();
    }

    public function actionGetCard()
    {
        $url = Yii::app()->request->getQuery('id');
        $spot = Spot::model()->findByAttributes(array('url' => $url));
        if ($spot and $spot->spot_type->key == 'personal') {
            //$content=SpotModel::model()->findByAttributes(array('spot_id'=>$spot->discodes_id, 'type'=>$spot->type));
            $spotContent = SpotContent::getSpotContent($spot);
            $content = $spotContent['content'];
            if ($content and isset($content['razreshit-skachivat-vizitku_3'][0])) {

                $data = array();
                if ($content['kontaktyi_3'] !== null)
                    $data = $data + $content['kontaktyi_3'];
                if ($content['sotsseti_3'] !== null)
                    $data = $data + $content['sotsseti_3'];
                if ($content['opisanie_3'] !== null)
                    $data = $data + $content['opisanie_3'];

                $all_field = SpotPersonalField::getPersonalFieldAll();
                $select_field = UserPersonalField::getField($spot->discodes_id);

                if (!$select_field)
                    $select_field = array(9999);

                $text = $this->renderPartial('/widget/vcard', array(
                    'content' => $content,
                    'spot' => $spot,
                    'all_field' => $all_field,
                    'data' => $data,
                    'select_field' => $select_field,
                        ), true);
                header('Content-type: text/x-vcard');
                header('Content-Disposition: attachment; filename="card.vcf"');
                echo $text;
            } else
                $this->redirect('/');
        } else
            $this->redirect('/');
    }

    public function actionError()
    {
        if (isset(Yii::app()->session['spot_view_error'])) {
            $form = new ErrorForm();
            if (isset($_POST['ErrorForm'])) {
                $form->attributes = $_POST['ErrorForm'];
                if ($form->validate() and (!isset($_POST['email'][1]))) {
                    unset(Yii::app()->session['spot_view_error']);
                    unset(Yii::app()->session['Yii_Captcha']);
                    $this->redirect('/');
                }
            }
            $this->layout = '//layouts/mobile';
            $this->render('error', array(
                'form' => $form,
            ));
        } else
            $this->redirect('http://mobispot.com');
    }

    //Определяем вкладку таба открытую в последний раз
    public function getCurentViews($curent = 'spot')
    {
        $curent_views = $curent;
        if (isset(Yii::app()->request->cookies['spot_curent_views']))
            $curent_views = Yii::app()->request->cookies['spot_curent_views']->value;
        return $curent_views;
    }
}
