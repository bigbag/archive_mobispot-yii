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
                $answer['content'] = $this->renderPartial('//widget/spot/' . $spot->spot_type->key, array(
                    'spot' => $spot,
                    'spotContent' => $spotContent,
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

                    $SocInfo = new SocInfo;
                    $socNet = $SocInfo->getNetByLink($spotContent->content['data'][$data['key']]);

                    if (!empty($socNet['name']))
                    {
                        $netName = $socNet['name'];
                        $content = $spotContent->content;

                        if ((isset(Yii::app()->session[$netName]) and (Yii::app()->session[$netName] == 'auth')) || (isset($socNet['needAuth']) and $socNet['needAuth'] === false))
                        {
                            $isSocLogged = true;
                            $needSave = $SocInfo->contentNeedSave($spotContent->content['data'][$data['key']]);

                            if ($needSave)
                            {
                                $userDetail = $SocInfo->getSocInfo($socNet, $spotContent->content['data'][$data['key']], $data['discodes'], $data['key']);
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
                                $linkCorrect = $SocInfo->isLinkCorrect($spotContent->content['data'][$data['key']], $data['discodes'], $data['key']);
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
                                        $content = $this->renderPartial('//widget/spot/personal/new_socnet', array(
                                            'content' => $content['data'][$data['key']],
                                            'key' => $data['key'],
                                                ), true);
                                }
                                unset(Yii::app()->session['bind_discodes']);
                                unset(Yii::app()->session['bind_key']);
                            }
                        }
                        else
                        {
                            Yii::app()->session['bind_discodes'] = $data['discodes'];
                            Yii::app()->session['bind_key'] = $data['key'];
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
