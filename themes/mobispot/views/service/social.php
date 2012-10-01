<?php $this->beginContent('//layouts/general'); ?>
<?php if (Yii::app()->user->isGuest): ?>
    <?php switch($service):?>
        <?php case('twitter'):?>
            <?php include('block/_not_auth_with_email.php'); ?>
        <?php break;?>
        <?php default:?>
            <?php include('block/_not_auth_no_email.php'); ?>
        <?php break;?>
    <?php endswitch;?>
<?php else: ?>
<?php include('../site/block/_auth.php'); ?>
<?php endif; ?>
<?php $this->endContent(); ?>