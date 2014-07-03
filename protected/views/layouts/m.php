<!DOCTYPE html>
<html ng-app="mobispot">
    <head>
        <meta charset="utf-8">
            <title><?php echo Yii::app()->params['siteTitle']; ?></title>
            <link rel="stylesheet" href="/themes/mobile/stylesheets/m-style.css">
            <link rel="stylesheet" href="/themes/mobile/stylesheets/add.css">
            
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <?php Yii::app()->getClientScript()->registerScriptFile('http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js'); ?>
            <?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobile/js/script-ck.js'); ?>
            <?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobile/js/script.js'); ?>
            <?php Yii::app()->getClientScript()->registerScriptFile('http://ajax.googleapis.com/ajax/libs/angularjs/1.1.5/angular.min.js'); ?>
            <?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobile/angular/app/app.js'); ?>
            <?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobile/angular/app/controllers/user.js'); ?>
            <?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobile/angular/app/controllers/spot.js'); ?>
            <?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/angular/app/service.js'); ?>
    </head>
    <body>
        
        <?php echo $content; ?>
        
        <footer id="footer">
            <a href="http://mobispot.com/readers">Device compatibility</a> <a href="http://mobispot.com/help">Get Help</a> <a href="#">Email us</a> 
        </footer>
        <div class="m-result">
            <p></p>
        </div>
    </body>
</html>