<?php

class FacebookContent extends SocContentBase
{

    public static function isLinkCorrect($link, $discodesId = null, $dataKey = null)
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

	public static function getContent($link, $discodesId = null, $dataKey = null)
    {
	    $socUsername = self::parseUsername($link);
        $socContent = array();
	
        $socUser = self::makeRequest('https://graph.facebook.com/'.$socUsername);

        if (!isset($socUser['error'])){
          $socContent['UserExists'] = true;
          //$socContent['soc_id'] = $socUser['id'];
          $socContent['photo'] = 'http://graph.facebook.com/'.$socUsername.'/picture';
          if(isset($socUser['name']))
            $socContent['soc_username'] = $socUser['name'];
          if(!empty($socUser['first_name']) && !empty($socUser['last_name']))
            $socContent['soc_username'] = $socUser['first_name'].' '.$socUser['last_name'];
          if(isset($socUser['soc_url']))
            $socContent['soc_url'] = $socUser['link'];
          if(isset($socUser['gender']))
            $socContent['gender'] = $socUser['gender'];
          if(isset($socUser['locale']))
            $socContent['locale'] = $socUser['locale'];
            
          //последний пост
          $appToken = Yii::app()->cache->get('facebookAppToken');
          $isAppTokenValid = false;

          if($appToken !== false){
            $validation = self::makeRequest('https://graph.facebook.com/debug_token?input_token='.$appToken.'&access_token='.$appToken, array(), false);
            $validation = CJSON::decode($validation, true);
            if(isset($validation['data']) and isset($validation['data']['is_valid']) and ($validation['data']['is_valid'] == 'true'))
              $isAppTokenValid = true;
          }

          if(!$isAppTokenValid){
            if (@fopen('https://graph.facebook.com/oauth/access_token?client_id='.Yii::app()->eauth->services['facebook']['client_id'].'&client_secret='.Yii::app()->eauth->services['facebook']['client_secret'].'&grant_type=client_credentials', 'r')){
              $textToken = fopen('https://graph.facebook.com/oauth/access_token?client_id='.Yii::app()->eauth->services['facebook']['client_id'].'&client_secret='.Yii::app()->eauth->services['facebook']['client_secret'].'&grant_type=client_credentials', 'r');
              $appToken = fgets($textToken);
              fclose($textToken);
              if((strpos($appToken, 'access_token=') > 0) || (strpos($appToken, 'access_token=') !== false))
                $appToken = substr($appToken, (strpos($appToken, 'access_token=')+13));
              Yii::app()->cache->set('facebookAppToken', $appToken);
                $isAppTokenValid = true;
            }
          }

          $userFeed = self::makeRequest('https://graph.facebook.com/'.$socUsername.'/feed?access_token='.$appToken);
          unset($lastPost);
          $i=0;
          $prevPageUrl= '';

          if(isset($socUser['id'])){
            while(!isset($lastPost)){
              
              if(isset($userFeed['data']) && isset($userFeed['data'][$i]) && isset($userFeed['data'][$i]['from']) && isset($userFeed['data'][$i]['from']['id']) && ($userFeed['data'][$i]['from']['id'] == $socUser['id']) && !isset($userFeed['data'][$i]['application'])){
                $lastPost = $userFeed['data'][$i];
              }
              //следующая страница
              elseif(!isset($userFeed['data']) || ($i >= count($userFeed['data'])) || (!isset($userFeed['data'][$i]))){
                if(isset($userFeed['paging']) && isset($userFeed['paging']['previous']) && ($userFeed['paging']['previous'] != $prevPageUrl)){
                  $prevPageUrl = $userFeed['paging']['previous'];
                  $userFeed = self::makeRequest($userFeed['paging']['previous'].'&access_token='.$appToken);
                  $i=0;
                }else{
                  $lastPost = 'no';
                }
              } else{
                $i++;
              }
            }

            if($lastPost != 'no'){
              if($lastPost['type'] == 'photo'){
                $socContent['last_img'] =  $lastPost['picture'];
                if(isset($lastPost['message']))
                  $socContent['last_img_msg'] =  $lastPost['message'];
                if(isset($lastPost['story']))
                  $socContent['last_img_story'] =  $lastPost['story'];
              }elseif(($lastPost['type'] == 'status') && isset($lastPost['place']) && isset($lastPost['place']['location']) && isset($lastPost['place']['location']['latitude'])){
                //"место" на карте
                if(isset($lastPost['message']))
                  $socContent['place_msg'] = $lastPost['message'];
                $socContent['place_lat'] = $lastPost['place']['location']['latitude'];
                $socContent['place_lng'] = $lastPost['place']['location']['longitude'];
                $socContent['place_name'] = $lastPost['place']['name'];
              }else{
                if(isset($lastPost['message']))
                  $socContent['last_status'] = $lastPost['message'];
                elseif(isset($lastPost['story']))
                  $socContent['last_status'] = $lastPost['story'];
              }
            }
          }
        }else{
          $socContent['soc_username'] = Yii::t('eauth', "Пользователя с таким именем не существует:").$socUsername;
        }

		return $socContent;
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