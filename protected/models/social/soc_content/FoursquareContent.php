<?php

class FoursquareContent extends SocContentBase
{

    public static function isLinkCorrect($link, $discodesId = null, $dataKey = null)
    {
        $socUsername = self::parseUsername($link);
        $result = 'ok';
        $socId = $socUsername;

        if (!is_numeric($socId))
        {
            $profile = self::makeRequest('https://foursquare.com/' . $socId, array(), false);
            $match = array();
            preg_match('~user: {"id":"[0-9]+","firstName":~', $profile, $match);
            if (isset($match[0]) && (strpos($match[0], 'user: {"id":"') !== false))
            {
                $socId = str_replace('user: {"id":"', '', $match[0]);
                $socId = str_replace('","firstName":', '', $socId);
            }
        }

        $socUser = self::makeRequest('https://api.foursquare.com/v2/users/' . $socId . '?client_id=' . Yii::app()->eauth->services['foursquare']['client_id'] . '&client_secret=' . Yii::app()->eauth->services['foursquare']['client_secret'] . '&v=20130211');
        if (!is_array($socUser) || empty($socUser['response']) || empty($socUser['response']['user']))
            $result = Yii::t('eauth', "This account doesn't exist:") . $socUsername;

        return $result;
    }

    public static function parseUsername($link)
    {
        $username = $link;
        if (strpos($username, 'foursquare.com/user/') !== false)
        {
            $username = substr($username, (strpos($username, 'foursquare.com/user/') + 20));
        }
        if (strpos($username, 'foursquare.com') !== false)
        {
            $username = substr($username, (strpos($username, 'foursquare.com') + 15));
        }
        $username = self::rmGetParam($username);
        return $username;
    }

