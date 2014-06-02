<div id="block-<?php echo $dataKey;?>" class="spot-item">
    <div class="item-area type-itembox">
        <div class="item-head">
            <a href="<?php echo $socContent['soc_url']; ?>" class="type-link">
                <img class="soc-icon" src="/themes/mobispot/socialmediaicons/instagram.png" height="36"><span class="link"><?php echo $socContent['soc_url']; ?></span>
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
                    <b class="time">
                    <?php echo (isset($socContent['sub-time']))?
                        $socContent['sub-time']:'' ?>
                    </b>
                    <div class="sub-line">
                    <?php if (!empty($socContent['sub-line'])): ?>
                        <span class="icon">&#xe01b;</span>
                        <?php echo $socContent['sub-line'] ?>
                    <?php endif ?>
                    </div>
                </div>
                <div class="ins-block">
                    <?php if (!empty($socContent['text'])): ?>
                        <p><?php echo $this->hrefActivate($socContent['text']); ?></p>
                    <?php endif ?>
                    
                    <?php if (!empty($socContent['last_img'])): ?>
                    <img src="<?php echo $socContent['last_img'] ?>">
                    <?php endif ?>
                    <?php if (!empty($socContent['likes-block'])): ?>
                        <div class="likes-block">
                        <?php echo $socContent['likes-block']; ?>
                        </div>
                    <?php endif ?>
                    <?php /*?>
                    <div class="comments">
                        <img width="24" src="img/avatar.png"> <a class="authot-name" href="#">katya_fug</a> асфальт!
                    </div>
                    <?php */?>
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
