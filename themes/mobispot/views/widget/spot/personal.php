<ul class="spot-hat-button">
    <li>
        <a data-tooltip 
            title="<?php echo Yii::t('spots', 'Settings'); ?>" 
            id="j-settings" 
            class="tip-top icon-spot-button right text-center settings-button icon" 
            href="javascript:;">
            &#xe00f;
        </a>
    </li>
</ul>
<div class="spot-content slide-content" ng-init="spot.status='<?php echo $spot->status; ?>'">
    <div class="spot-content_row">
        <div id="dropbox" class="spot-item spot-main-input">
            <textarea ng-model="spot.content" ui-keypress="{enter: 'addContent(spot)'}">

            </textarea>
            <div class="text-center label-cover">
                <h4><?php echo Yii::t('spots', 'Drag your files here or begin to type info or links'); ?></h4>
                <span><?php echo Yii::t('spots', 'A maximum file size limit of 25mb for free accounts'); ?></span>
                <div class="cover-fast-link">
                    <label for="add-file" data-tooltip title="<?php echo Yii::t('spots', 'Add file'); ?>"  class="icon tip-left">&#xe00e;</label>
                    <a data-tooltip ng-click="socialButton();" title="<?php echo Yii::t('spots', 'Add links and social accounts'); ?>" id="extraMedia" class="tip-right icon toggle-box">&#xe005;</a>
                    <input id="add-file"  type="file">
                </div>
                <div class="hat-cover"></div>
            </div>

            <div id="extraMediaForm" class="spot-sub-slide slide-content">
                <a data-tooltip title="Facebook" class="tip-top" ng-click="bindNet('facebook')";>
                    <img width="36" src="/themes/mobispot/images/icons/social/facebook.png"> 
                </a>
                <?php /*
                <a data-tooltip title="Flickr" class="tip-top" ng-click="bindNet('')">
                    <img width="36" src="/themes/mobispot/images/icons/social/flickr.png"> 
                </a>
                */?>
                <?php /*
                <a data-tooltip title="Behance" class="tip-top" ng-click="bindNet('Behance')">
                    <img width="36" src="/themes/mobispot/images/icons/social/behance.png"> 
                </a>
                */?>
                <a data-tooltip title="Vimeo" class="tip-top" ng-click="bindNet('vimeo')">
                    <img width="36" src="/themes/mobispot/images/icons/social/vimeo.png"> 
                </a>
                <?php /*
                <a data-tooltip title="LinkedIn" class="tip-top" ng-click="bindNet('linkedin')">
                    <img width="36" src="/themes/mobispot/images/icons/social/linkedin.png"> 
                </a>
                */?>
                <?php /*
                <a data-tooltip title="LastFM" class="tip-top" ng-click="bindNet()">
                    <img width="36" src="/themes/mobispot/images/icons/social/lastfm.png"> 
                </a>
                */?>
                <?php /*
                <a data-tooltip title="MySpace" class="tip-top" ng-click="bindNet()">
                    <img width="36" src="/themes/mobispot/images/icons/social/myspace.png"> 
                </a>
                */?>
                <?php /*
                <a data-tooltip title="tumblr" class="tip-top" ng-click="bindNet('tumblr')">
                    <img width="36" src="/themes/mobispot/images/icons/social/tumblr.png"> 
                </a>
                */?>
                <a data-tooltip title="YouTube" class="tip-top" ng-click="bindNet('YouTube')">
                    <img width="36" src="/themes/mobispot/images/icons/social/youtube.png"> 
                </a>
                <a data-tooltip title="Twitter" class="tip-top" ng-click="bindNet('twitter')">
                    <img width="36" src="/themes/mobispot/images/icons/social/twitter.png"> 
                </a>
                <a data-tooltip title="Google+" class="tip-top" ng-click="bindNet('google_oauth')">
                    <img width="36" src="/themes/mobispot/images/icons/social/google.png"> 
                </a>
                <a data-tooltip title="VKontakte" class="tip-top" ng-click="bindNet('vk')">
                    <img width="36" src="/themes/mobispot/images/icons/social/vk.png"> 
                </a>
                <?php /*
                <a data-tooltip title="Instagram" class="tip-top" ng-click="bindNet('instagram')">
                    <img width="36" src="/themes/mobispot/images/icons/social/instagram.png"> 
                </a>
                */?>
                <?php /*
                <a data-tooltip title="Pinterest" class="tip-top" ng-click="bindNet('pinterest')">
                    <img width="36" src="/themes/mobispot/images/icons/social/pinterest.png"> 
                </a>
                */?>
                <a data-tooltip title="DeviantART" class="tip-top" ng-click="bindNet('deviantart')">
                    <img width="36" src="/themes/mobispot/images/icons/social/deviantart.png"> 
                </a>
            </div>
        </div>
        <div id="error-upload" class="spot-item">
            <div class="item-area text-center type-error">
                <h4 class="color"><?php echo Yii::t('spot', 'Oops!') ?></h4>
                <h4><?php echo Yii::t('spot', 'There was an error when attempting to upload this file<br/>Please try again') ?></h4>
            </div>
        </div>
        <div id="progress-content" class="spot-item">
            <div class="item-area type-progress">
                <div class="progress-bar">
                    <div class="meter" ng-style="{'width': progress+'%'}">{{progress}}%</div>
                </div>
            </div>
        </div>

    <?php if (!empty($spotContent->content)): ?>
        <?php $content = $spotContent->content ?>

        <?php if (isset($content['data']) and isset($content['keys'])): ?>

            <?php $keys = (isset($content['keys']) ? array_keys($content['keys']) : array()) ?>
            <?php $keys = '[' . implode(',', $keys) . ']'; ?>

            <span ng-init="spot.vcard=<?php echo $content['vcard']; ?>; spot.private=<?php echo $content['private']; ?>; keys=<?php echo $keys; ?>;"></span>

            <div ui-sortable="sortableOptions" ng-model="keys" id="add-content">
                <?php $content_keys = $content['keys'];?>
                <?php ksort($content_keys);?>
                <?php foreach ($content_keys as $key => $type): ?>
                    <?php $value = $content['data'][$key]; ?>
                        <?php echo $this->renderPartial('/widget/spot/personal/new_' . $type,
                            array(
                                'key' => $key,
                                'content' => $value,

                                )
                            );
                        ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <span ng-init="spot.vcard=0; spot.private=0"></span>
    <?php endif; ?>
</div>

<script type="text/javascript">
    $('textarea').autosize();
</script>
<!-- <script src="/themes/mobispot/js/slide-box.min.js"></script> -->