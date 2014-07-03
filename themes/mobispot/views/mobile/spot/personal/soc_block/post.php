<article id="block-<?php echo $dataKey;?>" class="spot-item">
    <div class="item-area type-itembox">
        <div class="item-head">
            <a href="<?php echo $socContent['soc_url']; ?>" class="type-link">
                <img class="soc-icon" src="/themes/mobispot/socialmediaicons/<?php echo $socInfo->getSmallIcon(CHtml::encode($socContent['soc_url']));?>" height="18"><span class="link"><?php echo $socContent['soc_url']; ?></span>
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
                    <span class="sub-line">
                    <?php if (!empty($socContent['sub-line'])): ?>
                        <?php echo $socContent['sub-line']; ?>
                    <?php elseif (!empty($socContent['venue_name'])): ?>
                        <span class="icon">&#xe01b;</span>
                        <?php echo Yii::t('eauth', 'at ') . $socContent['venue_name'] ?>
                    <?php endif; ?>
                    </span>
                </div>
                <div class="ins-block">
                    <?php if (!empty($socContent['text'])): ?>
                        <p><?php echo $socContent['text']; ?></p>
                    <?php elseif (!empty($socContent['last_status'])):?>
                        <p><?php echo $socContent['last_status']; ?></p>
                    <?php elseif (!empty($socContent['tweet_text'])):?>
                        <p><?php echo $socContent['tweet_text']; ?></p>
                    <?php elseif (!empty($socContent['checkin_shout'])):?>
                        <p><?php echo $socContent['checkin_shout']; ?></p>
                    <?php endif ?>
                    <?php if (!empty($socContent['checkin_photo'])):?>
                    <img src="<?php echo $socContent['checkin_photo']; ?>">
                    <?php elseif (!empty($socContent['last_img'])): ?>
                    <img src="<?php echo $socContent['last_img']; ?>">
                    <?php endif ?>
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
</article>