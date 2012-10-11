<div class="page">
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
                    <select name='action' class='action'>
                    <option selected disabled="disabled"><?php echo Yii::t('account', 'Выберите действие');?></option>
                    <option
                            value="<?php echo Spot::ACTION_CHANGE_NAME;?>"><?php echo Yii::t('account', 'Изменить название'); ?></option>
                    <option
                            value="<?php echo Spot::ACTION_CHANGE_TYPE;?>"><?php echo Yii::t('account', 'Изменить тип'); ?></option>
                    <option
                            value="<?php echo Spot::ACTION_COPY;?>"><?php echo Yii::t('account', 'Копировать'); ?></option>
                    <option
                            value="<?php echo Spot::ACTION_INVISIBLE;?>"><?php echo Yii::t('account', 'Невидимость'); ?></option>
                    <option
                            value="<?php echo Spot::ACTION_CLEAR;?>"><?php echo Yii::t('account', 'Очистить'); ?></option>
                    <option
                            value="<?php echo Spot::ACTION_REMOVE;?>"><?php echo Yii::t('account', 'Удалить'); ?></option>
                </select>
                </div>
                <div class="six columns">

                </div>
                <div class="three columns add-spot">
                    <span class="m-button"><i class="icon-plus"></i>&nbsp;<?php echo Yii::t('account', 'Добавить спот'); ?></span>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include('block/script.php') ?>
<?php include('modal/spot_clear.php') ?>
<?php include('modal/spot_invisible.php') ?>
<?php include('modal/spot_remove.php') ?>
<?php include('modal/spot_add.php') ?>
<?php include('modal/spot_copy.php') ?>
<?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/js/jquery.uploadifive.min.js'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/js/relcopy.min.js'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/js/jquery.miniColors.min.js'); ?>

<?php Yii::app()->getClientScript()->registerCssFile('/themes/mobispot/css/jquery.miniColors.css'); ?>