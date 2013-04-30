<?php
/**
 * An example of extending the provider class.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://github.com/Nodge/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

require_once dirname(dirname(__FILE__)) . '/services/GoogleOAuthService.php';

class CustomGoogleOAuthService extends GoogleOAuthService
{

    protected function fetchAttributes()
    {
        $info = (array)$this->makeSignedRequest('https://www.googleapis.com/oauth2/v1/userinfo');

        $this->attributes['id'] = $info['id'];
        $this->attributes['name'] = $info['name'];

        if (!empty($info['link']))
            $this->attributes['url'] = $info['link'];

        if (!empty($info['email']))
            $this->attributes['email'] = $info['email'];

        if (!empty($info['gender']))
         $this->attributes['gender'] = $info['gender'] == 'male' ? 'Ì' : 'Æ';

		if (!empty($info['picture']))
			$this->attributes['photo'] = $info['picture'];
		 
		$this->attributes['language'] = $info['locale'];
		
//$this->attributes['info'] = $info;
		
/*
     $info['given_name']; // first name
     $info['family_name']; // last name
     $info['birthday']; // format: 0000-00-00
     $info['locale']; // format: en*/
    }
}