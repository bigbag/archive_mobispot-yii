<?php

class MailCommand extends CConsoleCommand {

  const MAIL_COUNT = 100;

  public function SendMail($from, $to, $subject, $body, $attachFile = false) 
  {
    spl_autoload_unregister(array('YiiBase', 'autoload'));
    Yii::import('application.vendors.swift.swift_required', true);
    spl_autoload_register(array('YiiBase', 'autoload'));

    $message = Swift_Message::newInstance();
    $message -> setSubject($subject);
    $message -> setBody($body, 'text/html', 'utf-8');
    $message -> setFrom($from);
    $message -> setTo($to);
    if ($attachFile) {
      if (count($attachFile) > 0) 
      {
        foreach ($attachFile as $file) 
        {
          $file_name = Yii::getPathOfAlias('webroot.uploads.spot.') . '/' . $file;
          $attachment = Swift_Attachment::fromPath($file_name);
          $message->attach($attachment);
        }
      }
    }

    $transport = Swift_SendmailTransport::newInstance('/usr/sbin/exim -bs');
    $mailer = Swift_Mailer::newInstance($transport);
    $mailer->send($message);
  }

  public function actionIndex() {
    for ($i=0; $i < self::MAIL_COUNT; $i++) 
    {  
      $mail_stack = MailStack::model()->findByAttributes(
        array(
          'lock'=>0
          )
        );
      if (!$mail_stack)
        continue;
      
      $mail_stack->lock = 1;
      $mail_stack->save();

      $attach = unserialize($mail_stack->attach);
      if (count($attach) == 0)
      {
        $attach = false;
      }
        
      $test = $this->SendMail(
        unserialize($mail_stack->senders), 
        unserialize($mail_stack->recipients), 
        $mail_stack->subject, 
        $mail_stack->body, 
        $attach
      );

      if ($test === NULL)
      {
        $mail_stack->delete();
        continue;
      }

      $mail_stack->lock = 0;
      $mail_stack->save();
    }
  }
}