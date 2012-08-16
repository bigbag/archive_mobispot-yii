<?php
/* @var $this SpotController */
/* @var $model Spot */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('discodes_id')); ?>:</b>
	<?php echo CHtml::encode($data->discodes_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('spot_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->spot_type_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('spot_hard_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->spot_hard_type_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('spot_hard')); ?>:</b>
	<?php echo CHtml::encode($data->spot_hard); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('nfc')); ?>:</b>
	<?php echo CHtml::encode($data->nfc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('generated_date')); ?>:</b>
	<?php echo CHtml::encode($data->generated_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('registerered_date')); ?>:</b>
	<?php echo CHtml::encode($data->registerered_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('removed_date')); ?>:</b>
	<?php echo CHtml::encode($data->removed_date); ?>
	<br />

	*/ ?>

</div>