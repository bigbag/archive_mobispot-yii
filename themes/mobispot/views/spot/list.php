<div class="content-wrapper"
    ng-controller="SpotController"
    ng-init="spot.token=user.token; spot.discodes='<?php echo $default_discodes;?>';general.views='spot'">
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
<div id="spot-edit"
    class="hide spot-item spot-main-input info-pick">
    <textarea
        ng-model="spot.content_new"
        ng-trim="true">
    </textarea>
    <div class="cover-fast-link">
            <a ng-click="saveContent(spot, $event)"
                class="right form-button"
                ng-class="{visible: spot.content_new}"
                >
                <?php echo Yii::t('spot', 'Post')?>
            </a>
    </div>
</div>