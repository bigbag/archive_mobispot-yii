<button class="m-button" ng-click="feedback(<?php echo $discodes_id; ?>)">
<?php echo Yii::t('account', 'Вернуться в спот');?>
</button>
<br />
<br />

<table cellpadding="6" cellspacing="0">
<tbody>
<tr>
<td><?php echo Yii::t('account', 'Дата и время');?></td>
<td><?php echo Yii::t('account', 'Имя');?></td>
<td><?php echo Yii::t('account', 'Телефон');?></td>
<td><?php echo Yii::t('account', 'E-mail');?></td>
<td><?php echo Yii::t('account', 'Комментарий');?></td>
</tr>
<?php foreach ($spot as $row): ?>
<tr>
<td><?php echo Yii::app()->dateFormatter->format("dd.MM.yyyy", $row['creation_date']);?>
<td><?php echo mb_substr($row['name'], 0, 45, 'utf-8'); ?></td>
<td><?php echo $row['phone']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo nl2br(CHtml::encode($row['comment']))?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>