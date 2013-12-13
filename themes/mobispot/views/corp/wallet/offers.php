<div class="row">
    <div class="large-12 columns">
        <div id="all-actions" class="singlebox-margin">
            <h3><?php echo Yii::t('wallet', 'Специальные предложения')?></h3>
            <div class="table-fltr add-active">
                <a id="actions-actual" class="spot-button" ng-click="getAllActions(1, 1)"><?php echo Yii::t('wallet', 'Актуальные')?></a>
                <a id="actions-old" class="spot-button" ng-click="getAllActions(0, 1)"><?php echo Yii::t('wallet', 'Прошедшие')?></a>
                <a id="actions-my" class="spot-button" ng-click="getAllActions(100, 1)"><?php echo Yii::t('wallet', 'Принимаю участие')?></a>
                <a id="actions-all" class="spot-button active"  ng-click="getAllActions(2, 1)"><?php echo Yii::t('wallet', 'Все')?></a>
                <input class="no-active" type="text" ng-init="allActions.newSearch='';allActions.search=''" ng-model="allActions.newSearch" placeholder="<?php echo Yii::t('wallet', 'Поиск')?>">
                <a id="button-search" class="spot-button text-center no-active" href="javascript:;" ng-click="getAllActions('current', 1, allActions.newSearch)"><?php echo Yii::t('wallet', 'Искать');?></a>
            </div>
            <div class="m-table-wrapper item-area_table">
                <table id="all-actions-table" class="m-spot-table" ng-grid="gridOptions">
                    <thead>
                    <tr>
                        <th><div><span><?php echo Yii::t('wallet', 'Магазин')?></span></div></th>
                        <th><div><span><?php echo Yii::t('wallet', 'Условие')?></span></div></th>
                        <th><div><span><?php echo Yii::t('wallet', 'Описание')?></span></div></th>
                        <th><div><span><?php echo Yii::t('wallet', 'Период')?></span></div></th>
                        <th><div><span><?php echo Yii::t('wallet', 'Получено')?></span></div></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php include(Yii::getPathOfAlias('webroot') . '/themes/mobispot/views/wallet/block/offers_tbody.php'); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>