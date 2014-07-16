<article class="active spot-link">
    <div class="input-block">
        <textarea class="main-input" ng-model="spot.content" name=""></textarea>
        <p class="input-over" ng-hide="spot.content">
            <?php echo Yii::t('spot', 'Type the text or links'); ?>
        </p>
        <div class="soc-link">
            <p><?php echo Yii::t('spot', 'Adding files is not available in the mobile version'); ?><br>
                <a class="full-size" href="<?php echo MHttp::desktopHost()?>"><?php echo Yii::t('spot', 'Full size version'); ?></a>
            </p>
            <div class="linking">
                    <h4><?php echo Yii::t('spot', 'Social network connecting'); ?></h4>

            <a class="<?php
                echo (SocInfo::nameInList('facebook', $spotNets))?'link':''
                ?>"
                title="Facebook"
                ng-click="bindByPanel('facebook')"

            >
                <img width="36" src="<?php echo MHttp::desktopHost(); ?>/themes/mobispot/socialmediaicons/facebook.png">
            </a>
            <a class="<?php
                echo (SocInfo::nameInList('twitter', $spotNets))? 'link':''
                ?>"
                title="Twitter"
                ng-click="bindByPanel('twitter')"

            >
                <img width="36" src="<?php echo MHttp::desktopHost(); ?>/themes/mobispot/socialmediaicons/twitter.png">
            </a>
            <a class="<?php
                echo (SocInfo::nameInList('linkedin', $spotNets))? 'link':''
                ?>"
                title="LinkedIn"
                ng-click="bindByPanel('linkedin')"
                ><img width="36" src="<?php echo MHttp::desktopHost(); ?>/themes/mobispot/socialmediaicons/linkedin.png"> </a>
            <a class="<?php
                echo (SocInfo::nameInList('foursquare', $spotNets))?        'link':''
                ?>"
                title="Foursquare"
                ng-click="bindByPanel('foursquare')"
                ><img width="36" src="<?php echo MHttp::desktopHost(); ?>/themes/mobispot/socialmediaicons/foursquare.png"> </a>
            <a class="<?php
                echo (SocInfo::nameInList('google_oauth', $spotNets))?        'link':''
                ?>"
                title="Google+"
                ng-click="bindByPanel('google_oauth')"
                ><img width="36" src="<?php echo MHttp::desktopHost(); ?>/themes/mobispot/socialmediaicons/google.png"> </a>
            <a class="<?php
                echo (SocInfo::nameInList('YouTube', $spotNets))?        'link':''
                ?>"
                title="YouTube"
                ng-click="bindByPanel('YouTube')"
                ><img width="36" src="<?php echo MHttp::desktopHost(); ?>/themes/mobispot/socialmediaicons/youtube.png"> </a>
            <a class="<?php
                echo (SocInfo::nameInList('vimeo', $spotNets))?        'link':''
                ?>"
                title="Vimeo"
                ng-click="bindByPanel('vimeo')"
                ><img width="36" src="<?php echo MHttp::desktopHost(); ?>/themes/mobispot/socialmediaicons/vimeo.png"> </a>
            <a class="<?php
                echo (SocInfo::nameInList('vk', $spotNets))?        'link':''
                ?>"
                title="VKontakte"
                ng-click="bindByPanel('vk')"
                ><img width="36" src="<?php echo MHttp::desktopHost(); ?>/themes/mobispot/socialmediaicons/vk.png"> </a>
            <a class="<?php
                echo (SocInfo::nameInList('Behance', $spotNets))?        'link':''
                ?>"
                title="Behance"
                ng-click="bindByPanel('Behance')"
                ><img width="36" src="<?php echo MHttp::desktopHost(); ?>/themes/mobispot/socialmediaicons/behance.png"> </a>
            <a class="<?php
                echo (SocInfo::nameInList('deviantart', $spotNets))?        'link':''
                ?>"
                title="DeviantART"
                ng-click="bindByPanel('deviantart')"
                ><img width="36" src="<?php echo MHttp::desktopHost(); ?>/themes/mobispot/socialmediaicons/deviantart.png"> </a>
            <a class="<?php
                echo (SocInfo::nameInList('instagram', $spotNets))?        'link':''
                ?>"
                title="Instagram"
                ng-click="bindByPanel('instagram_mobile')"
                ><img width="36" src="<?php echo MHttp::desktopHost(); ?>/themes/mobispot/socialmediaicons/instagram.png"> </a>
                </div>
        </div>
        <a class="add-button" ng-click="addContent()"><?php echo Yii::t('spot', 'Post'); ?></a>
    </div>
    <?php if (!empty($spotContent->content)): ?>
        <?php $content = $spotContent->content ?>
        <?php if (isset($content['data']) and isset($content['keys'])): ?>
            <?php $keys = (isset($content['keys']) ? array_keys($content['keys']) : array()) ?>
            <?php $keys = '[' . implode(',', $keys) . ']'; ?>
            <span ng-init="spot.keys=<?php echo $keys; ?>"></span>
            <div ui-sortable="sortableOptions" ng-model="spot.keys" id="add-content" class="spot-items-area">
            <?php foreach ($content_keys as $key => $type): ?>
                <?php $value = $content['data'][$key]; ?>
                    <?php echo $this->renderPartial('/mobile/spot/personal/new_' . $type,
                        array(
                            'key' => $key,
                            'content' => $value,
                            )
                        );
                    ?>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endif; ?>

        <article id="spot-edit" class="hide spot-item item-area input-block">
            <textarea class="main-input"
                ng-model="spot.content_new"
                ng-trim="true">
            </textarea>
            <a ng-click="saveContent(spot, $event)"
                class="right m-link"
                ng-class="{visible: spot.content_new}"
                >
                <?php echo Yii::t('spot', 'Post')?>
            </a>
        </article>
    </div>
    <?php if (!empty($to_key)):?>
        <span ng-init="toKey(<?php echo $to_key; ?>)"></span>
    <?php endif; ?>
</article>
