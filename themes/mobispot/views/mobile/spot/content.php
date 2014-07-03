    <article class="active spot-link">
        <div class="input-block">
            <textarea class="main-input" ng-model="spot.content" name=""></textarea>
            <p class="input-over">
                <?php echo Yii::t('spot', 'Begin to type info or links'); ?>
            </p>
            <div class="soc-link">
                <p><?php echo Yii::t('spot', 'Добовление файлов недоступно в мобильной версии'); ?><br>
                    <a class="full-size" href="http://mobispot.com"><?php echo Yii::t('spot', 'Full size version'); ?></a>
                </p>
                <div class="linking">
                        <h4><?php echo Yii::t('spot', 'Привязка социальных сетей'); ?></h4>

    <a class="<?php
        echo (SocInfo::nameInList('facebook', $spotNets))?'link':''
        ?>" 
        title="Facebook" 
        ng-click="bindByPanel('facebook')"
        href="javascript:;"
    >
        <img width="36" src="<?php echo $this->desctopHost(); ?>/themes/mobispot/socialmediaicons/facebook.png"> 
    </a>
    <a class="<?php
        echo (SocInfo::nameInList('twitter', $spotNets))? 'link':''
        ?>" 
        title="Twitter" 
        ng-click="bindByPanel('twitter')"        
        href="javascript:;"
    >
        <img width="36" src="<?php echo $this->desctopHost(); ?>/themes/mobispot/socialmediaicons/twitter.png"> 
    </a>
    <a class="<?php
        echo (SocInfo::nameInList('linkedin', $spotNets))? 'link':''
        ?>" 
        title="LinkedIn"
        ng-click="bindByPanel('linkedin')"
        href="javascript:;"><img width="36" src="<?php echo $this->desctopHost(); ?>/themes/mobispot/socialmediaicons/linkedin.png"> </a>
    <a class="<?php
        echo (SocInfo::nameInList('foursquare', $spotNets))?        'link':''
        ?>" 
        title="Foursquare"
        ng-click="bindByPanel('foursquare')"
        href="javascript:;"><img width="36" src="<?php echo $this->desctopHost(); ?>/themes/mobispot/socialmediaicons/foursquare.png"> </a>
    <a class="<?php
        echo (SocInfo::nameInList('google_oauth', $spotNets))?        'link':''
        ?>" 
        title="Google+"
        ng-click="bindByPanel('google_oauth')"
        href="javascript:;"><img width="36" src="<?php echo $this->desctopHost(); ?>/themes/mobispot/socialmediaicons/google.png"> </a>
    <a class="<?php
        echo (SocInfo::nameInList('YouTube', $spotNets))?        'link':''
        ?>" 
        title="YouTube"  
        ng-click="bindByPanel('YouTube')"
        href="javascript:;"><img width="36" src="<?php echo $this->desctopHost(); ?>/themes/mobispot/socialmediaicons/youtube.png"> </a>
    <a class="<?php
        echo (SocInfo::nameInList('vimeo', $spotNets))?        'link':''
        ?>" 
        title="Vimeo"
        ng-click="bindByPanel('vimeo')"
        href="javascript:;"><img width="36" src="<?php echo $this->desctopHost(); ?>/themes/mobispot/socialmediaicons/vimeo.png"> </a>
    <a class="<?php
        echo (SocInfo::nameInList('vk', $spotNets))?        'link':''
        ?>" 
        title="VKontakte"
        ng-click="bindByPanel('vk')"
        href="javascript:;"><img width="36" src="<?php echo $this->desctopHost(); ?>/themes/mobispot/socialmediaicons/vk.png"> </a>
    <a class="<?php
        echo (SocInfo::nameInList('Behance', $spotNets))?        'link':''
        ?>" 
        title="Behance"
        ng-click="bindByPanel('Behance')"
        href="javascript:;"><img width="36" src="<?php echo $this->desctopHost(); ?>/themes/mobispot/socialmediaicons/behance.png"> </a>
    <a class="<?php
        echo (SocInfo::nameInList('deviantart', $spotNets))?        'link':''
        ?>" 
        title="DeviantART"
        ng-click="bindByPanel('deviantart')"
        href="javascript:;"><img width="36" src="<?php echo $this->desctopHost(); ?>/themes/mobispot/socialmediaicons/deviantart.png"> </a>
    <a class="<?php
        echo (SocInfo::nameInList('instagram', $spotNets))?        'link':''
        ?>" 
        title="Instagram"
        ng-click="bindByPanel('instagram_mobile')"
        href="javascript:;"><img width="36" src="<?php echo $this->desctopHost(); ?>/themes/mobispot/socialmediaicons/instagram.png"> </a>
                    </div>
            </div>
            <a class="add-button" ng-click="addContent()" href="javascript:;" ><?php echo Yii::t('spot', 'Post'); ?></a>
        </div>
        <div id="add-content" class="spot-items-area">
        <?php if (!empty($spotContent->content)): ?>
            <?php $content = $spotContent->content ?>
            <?php foreach ($content_keys as $key => $type): ?>
                <?php $value = $content['data'][$key]; ?>
                    <?php echo $this->renderPartial('/spot/personal/new_' . $type,
                        array(
                            'key' => $key,
                            'content' => $value,
                            )
                        );
                    ?>
            <?php endforeach; ?>
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