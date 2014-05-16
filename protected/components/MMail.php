<?php

Class MMail
{

    public function render($template, array $data = array())
    {
        $path = Yii::getPathOfAlias('webroot.themes.mobispot.views.mail') . '/' . $template . '.php';
        if (!file_exists($path))
            throw new Exception('Template ' . $path . ' does not exist.');
        return $this->renderFile($path, $data, true);
    }

    public function activation($email, $activkey, $lang)
    {
        $mail_template = MailTemplate::getTemplate('activation', $lang);
        $activation_url = Yii::app()->par->load('siteUrl') . '/service/activation/activkey/' . $activkey . '/email/' . $email;

        $stack = new MailStack;
        $stack->senders = serialize(array(Yii::app()->par->load('adminEmail') => Yii::app()->par->load('generalSender')));
        $stack->recipients = serialize(array($email));
        $stack->subject = $mail_template->subject;
        $stack->body = MMail::render($lang . '_' . $mail_template->slug, array(
                    'activation_url' => $activation_url,
                        ), true);

        if ($stack->save())
            return true;
        else
            return false;
    }

    public function recovery($email, $activkey, $lang)
    {
        $mail_template = MailTemplate::getTemplate('recovery', $lang);
        $activation_url = Yii::app()->par->load('siteUrl') . '/service/change/activkey/' . $activkey . '/email/' . $email;

        $stack = new MailStack;
        $stack->senders = serialize(array(Yii::app()->par->load('adminEmail') => Yii::app()->par->load('generalSender')));
        $stack->recipients = serialize(array($email));
        $stack->subject = $mail_template->subject;
        $stack->body = MMail::render($lang . '_' . $mail_template->slug, array(
                    'activation_url' => $activation_url,
                        ), true);

        if ($stack->save())
            return true;
        else
            return false;
    }

    public function spot_feedback($email, $data, $lang)
    {
        $mail_template = MailTemplate::getTemplate('spot_feedback', $lang);

        $stack = new MailStack;
        $stack->senders = serialize(array(Yii::app()->par->load('adminEmail') => Yii::app()->par->load('generalSender')));
        $stack->recipients = serialize(array($email));
        $stack->subject = $mail_template->subject;
        $stack->body = MMail::render($lang . '_' . $mail_template->slug, array(
                    'spot_name' => (isset($data['spot_name'])) ? $data['spot_name'] : '',
                    'name' => (isset($data['name'])) ? $data['name'] : '',
                    'email' => (isset($data['email'])) ? $data['email'] : '',
                    'phone' => (isset($data['phone'])) ? $data['phone'] : '',
                    'comment' => (isset($data['comment'])) ? $data['comment'] : '',
                        ), true);

        if ($stack->save())
            return true;
        else
            return false;
    }

    public function spot_send($email, $data, $lang)
    {
        $mail_template = MailTemplate::getTemplate('spot_send', $lang);

        $stack = new MailStack;
        $stack->senders = serialize(array(Yii::app()->par->load('adminEmail') => Yii::app()->par->load('generalSender')));
        $stack->recipients = serialize(array($email));
        $stack->subject = $mail_template->subject;
        $stack->attach = serialize($data['files']);
        $stack->body = $stack->body = $this->renderPartial('//mail/' . $lang . '_' . $mail_template->slug, array(
            'spot_name' => (isset($data['spot_name'])) ? $data['spot_name'] : '',
            'spot_id' => (isset($data['spot_id'])) ? $data['spot_id'] : '',
                ), true);

        if ($stack->save())
            return true;
        else
            return false;
    }

    public function spot_comment($email, $data, $lang)
    {
        $mail_template = MailTemplate::getTemplate('spot_comment', $lang);

        $stack = new MailStack;
        $stack->senders = serialize(array(Yii::app()->par->load('adminEmail') => Yii::app()->par->load('generalSender')));
        $stack->recipients = serialize(array($email));
        $stack->subject = $mail_template->subject;
        $stack->body = MMail::render($lang . '_' . $mail_template->slug, array(
                    'comment_user_id' => (!empty($data->comment_user_id)) ? $data->comment_user_id : '',
                    'comment' => $data->body,
                    'spot_id' => $data->spot_id,
                        ), true);

        if ($stack->save())
            return true;
        else
            return false;
    }

    public function question($email, $data, $lang)
    {
        $mail_template = MailTemplate::getTemplate('faq_question', $lang);

        $stack = new MailStack;
        $stack->senders = serialize(array(Yii::app()->par->load('adminEmail') => Yii::app()->par->load('generalSender')));
        $stack->recipients = serialize($email);
        $stack->subject = $mail_template->subject;
        $stack->body = MMail::render($lang . '_' . $mail_template->slug, array(
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => (isset($data['phone'])) ? $data['phone'] : false,
                    'question' => $data['question'],
                        ), true);

        if ($stack->save())
            return true;
        else
            return false;
    }

    public function order_track($email, $mailOrder, $lang)
    {
        $mail_template = MailTemplate::getTemplate('store_order', $lang);

        $stack = new MailStack;
        $stack->senders = serialize(array(Yii::app()->par->load('adminEmail') => Yii::app()->par->load('generalSender')));
        $stack->recipients = serialize(array($email));
        $stack->subject = $mail_template->subject;
        $stack->body = MMail::render($lang . '_' . $mail_template->slug, array('order' => $mailOrder), true);

        if ($stack->save())
            return true;
        else
            return false;
    }

    public function demokit_order($email, $mailOrder, $lang)
    {
        $mail_template = MailTemplate::getTemplate('demokit_order', $lang);

        $stack = new MailStack;
        $stack->senders = serialize(array(Yii::app()->par->load('adminEmail') => Yii::app()->par->load('generalSender')));
        $stack->recipients = serialize(array($email));
        $stack->subject = $mail_template->subject;
        $stack->body = MMail::render($lang . '_' . $mail_template->slug, array('order' => $mailOrder), true);

        if ($stack->save())
            return true;
        else
            return false;
    }
}
