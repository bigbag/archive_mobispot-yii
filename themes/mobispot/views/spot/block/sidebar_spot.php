<li id="<?php echo $spot->discodes_id;?>"
    <?php if ($spot->status == 6): ?>
    class="invisible"
    <?php endif; ?>
    ng-click="spot.discodes='<?php echo $spot->discodes_id;?>'; general.views='<?php echo (SpotTroika::isBlockedCard($spot->discodes_id))?'transport':'wallet'?>'"
    ng-class="{active: spot.discodes=='<?php echo $spot->discodes_id;?>'}">
    <i class="icon i-invisible">&#xe60b;</i>
    <div class="box">
        <div class="spot-img">
            <img src="/uploads/products/<?php echo $spot->hard->image;?>">
        </div>
        <h3>
            <?php echo mb_substr($spot->name, 0, 50, 'utf-8') ?>
        </h3>
        <span class="spot-id"><?php echo $spot->code;?></span>
    </div>
</li>
