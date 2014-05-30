<div id="block-<?php echo $dataKey;?>" class="spot-item spot-item_twi">
    <div class="item-area type-itembox">
        <div class="item-head">
            <a href="<?php echo $socContent['soc_url'] ?>" class="type-link">
                <img class="soc-icon" src="/themes/mobispot/socialmediaicons/twitter.png" height="36"> <span class="link"><?php echo $socContent['soc_url'] ?></span>
            </a>
        </div>
        <div class="type-mess item-body">
            <div class="item-user-avatar">
            <?php if (!empty($socContent['photo'])):?>
                <img width="50" height="50" src="<?php echo $socContent['photo'] ?>">
            <?php endif ?>
            </div>
            <div class="mess-body">
                <?php if (!empty($socContent['tweet_author'])):?>
                <div class="author-row"><a class="authot-name" href="<?php echo $socContent['soc_url'] ?>"><?php echo $socContent['tweet_author'] ?></a>
                    <a class="user-name sub-line" href="<?php echo $socContent['soc_url'] ?>">@<?php echo $socContent['tweet_username'] ?></a>
                </div>
                <?php endif ?>
                <?php if (!empty($socContent['tweet_text'])):?>
                <div class="ins-block">
                    <p><?php echo $socContent['tweet_text'] ?>
                    </p>
                    <footer>
                        <div class="left timestamp"><?php echo $socContent['tweet_datetime'] ?></div>
                    </footer>
                </div>
                <?php endif ?>
            </div>
        </div>
            <div class="item-control">
                    <span class="move move-top"></span>
                        <div class="spot-activity">
                    <a class="button round" ng-click="unBindSocial(spot, <?php echo $dataKey; ?>, $event)">&#xe003;</a>
                    <a class="button round" ng-click="removeContent(spot, <?php echo $dataKey; ?>, $event)">&#xe00b;</a>
                        </div>
                    <span class="move move-bottom"></span>
            </div>
    </div>
</div>