<div class="page" ng-controller="SpotController">
    <div class="title"><?php echo Yii::t('account', 'Управление спотами');?></div>
    <div class="row account">
        <div class="twelve columns">
            <div class="table-title">
                <div class="one columns">

                </div>
                <div class="six columns">
                    <?php echo Yii::t('account', 'Название');?>
                </div>
                <div class="two columns">
                    <?php echo Yii::t('account', 'ID-спота');?>
                </div>
                <div class="three columns">
                    <?php echo Yii::t('account', 'Тип спота');?>
                </div>
            </div>
                <?php $this->widget('MListView', array(
                    'dataProvider' => $dataProvider,
                    'itemView' => 'block/_spots_list',
                    'enableSorting' => false,
                    'template' => '{items} {pager}',
                    'cssFile' => false,
                    'id' => 'spotslistview',
                )); ?>
            <div class="action-menu">
                <div class="three columns">
                    <select name='action' id="action-select" ng-model="action">
                        <option></option>
                    <option value="rename">
                        <?php echo Yii::t('account', 'Изменить название'); ?>
                    </option>
                    <option value="retype">
                        <?php echo Yii::t('account', 'Изменить тип'); ?>
                    </option>
                    <option value="copy">
                        <?php echo Yii::t('account', 'Копировать'); ?>
                    </option>
                    <option value="invisible">
                        <?php echo Yii::t('account', 'Невидимость'); ?>
                    </option>
                    <option value="clear">
                        <?php echo Yii::t('account', 'Очистить'); ?>
                    </option>
                    <option value="remove">
                        <?php echo Yii::t('account', 'Удалить'); ?>
                    </option>
                </select>
                </div>
                <div class="six columns">

                </div>
                <div class="three columns add-spot">
                    <span class="m-button" ng-click="action = 'add'" ><i class="icon-plus"></i>&nbsp;<?php echo Yii::t('account', 'Добавить спот'); ?></span>
                </div>

            </div>

        </div>
    </div>
</div>

<?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/js/jquery.uploadifive.min.js'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/js/relcopy.min.js'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/js/jquery.miniColors.min.js'); ?>

<?php Yii::app()->getClientScript()->registerCssFile('/themes/mobispot/css/jquery.miniColors.css'); ?>