<?php $this->beginContent('//layouts/general'); ?>
<?php if (Yii::app()->user->isGuest): ?>
<? switch ($service_name) {
        case 'facebook':
            include('block/facebook.php');
            break;
        case 'google_oauth':
            include('block/google.php');
            break;
        case 'twitter':
            include('block/twitter.php');
            break;
        case 'occupied':
            include('block/occupied.php');
            break;
        default:
            include('../site/block/_not_auth.php');
            break;
    }
    ?>
<?php else: ?>
<?php include('../site/block/_auth.php'); ?>
<?php endif; ?>
<?php $this->endContent(); ?>


