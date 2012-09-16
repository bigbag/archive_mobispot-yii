<?php
Class MMail
{
    public function activation($email, $activkey)
    {
        $mail_template = MailTemplate::getTemplate('activation', $lang);
        $activation_url = Yii::app()->request->hostInfo . '/service/activation/activkey/' . $activkey . '/email/' . $email;

        $stack = new MailStack;
        $stack->from = serialize(array(Yii::app()->par->load('adminEmail') => Yii::app()->par->load('generalSender')));
        $stack->to = serialize(array($email));
        $stack->subject = $mail_template->subject;
        $stack->body = $stack->body = $this->renderPartial('//mail/' . $lang . '_' . $mail_template->slug,
            array(
                'activation_url' => $activation_url,
            ),
            true);

        if ($stack->save()) return true;
        else return false;
    }

    public function recovery($email, $activkey, $lang)
    {
        $mail_template = MailTemplate::getTemplate('recovery', $lang);
        $activation_url = Yii::app()->request->hostInfo . '/service/recovery/activkey/' . $activkey . '/email/' . $email;

        $stack = new MailStack;
        $stack->from = serialize(array(Yii::app()->par->load('adminEmail') => Yii::app()->par->load('generalSender')));
        $stack->to = serialize(array($email));
        $stack->subject = $mail_template->subject;
        $stack->body = $stack->body = $this->renderPartial('//mail/' . $lang . '_' . $mail_template->slug,
            array(
                'activation_url' => $activation_url,
            ),
            true);

        if ($stack->save()) return true;
        else return false;
    }

    public function spot_feedback($email, $data, $lang)
    {
        $mail_template = MailTemplate::getTemplate('spot_feedback', $lang);

        $stack = new MailStack;
        $stack->from = serialize(array(Yii::app()->par->load('adminEmail') => Yii::app()->par->load('generalSender')));
        $stack->to = serialize(array($email));
        $stack->subject = $mail_template->subject;
        $stack->body = $stack->body = $this->renderPartial('//mail/' . $lang . '_' . $mail_template->slug,
            array(
                'spot_name' => (isset($data['spot_name'])) ? $data['spot_name'] : '',
                'name' => (isset($data['name'])) ? $data['name'] : '',
                'email' => (isset($data['email'])) ? $data['email'] : '',
                'phone' => (isset($data['phone'])) ? $data['phone'] : '',
                'comment' => (isset($data['comment'])) ? $data['comment'] : '',
            ),
            true);

        if ($stack->save()) return true;
        else return false;
    }

    public function spot_send($email, $data, $lang)
    {
        $mail_template = MailTemplate::getTemplate('spot_send', $lang);

        $stack = new MailStack;
        $stack->from = serialize(array(Yii::app()->par->load('adminEmail') => Yii::app()->par->load('generalSender')));
        $stack->to = serialize(array($email));
        $stack->subject = $mail_template->subject;
        $stack->attach = serialize($data['files']);
        $stack->body = $stack->body = $this->renderPartial('//mail/' . $lang . '_' . $mail_template->slug,
            array(
                'spot_name' => (isset($data['spot_name'])) ? $data['spot_name'] : '',
                'spot_id' => (isset($data['spot_id'])) ? $data['spot_id'] : '',
            ),
            true);

        if ($stack->save()) return true;
        else return false;
    }


}