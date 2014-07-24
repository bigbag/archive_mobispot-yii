<!DOCTYPE html>
<html ng-app="mobispot">
    <head>
        <meta charset="utf-8">
            <title><?php echo Yii::app()->params['siteTitle']; ?></title>
            <link rel="stylesheet" href="/themes/mobispot/css/mobile-style.css">
            <link rel="stylesheet" href="/themes/mobispot/css/mobile-add.css">

            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <script src="/themes/mobispot/js/jquery.min.js"></script>
            <script src="/themes/mobispot/js/angular.min.js"></script>
            <script src="/themes/mobispot/angular/modules/autofill-event.js"></script>
            <script src="/themes/mobispot/js/mobile/script-ck.js"></script>
            <script src="/themes/mobispot/js/mobile/script.js"></script>
    </head>
    <body>

        <?php echo $content; ?>

        <footer id="footer">
            <a href="/readers"><?php echo Yii::t('phone', 'Device compatibility'); ?></a> <a href="/help"><?php echo Yii::t('user', 'Get Help'); ?></a> <a href="mailto:helpme@mobispot.com"><?php echo Yii::t('user', 'Email us'); ?></a>
        </footer>
        <div class="m-result">
            <p></p>
        </div>
        <?php include('block/script/mobile.php'); ?>
    </body>
</html>