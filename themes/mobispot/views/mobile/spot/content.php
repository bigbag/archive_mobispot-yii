    <article class="active spot-link">
        <div class="input-block">
            <textarea class="main-input" name=""></textarea>
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
        echo (SocInfo::nameInList('facebook', $spotNets))?        'link':''
        ?>" title="Facebook" href="javascript:;"><img width="36" src="<?php echo $this->desctopHost(); ?>/themes/mobispot/socialmediaicons/facebook.png"> </a>
    <a class="<?php
        echo (SocInfo::nameInList('twitter', $spotNets))?        'link':''
        ?>" title="Twitter"  href="javascript:;"><img width="36" src="<?php echo $this->desctopHost(); ?>/themes/mobispot/socialmediaicons/twitter.png"> </a>
    <a class="<?php
        echo (SocInfo::nameInList('linkedin', $spotNets))?        'link':''
        ?>" title="LinkEdin"  href="javascript:;"><img width="36" src="<?php echo $this->desctopHost(); ?>/themes/mobispot/socialmediaicons/linkedin.png"> </a>
    <a class="<?php
        echo (SocInfo::nameInList('foursquare', $spotNets))?        'link':''
        ?>" title="Foursquare"  href="javascript:;"><img width="36" src="<?php echo $this->desctopHost(); ?>/themes/mobispot/socialmediaicons/foursquare.png"> </a>
    <a class="<?php
        echo (SocInfo::nameInList('google_oauth', $spotNets))?        'link':''
        ?>" title="Google+"  href="javascript:;"><img width="36" src="<?php echo $this->desctopHost(); ?>/themes/mobispot/socialmediaicons/google.png"> </a>
    <a class="<?php
        echo (SocInfo::nameInList('YouTube', $spotNets))?        'link':''
        ?>" title="YouTube"  href="javascript:;"><img width="36" src="<?php echo $this->desctopHost(); ?>/themes/mobispot/socialmediaicons/youtube.png"> </a>
    <a class="<?php
        echo (SocInfo::nameInList('vimeo', $spotNets))?        'link':''
        ?>" title="Vimeo"  href="javascript:;"><img width="36" src="<?php echo $this->desctopHost(); ?>/themes/mobispot/socialmediaicons/vimeo.png"> </a>
    <a class="<?php
        echo (SocInfo::nameInList('vk', $spotNets))?        'link':''
        ?>" title="VKontakte"  href="javascript:;"><img width="36" src="<?php echo $this->desctopHost(); ?>/themes/mobispot/socialmediaicons/vk.png"> </a>
    <a class="<?php
        echo (SocInfo::nameInList('Behance', $spotNets))?        'link':''
        ?>" title="Behance"  href="javascript:;"><img width="36" src="<?php echo $this->desctopHost(); ?>/themes/mobispot/socialmediaicons/behance.png"> </a>
    <a class="<?php
        echo (SocInfo::nameInList('deviantart', $spotNets))?        'link':''
        ?>" title="DeviantART"  href="javascript:;"><img width="36" src="<?php echo $this->desctopHost(); ?>/themes/mobispot/socialmediaicons/deviantart.png"> </a>
    <a class="<?php
        echo (SocInfo::nameInList('instagram', $spotNets))?        'link':''
        ?>" title="Instagram"  href="javascript:;"><img width="36" src="<?php echo $this->desctopHost(); ?>/themes/mobispot/socialmediaicons/instagram.png"> </a>
                    </div>
            </div>
            <a class="add-button" href="javascript:;"><?php echo Yii::t('user', 'Post'); ?></a>
        </div>
        <div class="spot-items-area">
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
        </div>
    </article>