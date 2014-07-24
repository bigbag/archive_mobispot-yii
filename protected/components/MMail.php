<?php

Class MMail
{

    public function render($template, array $data = array())
    {
        $path = Yii::getPathOfAlias(Yii::app()->params['mail_template']) . '/' . $template . '.php';

        if (!file_exists($path))
            throw new Exception('Template ' . $path . ' does not exist.');
        return $this->renderFile($path, $data, true);
    }

    public function saveMail($method, $lang, $senders, $recipients, $data)
    {
        $mail_template = MailTemplate::getTemplate($method, $lang);

        if (!is_array($senders))
            $senders = array($senders);

        if (!is_array($recipients))
            $senders = array($recipients);

        $stack = new MailStack;
        $stack->senders = json_encode($senders);
        $stack->recipients = json_encode($recipients);
        $stack->subject = $mail_template->subject;
        $stack->body = MMail::render($lang . '_' . $mail_template->slug, $data, true);

        if (!$stack->save())
            return false;
        return true;
    }

    public function activation($email, $activkey, $lang)
    {
        $activation_url = Yii::app()->request->getBaseUrl(true) . '/service/activation/activkey/' . $activkey . '/email/' . $email;

        return MMail::saveMail(
            'activation',
            $lang,
            array(Yii::app()->params['adminEmail'] => Yii::app()->params['generalSender']),
            $email,
            array('activation_url' => $activation_url)
        );
    }

    public function recovery($email, $activkey, $lang)
    {
        $activation_url = Yii::app()->request->getBaseUrl(true) . '/service/change/activkey/' . $activkey . '/email/' . $email;

        return MMail::saveMail(
            'recovery',
            $lang,
            array(Yii::app()->params['adminEmail'] => Yii::app()->params['generalSender']),
            $email,
            array('activation_url' => $activation_url)
        );
    }

    public function question($email, $data, $lang)
    {
        return MMail::saveMail(
            'faq_question',
            $lang,
            array(Yii::app()->params['adminEmail'] => Yii::app()->params['generalSender']),
            $email,
            array(
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => (isset($data['phone'])) ? $data['phone'] : false,
                'question' => $data['question'],
            )
        );
    }

    public function order_track($email, $mailOrder, $lang)
    {
        return MMail::saveMail(
            'store_order',
            $lang,
            array(Yii::app()->params['adminEmail'] => Yii::app()->params['generalSender']),
            $email,
            array('order' => $mailOrder)
        );
    }

    public function demokit_order($email, $mailOrder, $lang)
    {
        return MMail::saveMail(
            'demokit_order',
            $lang,
            array(Yii::app()->params['adminEmail'] => Yii::app()->params['generalSender']),
            $email,
            array('order' => $mailOrder)
        );
    }
}
