<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="ru"/>

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css"
          media="screen, projection"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css"
          media="print"/>
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css"
          media="screen, projection"/>
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css"/>

    <title><?php echo Yii::app()->params['siteTitle']; ?> - <?php echo CHtml::encode($this->pageTitle); ?></title>
  </head>
  <body>
    <?php
    Yii::app()->getClientScript()->registerCoreScript('jquery.ui');

    Yii::app()->clientScript->registerCssFile(
            Yii::app()->clientScript->getCoreScriptUrl() .
            '/jui/css/base/jquery-ui.css'
    )
    ?>

    <div class="container" id="page">

      <div id="header">
        <div id="logo"><?php echo CHtml::encode(Yii::app()->params['siteTitle']); ?></div>
        <div><?php echo Yii::app()->params['siteTitle']; ?></div>
      </div>
      <!-- header -->

      <div id="mainmenu">
        <?php
        $this->widget('zii.widgets.CMenu', array(
            'items' => array(
                array('label' => 'Главная', 'url' => array('/site/index')),
                array('label' => 'Карты', 'url' => array('/site/map')),
                array('label' => 'Геокодинг', 'url' => array('/site/geo')),
                array('label' => 'Обратная связь', 'url' => array('/site/contact')),
                array('label' => 'Страницы', 'url' => array('/page/list')),
                array('label' => 'Админка', 'url' => array('/admin/'), 'visible' => !Yii::app()->user->isGuest),
                array('label' => 'Войти', 'url' => array('/user/login'), 'visible' => Yii::app()->user->isGuest),
                array('label' => 'Выйти (' . Yii::app()->user->name . ')', 'url' => array('/user/logout'), 'visible' => !Yii::app()->user->isGuest)
            ),
        ));
        ?>
      </div>
      <!-- mainmenu -->
      <?php if (isset($this->breadcrumbs)): ?>
        <?php
        $this->widget('zii.widgets.CBreadcrumbs', array(
            'links' => $this->breadcrumbs,
        ));
        ?><!-- breadcrumbs -->
      <?php endif ?>

      <?php echo $content; ?>

      <div class="clear"></div>

      <div id="footer"><?php echo Yii::app()->params['copyright']; ?></div>

    </div>
    <!-- page -->

  </body>
</html>
