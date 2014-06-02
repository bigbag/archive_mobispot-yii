<div id="block-<?php echo $dataKey;?>" class="spot-item">
    <div class="item-area type-itembox">
        <div class="item-head">
            <a href="<?php echo $socContent['soc_url']; ?>" class="type-link">
                <?php $socInfo = new SocInfo;?>
                <img class="soc-icon" src="/themes/mobispot/socialmediaicons/<?php echo $socInfo->getSmallIcon($socContent['soc_url']);?>" height="36"> <span class="link"><?php echo $socContent['soc_url']; ?></span>
            </a>
        </div>
        <div class="type-mess item-body">
            <div class="item-user-avatar">
            <?php if (!empty($socContent['photo'])):?>
                <img width="50" height="50" src="<?php echo $socContent['photo'] ?>" >
            <?php endif ?>
            </div>
            <div class="mess-body">
                <div class="author-row">
                <?php if (!empty($socContent['soc_username'])): ?>
                <a class="authot-name" href="<?php echo $socContent['soc_url']; ?>"><?php echo $socContent['soc_username'] ?></a>
                <?php endif ?>
                <span class="sub-line">
                <?php echo (!empty($socContent['sub-line']))?$socContent['sub-line']:'' ?>
                </span>
                </div>
                <div class="ins-block">
                    <p> <?php echo (!empty($socContent['text']))?
                        $socContent['text']:'' ?></p>

                    <a href="<?php echo (!empty($socContent['shared_link']))?
                        $socContent['shared_link']:'' ?>" class="thumbnail">
                        <?php if (!empty($socContent['last_img'])): ?>
                        <img src="<?php echo $socContent['last_img']; ?>">
                        <?php endif ?>
                        <h4><?php echo (!empty($socContent['link_name']))?
                        $socContent['link_name']:'' ?></h4>
                        <span class="sub-txt"><?php echo (!empty($socContent['link_caption']))?
                        $socContent['link_caption']:'' ?></span>
                        <p><?php echo (!empty($socContent['link_description']))?
                        $socContent['link_description']:'' ?></p>
                    </a>

                    <footer>
                        <span><?php echo (!empty($socContent['footer-line']))?
                        $socContent['footer-line']:'' ?></span>
                    </footer>
                </div>
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