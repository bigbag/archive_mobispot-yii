<div class="spot-content slide-content" ng-init="spot.status='<?php echo $spot->status; ?>'">
<!--     <div class="spot-tabs">
        <a id="icon-spot" ng-click="showSpotContent()" class="active">Spot list<i class="icon">&#xe600;</i></a>
        <a href="/corp/wallet/">Wallet<i class="icon">&#xe006;</i></a>
        <a id="icon-coupons" ng-click="showCoupons()">Coupons<i class="icon">&#xe601;</i></a>
    </div>
     -->
    <div class="tabs-block">
        <div id="spot-block" class="spot-content_row tabs-item">
            <div id="dropbox" class="spot-item spot-main-input">
                <textarea 
                    ng-model="spot.content" 
                    ng-init="getSocPatterns()" 
                    ng-change="changeContent()"
                    ng-keypress="($event.keyCode == 13)?addContent(spot):''" >

                </textarea>
                <div class="text-center label-cover">
                    <div id="mainHolder">
                        <h4><?php echo Yii::t('spots', 'Drag your files here or begin to type info or links'); ?></h4>
                        <span><?php echo Yii::t('spots', 'A maximum file size limit of 25mb for free accounts'); ?></span>
                    </div>
                    <div id="socLinkHolder" class="hide">
                        <h4></h4>
                    </div>
                    <div class="cover-fast-link">
                        <label for="add-file" data-tooltip title="<?php echo Yii::t('spots', 'Add file'); ?>"  class="icon tip-left">&#xe00e;</label>
                        <a data-tooltip ng-click="socialButton();" title="<?php echo Yii::t('spots', 'Add links and social accounts'); ?>" id="extraMedia" class="tip-right icon toggle-box">&#xe005;</a>
                        <input id="add-file"  type="file">
                    </div>
                    <div class="hat-cover"></div>
                </div>

                <div id="extraMediaForm" class="spot-sub-slide slide-content">
                    <a data-tooltip title="Facebook" net="facebook" class="tip-top" ng-click="bindByPanel('facebook')" ng-mouseenter="socView('facebook')" ng-mouseleave="socView()">
                        <img width="36" src="/themes/mobispot/images/icons/social/facebook.png"> 
                    </a>
                    <a data-tooltip title="Twitter" net="twitter" class="tip-top" ng-click="bindByPanel('twitter')" ng-mouseenter="socView('twitter')" ng-mouseleave="socView()">
                        <img width="36" src="/themes/mobispot/images/icons/social/twitter.png"> 
                    </a>
                    <a data-tooltip title="Google+" net="google_oauth" class="tip-top" ng-click="bindByPanel('google_oauth')" ng-mouseenter="socView('google_oauth')" ng-mouseleave="socView()">
                        <img width="36" src="/themes/mobispot/images/icons/social/google.png"> 
                    </a>
                    <a data-tooltip title="tumblr" net="tumblr" class="tip-top" ng-click="bindByPanel('tumblr')" ng-mouseenter="socView('tumblr')" ng-mouseleave="socView()">
                        <img width="36" src="/themes/mobispot/images/icons/social/tumblr.png"> 
                    </a>
                    <a data-tooltip title="Pinterest" net="pinterest" class="tip-top" ng-click="bindByPanel('pinterest')" ng-mouseenter="socView('pinterest')" ng-mouseleave="socView()">
                        <img width="36" src="/themes/mobispot/images/icons/social/pinterest.png"> 
                    </a>
                    <a data-tooltip title="LinkedIn" net="linkedin" class="tip-top" ng-click="bindByPanel('linkedin')" ng-mouseenter="socView('linkedin')" ng-mouseleave="socView()">
                        <img width="36" src="/themes/mobispot/images/icons/social/linkedin.png"> 
                    </a>
                    <a data-tooltip title="Foursquare" net="foursquare" class="tip-top" ng-click="bindByPanel('foursquare')" ng-mouseenter="socView('foursquare')" ng-mouseleave="socView()">
                        <img width="36" src="/themes/mobispot/images/icons/social/foursquare.png"> 
                    </a>
                    <a data-tooltip title="Instagram" net="instagram" class="tip-top" ng-click="bindByPanel('instagram')" ng-mouseenter="socView('instagram')" ng-mouseleave="socView()">
                        <img width="36" src="/themes/mobispot/images/icons/social/instagram.png"> 
                    </a>
                    <a data-tooltip title="YouTube" net="YouTube" class="tip-top" ng-click="bindByPanel('YouTube')" ng-mouseenter="socView('YouTube')" ng-mouseleave="socView()">
                        <img width="36" src="/themes/mobispot/images/icons/social/youtube.png"> 
                    </a>
                    <a data-tooltip title="Vimeo" net="vimeo" class="tip-top" ng-click="bindByPanel('vimeo')" ng-mouseenter="socView('vimeo')" ng-mouseleave="socView()">
                        <img width="36" src="/themes/mobispot/images/icons/social/vimeo.png"> 
                    </a>
                    <a data-tooltip title="VKontakte" net="vk" class="tip-top" ng-click="bindByPanel('vk')" ng-mouseenter="socView('vk')" ng-mouseleave="socView()">
                        <img width="36" src="/themes/mobispot/images/icons/social/vk.png"> 
                    </a>
                    <a data-tooltip title="Behance" net="Behance" class="tip-top" ng-click="bindByPanel('Behance')" ng-mouseenter="socView('Behance')" ng-mouseleave="socView()">
                        <img width="36" src="/themes/mobispot/images/icons/social/behance.png"> 
                    </a>
                    <a data-tooltip title="DeviantART" net="deviantart" class="tip-top" ng-click="bindByPanel('deviantart')" ng-mouseenter="socView('deviantart')" ng-mouseleave="socView()">
                        <img width="36" src="/themes/mobispot/images/icons/social/deviantart.png"> 
                    </a>
                    <a data-tooltip title="CrunchBase" net="crunchbase" class="tip-top" ng-click="bindByPanel('crunchbase')" ng-mouseenter="socView('crunchbase')" ng-mouseleave="socView()">
                        <img width="36" src="/themes/mobispot/images/icons/social/crunchbase.png"> 
                    </a>
                    <?php /*
                    <a data-tooltip title="LastFM" net="Last.fm" class="tip-top" ng-click="bindByPanel()" ng-mouseenter="socView('Last.fm')" ng-mouseleave="socView()">
                        <img width="36" src="/themes/mobispot/images/icons/social/lastfm.png"> 
                    </a>
                    */?>
                    <?php /*
                    <a data-tooltip title="MySpace" net="MySpace" class="tip-top" ng-click="bindByPanel()" ng-mouseenter="socView('MySpace')" ng-mouseleave="socView()">
                        <img width="36" src="/themes/mobispot/images/icons/social/myspace.png"> 
                    </a>
                    */?>
                    <?php /*

                    */?>
                    <?php /*
                    <a data-tooltip title="Flickr" net="Flickr" class="tip-top" ng-click="bindByPanel('')" ng-mouseenter="socView('Flickr')" ng-mouseleave="socView()">
                        <img width="36" src="/themes/mobispot/images/icons/social/flickr.png"> 
                    </a>
                    */?>

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
                </div>
            <?php endif; ?>
        <?php else: ?>
            <span ng-init="spot.vcard=0; spot.private=0"></span>
        <?php endif; ?>
        </div>
    </div>
</div>