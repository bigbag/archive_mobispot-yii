<!DOCTYPE html>
<html ng-app="mobispot">
    <head>
        <meta charset="utf-8">
            <title><?php echo Yii::app()->params['siteTitle']; ?></title>
            <link rel="stylesheet" href="/themes/mobile/stylesheets/m-style.css">
            <link rel="stylesheet" href="/themes/mobile/stylesheets/add.css">

            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/js/jquery.min.js'); ?>
            <?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/js/angular.min.js'); ?>
            <script src="/themes/mobile/js/script-ck.js"></script>
            <script src="/themes/mobile/js/script.js"></script>
    </head>
    <body>

        <?php echo $content; ?>

        <footer id="footer">
            <a href="/readers"><?php echo Yii::t('user', 'Device compatibility'); ?></a> <a href="/help"><?php echo Yii::t('user', 'Get Help'); ?></a> <a href="mailto:helpme@mobispot.com"><?php echo Yii::t('user', 'Email us'); ?></a>
        </footer>
        <div class="m-result">
            <p></p>
        </div>
        <?php include('block/script/mobile.php'); ?>
    </body>
</html>
