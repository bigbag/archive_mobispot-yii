<?php
/**
 * An example of extending the provider class.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://github.com/Nodge/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

require_once dirname(dirname(__FILE__)) . '/services/FacebookOAuthService.php';

class CustomFacebookOAuthService extends FacebookOAuthService
{
    protected function fetchAttributes()
    {
        $info = (object)$this->makeSignedRequest('https://graph.facebook.com/me');

        $this->attributes['id'] = $info->id;
        $this->attributes['name'] = $info->name;
        $this->attributes['url'] = $info->link;
        $this->attributes['email'] = $info->email;
    }

}