<div class="content-wrapper"
    ng-controller="SpotController"
    ng-init="spot.token=user.token; spot.discodes='<?php echo $default_discodes;?>'">
    <div class="content-block">
        <div class="row">
            <div class="columns small-3 large-3">
                <?php include('block/sidebar.php'); ?>
            </div>
            <div class="columns small-9 large-9">
            <?php include('block/body.php'); ?>
            </div>
        </div>
    </div>
</div>