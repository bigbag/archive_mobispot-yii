<div class="content-wrapper"
    ng-controller="SpotController"
    ng-init="spot.token=user.token; spot.discodes='<?php echo $default_discodes;?>'">
    <div class="content-block">
        <div class="row">
            <div class="columns small-3 large-3">
                <?php include('block/sidebar.php'); ?>
            </div>
            <div id="spot-block" class="columns small-9 large-9">

            </div>
        </div>
    </div>
</div>