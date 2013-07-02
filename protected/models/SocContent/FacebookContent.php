<?php

class FacebookContent extends SocContentBase
{

    public static function isLinkCorrect($link)
    {
        $socUsername = self::parseUsername($link);
        $result = 'ok';
        $socUser = self::makeRequest('https://graph.facebook.com/'.$socUsername);
      
        if(!empty($socUser['error']) || empty($socUser['id']))
            $result = Yii::t('eauth', "Такого профиля не существует: $socUsername");
        elseif(empty($socUser['is_published']) || ($socUser['is_published'] != 'true')){
            if(empty(Yii::app()->session['facebook_id'])){
                $result = Yii::t('eauth', "Для этого действия требуется авторизация через Facebook!");
            }
            elseif(Yii::app()->session['facebook_id'] != $socUser['id'] ){
                $result = Yii::t('eauth', "Вы не можете привязать чужкю личную страницу Facebook!");
            }
        }
      
        return $result;
    }

    public static function parseUsername($link){
        $username = $link;
            if(strpos($username, 'facebook.com/') !== false){
                $username = substr($username, (strpos($username, 'facebook.com/')+13) );
                $username = self::rmGetParam($username);
            }
        return $username;
    }
}