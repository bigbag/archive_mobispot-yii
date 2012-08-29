<div id="main-container">
    <div id="cont-block" class="center">
        <div id="cont-block-760" class="center">
            <div id="zag-cont-block"><?php echo Yii::t('account', 'Управление спотами');?></div>
            <table class="headTable">
                <tr>
                    <td class="td60"></td>
                    <td class="td100p">
                        <center><?php echo Yii::t('account', 'Название');?></center>
                    </td>
                    <td class="td115">
                        <center><?php echo Yii::t('account', 'ID-спота');?></center>
                    </td>
                    <td class="td180">
                        <center><?php echo Yii::t('account', 'Тип спота');?></center>
                    </td>
                </tr>
            </table>

            <div id="table-spots">
                <ul>
                    <?php $this->widget('MListView', array(
                    'dataProvider' => $dataProvider,
                    'itemView' => 'block/_spots_list',
                    'enableSorting' => false,
                    'template' => '{items} {pager}',
                    'cssFile' => false,
                    'id' => 'spotslistview',
                )); ?>

                </ul>
            </div>

            <div class="clear"></div>
            <div id="foot-cont-block">
                <select name='action' class='action'>
                    <option selected><?php echo Yii::t('account', 'Выберите действие');?></option>
                    <option value="<?php echo Spot::ACTION_CHANGE_NAME;?>"><?php echo Yii::t('account', 'Изменить название'); ?></option>
                    <option value="<?php echo Spot::ACTION_CHANGE_TYPE;?>"><?php echo Yii::t('account', 'Изменить тип'); ?></option>
                    <option value="<?php echo Spot::ACTION_COPY;?>"><?php echo Yii::t('account', 'Копировать'); ?></option>
                    <option value="<?php echo Spot::ACTION_EMPTY;?>"><?php echo Yii::t('account', 'Очистить'); ?></option>
                    <option value="<?php echo Spot::ACTION_REMOVE;?>"><?php echo Yii::t('account', 'Удалить'); ?></option>
                </select>

                <a href="#" class="r-btn-30 spot_add_modal">
                    <span>
                        <span class="plus-ico"></span><?php echo Yii::t('account', 'Добавить спот'); ?>
                    </span>
                </a>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>

<?php include('block/script.php')?>
<?php include('modal/spot_clear.php')?>
<?php include('modal/spot_add.php')?>