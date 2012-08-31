<?php if ($first): ?>

<h2><?php echo Yii::t('general', 'Вам необходимо выбрать тип вашего первого спота.')?></h2>
<form action="" method="post">
    <div class="btn-form">
        <div class="btn-form-cl">
            <a href=""><?php echo $spot->discodes_id;?></a>
            <div style="float: right; margin-top: 3px;">
                <select name="spot_type" >
                    <?php foreach ($spot_type as $key => $value): ?>
                    <option value='<?php echo $key;?>'><?php echo $value;?></option>
                    <?php endforeach; ?>
                </select>
            </div>

        </div>
    </div>

    <div class="btn-30">
        <input type="hidden" name="discodes_id" value="<?php echo $spot->discodes_id;?>">

        <div><input type="submit" value="<?php echo Yii::t('general', 'Сохранить');?>"/></div>
    </div>
</form>
<?php else: ?>
<h2><?php echo Yii::t('general', 'Мои споты');?></h2>
<?php $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $dataProvider,
        'itemView' => 'block/_spots_list',
        'template' => '{items} {pager}',
        'cssFile' => false,
        'id' => 'spotslistview',
        'pager'=>array('cssFile'=>false,
            'class'=>'MLinkPager',
        ),
    )); ?>
<div class="bnt-account">
    <div class="btn-30">
        <div>
            <input type="submit" id="account" value="<?php echo Yii::t('general', 'Перейти в личный кабинет')?>"/>
        </div>
    </div>
</div>


<?php endif; ?>

