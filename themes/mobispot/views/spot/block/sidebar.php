<div class="row">
    <div class="large-12 columns">
        <ul class="spot-list so-awesome">
            <?php foreach ($spots as $spot):?>
            <?php $invisible = ($spot->status==Spot::STATUS_INVISIBLE)?'invisible':'';?>
            <li id="<?php echo $spot->discodes_id;?>"
                class="<?php echo $invisible; ?>"
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
            <?php endforeach;?>
        </ul>
    </div>
</div>
<div class="row">
    <div class="column twelve text-center toggle-active">
        <a href="#actSpotForm" id="actSpot" class="add-spot toggle-box button round slideToThis">
            <i class="icon">&#xe015;</i>
            <span class="m-tooltip m-tooltip-open">
                <?php echo Yii::t('spot', 'Add new spot'); ?>
            </span>
            <span class="m-tooltip m-tooltip-close">
                <?php echo Yii::t('spot', 'Close form'); ?>
            </span>
        </a>
    </div>
</div>
<div class="row actSpot-wrapper">
   <?php include('add_spot_form.php'); ?>
</div>
