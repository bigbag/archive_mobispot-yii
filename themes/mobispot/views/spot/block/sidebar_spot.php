<li id="<?php echo $spot->discodes_id;?>"
    ng-click="spot.discodes='<?php echo $spot->discodes_id;?>'; general.views='spot'"
    ng-class="{active: spot.discodes=='<?php echo $spot->discodes_id;?>'}">
    <i class="icon i-invisible">&#xe60b;</i>
    <div class="box">
        <div class="spot-img">
            <img src="/themes/mobispot/img/spot-img/spot-key_red.png">
        </div>
        <h3>
            <?php echo mb_substr($spot->name, 0, 50, 'utf-8') ?>
        </h3>
        <span class="spot-id"><?php echo $spot->code;?></span>
    </div>
</li>