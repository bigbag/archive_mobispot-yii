<div class="row">
    <div class="large-12 columns">
        <ul class="spot-list so-awesome">
            <?php foreach ($spots as $spot):?>
            <?php $invisible = ($spot->status==Spot::STATUS_INVISIBLE)?'invisible':'';?>
            <?php include('sidebar_spot.php'); ?>
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
