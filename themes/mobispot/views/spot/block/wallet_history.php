<div class="item-area_table">
    <img src="/themes/mobispot/img/icons/datepicker.jpg" style="float:right;font-family:mobispot-icon;fotn-size:72px;font-style:normal;position:relative;top:5px;cursor:pointer" ng-click="$event.stopPropagation();showDatepicker('#date_history')">
    <input id="date_history" style="float:right;margin-right:10px;position:relative;width:1px;right:-10px;visibility:hidden;">
    <h4><?php echo Yii::t('spot', 'Recent transactions')?></h4>
    <div id="history-wrapper" class="m-table-wrapper">
        <?php include(Yii::getPathOfAlias('webroot') . '/themes/mobispot/views/spot/block/list_history.php'); ?>
    </div>
    <!-- <a href="javascripts:;" class="link-report">
        <i class="icon">&#xe608;</i><?php echo Yii::t('spot', 'Get the statement')?>
    </a> -->
</div>