    public static function getContent($link, $discodesId = null, $dataKey = null)
    {
        $userDetail = array();
        $userDetail['block_type'] = self::TYPE_CHECKIN;
        $socUsername = self::parseUsername($link);

        if (!is_numeric($socUsername))
        {
            $profile = self::makeRequest('https://foursquare.com/' . $socUsername, array(), false);
            $match = array();
            preg_match('~user: {"id":"[0-9]+","firstName":~', $profile, $match);
            if (isset($match[0]) && (strpos($match[0], 'user: {"id":"') !== false))
            {
                $socUsername = str_replace('user: {"id":"', '', $match[0]);
                $socUsername = str_replace('","firstName":', '', $socUsername);
            }
        }
        /* search user by twitter nikname - user's authorization needed */
        /*
          $token = Yii::app()->user->token;
          $user = (array)self::makeRequest('https://api.foursquare.com/v2/users/search?twitter='.$socUsername.'&oauth_token='.$token.'&v=20130211', array(), true);
          $socUser = $user['response']['results']['0'];
          $socUsername = $socUser['id'];
         */

        $socUser = self::makeRequest('https://api.foursquare.com/v2/users/' . $socUsername . '?client_id=' . Yii::app()->eauth->services['foursquare']['client_id'] . '&client_secret=' . Yii::app()->eauth->services['foursquare']['client_secret'] . '&v=20130211');
        $socUser = $socUser['response']['user'];

        if (!empty($socUser['firstName']))
        {
            if (!empty($socUser['lastName']))
                $userDetail['soc_username'] = $socUser['firstName'] . ' ' . $socUser['lastName'];
            else
                $userDetail['soc_username'] = $socUser['firstName'];
        }
        else
            $userDetail['soc_username'] = $socUser['id'];
        if (isset($socUser['photo']) && !empty($socUser['photo']['prefix']) && isset($socUser['photo']['suffix']))
            $userDetail['photo'] = $socUser['photo']['prefix'] . '100x100' . $socUser['photo']['suffix'];


        //Последний чекин
        if (!empty($socUser['id']))
        {
            $user = User::model()->findByAttributes(array(
                'foursquare_id' => $socUser['id']
            ));

            if ($user && !empty($user->foursquare_token))
            {
                $checkins = self::makeRequest('https://api.foursquare.com/v2/users/' . $socUser['id'] . '/checkins?limit=250&sort=newestfirst&oauth_token=' . $user->foursquare_token . '&v=20130211');
                if (isset($checkins['response']) && isset($checkins['response']['checkins']) && isset($checkins['response']['checkins']['items']))
                {
                    unset($lastCheckin);
                    $i = 0;

                    while (!isset($lastCheckin))
                    {
                        if (isset($checkins['response']['checkins']['items'][$i]) && isset($checkins['response']['checkins']['items'][$i]['type']) && ($checkins['response']['checkins']['items'][$i]['type'] == 'checkin') && isset($checkins['response']['checkins']['items'][$i]['venue']) && isset($checkins['response']['checkins']['items'][$i]['venue']['name']) && !isset($checkins['response']['checkins']['items'][$i]['private']))
                        {
                            $lastCheckin = $checkins['response']['checkins']['items'][$i];
                        }
                        elseif (!isset($checkins['response']['checkins']['items'][$i]))
                        {
                            $lastCheckin = 'no';
                        }
                        else
                            $i++;
                    }

                    if ($lastCheckin != 'no')
                    {
                        $userDetail['venue_name'] = $lastCheckin['venue']['name'];
                        if (!empty($lastCheckin['shout']))
                            $userDetail['checkin_shout'] = $lastCheckin['shout'];
                        if (isset($lastCheckin['venue']['location']) && isset($lastCheckin['venue']['location']['address']))
                            $userDetail['venue_address'] = $lastCheckin['venue']['location']['address'];
                        if (isset($lastCheckin['createdAt']) && isset($lastCheckin['timeZoneOffset']))
                        {
                            $dateDiff = time() - $lastCheckin['createdAt'] + $lastCheckin['timeZoneOffset'];
                            $userDetail['sub-time'] = SocContentBase::timeDiff($dateDiff);
                            $userDetail['checkin_date'] = date('F j, Y', ($lastCheckin['createdAt'] + $lastCheckin['timeZoneOffset']));
                        }
                        if (isset($lastCheckin['photos']) && isset($lastCheckin['photos']['items']) && isset($lastCheckin['photos']['items'][0]) && isset($lastCheckin['photos']['items'][0]['prefix']) && isset($lastCheckin['photos']['items'][0]['suffix']) && isset($lastCheckin['photos']['items'][0]['width']) && isset($lastCheckin['photos']['items'][0]['height']))
                        {
                            $userDetail['checkin_photo'] = $lastCheckin['photos']['items'][0]['prefix'] . $lastCheckin['photos']['items'][0]['width'] . 'x' . $lastCheckin['photos']['items'][0]['height'] . $lastCheckin['photos']['items'][0]['suffix'];
                        }
                    }
                }
            }
        }
        //Последний бейдж
        $badges = self::makeRequest('https://api.foursquare.com/v2/users/' . $socUsername . '/badges?client_id=' . Yii::app()->eauth->services['foursquare']['client_id'] . '&client_secret=' . Yii::app()->eauth->services['foursquare']['client_secret'] . '&v=20130211');
        $last_badge = array();
        if (isset($badges['response']) && isset($badges['response']['badges']))
        {
            foreach ($badges['response']['badges'] as $badge)
            {
                if (isset($badge['unlocks']) && isset($badge['unlocks'][0]) && !isset($last_badge['id']))
                {
                    $last_badge['id'] = $badge['id'];
                    if (isset($badge['image']) && isset($badge['image']['prefix']) && isset($badge['image']['sizes']) && isset($badge['image']['sizes']['1']) && isset($badge['image']['name']))
                        $last_badge['image'] = $badge['image']['prefix'] . $badge['image']['sizes']['1'] . $badge['image']['name'];
                    if (!empty($badge['name']))
                        $last_badge['name'] = $badge['name'];
                    if (isset($badge['unlocks']) && isset($badge['unlocks'][0]) && isset($badge['unlocks'][0]['checkins']) && isset($badge['unlocks'][0]['checkins'][0]) && isset($badge['unlocks'][0]['checkins'][0]['createdAt']) && isset($badge['unlocks'][0]['checkins'][0]['timeZoneOffset']))
                    {
                        $last_badge['date'] = $badge['unlocks'][0]['checkins'][0]['createdAt'];
                        $last_badge['timeZoneOffset'] = $badge['unlocks'][0]['checkins'][0]['timeZoneOffset'];
                    }
                    if (!empty($badge['description']))
                        $last_badge['description'] = $badge['description'];
                    if (!empty($badge['badgeText']))
                        $last_badge['badgeText'] = $badge['badgeText'];
                    if (isset($badge['unlocks']) && isset($last_badge['date']))
                    {
                        foreach ($badge['unlocks'] as $unlock)
                        {
                            if (isset($unlock['checkins']))
                            {
                                foreach ($unlock['checkins'] as $checkin)
                                {
                                    if (isset($checkin['createdAt']) && isset($checkin['timeZoneOffset']) && ($checkin['createdAt'] > $last_badge['date']))
                                    {
                                        $last_badge['date'] = $checkin['createdAt'];
                                        $last_badge['timeZoneOffset'] = $checkin['timeZoneOffset'];
                                    }
                                }
                            }
                        }
                    }
                }
                else
                {
                    if (isset($badge['unlocks']))
                    {
                        foreach ($badge['unlocks'] as $unlock)
                        {
                            if (isset($unlock['checkins']))
                            {
                                foreach ($unlock['checkins'] as $checkin)
                                {
                                    if ($checkin['createdAt'] > $last_badge['date'])
                                    {
                                        $last_badge['id'] = $badge['id'];
                                        $last_badge['image'] = $badge['image']['prefix'] . $badge['image']['sizes']['1'] . $badge['image']['name'];
                                        $last_badge['name'] = $badge['name'];
                                        $last_badge['date'] = $checkin['createdAt'];
                                        $last_badge['timeZoneOffset'] = $checkin['timeZoneOffset'];
                                        $last_badge['description'] = $badge['description'];
                                        $last_badge['badgeText'] = $badge['badgeText'];
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        if (!empty($last_badge['id']) && !empty($last_badge['image']))
        {
            $userDetail['last_img'] = $last_badge['image'];
            $userDetail['last_img_href'] = 'https://foursquare.com/user/' . $socUsername . '/badge/' . $last_badge['id'];
            if (!empty($last_badge['name']))
            {
                $userDetail['last_img_msg'] = $last_badge['name'];
                if (!empty($last_badge['date']) && isset($last_badge['timeZoneOffset']))
                    $userDetail['last_img_msg'] .= '<br/>' . date('F j, Y', ($last_badge['date'] + $last_badge['timeZoneOffset']));
            }
            if (!empty($last_badge['description']))
                $userDetail['last_img_story'] = $last_badge['description'];
        }
        /*
          $userDetail['url'] = 'https://foursquare.com/user/'.$socUser['id'];
          if (!empty($socUser['gender']))
          $userDetail['gender'] = $socUser['gender'];
          if (!empty($socUser['homeCity']))
          $userDetail['location'] = $socUser['homeCity'];
          if (!empty($socUser['bio']))
          $userDetail['about'] = $socUser['bio'];
          $tips = self::makeRequest('https://api.foursquare.com/v2/lists/'.$socUsername.'/tips?client_id='.Yii::app()->eauth->services['foursquare']['client_id'].'&client_secret='.Yii::app()->eauth->services['foursquare']['client_secret'].'&v=20130211');
          if (!empty($tips['response']['list']['listItems']['items']['0']))
          $userDetail['last_tip'] = '"<a href="'.$tips['response']['list']['listItems']['items']['0']['venue']['canonicalUrl'].'">'.$tips['response']['list']['listItems']['items']['0']['venue']['name'].'</a> :'.$tips['response']['list']['listItems']['items']['0']['tip']['text'].'"';
         */

        return $userDetail;
    }

    public static function isLoggegByNet()
    {
        $answer = false;
        if (!empty(Yii::app()->session['foursquare_id']))
            $answer = true;

        return $answer;
    }

}
