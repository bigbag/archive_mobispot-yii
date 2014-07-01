<div id="block-<?php echo $dataKey;?>" class="spot-item">
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
                    <?php if (!empty($socContent['view_count'])): ?>
                    <?php echo $socContent['view_count'] . ' ' . Yii::t('eauth', 'просмотров'); ?>
                    <?php endif ?>
                    </span>
                </div>
                <div class="ins-block">
                <object>
                    <param name="movie" value="<?php
                    echo (!empty($socContent['youtube_video_flash']))?
                        $socContent['youtube_video_flash']:'' ?>">
                    <param name="allowFullScreen" value="true">
                    <embed class="yt_player" id="player_<?php echo $dataKey; ?>" src="<?php
                    echo (!empty($socContent['youtube_video_flash']))?
                        $socContent['youtube_video_flash']:'' ?>"
                    <?php if (isset($socContent['youtube_video_rel'])): ?>
                        rel="<?php echo $socContent['youtube_video_rel']; ?>"
                    <?php endif; ?>
                    type="application/x-shockwave-flash"
                        width="100%" height="480"
                    allowfullscreen="true">
                </object>
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
