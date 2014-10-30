<?php $this->mainBackground = 'main-bg-w.png'?>

<div class="content-wrapper"
    ng-controller="SpotController"
    ng-init="spot.token=user.token; spot.discodes='<?php echo $curent_discodes;?>';general.views='<?php echo $curent_views;?>';setSpot(spot);">
    <div class="content-block">
        <div class="row">
            <div class="columns small-3 large-3">
                <?php include('block/sidebar.php'); ?>
            </div>
            <div id="spot-block" class="columns small-9 large-9">

            </div>
        </div>
    </div>
    <div class="fc"></div>
    <span ng-init="
        text.yes_btn='<?php echo Yii::t('spot', 'Yes'); ?>';
        text.no_btn='<?php echo Yii::t('spot', 'No'); ?>';
        text.mk_invisible='<?php echo Yii::t('spot', 'Make spot invisible').'?'; ?>';
        text.mk_invisible_descr='<?php echo Yii::t('spot', 'Make your spot invisible for the handsets'); ?>';
        text.mk_visible='<?php echo Yii::t('spot', 'Make spot visible').'?'; ?>';
        text.mk_visible_descr='<?php echo Yii::t('spot', 'Make your spot visible for the handsets'); ?>';
        text.clean_spot='<?php echo Yii::t('spot', 'Clean spot').'?'; ?>';
        text.clean_spot_descr='<?php echo Yii::t('spot', 'Clean all the content from your spot.<br /> Will be impossible to restore.'); ?>';
        text.rm_spot='<?php echo Yii::t('spot', 'Delete spot').'?'; ?>';
        text.rm_spot_descr='<?php echo Yii::t('spot', 'Delete the spot from your account.<br /> Attention: Will be impossible to restore.'); ?>'">
        
    </span>
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
<div class="fc"></div>
