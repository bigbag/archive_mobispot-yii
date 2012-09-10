<?php
Class MMail
{
    public function activation($email, $activkey)
    {
        $mail_template = MailTemplate::getTemplate('activation');
        $activation_url = Yii::app()->request->hostInfo . '/service/activation/activkey/' . $activkey . '/email/' . $email;

        $stack = new MailStack;
        $stack->from = serialize(array(Yii::app()->par->load('adminEmail') => Yii::app()->par->load('generalSender')));
        $stack->to = serialize(array($email));
        $stack->subject = $mail_template->subject;
        $stack->body = $stack->body = $this->renderPartial('/mail/' . $mail_template->lang_id . '_' . $mail_template->slug,
            array(
                'activation_url' => $activation_url,
            ),
            true);

        if ($stack->save()) return true;
        else return false;
    }

    public function recovery($email, $activkey)
    {
        $mail_template = MailTemplate::getTemplate('recovery');
        $activation_url = Yii::app()->request->hostInfo . '/service/recovery/activkey/' . $activkey . '/email/' . $email;

        $stack = new MailStack;
        $stack->from = serialize(array(Yii::app()->par->load('adminEmail') => Yii::app()->par->load('generalSender')));
        $stack->to = serialize(array($email));
        $stack->subject = $mail_template->subject;
        $stack->body = $stack->body = $this->renderPartial('/mail/' . $mail_template->lang_id . '_' . $mail_template->slug,
            array(
                'activation_url' => $activation_url,
            ),
            true);

        if ($stack->save()) return true;
        else return false;
    }

    public function spot_feedback($email, $data)
    {
        $mail_template = MailTemplate::getTemplate('spot_feedback');

        $stack = new MailStack;
        $stack->from = serialize(array(Yii::app()->par->load('adminEmail') => Yii::app()->par->load('generalSender')));
        $stack->to = serialize(array($email));
        $stack->subject = $mail_template->subject;
        $stack->body = $stack->body = $this->renderPartial('//mail/' . $mail_template->lang_id . '_' . $mail_template->slug,
            array(
                'spot_name' => (isset($data['spot_name'])) ? $data['name'] : '',
                'name' => (isset($data['name'])) ? $data['name'] : '',
                'email' => (isset($data['email'])) ? $data['email'] : '',
                'phone' => (isset($data['phone'])) ? $data['phone'] : '',
                'comment' => (isset($data['comment'])) ? $data['comment'] : '',
            ),
            true);

        if ($stack->save()) return true;
        else return false;
    }

    public function spot_send($email, $data)
    {
        $mail_template = MailTemplate::getTemplate('spot_send');

        $stack = new MailStack;
        $stack->from = serialize(array(Yii::app()->par->load('adminEmail') => Yii::app()->par->load('generalSender')));
        $stack->to = serialize(array($email));
        $stack->subject = $mail_template->subject;
        $stack->attach = serialize($data);
        $stack->body = $stack->body = $this->renderPartial('//mail/' . $mail_template->lang_id . '_' . $mail_template->slug,
            array(
            ),
            true);

        if ($stack->save()) return true;
        else return false;
    }


}