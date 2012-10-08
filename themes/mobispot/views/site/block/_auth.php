<?php if ($first): ?>

<div class="title"><?php echo Yii::t('general', 'Вам необходимо выбрать тип вашего первого спота.')?></div>
<form action="" method="post">
    <div class="btn-form">
        <div class="btn-form-cl">
            <a href=""><?php echo $spot->discodes_id;?></a>

            <div style="float: right; margin-top: 3px;">
                <select name="spot_type">
                    <?php foreach ($spot_type as $key => $value): ?>
                    <option value='<?php echo $key;?>'><?php echo $value;?></option>
                    <?php endforeach; ?>
                </select>
            </div>

        </div>
    </div>

    <input type="hidden" name="discodes_id" value="<?php echo $spot->discodes_id;?>">
    <input type="submit"  class="m-button" value="<?php echo Yii::t('general', 'Сохранить');?>"/>
</form>
<?php else: ?>
<div class="title"><?php echo Yii::t('general', 'Мои споты');?></div>
<?php $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $dataProvider,
        'itemView' => 'block/_spots_list',
        'template' => '{items} {pager}',
        'cssFile' => false,
        'id' => 'spotslistview',
        'pager' => array('cssFile' => false,
            'class' => 'MLinkPager',
        ),
    )); ?>
<div class="bnt-account">
    <input type="submit" id="account" class="m-button"
           value="<?php echo Yii::t('general', 'Перейти в личный кабинет')?>"/>
</div>

<?php endif; ?>

