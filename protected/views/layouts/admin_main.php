<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="/css/screen.css" media="screen, projection"/>
    <link rel="stylesheet" type="text/css" href="/themes/mobispot/css/lightbox.css" media="screen, projection"/>
    <link rel="stylesheet" type="text/css" href="/css/print.css" media="print"/>
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="/css/ie.css" media="screen, projection"/>
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css"/>
    <?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/js/jquery.form.min.js' ); ?>
    <?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/js/jquery.redirect.min.js'); ?>
    <?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/js/lightbox.js'); ?>

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div class="container" id="page">

    <div id="header">
        <div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
    </div>
    <!-- header -->

    <div id="mainMbMenu"><?php include('block_menu.php');?></div>
    <?php if (isset($this->breadcrumbs)): ?>
    <?php $this->widget('zii.widgets.CBreadcrumbs', array(
        'links' => $this->breadcrumbs,
    )); ?>
    <?php endif?>

    <?php echo $content; ?>

    <div class="clear"></div>

    <div id="footer"><?php echo Yii::app()->par->load('copyright'); ?></div>

</div>
</body>
</html>
