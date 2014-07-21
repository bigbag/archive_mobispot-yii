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
                    <b class="time sub-line">
                    <?php echo (!empty($socContent['sub-line']))?
                        $socContent['sub-line']:'' ?>
                    </b>
                </div>
                <div class="ins-block">
                    <table class="j-list">
                    <?php if (!empty($socContent['list'])): ?>
                        <?php foreach ($socContent['list']['values'] as $li): ?>
                        <tr>
                            <td>
                            <?php if (!empty($li['href']) && !empty($li['title'])): ?>
                                <span><a class="authot-name" href="<?php echo $li['href']; ?>"><?php echo $li['title']; ?></a></span>
                            <?php else:?>
                                <span><?php if (isset($li['title'])) echo $li['title']; ?></span>
                            <?php endif; ?>
                            </td>
                            <td><?php if (isset($li['comment'])) echo $li['comment']; ?></td>
                        </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                    </table>
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
