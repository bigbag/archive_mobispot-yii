<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include('block/header.php');?>
<body>
<div id="wrapper">
    <div id="header">
        <?php include('block/menu.php');?>
    </div>
    <div id="errors"></div>
    <?php echo $content; ?>
</div>
<div class="center-rel">
    <?php include('block/footer.php');?>
</div>

<?php include('block/script.php');?>

<?php if (Yii::app()->user->isGuest): ?>
    <?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/js/eauth.js'); ?>
<script type="text/javascript">
    jQuery(function ($) {
        $(".auth-service.twitter a").eauth({"popup":{"width":900, "height":550}, "id":"twitter"});
        $(".auth-service.google_oauth a").eauth({"popup":{"width":500, "height":450}, "id":"google_oauth"});
        $(".auth-service.facebook a").eauth({"popup":{"width":585, "height":290}, "id":"facebook"});
    });
</script>

    <?php include('modal/recovery.php'); ?>
    <?php include('modal/login_captcha.php'); ?>
    <?php endif;?>
</body>
</html>