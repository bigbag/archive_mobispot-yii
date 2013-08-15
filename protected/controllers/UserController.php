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

            if (isset($_POST['UserProfile']))
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

            if (isset(Yii::app()->session['bind_discodes']) && isset(Yii::app()->session['bind_key']))
            {
                $defDiscodes = Yii::app()->session['bind_discodes'];
                $defKey = Yii::app()->session['bind_key'];
                $spot = Spot::getSpot(array('discodes_id' => Yii::app()->session['bind_discodes']));
                if ($spot)
                {
                    $spotContent = SpotContent::getSpotContent($spot);

                    if ($spotContent)
                    {
                        $socInfo = new SocInfo;
                        $socNet = $socInfo->getNetByLink($spotContent->content['data'][$defKey]);
                        
                        if (!empty($socNet['name']))
                        {
                            $netName = $socNet['name'];
                            $content = $spotContent->content;
                            
                            if (isset(Yii::app()->session[$netName]) && (Yii::app()->session[$netName] == 'auth'))
                            {
                                $needSave = $socInfo->contentNeedSave($spotContent->content['data'][$defKey]);
                                
                                if ($needSave)
                                {
                                    $userDetail = $socInfo->getSocInfo($socNet, $spotContent->content['data'][$defKey], $defDiscodes, $defKey);
                                    if (empty($userDetail['error']))
                                    {
                                        $userDetail['binded_link'] = $content['data'][$defKey];
                                        $content['keys'][$defKey] = 'content';
                                        $content['data'][$defKey] = $userDetail;
                                        $spotContent->content = $content;
                                        $spotContent->save();
                                        $linkCorrect = 'ok';
                                    }
                                    else
                                        $linkCorrect = $userDetail['error'];
                                }
                                else
                                {
                                    $linkCorrect = $socInfo->isLinkCorrect($spotContent->content['data'][$defKey], $defDiscodes, $defKey);
                                    
                                    if ($linkCorrect == 'ok')
                                    {
                                        $content['keys'][$defKey] = 'socnet';
                                        $spotContent->content = $content;
                                        $spotContent->save();
                                    }
                                }
                                if (isset($linkCorrect) && ($linkCorrect != 'ok'))
                                    $message = $linkCorrect;
                            }
                        }
                    }
                }
                unset(Yii::app()->session['bind_discodes']);
                unset(Yii::app()->session['bind_key']);
            }

            $dataProvider = new CActiveDataProvider(
                    Spot::model()->personal()->used()->selectUser($user_id), array(
                'pagination' => array(
                    'pageSize' => 100,
                ),
                'sort' => array('defaultOrder' => 'registered_date desc'),
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

        if (isset($service))
        {
            if (!Yii::app()->user->id)
            {
                $this->setAccess();
            }
            else
            {
                if (($service == 'instagram') && isset($_GET['tech']) && ($_GET['tech'] == Yii::app()->eauth->services['instagram']['client_id']))
                {
                    Yii::app()->session['instagram_tech'] = $_GET['tech'];
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
                        $authIdentity->redirect(array('user/personal'));
                    }
                    else
                    {
                        $authIdentity->cancel();
                    }
                }
            }
        }
        else
        {
            $this->setNotFound();
        }
    }

}