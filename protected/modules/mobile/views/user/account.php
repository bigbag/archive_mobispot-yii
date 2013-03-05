<div id="main-container">
<div class="graySpotBlock rad6 shadow">
<div class="grayBigHead radTop6"><?php echo Yii::t('mobile', 'Управление спотами');?></div>
<form>
<table class="headTable">
<tr>
<td class="td100p">
<center><?php echo Yii::t('mobile', 'Название');?></center>
</td>
<td class="td127" nowrap>
<center><?php echo Yii::t('mobile', 'ID-спота');?></center>
</td>
</tr>
</table>

<div id="table-spots">
<ul>
<?php foreach ($model as $row): ?>
<li class="oneSpotBlock">
<div class="oneSpot">
<table class="formSpot">
<tr>
<td class="td40" nowrap>
<center><input type="checkbox" class="niceCheck"></center>
</td>
<td class="td100p" nowrap><?php echo (!empty($row->name))?$row->name:''?></td>
<td class="td127" nowrap><span><?php echo $row->discodes_id?></span></td>
</tr>
</table>
</div>
</li>
<?php endforeach;?>
</ul>
</div>
<div class="clear"></div>

<div id="foot-cont-block">
<select name='action' class='action'>
<option selected><?php echo Yii::t('account', 'Выберите действие');?></option>
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
<a href="" class="btn-round fright rad12 shadow"><?php echo Yii::t('account', 'Добавить спот'); ?></a>
</div>
</form>
</div>
</div>