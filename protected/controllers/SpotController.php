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
        if (Yii::app()->request->getQuery('url', 0))
        {
            $url = Yii::app()->request->getQuery('url', 0);
            $this->redirect('http://m.tmp.mobispot.com/' . $url);
        }
    }

    // Загрузка файлов в спот
    public function actionUpload()
    {
        $answer = array();
        $answer['error'] = 'yes';
        $answer['content'] = '';
        $answer['key'] = '';

        $discodes = (isset($_SERVER['HTTP_X_DISCODES']) ? $_SERVER['HTTP_X_DISCODES'] : false);
        $file = (isset($_SERVER['HTTP_X_FILE_NAME']) ? $_SERVER['HTTP_X_FILE_NAME'] : false);

        if ($file and $discodes)
        {
            $fileType = strtolower(substr(strrchr($file, '.'), 1));
            $file = md5(time() . $discodes) . '_' . $file;

            $patch = Yii::getPathOfAlias('webroot.uploads.spot.') . '/';
            $file_name = $patch . $file;

            if (file_put_contents($file_name, file_get_contents('php://input')))
            {
                $images = $this->getImageType();

                if (isset($images[$fileType]))
                {
                    $type = 'image';

                    $image = new CImageHandler();
                    $image->load($file_name);
                    if ($image->thumb(false, 300, true))
                    {
                        $image->save($patch . 'tmb_' . $file);
                    }
                }
                else
                {
                    $type = 'obj';
                }

                $spot = Spot::getSpot(array('discodes_id' => $discodes));
                $spotContent = SpotContent::getSpotContent($spot);

                if (!$spotContent)
                {
                    $spotContent = SpotContent::initPersonal($spot);
                }

                $content = $spotContent->content;
                $content['keys'][$content['counter']] = $type;
                $key = $content['counter'];
                $content['data'][$key] = $file;
                $content['counter'] = $content['counter'] + 1;
                $spotContent->content = $content;
                $spotContent->save();

                $answer['content'] = $this->renderPartial('//widget/spot/personal/new_' . $type, array(
                    'content' => $file,
                    'key' => $key,
                        ), true);
                $answer['key'] = $key;
                $answer['error'] = "no";
            }
        }
        echo json_encode($answer);
    }

    // Просмотр содержимого спота
    public function actionSpotView()
    {
        $data = $this->validateRequest();
        $answer = array();
        $answer['error'] = 'yes';
        $answer['content'] = '';

        if (isset($data['discodes']))
        {

            $spot = Spot::model()->findByPk($data['discodes']);
            if ($spot)
            {

                $spotContent = SpotContent::getSpotContent($spot);

                if (!isset($spotContent))
                {
                    $spotContent = new SpotContent();
                }

                $content = $spotContent->content;
                $content_keys = $content['keys'];
                // if (!empty($content_keys)) 
                // {
                //     ksort($content_keys);
                // }

                $answer['content'] = $this->renderPartial('//widget/spot/' . $spot->spot_type->key, array(
                    'spot' => $spot,
                    'spotContent' => $spotContent,
                    'content_keys' => $content_keys,

                        ), true);
                $answer['error'] = "no";
            }
        }
        echo json_encode($answer);
    }

    // Добавление блока в спот
    public function actionSpotAddContent()
    {
        $data = $this->validateRequest();
        $answer = array();
        $answer['error'] = 'yes';
        $answer['content'] = '';
        $answer['key'] = '';

        if (isset($data['content']) and isset($data['user']))
        {

            if (isset($data['discodes']))
            {

                $spot = Spot::getSpot(array('discodes_id' => $data['discodes']));
                $spotContent = SpotContent::getSpotContent($spot);

                if (!$spotContent)
                {
                    $spotContent = SpotContent::initPersonal($spot);
                }

                $content = $spotContent->content;
                $content['keys'][$content['counter']] = 'text';
                $key = $content['counter'];
                $content['data'][$key] = $data['content'];
                $content['counter'] = $content['counter'] + 1;
                $spotContent->content = $content;
                $spotContent->save();
                $answer['content'] = $this->renderPartial('//widget/spot/personal/new_text', array(
                    'content' => $data['content'],
                    'key' => $key,
                        ), true);
                $answer['key'] = $key;
                $answer['error'] = "no";
            }
        }
        echo json_encode($answer);
    }

    // Изменение атрибутов спота - приватность и возможность скачать визитку
    public function actionSpotAtributeSave()
    {
        $data = $this->validateRequest();
        $answer = array();
        $answer['error'] = 'yes';

        if (isset($data['discodes']))
        {

            $spot = Spot::getSpot(array('discodes_id' => $data['discodes']));
            if ($spot)
            {
                $spotContent = SpotContent::getSpotContent($spot);

                if (!$spotContent)
                {
                    $spotContent = SpotContent::initPersonal($spot);
                }

                $content = $spotContent->content;
                $content['private'] = $data['private'];
                $content['vcard'] = $data['vcard'];
                $spotContent->content = $content;
                if ($spotContent->save())
                {
                    $answer['error'] = "no";
                }
            }
        }
        echo json_encode($answer);
    }

    // Удаление блока из спота
    public function actionSpotRemoveContent()
    {
        $data = $this->validateRequest();
        $answer = array();
        $answer['error'] = 'yes';
        $answer['keys'] = '';

        if (isset($data['discodes']) and isset($data['key']))
        {

            $spot = Spot::getSpot(array('discodes_id' => $data['discodes']));
            if ($spot)
            {
                $spotContent = SpotContent::getSpotContent($spot);

                if ($spotContent)
                {
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
                        foreach ($content['keys'] as $key => $value)
                        {
                            $keys[] = $key;
                        }

                        $answer['keys'] = $keys;
                        $answer['error'] = "no";
                    }
                }
            }
        }
        echo json_encode($answer);
    }

    // Сохранение содержимого блока
    public function actionSpotSaveContent()
    {
        $data = $this->validateRequest();
        $answer = array();
        $answer['error'] = 'yes';
        $answer['content'] = '';

        if (isset($data['discodes']) and isset($data['key']))
        {
            $spot = Spot::getSpot(array('discodes_id' => $data['discodes']));
            if ($spot)
            {
                $spotContent = SpotContent::getSpotContent($spot);

                if ($spotContent)
                {
                    $content = $spotContent->content;
                    $content['data'][$data['key']] = $data['content_new'];

                    $spotContent->content = $content;
                    if ($spotContent->save())
                    {
                        $answer['content'] = $this->renderPartial('//widget/spot/personal/new_text', array(
                            'content' => $data['content_new'],
                            'key' => $data['key'],
                                ), true);
                        $answer['error'] = "no";
                    }
                }
            }
        }
        echo json_encode($answer);
    }

    //Привязка соцсетей
    
    //через кнопку
    public function actionBindSocial()
    {
        $data = $this->validateRequest();
        $error = "error";
        $content = '';
        $netName = 'no';
        $isSocLogged = false;
        $linkCorrect = Yii::t('eauth', "This account doesn't exist:");
        $needSave = false;

        if (isset($data['discodes']) and isset($data['key']))
        {

            $spot = Spot::getSpot(array('discodes_id' => $data['discodes']));
            if ($spot)
            {

                $spotContent = SpotContent::getSpotContent($spot);
                if ($spotContent)
                {

                    $socInfo = new SocInfo;
                    $socNet = $socInfo->getNetByLink($spotContent->content['data'][$data['key']]);

                    if (!empty($socNet['name']))
                    {
                        $netName = $socNet['name'];
                        $content = $spotContent->content;

                        if ((!empty(Yii::app()->session[$netName . '_id'])) || (isset($socNet['needAuth']) and $socNet['needAuth'] === false))
                        {
                            $isSocLogged = true;
                            $needSave = $socInfo->contentNeedSave($spotContent->content['data'][$data['key']]);

                            if ($needSave)
                            {
                                $userDetail = $socInfo->getSocInfo($socNet['name'], $spotContent->content['data'][$data['key']], $data['discodes'], $data['key']);
                                if (empty($userDetail['error']))
                                {
                                    $userDetail['binded_link'] = $spotContent->content['data'][$data['key']];
                                    $content['keys'][$data['key']] = 'content';
                                    $content['data'][$data['key']] = $userDetail;
                                    $spotContent->content = $content;

                                    $linkCorrect = 'ok';
                                }
                                elseif($userDetail['error'] == 'User not logged in'){
                                    $isSocLogged = false;
                                    Yii::app()->session['bind_discodes'] = $data['discodes'];
                                    Yii::app()->session['bind_key'] = $data['key'];
                                }
                                else
                                    $linkCorrect = $userDetail['error'];
                            }
                            else
                            {
                                $linkCorrect = $socInfo->isLinkCorrect($spotContent->content['data'][$data['key']], $data['discodes'], $data['key']);
                                if ($linkCorrect == 'ok')
                                {
                                    $content['keys'][$data['key']] = 'socnet';
                                    $spotContent->content = $content;
                                }
                            }
                            if ($linkCorrect == 'ok')
                            {
                                if ($spotContent->save())
                                {
                                    if ($needSave)
                                        $content = $this->renderPartial('//widget/spot/personal/new_content', array(
                                            'content' => $content['data'][$data['key']],
                                            'key' => $data['key'],
                                                ), true);
                                    else
                                    {
                                        $socContent = $socInfo->getNetData($content['data'][$data['key']], $data['discodes'], $data['key'], true);
                                        
                                        $content = $this->renderPartial('//widget/spot/personal/new_socnet', array(
                                            'content' => $content['data'][$data['key']],
                                            'socContent' => $socContent,
                                            'key' => $data['key'],
                                                ), true);
                                    }
                                }
                            }
                        }
                    }
                    $error = "no";
                }
            }
        }
        echo json_encode(
            array(
                'error' => $error,
                'content' => $content,
                'socnet' => $netName,
                'loggedIn' => $isSocLogged,
                'linkCorrect' => $linkCorrect
            )
        );
    }

    
    //Привязка через плашку
    public function actionBindByPanel()
    {
        $data = $this->validateRequest();
        $error = 'error';
        $content = '';
        $netName = 'no';
        $isSocLogged = false;
        $linkCorrect = Yii::t('eauth', "This account doesn't exist");
        $needSave = false;
        $profileHint = '';
        $key = false;
        
        if (isset($data['spot']) and !empty($data['spot']['discodes']) and isset($data['netName']))
        {
        
            $discodes_id = $data['spot']['discodes'];
            $spot = Spot::getSpot(array('discodes_id' => $discodes_id));
            $netName = $data['netName'];
            
            if ($spot)
            {
                $error = 'no';
                $socInfo = new SocInfo;
                $socNet = $socInfo->getNetByName($netName);
                
                if (isset($socNet['needAuth']) and !$socNet['needAuth'] and !empty($socNet['profileHint']) and empty($data['link']))
                {
                    //сеть не требует авторизации, но привязываемой сслки нет
                    $profileHint = $socNet['profileHint'];
                }
                else
                {
                    if (!empty($data['link']))
                    {
                        $socNet = $socInfo->getNetByLink($data['link']);
                        $needSave = $socInfo->contentNeedSave($data['link']);
                    }
                    else
                        $socNet = $socInfo->getNetByName($netName);
                    
                    if (!empty($socNet['name']) and (!empty(Yii::app()->session[$netName . '_profile_url']) || (!empty($data['link']) and !$socNet['needAuth'])))
                    {
                        //авторизован через соцсеть, либо сеть не требует авторизации и есть привязываемая ссылка
                        $isSocLogged = true;
                        $netName = $socNet['name'];
                        $spotContent = SpotContent::getSpotContent($spot);
                        
                        if ($spotContent)
                        {
                            $content = $spotContent->content;
                            if ($needSave && !empty($data['link']))
                            {
                                $userDetail = $socInfo->getSocInfo($netName, $data['link'], $discodes_id, null);
                                if (empty($userDetail['error']))
                                {
                                    $userDetail['binded_link'] = $data['link'];
                                    $content['keys'][$content['counter']] = 'content';
                                    $content['data'][$content['counter']] = $userDetail;
                                    $key = $content['counter'];
                                    $content['counter'] = $content['counter'] + 1;
                                    $spotContent->content = $content;
                                    $spotContent->save();
                                    $linkCorrect = 'ok';
                                    
                                    $content = $this->renderPartial('//widget/spot/personal/new_content', array(
                                            'content' => $content['data'][$key],
                                            'key' => $key,
                                                ), true);
                                }
                                else
                                    $linkCorrect = $userDetail['error'];
                            }
                            else
                            {
                                if (!empty($data['link']))
                                    $linkCorrect = $socInfo->isLinkCorrect($data['link'], $discodes_id, null);
                                else 
                                    $linkCorrect = 'ok';
                                
                                if ($linkCorrect == 'ok')
                                {
                                    $content['keys'][$content['counter']] = 'socnet';
                                    if (!empty($data['link']))
                                        $content['data'][$content['counter']] = $data['link'];
                                    else
                                        $content['data'][$content['counter']] = Yii::app()->session[$netName . '_profile_url'];
                                    $key = $content['counter'];
                                    $content['counter'] = $content['counter'] + 1;
                                    $spotContent->content = $content;
                                    $spotContent->save();
                                    
                                    $socContent = $socInfo->getNetData($content['data'][$key], $discodes_id, $key, true);
                                    $content = $this->renderPartial('//widget/spot/personal/new_socnet', array(
                                            'content' => $content['data'][$key],
                                            'key' => $key,
                                            'socContent' => $socContent,
                                        ), true);
                                }
                            }
                        }
                    }
                    else
                    {
                        $linkCorrect == 'ok';
                    }
                }
            }
        }
        
        echo json_encode(
            array(
                'error' => $error,
                'content' => $content,
                'key' => $key,
                'socnet' => $netName,
                'loggedIn' => $isSocLogged,
                'linkCorrect' => $linkCorrect,
                'profileHint' => $profileHint,
            )
        );
    }

    public function actionBindedContent()
    {
        $data = $this->validateRequest();
        //$error = 'error in spot/bindedContent';
        $content = '';
        $linkCorrect = Yii::t('eauth', "This account doesn't exist:");
        $isSocLogged = false;
        $newField = false;
        $newKey = false;
        $needSave = false;
        
        if (!isset($data['bindNet']) || empty($data['bindNet']['name']) || empty($data['bindNet']['discodes']))
        {
            $this->setBadReques();
        }
        $netName = $data['bindNet']['name'];
        $discodes_id = $data['bindNet']['discodes'];

        if (!empty(Yii::app()->session[$netName . '_id']))
            $isSocLogged = true;
        
        if (!empty($data['bindNet']['key']) && $isSocLogged)
        {
            //привязка через кнопку
            $key = $data['bindNet']['key'];
            $spot = Spot::getSpot(array('discodes_id' => $discodes_id));
            if ($spot)
            {
                $spotContent = SpotContent::getSpotContent($spot);
                if ($spotContent)
                {
                    $socInfo = new SocInfo;
                    $socNet = $socInfo->getNetByName($netName);

                    if (!empty($socNet['name']))
                    {
                        $content = $spotContent->content;
                        $needSave = $socInfo->contentNeedSave($spotContent->content['data'][$key]);

                        if ($needSave)
                        {
                            $userDetail = $socInfo->getSocInfo($socNet['name'], $spotContent->content['data'][$key], $discodes_id, $key);
                            if (empty($userDetail['error']))
                            {
                                $userDetail['binded_link'] = $spotContent->content['data'][$key];
                                $content['keys'][$key] = 'content';
                                $content['data'][$key] = $userDetail;
                                $spotContent->content = $content;

                                $linkCorrect = 'ok';
                            }
                            else
                                $linkCorrect = $userDetail['error'];
                        }
                        else
                        {
                            $linkCorrect = $socInfo->isLinkCorrect($spotContent->content['data'][$key], $discodes_id, $key);
                            if ($linkCorrect == 'ok')
                            {
                                $content['keys'][$key] = 'socnet';
                                $spotContent->content = $content;
                            }
                        }
                        if ($linkCorrect == 'ok')
                        {
                            if ($spotContent->save())
                            {
                                if ($needSave)
                                    $content = $this->renderPartial('//widget/spot/personal/new_content', array(
                                        'content' => $content['data'][$key],
                                        'key' => $key,
                                            ), true);
                                else
                                {
                                    $socContent = $socInfo->getNetData($content['data'][$key], $discodes_id, $key, true);
                                    
                                    $content = $this->renderPartial('//widget/spot/personal/new_socnet', array(
                                        'content' => $content['data'][$key],
                                        'key' => $key,
                                        'socContent' => $socContent,
                                            ), true);
                                }
                            }
                        }
                        //$error = "no";
                    }
                }
            }
        }
        elseif (!empty($data['bindNet']['newField']) && $isSocLogged)
        {
            //привязка через плашку
            $newField = true;
            $spot = Spot::getSpot(array('discodes_id' => $discodes_id));
            
            if ($spot)
            {
            
                $socInfo = new SocInfo;
                $socNet = $socInfo->getNetByName($netName);
                if (!empty($data['bindNet']['link']))
                {
                    $socNet = $socInfo->getNetByLink($data['bindNet']['link']);
                    $needSave = $socInfo->contentNeedSave($data['bindNet']['link']);
                }
                else
                    $socNet = $socInfo->getNetByName($netName);
             
                if (!empty($socNet['name']) and (!empty(Yii::app()->session[$netName . '_profile_url'])))
                {

                    $netName = $socNet['name'];
                    $spotContent = SpotContent::getSpotContent($spot);
                    
                    if ($spotContent)
                    {
                        $content = $spotContent->content;
                        
                        if ($needSave && !empty($data['bindNet']['link']))
                        {
                            $userDetail = $socInfo->getSocInfo($netName, $data['bindNet']['link'], $discodes_id, null);
                            if (empty($userDetail['error']))
                            {
                                $userDetail['binded_link'] = $data['bindNet']['link'];
                                $content['keys'][$content['counter']] = 'content';
                                $content['data'][$content['counter']] = $userDetail;
                                $key = $content['counter'];
                                $content['counter'] = $content['counter'] + 1;
                                $spotContent->content = $content;
                                $spotContent->save();
                                $newKey = $key;
                                $linkCorrect = 'ok';
                                
                                $content = $this->renderPartial('//widget/spot/personal/new_content', array(
                                        'content' => $content['data'][$key],
                                        'key' => $key,
                                            ), true);
                            }
                            else
                                $linkCorrect = $userDetail['error'];
                        }
                        else
                        {
                            if (!empty($data['bindNet']['link']))
                                $linkCorrect = $socInfo->isLinkCorrect($data['bindNet']['link'], $discodes_id);
                            else 
                                $linkCorrect = 'ok';
                                
                            if ($linkCorrect == 'ok')
                            {
                                $content['keys'][$content['counter']] = 'socnet';
                                if (!empty($data['bindNet']['link']))
                                    $content['data'][$content['counter']] = $data['bindNet']['link'];
                                else
                                    $content['data'][$content['counter']] = Yii::app()->session[$netName . '_profile_url'];
                                $key = $content['counter'];
                                $content['counter'] = $content['counter'] + 1;
                                $spotContent->content = $content;
                                $spotContent->save();
                                $newKey = $key;
                                
                                $socContent = $socInfo->getNetData($content['data'][$key], $discodes_id, $key, true);
                                $content = $this->renderPartial('//widget/spot/personal/new_socnet', array(
                                        'content' => $content['data'][$key],
                                        'key' => $key,
                                        'socContent' => $socContent,
                                    ), true);
                            }
                        }
                    }
                }
            }
        }

        echo json_encode(
            array(
                'content' => $content,
                'linkCorrect' => $linkCorrect,
                'loggedIn' => $isSocLogged,
                'newField' => $newField,
                'key' => $newKey,
            )
        );
    }
    
    public function actionSocNetContent()
    {
        $data = $this->validateRequest();
        $answer = array();
        $answer['error'] = 'error in spot/SocNetContent';
    
        if (isset($data['discodes']) and isset($data['key']))
        {
            $spot = Spot::getSpot(array('discodes_id' => $data['discodes']));
            if ($spot)
            {

                $spotContent = SpotContent::getSpotContent($spot);
                if ($spotContent)
                {
                    if ($spotContent->content['keys'][$data['key']] == 'socnet')
                    {
                        $socInfo = new SocInfo;
                        $socContent = $socInfo->getNetData($spotContent->content['data'][$data['key']], $data['discodes'], $data['key'], true);
                        
                        $content = $this->renderPartial('//widget/spot/personal/new_socnet', array(
                            'content' => $spotContent->content['data'][$data['key']],
                            'key' => $data['key'],
                            'socContent' => $socContent,
                        ), true);
                        
                        $answer['content'] = $content;
                        $answer['key'] = $data['key'];
                        $answer['error'] = 'no';
                        if (isset($data['lastKey']))
                            $answer['lastKey'] = $data['lastKey'];
                    }
                }
            }
        }
        
        echo json_encode($answer);
    }
    
    //Отвязка соцсети
    public function actionUnBindSocial()
    {
        $data = $this->validateRequest();
        $answer = array();
        $answer['error'] = 'yes';
        $answer['content'] = '';

        if (isset($data['discodes']) and isset($data['key']))
        {

            $spot = Spot::getSpot(array('discodes_id' => $data['discodes']));
            if ($spot)
            {

                $spotContent = SpotContent::getSpotContent($spot);
                if ($spotContent)
                {

                    $content = $spotContent->content;
                    if ($content['keys'][$data['key']] == 'socnet')
                    {
                        $content['keys'][$data['key']] = 'text';
                        $spotContent->content = $content;

                        if ($spotContent->save())
                        {
                            $answer['content'] = $this->renderPartial('//widget/spot/personal/new_text', array(
                                'content' => $content['data'][$data['key']],
                                'key' => $data['key'],
                                    ), true);
                            $answer['error'] = "no";
                        }
                    }
                    elseif ($content['keys'][$data['key']] == 'content')
                    {
                        $toDelete = array();
                        if(!empty($content['data'][$data['key']]['last_img']) && strpos($content['data'][$data['key']]['last_img'], '/uploads/spot/') === 0)
                            $toDelete[] = $content['data'][$data['key']]['last_img'];
                        if(!empty($content['data'][$data['key']]['photo']) && strpos($content['data'][$data['key']]['photo'], '/uploads/spot/') === 0)
                            $toDelete[] = $content['data'][$data['key']]['photo'];
                        $content['keys'][$data['key']] = 'text';
                        $content['data'][$data['key']] = $content['data'][$data['key']]['binded_link'];
                        $spotContent->content = $content;

                        if ($spotContent->save())
                        {
                            foreach($toDelete as $path)
                            {
                                $path = substr($path, (strpos($path, '/uploads/spot/') + 14));
                                $path = Yii::getPathOfAlias('webroot.uploads.spot.') . '/' . $path;
                                if (file_exists($path))
                                    unlink($path);
                            }
                            $answer['content'] = $this->renderPartial('//widget/spot/personal/new_text', array(
                                'content' => $content['data'][$data['key']],
                                'key' => $data['key'],
                                    ), true);
                            $answer['error'] = "no";
                        }
                    }
                }
            }
        }
        echo json_encode($answer);
    }
    
    public function actionSocPatterns()
    {
        $data = $this->validateRequest();
        
        $socInfo = new SocInfo;
        $answer['socPatterns'] = $socInfo->getSocPatterns();
        
        echo json_encode($answer);
    }

    // Добавление нового спота
    public function actionAddSpot()
    {
        $data = $this->validateRequest();
        $answer = array();
        $answer['error'] = 'yes';
        $answer['content'] = '';

        if (isset($data['code']))
        {

            $spot = Spot::model()->findByAttributes(array('code' => $data['code']));
            if ($spot)
            {
                $spot->status = Spot::STATUS_REGISTERED;
                $spot->lang = $this->getLang();
                $spot->user_id = Yii::app()->user->id;

                if (isset($data['name']))
                {
                    $spot->name = $data['name'];
                }
                $spot->spot_type_id = Spot::TYPE_PERSONAL;

                if ($spot->save())
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
                        $wallet->user_id = $spot->user_id;
                        $wallet->save();

                    }

                    $answer['content'] = $this->renderPartial('//user/block/spots', array(
                        'data' => $spot,
                        ), true);
                    $answer['error'] = "no";
                }
            }
        }
        echo json_encode($answer);
    }

    // Удаление спота
    public function actionRemoveSpot()
    {
        $data = $this->validateRequest();
        $answer = array();
        $answer['error'] = 'yes';
        $answer['discodes'] = '';

        if (isset($data['discodes']))
        {
            $spot = Spot::model()->findByPk($data['discodes']);
            if ($spot)
            {
                $spot->status = Spot::STATUS_REMOVED_USER;
                if ($spot->save())
                {
                    $answer['discodes'] = $spot->discodes_id;
                    $answer['error'] = "no";
                }
            }
        }
        echo json_encode($answer);
    }

    // Очистка спота
    public function actionCleanSpot()
    {
        $data = $this->validateRequest();
        $answer = array();
        $answer['error'] = 'yes';

        if (isset($data['discodes']))
        {
            $spot = Spot::model()->findByPk($data['discodes']);
            if ($spot)
            {

                $spotContent = SpotContent::getSpotContent($spot);
                $spotContent = SpotContent::initPersonal($spot, $spotContent);

                if ($spotContent->save())
                {
                    $answer['error'] = "no";
                }
            }
        }
        echo json_encode($answer);
    }

    //Делаем спот невидимым
    public function actionInvisibleSpot()
    {
        $data = $this->validateRequest();
        $answer = array();
        $answer['error'] = 'yes';

        if (isset($data['discodes']))
        {
            $spot = Spot::model()->findByPk($data['discodes']);

            if ($spot)
            {
                if ($spot->status == Spot::STATUS_INVISIBLE)
                    $spot->status = Spot::STATUS_REGISTERED;
                else
                    $spot->status = Spot::STATUS_INVISIBLE;

                if ($spot->save())
                {
                    $answer['error'] = "no";
                }
            }
        }
        echo json_encode($answer);
    }

    //Переименовываем спот
    public function actionRenameSpot()
    {
        $data = $this->validateRequest();
        $answer = array();
        $answer['error'] = 'yes';
        $answer['name'] = '';

        if (isset($data['newName']) and isset($data['discodes']))
        {
            $spot = Spot::model()->findByPk($data['discodes']);
            if ($spot)
            {
                $spot->name = CHtml::encode($data['newName']);
                if ($spot->save(false))
                {
                    $answer['name'] = mb_substr($spot->name, 0, 45, 'utf-8');
                    $answer['error'] = "no";

                    $wallet = PaymentWallet::model()->findByAttributes(
                        array(
                            'discodes_id'=>$data['discodes']
                            )
                        );
                    if ($wallet) 
                    {
                        $wallet->name = $spot->name;
                        $wallet->save(false);
                    }
                }
            }
        }
        echo json_encode($answer);
    }

    //Сохраняем
    public function actionSaveOrder()
    {
        $data = $this->validateRequest();
        $answer = array();
        $answer['error'] = 'yes';

        if (isset($data['discodes']) and isset($data['keys']))
        {

            $spot = Spot::getSpot(array('discodes_id' => $data['discodes']));
            if ($spot)
            {

                $spotContent = SpotContent::getSpotContent($spot);
                if ($spotContent)
                {

                    $content = $spotContent->content;
                    $newkeys = array();
                    foreach ($data['keys'] as $key)
                    {
                        if (isset($content['keys'][$key]))
                        {
                            $newkeys[$key] = $content['keys'][$key];
                        }
                    }
                    $content['keys'] = $newkeys;
                    $spotContent->content = $content;

                    if ($spotContent->save())
                    {
                        $answer['error'] = "no";
                    }
                }
            }
        }
        echo json_encode($answer);
    }
}
