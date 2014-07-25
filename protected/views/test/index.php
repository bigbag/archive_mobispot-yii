<hr/>

<h1>Debug:</h1>
<?php

if (!empty(Yii::app()->session['debug']))
{
	echo 'debug:'.Yii::app()->session['debug'].'<br/>';
	unset(Yii::app()->session['debug']);
}


echo '$_SERVER[SERVER_NAME] = '.$_SERVER['SERVER_NAME'].'<br/>';
echo '$_SERVER[HTTP_HOST] = ' . $_SERVER['HTTP_HOST'].'<br/>';

echo MHttp::desktopHost().'<br/>';

/*
$content = 'a:5:{s:7:"counter";i:17;s:7:"private";i:0;s:5:"vcard";i:0;s:4:"keys";a:4:{i:13;s:4:"text";i:14;s:4:"text";i:15;s:6:"socnet";i:16;s:6:"socnet";}s:4:"data";a:4:{i:13;s:1:"1";i:14;s:1:"1";i:15;s:22:"twitter.com/bigbag1983";i:16;s:42:"http://www.youtube.com/watch?v=rq2YUEFELLc";}}';


echo print_r(unserialize($content), true);

/*
 https://twitter.com/lebedevtema 

a:5:{s:7:"counter";i:304;s:7:"private";i:0;s:5:"vcard";i:0;s:4:"keys";a:61:{i:104;s:4:"text";i:2;s:4:"text";i:17;s:6:"socnet";i:81;s:4:"text";i:5;s:4:"text";i:6;s:4:"text";i:7;s:4:"text";i:8;s:4:"text";i:10;s:4:"text";i:12;s:4:"text";i:18;s:4:"text";i:19;s:4:"text";i:23;s:4:"text";i:24;s:7:"content";i:26;s:4:"text";i:33;s:6:"socnet";i:35;s:4:"text";i:60;s:6:"socnet";i:61;s:4:"text";i:62;s:4:"text";i:64;s:4:"text";i:76;s:4:"text";i:80;s:4:"text";i:88;s:4:"text";i:96;s:4:"text";i:97;s:4:"text";i:99;s:4:"text";i:100;s:4:"text";i:110;s:4:"text";i:114;s:4:"text";i:115;s:4:"text";i:128;s:4:"text";i:129;s:4:"text";i:133;s:4:"text";i:137;s:4:"text";i:138;s:4:"text";i:140;s:4:"text";i:147;s:4:"text";i:162;s:4:"text";i:163;s:4:"text";i:170;s:4:"text";i:172;s:4:"text";i:174;s:4:"text";i:175;s:4:"text";i:180;s:4:"text";i:181;s:4:"text";i:184;s:4:"text";i:195;s:4:"text";i:199;s:4:"text";i:214;s:6:"socnet";i:228;s:4:"text";i:262;s:3:"obj";i:263;s:3:"obj";i:264;s:3:"obj";i:267;s:4:"text";i:290;s:4:"text";i:291;s:4:"text";i:94;s:4:"text";i:296;s:7:"content";i:302;s:6:"socnet";i:303;s:4:"text";}s:4:"data";a:61:{i:2;s:31:"https://www.facebook.com/radaev";i:5;s:42:"http://www.youtube.com/watch?v=mghhLqu31cQ";i:6;s:56:"https://www.youtube.com/channel/UCR9FgAhHjmzywplw9nWp3hw";i:7;s:36:"https://plus.google.com/+GuyKawasaki";i:8;s:51:"https://plus.google.com/114626045399013550001/posts";i:10;s:32:"http://emilianrus.deviantart.com";i:12;s:30:"https://vimeo.com/user16398847";i:17;s:31:"https://twitter.com/lebedevtema";i:18;s:34:"http://instagram.com/yicheng1970/#";i:19;s:49:"http://www.linkedin.com/profile/view?id=230833151";i:23;s:46:"https://www.facebook.com/denis.amelin.35/about";i:24;a:7:{s:8:"last_img";s:146:"/uploads/spot/f333faa764779c4a874c5def609b4b03_https__scontent-b.xx.fbcdn.net_hphotos-frc3_t1.0-9_s720x720_1002821_373134726141747_830669622_n.jpg";s:12:"last_img_msg";s:110:"Мы знаем, что ты будешь делать 1 сентября.
http://runmoscow.com/ #werunmoscow";s:13:"last_img_href";s:106:"https://www.facebook.com/photo.php?fbid=373134726141747&set=a.207920069329881.42237.206345216154033&type=1";s:5:"photo";s:49:"http://graph.facebook.com/206345216154033/picture";s:12:"soc_username";s:19:"Nike Running Russia";s:7:"soc_url";s:114:"https://www.facebook.com/photo.php?fbid=373134726141747&set=a.207920069329881.42237.206345216154033&type=1&theater";s:11:"binded_link";s:114:"https://www.facebook.com/photo.php?fbid=373134726141747&set=a.207920069329881.42237.206345216154033&type=1&theater";}i:26;s:48:"http://www.crunchbase.com/person/mark-zuckerberg";i:33;s:32:"https://www.facebook.com/Dropbox";i:35;s:102:"https://www.facebook.com/photo.php?fbid=10151805889251756&set=a.314416211755.185135.19891061755&type=1";i:60;s:29:"https://www.facebook.com/ford";i:61;s:33:"https://www.facebook.com/ladygaga";i:62;s:18:"http://blog360.ru/";i:64;s:30:"http://www.museumsandstuff.org";i:76;s:32:"http://www.behance.net/herrstrom";i:80;s:29:"https://vimeo.com/user2956232";i:81;s:18:"vimeo.com/33382554";i:88;s:39:"https://ru.foursquare.com/user/58365941";i:94;s:42:"http://www.crunchbase.com/company/facebook";i:96;s:23:"http://vk.com/id8128950";i:97;s:39:"https://ru.foursquare.com/user/15356744";i:99;s:55:"https://plus.google.com/u/0/105054371588663458860/posts";i:100;s:28:"http://yuumei.deviantart.com";i:104;s:28:"http://instagram.com/dolboed";i:110;s:22:"http://vk.com/id270186";i:114;s:32:"http://emilianrus.deviantart.com";i:115;s:39:"https://ru.foursquare.com/user/58365941";i:128;s:28:"http://instagram.com/landik#";i:129;s:37:"http://ivanandreevich.deviantart.com/";i:133;s:49:"http://yuumei.deviantart.com/art/Leaden-398692880";i:137;s:54:"https://plus.google.com/+GuyKawasaki/posts/RYNJGz3fUZ5";i:138;s:54:"https://plus.google.com/+GuyKawasaki/posts/4Wy11wLwruB";i:140;s:67:"https://plus.google.com/u/0/105054371588663458860/posts/JNcENp28hyo";i:147;s:47:"http://blog360.ru/post/58374663473/phangan-view";i:162;s:55:"https://www.facebook.com/radaev/posts/10202000184674544";i:163;s:55:"https://www.facebook.com/radaev/posts/10202001166539090";i:170;s:102:"https://www.facebook.com/photo.php?fbid=10151937737935049&set=a.294205560048.184710.22166130048&type=1";i:172;s:40:"https://www.facebook.com/denis.amelin.35";i:174;s:32:"http://instagram.com/brand0nch1n";i:175;s:31:"http://instagram.com/emilianrus";i:180;s:29:"https://vimeo.com/user4908062";i:181;s:28:"https://vimeo.com/fpvnaround";i:184;s:106:"http://www.linkedin.com/pub/%D0%B4%D0%B5%D0%BD%D0%B8%D1%81-%D0%B0%D0%BC%D0%B5%D0%BB%D0%B8%D0%BD/65/37b/bbb";i:195;s:18:"http://blog360.ru/";i:199;s:42:"http://www.youtube.com/user/TheBadComedian";i:214;s:39:"https://ru.foursquare.com/user/58365941";i:228;s:36:"https://www.facebook.com/heyMobispot";i:262;s:48:"cb0d797476f8042e8885d623a3764439_transations.pdf";i:263;s:52:"71edf5767900dca4cdf8dc61e9bceb6b_distribute_setup.py";i:264;s:53:"114b2f03cc057d8289969bf5614e1430_DisplayDriverExt.dll";i:267;s:125:"https://www.facebook.com/photo.php?fbid=550594521727218&set=a.375701372549868.1073741826.100003300240179&type=1&stream_ref=10";i:290;s:36:"https://plus.google.com/+GuyKawasaki";i:291;s:69:"https://www.facebook.com/ibegtin/posts/10152043578548263?stream_ref=1";i:296;a:15:{s:10:"UserExists";s:1:"1";s:5:"photo";s:41:"http://graph.facebook.com/ibegtin/picture";s:12:"soc_username";s:11:"Begtin Ivan";s:7:"soc_url";s:69:"https://www.facebook.com/ibegtin/posts/10152043578548263?stream_ref=1";s:10:"follow_url";s:135:"https://www.facebook.com/dialog/friends/?id=625298262&app_id=205773976269406&redirect_uri=http%3A%2F%2Fm.mobispot.com%2F17e67165c871d1d";s:11:"shared_link";s:145:"http://www.plusworld.ru/daily/2gis-proanaliziroval-populyarnost-platejnih-sistem-v-rossii/?fb_action_ids=481545291972022&fb_action_types=og.likes";s:9:"link_name";s:104:"Visa и MasterCard — самые популярные платежные системы в России";s:12:"link_caption";s:16:"www.plusworld.ru";s:16:"link_description";s:534:"Компания 2ГИС выяснила, карты каких платежных систем чаще всего принимают в России. Для этого аналитики справочного сервиса изучили информацию о более чем 1,5 млн организаций из 220 городов России (в том числе о способах оплаты услуг, в частности, какими банковскими картами можно рассчитаться).";s:8:"sub-line";s:13:"shared a link";s:8:"last_img";s:224:"https://fbexternal-a.akamaihd.net/safe_image.php?d=AQDmqRKE8dnlMY66&w=154&h=154&url=http%3A%2F%2Fwww.plusworld.ru.images.1c-bitrix-cdn.ru%2Fupload%2Fmedialibrary%2F851%2F851cfac060fd49d2e8eafe5464d807a0.jpg%3F139814744954987";s:13:"last_img_href";s:145:"http://www.plusworld.ru/daily/2gis-proanaliziroval-populyarnost-platejnih-sistem-v-rossii/?fb_action_ids=481545291972022&fb_action_types=og.likes";s:12:"last_img_msg";s:363:"какое-то кривокосое исследование http://www.plusworld.ru/daily/2gis-proanaliziroval-populyarnost-platejnih-sistem-v-rossii/?fb_action_ids=481545291972022&fb_action_types=og.likes потому как УЭК принимают везде где есть эквайринг ПРО100 от Сбербанка а его немало так";s:11:"footer-line";s:13:" 18 hours ago";s:11:"binded_link";s:69:"https://www.facebook.com/ibegtin/posts/10152043578548263?stream_ref=1";}i:302;s:30:"https://twitter.com/bigbag1983";i:303;s:56:"https://twitter.com/bigbag1983/status/484052905989664768";}}


только в твоём споте http://m.mobispot.com/219435 ссылки не правильные получились, во всех остальных случаях все ссылки правльные, разбираюсь



/*
$spot = Spot::model()->findByPk(100240);
$spotContent = SpotContent::getSpotContent($spot);
echo print_r($spotContent->content, true);
/*
$link = '#test';

$liked = TwitterContent::checkHashtag($link);

//$liked = false;

if ($liked)
    echo '<h2>liked!</h2>';
else
    echo '<h2>not liked!</h2>';


//$link = 'http://mobispot.com/';
//$liked = FacebookContent::checkLinkSharing($link);]
/*
$liked = false;

if ($liked)
    echo '<h2>liked!</h2>';
else
    echo '<h2>not liked!</h2>';

if (!empty(Yii::app()->session['debug']))
{
	echo 'debug:'.Yii::app()->session['debug'].'<br/>';
	unset(Yii::app()->session['debug']);
}

/*

$order = DemoKitOrder::model()->findByPk(36);
//echo (float)(str_replace(',', '.', DemoKitOrder::getDollarRate())).'<br>*<br>';
echo DemoKitOrder::getDollarRate().'<br>*<br>';
echo $order->calcSumm().'<br>=<br>';
echo $order->getSummRub().'<br>';

$data = Array ('name' => 'testname', 'email' => 'testmail@test.ru', 'phone' => '12345', 'address' => 'Gdeto 3-13', 'city' => 'Minsk', 'zip' => '123456', 'country' => 'Belarus', 'shipping' => 2, 'payment' => 2, 'products' => Array('1' => 0, '2' => 1, '3' => 0 ) );

        $order = DemoKitOrder::fromArray($data);
        
        if(!$order->save())
        {
            $answer['message'] = '';
            $errors = $order->getErrors();
            foreach ($errors as $field=>$error)
                foreach ($error as $message)
                    $answer['message'] .= $message . ' ';
            $this->getJsonAndExit($answer);
        }
        
        if (!(DemoKitList::saveFromArray($data['products'], $order->id)))
        {
            $order->delete();
            $answer['message'] = Yii::t('store', 'Некорректные данные в заказанных спотах!');
            $this->getJsonAndExit($answer);
        }
        
        $answer['error'] = 'no';
        //$shipping = DemoKitOrder::getShipping($order->shipping);
        $payment = DemoKitOrder::getPayment($order->payment);
        
        if ($payment['action'] == DemoKitOrder::PAYMENT_BY_CARD or $payment['action'] == DemoKitOrder::PAYMENT_BY_YM)
        {
            $answer['content'] = $this->renderPartial('//store/_ym_form', 
                array(
                    'order'=>$order,
                    'action'=>$payment['action'],
                ), 
                true
            );
        }
        


/*
$main = simplexml_load_file("http://www.cbr.ru/scripts/XML_daily.asp?date_req=".date("d/m/Y"));
foreach($main as $key=>$v){
    if($v->Name == 'Доллар США')
    {
        echo $v->Name." ".$v->Value."<br>";
    }

}
//echo print_r(DemoKitOrder::getConfig(), true);
//echo Yii::app()->basePath.'<br/>'; 
//echo Yii::getPathOfAlias('webroot.uploads.spot.').'<br/>'; 





/*


$data = array(
                'discodes'=> 'dfag',
                'key' => $key = Yii::app()->request->getQuery('key'),
                'newField' => 'true',
                'link' => 'link_bla_bla',
            );
            
echo 'SocInfo::toGetParams:' . SocInfo::toGetParams($data, '&');




/*
?>
<hr>
<input type="checkbox" ng-model="confirmed" ng-change="importing()" id="ng-change-example1" />
<hr>
    <div class="content-row g-clearfix">
        <label for="ImportForm_file">Загрузить файл</label>

        <input id="ImportForm_file" type="file" name="ImportForm[file]" onchange="angular.element(this).scope().importing()"
            accept="application/excel, application/vnd.ms-excel, application/x-excel, application/x-msexcel">
    </div>

<hr>
<img width="50" height="50" src="http://graph.facebook.com/denis.amelin.35/picture"></img>
<hr/>
<br>
<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
<g:plusone size="standard" width="250px"></g:plusone>

<hr/>


$u = new Uniteller;

$u->shopId = '00001623';
$u->login = 813;
$u->pass = 'kl9Gu1PJyE0yKfNdhCOiTtQnBPFlNNnirGhaw1qY8cm4zVbZXKg79QAvUPnrZqydvcOBua6t1En1Fl3E';

$result = $u->getCheckData(15352);

echo print_r($result, true);
*/

?>
<!--
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=605375279481505&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<div class="fb-like" data-href="http://mobispot.com/" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
-->
