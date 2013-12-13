<?php

class SiteController extends MController
{
    public $layout = '//corp/layouts/all';

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionRegister()
    {
        $this->render('register');
    }

    public function actionRegister1()
    {
        $id = Yii::app()->request->getQuery('id');

        if (!empty($id) and $id == 'start')
        {
            $this->render('register/stage1');
        }
        else if (isset($_POST['choice']))
        {
            $choice = $_POST['choice'];
            switch ($_POST['choice'])
            {
                case 'self':
                    $model = new RegisterSelfForm;
                    $this->registerBody($choice, $model);
                    break;
                case 'rent':
                    $model = new RegisterRentForm;
                    $this->registerBody($choice, $model);
                    break;
                case 'connection':
                    $model = new RegisterConnectionForm;
                    $this->registerBody($choice, $model);
                    break;
                default:
                    $this->render('register/stage1');
                    break;
            }
        }
        else
        {
            $this->render('register/index');
        }
    }

    public function registerBody($choice, $model)
    {
        $this->layout = '//layouts/empty';
        $model_name = get_class($model);

        $mail = new MailStack;

        if (isset($_POST[$model_name]))
        {
            if (!$this->blockIp('register', ip2long(CHttpRequest::getUserHostAddress())))
            {
                $model->attributes = $_POST[$model_name];
                if ($model->validate() and (empty($_POST[$model_name]['email2'])))
                {
                    $mail->to = serialize(RegisterForm::getDefaultEmail());
                    $mail->subject = RegisterForm::DEFAULT_TOPIC;
                    $mail->body = $this->renderPartial(
                            '//mail/site/register', array('model' => $model, 'choice' => $choice,), true
                    );
                }
                else
                {
                    Yii::app()->user->setFlash('error', 'Неверные данные');
                }
            }
            else
            {
                Yii::app()->user->setFlash('error', 'Превышено максимальное число попыток');
            }
        }

        if ($mail->save())
        {
            echo "true";
        }
        else
        {
            $this->renderPartial('register/stage2/' . $choice, array(
                'model' => $model,
                'choice' => $choice,
                    )
            );
        }
    }

    public function actionRegisterSuccess()
    {
        $this->layout = '//layouts/payment';
        $this->render('register/stage2/success', array()
        );
    }

    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error)
        {
            if (Yii::app()->request->isPostRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
}