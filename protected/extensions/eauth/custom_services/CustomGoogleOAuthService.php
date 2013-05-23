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
	protected $key = '';

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
         $this->attributes['gender'] = $info['gender'] == 'male' ? 'М' : 'Ж';

		if (!empty($info['picture']))
			$this->attributes['photo'] = $info['picture'];
		 
		$this->attributes['language'] = $info['locale'];
		
		$sinfo = new SocInfo;
		$FreeUserDetail = array();	
		$FreeUserDetail = $sinfo->GetSocInfo('Google', $info['id']);
		if(isset($FreeUserDetail['UserExists']) && ($FreeUserDetail['UserExists'] === true)){
			if(isset($FreeUserDetail['work']))
				$this->attributes['work'] = $FreeUserDetail['work'];
			if(isset($FreeUserDetail['school']))
				$this->attributes['school'] = $FreeUserDetail['school'];
			if(isset($FreeUserDetail['first_name']))
				$this->attributes['first_name'] = $FreeUserDetail['first_name'];
			if(isset($FreeUserDetail['last_name']))
				$this->attributes['last_name'] = $FreeUserDetail['last_name'];
			if(isset($FreeUserDetail['aboutMe']))
				$this->attributes['about'] = $FreeUserDetail['aboutMe'];
			if(isset($FreeUserDetail['location']))
				$this->attributes['location'] = $FreeUserDetail['location'];
				
				
		}
//$this->attributes['info'] = $info;
		
/*
     $info['given_name']; // first name
     $info['family_name']; // last name
     $info['birthday']; // format: 0000-00-00
     $info['locale']; // format: en*/
    }
}