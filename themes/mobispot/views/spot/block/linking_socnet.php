<div id="extraMediaForm" class="linking">
    <?php $socInfo = new SocInfo; ?>
    <a class="link<?php
        echo (SocInfo::nameInList('facebook', $spotNets))?
        ' binded':''
        ?>"
        title="Facebook"
        net="facebook"
        ng-click="$event.stopPropagation();toggleBinding('facebook', $event, '<?php echo $socInfo->getUnbindWarning('facebook'); ?>')"
        >
        <img width="36" src="/themes/mobispot/socialmediaicons/facebook.png">
    </a>
    <a class="link<?php
        echo (SocInfo::nameInList('vk', $spotNets))?
        ' binded':''
        ?>"
        title="VKontakte"
        net="vk"
        ng-click="$event.stopPropagation();toggleBinding('vk', $event, '<?php echo $socInfo->getUnbindWarning('vk'); ?>')"
        >
        <img width="36" src="/themes/mobispot/socialmediaicons/vk.png">
    </a>
    <a class="link<?php
        echo (SocInfo::nameInList('twitter', $spotNets))?
        ' binded':''
        ?>"
        title="Twitter"
        net="twitter"
        ng-click="$event.stopPropagation();toggleBinding('twitter', $event, '<?php echo $socInfo->getUnbindWarning('twitter'); ?>')"
        >
        <img width="36" src="/themes/mobispot/socialmediaicons/twitter.png">
    </a>
    <a class="link<?php
        echo (SocInfo::nameInList('instagram', $spotNets))?
        ' binded':''
        ?>"
        title="Instagram"
        net="instagram"
        ng-click="$event.stopPropagation();toggleBinding('instagram', $event, '<?php echo $socInfo->getUnbindWarning('instagram'); ?>')"
        >
        <img width="36" src="/themes/mobispot/socialmediaicons/instagram.png">
    </a>
    <a class="link<?php
        echo (SocInfo::nameInList('foursquare', $spotNets))?
        ' binded':''
        ?>"
        title="Foursquare"
        net="foursquare"
        ng-click="$event.stopPropagation();toggleBinding('foursquare', $event, '<?php echo $socInfo->getUnbindWarning('foursquare'); ?>')"
        >
        <img width="36" src="/themes/mobispot/socialmediaicons/foursquare.png">
    </a>
    <a class="link<?php
        echo (SocInfo::nameInList('google_oauth', $spotNets))?
        ' binded':''
        ?>"
        title="Google+"
        net="google_oauth"
        ng-click="$event.stopPropagation();toggleBinding('google_oauth', $event, '<?php echo $socInfo->getUnbindWarning('google_oauth'); ?>')"
        >
        <img width="36" src="/themes/mobispot/socialmediaicons/google.png">
    </a>
    <a class="link<?php
        echo (SocInfo::nameInList('YouTube', $spotNets))?
        ' binded':''
        ?>"
        title="YouTube"
        net="YouTube"
        ng-click="$event.stopPropagation();toggleBinding('YouTube', $event, '<?php echo $socInfo->getUnbindWarning('YouTube'); ?>')"
        >
        <img width="36" src="/themes/mobispot/socialmediaicons/youtube.png">
    </a>
    <a class="link<?php
        echo (SocInfo::nameInList('vimeo', $spotNets))?
        ' binded':''
        ?>"
        title="Vimeo"
        net="vimeo"
        ng-click="$event.stopPropagation();toggleBinding('vimeo', $event, '<?php echo $socInfo->getUnbindWarning('vimeo'); ?>')"
        >
        <img width="36" src="/themes/mobispot/socialmediaicons/vimeo.png">
    </a>
</div>