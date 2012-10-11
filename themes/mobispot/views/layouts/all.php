<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en" ng-app> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" lang="en" ng-app> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9" lang="en" ng-app> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en" ng-app> <!--<![endif]-->

<?php include('block/header.php');?>
<body>
<div class="wrapper">
    <div class="top-bar header">
        <div class="row">
            <?php include('block/menu.php');?>
        </div>
    </div>
    <div class="row">
        <div class="twelve columns content">
            <?php echo $content; ?>

        </div>

    </div>
    <div class="push"></div>
</div>
<div class="footer">
    <div class="footer-bar">
        <div class="row">
            <div class="twelve columns centered">
                <?php include('block/footer.php');?>
            </div>
        </div>
    </div>
</div>

<?php include('block/script.php');?>
<?php include('modal/messages.php'); ?>

<?php if (!isset(Yii::app()->user->id)): ?>
    <?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/js/eauth.min.js'); ?>
<script type="text/javascript">
    jQuery(function ($) {
        $("a.twitter").eauth({"popup":{"width":900, "height":550}, "id":"twitter"});
        $("a.google_oauth").eauth({"popup":{"width":500, "height":450}, "id":"google_oauth"});
        $("a.facebook").eauth({"popup":{"width":585, "height":290}, "id":"facebook"});
    });
</script>

    <?php include('modal/recovery.php'); ?>
    <?php include('modal/login_captcha.php'); ?>
    <?php endif;?>
</body>
</html>
