<article id="block-<?php echo $dataKey;?>" class="spot-item">
    <div class="item-area type-itembox">
        <div class="item-head">
            <a href="<?php echo $socContent['soc_url']; ?>" class="type-link">
                <img class="soc-icon" src="/themes/mobispot/socialmediaicons/<?php echo $socInfo->getSmallIcon(CHtml::encode($content));?>" height="18"><span class="link"><?php echo $socContent['soc_url']; ?></span>
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
                    <?php endif?>
                    <b class="time"><?php //echo $socContent['sub-time']; ?></b>
                    <span class="sub-line"><?php if (!empty($socContent['view_count'])): ?>
                    <?php echo $socContent['view_count'] . ' ' . Yii::t('eauth', 'просмотров'); ?>
                    <?php endif ?></span>
                </div>
                <div class="ins-block">
                <iframe id="vimeo_11" src="http://player.vimeo.com/video/33382554" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                
                </div>
            </div>
        </div>
            <div class="item-control">
                    <div class="spot-activity">
                        <a class="button round" href="javascripts:;">&#xe009;</a>
                        <a class="button round" href="javascripts:;">&#xe00b;</a>
                    </div>
        </div>
    </div>
</article>