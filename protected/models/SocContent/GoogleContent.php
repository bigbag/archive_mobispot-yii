<?php

class GoogleContent extends SocContentBase
{

    public static function isLinkCorrect($link, $discodesId = null, $dataKey = null)
	{
	  $socUsername = self::parseUsername($link);
	  $result = 'ok';
	  $ch = curl_init('https://www.googleapis.com/plus/v1/people/'.$socUsername.'?key='.Yii::app()->eauth->services['google_oauth']['key']);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	  curl_setopt($ch, CURLOPT_CAINFO, Yii::app()->eauth->services['ssl']['path']);

      $curl_result = curl_exec($ch);
      curl_close($ch);

      $socUser = CJSON::decode($curl_result, true);
	  if(empty($socUser['id']) || !empty($socUser['error']) || !empty($socUser['errors']))
	    $result = Yii::t('eauth', "Такого профиля не существует: $socUsername");
	  
      return $result;
    }

	public static function parseUsername($link){
	  $username = $link;
	  if(strpos($username, 'google.com') !== false){
        if (strpos($username, 'google.com/u/0/') !== false){
          $username = substr($username, (strpos($username, 'google.com/u/0/')+15));
        }
        if (strpos($username, 'google.com/') !== false){
          $username = substr($username, (strpos($username, 'google.com/')+11));
        }
		$username = self::rmGetParam($username);
      }
	  return $username;
	}
	
    
}