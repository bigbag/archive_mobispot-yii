<!DOCTYPE html>
<html ng-app="mobispot">
    <head>
        <meta charset="utf-8">
            <title><?php echo Yii::app()->params['siteTitle']; ?></title>

            <link rel="stylesheet" href="/themes/mobispot/css/style_mobile.min.css">

            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <script src="/themes/mobispot/js/jquery.min.js"></script>
            <script src="/themes/mobispot/js/angular.min.js"></script>
    </head>
    <body>

        <?php echo $content; ?>

        <footer id="footer">
            <a href="/readers"><?php echo Yii::t('phone', 'Device compatibility'); ?></a><a href="mailto:helpme@mobispot.com"><?php echo Yii::t('user', 'Email us'); ?></a>
        </footer>
        <div class="m-result">
            <p></p>
        </div>
        <script src="/themes/mobispot/js/jquery-ui.min.js"></script>
        <script src="/themes/mobispot/angular/app.min.js"></script>
        <?php echo $this->blockFooterScript; ?>
        <script src="/themes/mobispot/js/script_mobile.min.js"></script>
        
    <div id="dialog-confirm" style="display:none" title="<?php echo Yii::t('spot', 'Подтвердите действие'); ?>">
      <p><span id="dialog-question"></span></p>
    </div>
    </body>
</html>
