<head>
    <meta charset="utf-8"/>

    <!-- Set the viewport width to device width for mobile -->
    <meta name="viewport" content="width=device-width"/>

    <title><?php echo Yii::app()->par->load('siteTitle'); ?></title>
    <link rel="icon" type="image/png" href="/themes/mobispot/images/favicon.ico"/>

    <?php Yii::app()->getClientScript()->registerCssFile('/themes/mobispot/stylesheets/foundation.min.css'); ?>
    <?php Yii::app()->getClientScript()->registerCssFile('/themes/mobispot/stylesheets/font-awesome.css'); ?>
    <?php Yii::app()->getClientScript()->registerCssFile('/themes/mobispot/stylesheets/select2.css'); ?>
    <?php Yii::app()->getClientScript()->registerCssFile('/themes/mobispot/stylesheets/app.css'); ?>

    <?php Yii::app()->getClientScript()->registerCoreScript('jquery');?>

    <?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/javascripts/foundation/foundation.min.js'); ?>
    <?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/javascripts/foundation/modernizr.foundation.js'); ?>
    <?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/javascripts/foundation/jquery.foundation.reveal.js'); ?>
    <?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/javascripts/foundation/jquery.foundation.alerts.js'); ?>

    <?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/javascripts/angular/angular.min.js'); ?>
    <?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/javascripts/angular/angular-resource.min.js'); ?>
    <?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/javascripts/select2/select2.min.js'); ?>
    <?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/javascripts/jquery/jquery.form.min.js'); ?>
    <?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/javascripts/jquery/jquery.redirect.min.js'); ?>
    <?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/javascripts/jquery/jquery.placeholder.js'); ?>


    <!-- IE Fix for HTML5 Tags -->
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
     <script>
        $(document).ready(function() { $("select").select2({
            'width':'element',
            'minimumResultsForSearch': 100,
        }); });

        jQuery('input[placeholder], textarea[placeholder]').placeholder();

        $(document).foundationAlerts();
    </script>
</head>
