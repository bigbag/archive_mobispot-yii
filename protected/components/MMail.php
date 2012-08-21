<?php
Class MMail
{
    public function activation($email, $activkey)
    {
        $activation_url = Yii::app()->request->hostInfo . '/user/activation/activkey/' . $activkey . '/email/' . $email;
        $subject = Yii::t('mail','Вы зарегистрировались на сайте ') . Yii::app()->par->load('siteTitle');
        $message = Yii::t('mail','Для активации вашей учётной записи вам необходимо перейти по ссылке<br/> ') . $activation_url;

        $stack = new MailStack;
        $stack->from = serialize(array(Yii::app()->par->load('adminEmail') => Yii::app()->par->load('generalSender')));
        $stack->to = serialize(array($email));
        $stack->subject = $subject;
        $stack->body = $this->renderPartial('/mail/info',
            array(
                'title' => $subject,
                'message' => $message,
            ),
            true);

        if ($stack->save()) return true;
        else return false;
    }

    public function recovery($email, $activkey)
    {
        $activation_url = Yii::app()->request->hostInfo . '/user/activation/activkey/' . $activkey . '/email/' . $email;
        $subject = Yii::t('mail', 'Востановление пароля на сайте ') . Yii::app()->par->load('siteTitle');
        $message = Yii::t('mail', 'Для востановления пароля вам необходимо перейти по ссылке<br/> ') . $activation_url;

        $stack = new MailStack;
        $stack->from = serialize(array(Yii::app()->par->load('adminEmail') => Yii::app()->par->load('generalSender')));
        $stack->to = serialize(array($email));
        $stack->subject = $subject;
        $stack->body = $this->renderPartial('/mail/info',
            array(
                'title' => $subject,
                'message' => $message,
            ),
            true);

        if ($stack->save()) return true;
        else return false;
    }

}