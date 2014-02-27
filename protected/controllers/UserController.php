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

            if (isset(Yii::app()->request->getParam('UserProfile')))
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

            $dataProvider = new CActiveDataProvider(
                    Spot::model()->personal()->used()->selectUser($user_id), array(
                'pagination' => array(
                    'pageSize' => 100,
                ),
                'sort' => array('defaultOrder' => 'registered_date asc'),
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

        if (!isset($service))
            $this->setNotFound();
        
        if (!Yii::app()->user->id)
            $this->setAccess();

        $tech = Yii::app()->request->getParam('tech');

        if (($service == 'instagram') && isset($tech) && ($tech == Yii::app()->eauth->services['instagram']['client_id']))
        {
            Yii::app()->session['instagram_tech'] = $tech;
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
                Yii::app()->session[$service . '_profile_url'] = $identity->getProfileUrl();
            }
            else
            {
                $authIdentity->cancel();
            }
        }
    }
}