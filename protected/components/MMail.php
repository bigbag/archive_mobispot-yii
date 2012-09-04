<?php
Class MMail
{
    public function activation($email, $activkey)
    {
        $mail_template = MailTemplate::getTemplate('activation');
        $activation_url = Yii::app()->request->hostInfo . '/service/activation/activkey/' . $activkey . '/email/' . $email;
        $body = $mail_template->content;

        $stack = new MailStack;
        $stack->from = serialize(array(Yii::app()->par->load('adminEmail') => Yii::app()->par->load('generalSender')));
        $stack->to = serialize(array($email));
        $stack->subject = $mail_template->subject;
        $stack->body = $body;

        if ($stack->save()) return true;
        else return false;
    }

    public function recovery($email, $activkey)
    {
        $mail_template = MailTemplate::getTemplate('recovery');
        $activation_url = Yii::app()->request->hostInfo . '/service/recovery/activkey/' . $activkey . '/email/' . $email;
        $body = $mail_template->content;

        $stack = new MailStack;
        $stack->from = serialize(array(Yii::app()->par->load('adminEmail') => Yii::app()->par->load('generalSender')));
        $stack->to = serialize(array($email));
        $stack->subject = $mail_template->subject;
        $stack->body = $body;

        if ($stack->save()) return true;
        else return false;
    }

}