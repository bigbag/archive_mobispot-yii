<?php
class MailCommand extends CConsoleCommand
{
    public function SendMail($from, $to, $subject, $body, $attachFile = false)
    {
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        Yii::import('application.vendors.swift.swift_required', true);
        spl_autoload_register(array('YiiBase', 'autoload'));

        $message = Swift_Message::newInstance();
        $message->setSubject($subject);
        $message->setBody($body, 'text/html', 'utf-8');
        $message->setFrom($from);
        $message->setTo($to);
        if ($attachFile) {
            if (count($attachFile) > 0) {
                foreach ($attachFile as $file) {
                    $file_name = Yii::getPathOfAlias('webroot.uploads.spot.') . '/' . $file;
                    $attachment = Swift_Attachment::fromPath($file_name);
                    $message->attach($attachment);
                }
            }
        }

       $transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 587, 'tls')
            ->setUsername('no-reply@mobispot.com')
            ->setPassword('!yvM83kd')
            ->setTimeout(60);
        $mailer = Swift_Mailer::newInstance($transport);
        $mailer->send($message);
    }

    public function actionIndex()
    {
        $conn = Yii::app()->db;
        $result = $conn->createCommand()
            ->select('*')
            ->from('mail_stack')
            ->where('`lock`!=:lock', array(':lock' => 1))
            ->limit(10)
            ->queryAll();

        foreach ($result as $row) {
            $conn->createCommand()->update('mail_stack', array('lock' => 1), 'id=:id', array(':id' => $row['id']));

            $attach = unserialize($row['attach']);
            if (count($attach) == 0) $attach = false;

            $test = $this->SendMail(unserialize($row['from']), unserialize($row['to']), $row['subject'], $row['body'], $attach);

            if ($test === NULL) {
                $conn->createCommand()->delete('mail_stack', 'id=:id', array(':id' => $row['id']));
            } else $conn->createCommand()->update('mail_stack', array('lock' => 0), 'id=:id', array(':id' => $row['id']));
        }
    }
}