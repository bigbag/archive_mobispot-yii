<?php $this->beginContent('//layouts/general'); ?>
<?php if (Yii::app()->user->isGuest): ?>
<?php include('block/_not_auth.php');?>
<?php else: ?>
<?php include('../site/block/_auth.php'); ?>
<?php endif; ?>
<?php $this->endContent(); ?>


