<?php

class Translation
{

    public static function missing($messageEvent)
    {
        Yii::log(
                "'" . $messageEvent->message . "' => '',", 'translation', $messageEvent->category . '.' . $messageEvent->language
        );
    }

}
