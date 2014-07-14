<div id="block-<?php echo $dataKey;?>" class="spot-item ">
    <div class="item-area type-itembox">
        <div class="item-head">
            <a href="<?php echo $socContent['soc_url']; ?>" class="type-link">
                <?php $socInfo = new SocInfo;?>
                <img class="soc-icon" src="/themes/mobispot/socialmediaicons/<?php echo $socInfo->getSmallIcon($socContent['soc_url']);?>" height="36"><span class="link"><?php echo $socContent['soc_url']; ?></span>
            </a>
        </div>
        <div class="type-mess item-body">
            <div class="item-user-avatar">
            <?php if (!empty($socContent['photo'])):?>
            <img width="50" height="50" src="<?php echo $socContent['photo'] ?>">
            <?php endif ?>
            </div>
            <div class="mess-body">
                <div class="author-row">
                    <?php if (!empty($socContent['soc_username'])): ?>
                    <a class="authot-name" href="<?php echo $socContent['soc_url']; ?>"><?php echo $socContent['soc_username'] ?></a>
                    <?php endif ?>
                    <b class="time"><?php //echo $socContent['sub-time']; ?></b>
                    <span class="sub-line">
                    <?php if (!empty($socContent['vimeo_last_video_counter'])): ?>
                    <?php echo $socContent['vimeo_last_video_counter'] . ' ' . Yii::t('eauth', 'views'); ?>
                    <?php endif ?>
                    </span>
                </div>
                <div class="ins-block">
                <iframe id="vimeo_<?php echo $dataKey; ?>" src="http://player.vimeo.com/video/<?php echo $socContent['vimeo_last_video']; ?>" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                </div>
            </div>
        </div>
            <div class="item-control">
                <div class="spot-activity">
                    <a
                        class="button round"
                        href=""
                        ng-click="removeContent(spot, <?php echo $key; ?>, $event)"
                    >
                    &#xe00b;
                    </a>
                </div>
            </div>
    </div>
</div>
