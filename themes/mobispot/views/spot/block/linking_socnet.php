<div id="extraMediaForm" class="linking">
    <a class="link<?php
        echo (SocInfo::nameInList('facebook', $spotNets))?
        ' binded':''
        ?>"
        title="Facebook"
        net="facebook"
        ng-click="loginByService('facebook')"
        >
        <img width="36" src="/themes/mobispot/socialmediaicons/facebook.png">
    </a>
    <a class="link<?php
        echo (SocInfo::nameInList('vk', $spotNets))?
        ' binded':''
        ?>"
        title="VKontakte"
        net="vk"
        ng-click="loginByService('vk')"
        >
        <img width="36" src="/themes/mobispot/socialmediaicons/vk.png">
    </a>
    <a class="link<?php
        echo (SocInfo::nameInList('twitter', $spotNets))?
        ' binded':''
        ?>"
        title="Twitter"
        net="twitter"
        ng-click="loginByService('twitter')"
        >
        <img width="36" src="/themes/mobispot/socialmediaicons/twitter.png">
    </a>
    <a class="link<?php
        echo (SocInfo::nameInList('instagram', $spotNets))?
        ' binded':''
        ?>"
        title="Instagram"
        net="instagram"
        ng-click="loginByService('instagram')"
        >
        <img width="36" src="/themes/mobispot/socialmediaicons/instagram.png">
    </a>
    <a class="link<?php
        echo (SocInfo::nameInList('foursquare', $spotNets))?
        ' binded':''
        ?>"
        title="Foursquare"
        net="foursquare"
        ng-click="loginByService('foursquare')"
        >
        <img width="36" src="/themes/mobispot/socialmediaicons/foursquare.png">
    </a>
    <a class="link<?php
        echo (SocInfo::nameInList('google_oauth', $spotNets))?
        ' binded':''
        ?>"
        title="Google+"
        net="google_oauth"
        ng-click="loginByService('google_oauth')"
        >
        <img width="36" src="/themes/mobispot/socialmediaicons/google.png">
    </a>
    <a class="link<?php
        echo (SocInfo::nameInList('YouTube', $spotNets))?
        ' binded':''
        ?>"
        title="YouTube"
        net="YouTube"
        ng-click="loginByService('YouTube')"
        >
        <img width="36" src="/themes/mobispot/socialmediaicons/youtube.png">
    </a>
    <a class="link<?php
        echo (SocInfo::nameInList('vimeo', $spotNets))?
        ' binded':''
        ?>"
        title="Vimeo"
        net="vimeo"
        ng-click="loginByService('vimeo')"
        >
        <img width="36" src="/themes/mobispot/socialmediaicons/vimeo.png">
    </a>
</div>