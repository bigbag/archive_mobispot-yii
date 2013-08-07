<?php

class SpotController extends MController
{

    const BAN_TIME = 5;

    public $layout = '//layouts/mobile';

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

    //Отоюражение спота на мобильном
    public function actionIndex()
    {
        if (Yii::app()->request->getQuery('url', 0))
        {
            $url = Yii::app()->request->getQuery('url', 0);
            $spot = Spot::model()->mobil()->findByAttributes(array('url' => $url));

            if (isset(Yii::app()->session['spot_view_ban']) && (Yii::app()->session['spot_view_ban'] > time()))
            {
                $this->redirect(array('error'));
            }
            elseif (!$spot)
            {
                $this->setBanned();
            }
            else
            {
                if (isset(Yii::app()->session['spot_view_error_count']))
                {
                    Yii::app()->session['spot_view_error_count'] = 0;
                    Yii::app()->session['spot_view_ban'] = 0;
                }

                $spotContent = SpotContent::getSpotContent($spot);

                if (!$spotContent) {
                    $this->setNotFound();
                }

                $content = $spotContent['content'];

                $dataKeys = array_keys($content['keys']);
                $fileKeys = array_keys($content['keys'], 'file');

                if (count($dataKeys) == 0)
                {
                    $this->setNotFound();
                }

                if ($content['private'] == 0)
                {
                    //только файлы
                    if (count($fileKeys) == count($dataKeys))
                    {
                        $this->render('/widget/spot/send', array('content' => $content));
                    }
                    else
                    {
                        $url = $this->urlActivate($content['data'][$dataKeys[0]]);
                        $urlVal = new CUrlValidator;

                        //одна ссылка
                        if ((count($content['data']) == 1) and ($content['keys'][$dataKeys[0]] == 'text') and ($urlVal->validateValue($url)))
                        {
                            $this->redirect($url);
                        }
                        //стандартное отображение
                        else
                        {
                            $size = count($content['keys']);
                            for ($i = 0; $i < $size; $i++)
                            {
                                if ($content['keys'][$dataKeys[$i]] == 'socnet')
                                {
                                    $link = $content['data'][$dataKeys[$i]];
                                    $socInfo = new SocInfo;
                                    $socData = $socInfo->getNetData($link);
                                    if (isset($socData['netName']))
                                    {
                                        if(empty($socData['soc_url']))
                                            $socData['soc_url'] = $link;
                                        $content['data'][$dataKeys[$i]] = $socData;
                                    }
                                }
                                elseif ($content['keys'][$dataKeys[$i]] == 'content')
                                {
                                    $socInfo = new SocInfo;
                                    $net = $socInfo->getNetByLink($content['data'][$dataKeys[$i]]['binded_link']);
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
                }
                else
                {
                    $baseUrl = $this->createAbsoluteUrl("");
                    if ((strpos($baseUrl, "http://") > 0) || (strpos($baseUrl, "http://") !== false))
                    {
                        $baseUrl = substr($baseUrl, (strpos($baseUrl, "http://") + 7));
                    }
                    if (strpos($baseUrl, "/") > 0)
                    {
                        $baseUrl = substr($baseUrl, 0, strpos($baseUrl, "/"));
                    }
                    $baseUrl = "http://" . $baseUrl;
                    $this->redirect($baseUrl);
                }
            }
        }
        else
        {
            $this->setNotFound();
        }
    }

    //Защита от перебора url
    public function setBanned()
    {
        if (!isset(Yii::app()->session['spot_view_error_count']))
        {
            Yii::app()->session['spot_view_error_count'] = 0;
        }
        Yii::app()->session['spot_view_error_count'] = Yii::app()->session['spot_view_error_count'] + 1;

        if (Yii::app()->session['spot_view_error_count'] >= 5)
        {
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
        if ($spot and $spot->spot_type->key == 'personal')
        {
            //$content=SpotModel::model()->findByAttributes(array('spot_id'=>$spot->discodes_id, 'spot_type_id'=>$spot->spot_type_id));
            $spotContent = SpotContent::getSpotContent($spot);
            $content = $spotContent['content'];
            if ($content and isset($content['razreshit-skachivat-vizitku_3'][0]))
            {

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
            }
            else
                $this->redirect('/');
        }
        else
            $this->redirect('/');
    }

    public function actionError()
    {
        if (isset(Yii::app()->session['spot_view_error']))
        {
            $form = new ErrorForm();
            if (isset($_POST['ErrorForm']))
            {
                $form->attributes = $_POST['ErrorForm'];
                if ($form->validate() and (!isset($_POST['email'][1])))
                {
                    unset(Yii::app()->session['spot_view_error']);
                    unset(Yii::app()->session['Yii_Captcha']);
                    $this->redirect('/');
                }
            }
            $this->render('error', array(
                'form' => $form,
            ));
        }
        else
            $this->redirect('http://mobispot.com');
    }

}
