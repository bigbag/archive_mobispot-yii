<?php

class CrunchBaseContent extends SocContentBase
{

    public static function isLinkCorrect($link, $discodesId = null, $dataKey = null)
    {
        $result = 'ok';
        
        if (strpos($link, 'crunchbase.com/person/') !== false)
        {
            $person = substr($link, (strpos($link, 'crunchbase.com/person/') + strlen('crunchbase.com/person/')));
            $person = self::rmGetParam($person);
            
            $socUser = self::makeRequest('http://api.crunchbase.com/v/1/person/' . $person . '.js?api_key=' . Yii::app()->eauth->services['crunchbase']['key']);
        }
        elseif (strpos($link, 'crunchbase.com/company/') !== false)
        {
            $company = substr($link, (strpos($link, 'crunchbase.com/company/') + strlen('crunchbase.com/company/')));
            $company = self::rmGetParam($company);
            $socUser = self::makeRequest('http://api.crunchbase.com/v/1/company/' . $company . '.js?api_key=' . Yii::app()->eauth->services['crunchbase']['key']);
        }
        elseif (strpos($link, 'crunchbase.com/product/') !== false)
        {
            $product = substr($link, (strpos($link, 'crunchbase.com/product/') + strlen('crunchbase.com/product/')));
            $product = self::rmGetParam($product);
            $socUser = self::makeRequest('http://api.crunchbase.com/v/1/product/' . $product . '.js?api_key=' . Yii::app()->eauth->services['crunchbase']['key']);
        }
        else
        {
            $result = Yii::t('eauth', "This post doesn't exist:") . $link;
        }
        if (isset($socUser) && is_string($socUser) && (strpos($socUser, 'error:') !== false))
            $result = Yii::t('eauth', "This post doesn't exist:") . $link;
            
        return $result;
    }

