<?php class Translation
{
  public function missing($messageEvent)
  {
    Yii::log(
      "'" . $messageEvent->message . "' => '',",
      'translation',
      $messageEvent->category . '.' . $messageEvent->language
    );
  }
  
}