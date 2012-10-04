<head>
    <meta charset="utf-8"/>

    <!-- Set the viewport width to device width for mobile -->
    <meta name="viewport" content="width=device-width"/>

    <title><?php echo Yii::app()->par->load('siteTitle'); ?></title>
    <link rel="icon" type="image/png" href="/themes/mobispot/images/favicon.ico"/>
    <?php Yii::app()->getClientScript()->registerCssFile('/themes/mobispot/stylesheets/foundation.min.css'); ?>
    <?php Yii::app()->getClientScript()->registerCssFile('/themes/mobispot/stylesheets/app.css'); ?>

    <?php Yii::app()->getClientScript()->registerCoreScript('jquery');?>
    <?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/js/plugin.js'); ?>
    <?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/javascripts/foundation.min.js'); ?>
    <?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/javascripts/modernizr.foundation.js'); ?>
    <?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/javascripts/app.js'); ?>
    <?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/js/jquery.form.min.js'); ?>

    <!-- IE Fix for HTML5 Tags -->
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