    public static function getContent($link, $discodesId = null, $dataKey = null)
    {
        $userDetail = array();
        
        if (strpos($link, 'crunchbase.com/person/') !== false)
        {
            //person
            $person = substr($link, (strpos($link, 'crunchbase.com/person/') + strlen('crunchbase.com/person/')));
            $person = self::rmGetParam($person);
            
            $socUser = self::makeRequest('http://api.crunchbase.com/v/1/person/' . $person . '.js?api_key=' . Yii::app()->eauth->services['crunchbase']['key']);

            if (!empty($socUser['crunchbase_url']))
                $userDetail['soc_url'] = $socUser['crunchbase_url'];

            if (!empty($socUser['first_name']))
            {
                $userDetail['soc_username'] = $socUser['first_name'];
                if (!empty($socUser['last_name']))
                    $userDetail['soc_username'] .= $socUser['last_name'];
            }
            elseif (!empty($socUser['last_name']))
                $userDetail['soc_username'] = $socUser['last_name'];

            if(!empty($socUser['image']) && !empty($socUser['image']['available_sizes']))
            {
                if (!empty($socUser['image']['available_sizes'][0][1]) && !empty($socUser['image']['available_sizes'][0][0]) && !empty($socUser['image']['available_sizes'][0][0][0]) && !empty($socUser['image']['available_sizes'][0][0][1]))
                {
                    $size = $socUser['image']['available_sizes'][0][0][0] * $socUser['image']['available_sizes'][0][0][1];
                    $userDetail['photo'] = 'http://s3.amazonaws.com/crunchbase_prod_assets/' . $socUser['image']['available_sizes'][0][1];
                }
            }

            if (!empty($socUser['overview']))
                $userDetail['last_status'] = strip_tags($socUser['overview']);
            
            //links
            if (!empty($socUser['web_presences']) && !empty($socUser['web_presences'][0]) && is_array($socUser['web_presences']))
            {
                $userDetail['list'] = array();
                $userDetail['list']['values'] = array();
                foreach ($socUser['web_presences'] as $link)
                {
                    $value = array();
                    if (!empty($link['external_url']))
                        $value['href'] = $link['external_url'];
                    if (!empty($link['title']))
                    {
                        $value['title'] = $link['title'];
                        $userDetail['list']['values'][] = $value;
                    }
                }
                if(count($userDetail['list']['values']) == 0)
                    unset($userDetail['list']);
            }
        }
        elseif (strpos($link, 'crunchbase.com/company/') !== false)
        {
            //company
            $company = substr($link, (strpos($link, 'crunchbase.com/company/') + strlen('crunchbase.com/company/')));
            $company = self::rmGetParam($company);
            $socUser = self::makeRequest('http://api.crunchbase.com/v/1/company/' . $company . '.js?api_key=' . Yii::app()->eauth->services['crunchbase']['key']);
            
            if (!empty($socUser['crunchbase_url']))
                $userDetail['soc_url'] = $socUser['crunchbase_url'];
            if (!empty($socUser['name']))
                $userDetail['soc_username'] = $socUser['name'];
                
            if(!empty($socUser['image']) && !empty($socUser['image']['available_sizes']))
            {
                if (!empty($socUser['image']['available_sizes'][0][1]) && !empty($socUser['image']['available_sizes'][0][0]) && !empty($socUser['image']['available_sizes'][0][0][0]) && !empty($socUser['image']['available_sizes'][0][0][1]))
                {
                    $size = $socUser['image']['available_sizes'][0][0][0] * $socUser['image']['available_sizes'][0][0][1];
                    $userDetail['photo'] = 'http://s3.amazonaws.com/crunchbase_prod_assets/' . $socUser['image']['available_sizes'][0][1];
                }
            }
            if (!empty($socUser['overview']))
                $userDetail['last_status'] = strip_tags($socUser['overview']);
            
            if (!empty($socUser['products']) && !empty($socUser['products'][0]) && is_array($socUser['products']))
            {
                $userDetail['list'] = array();
                $userDetail['list']['title'] = 'Products:';
                $userDetail['list']['values'] = array();
                foreach ($socUser['products'] as $link)
                {
                    $value = array();
                    if (!empty($link['permalink']))
                        $value['href'] = 'http://www.crunchbase.com/product/' . $link['permalink'];
                    if (!empty($link['name']))
                    {
                        $value['title'] = $link['name'];
                        $userDetail['list']['values'][] = $value;
                    }
                }
                if(count($userDetail['list']['values']) == 0)
                    unset($userDetail['list']);
            }
            
            if (!empty($socUser['relationships']) && !empty($socUser['relationships'][0]) && is_array($socUser['relationships']))
            {
                $userDetail['list2'] = array();
                $userDetail['list2']['title'] = 'People:';
                $userDetail['list2']['values'] = array();
                foreach ($socUser['relationships'] as $link)
                {
                    if (!(isset($link['is_past']) && ($link['is_past'] == 1)))
                    {
                        $value = array();
                        if (isset($link['person']) && !empty($link['person']['permalink']))
                            $value['href'] = 'http://www.crunchbase.com/person/' . $link['person']['permalink'];
                        if (!empty($link['title']))
                            $value['comment'] = $link['title'];
                        if (!empty($link['person']['first_name']) || !empty($link['person']['last_name']))
                        {
                            if (!empty($link['person']['first_name']))
                            {
                                $value['title'] = $link['person']['first_name'];
                                if (!empty($link['person']['last_name']))
                                    $value['title'] .= $link['person']['last_name'];
                            }
                            else
                                $value['title'] = $link['person']['last_name'];
                            
                            $userDetail['list2']['values'][] = $value;
                        }
                    }
                }
                if(count($userDetail['list2']['values']) == 0)
                    unset($userDetail['list2']);
            }
        }
        elseif (strpos($link, 'crunchbase.com/product/') !== false)
        {
            //product
            $product = substr($link, (strpos($link, 'crunchbase.com/product/') + strlen('crunchbase.com/product/')));
            $product = self::rmGetParam($product);
            $socUser = self::makeRequest('http://api.crunchbase.com/v/1/product/' . $product . '.js?api_key=' . Yii::app()->eauth->services['crunchbase']['key']);

            if (!empty($socUser['crunchbase_url']))
                $userDetail['soc_url'] = $socUser['crunchbase_url'];
            if (!empty($socUser['name']))
                $userDetail['soc_username'] = $socUser['name'];
            if (!empty($socUser['overview']))
                $userDetail['last_status'] = strip_tags($socUser['overview']);
                
            if(!empty($socUser['image']) && !empty($socUser['image']['available_sizes']))
            {
                if (!empty($socUser['image']['available_sizes'][0][1]) && !empty($socUser['image']['available_sizes'][0][0]) && !empty($socUser['image']['available_sizes'][0][0][0]) && !empty($socUser['image']['available_sizes'][0][0][1]))
                {
                    $size = $socUser['image']['available_sizes'][0][0][0] * $socUser['image']['available_sizes'][0][0][1];
                    $userDetail['photo'] = 'http://s3.amazonaws.com/crunchbase_prod_assets/' . $socUser['image']['available_sizes'][0][1];
                }
            }
            elseif(!empty($socUser['company']['image']) && !empty($socUser['company']['image']['available_sizes']))
            {
                if (!empty($socUser['company']['image']['available_sizes'][0][1]) && !empty($socUser['company']['image']['available_sizes'][0][0]) && !empty($socUser['company']['image']['available_sizes'][0][0][0]) && !empty($socUser['company']['image']['available_sizes'][0][0][1]))
                {
                    $size = $socUser['company']['image']['available_sizes'][0][0][0] * $socUser['company']['image']['available_sizes'][0][0][1];
                    $userDetail['photo'] = 'http://s3.amazonaws.com/crunchbase_prod_assets/' . $socUser['company']['image']['available_sizes'][0][1];
                }
            }
            
            if (!empty($socUser['external_links']) && !empty($socUser['external_links'][0]) && is_array($socUser['external_links']))
            {
                $userDetail['list'] = array();
                $userDetail['list']['title'] = 'External Links:';
                $userDetail['list']['values'] = array();
                foreach ($socUser['external_links'] as $link)
                {
                    $value = array();
                    if (!empty($link['external_url']))
                        $value['href'] = $link['external_url'];
                    if (!empty($link['title']))
                    {
                        $value['title'] = $link['title'];
                        $userDetail['list']['values'][] = $value;
                    }
                }
                if(count($userDetail['list']['values']) == 0)
                    unset($userDetail['list']);
            }
        }
        else
            $userDetail['error'] = Yii::t('eauth', "This post doesn't exist:") . $link;

        return $userDetail;
    }

}