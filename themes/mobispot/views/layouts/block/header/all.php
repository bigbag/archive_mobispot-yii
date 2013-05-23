<header class="header-page">
  <?php if (Yii::app()->user->isGuest): ?>
  <div class="m-page-hat">
    <?php include('block/activ.php');?>
    <?php include('block/sign.php');?>
    <?php include('block/recovery.php');?>
  </div>
  <?php endif; ?>
  <div class="row row__head-slider">
    <div class="twelve">
      <div class="header-top">
        <?php if (!Yii::app()->user->isGuest): ?>
          <ul class="login-bar">
            <li><a href="/user/personal"><?php echo Yii::t('menu', 'To my spots')?></a></li>
            <?php if(isset(Yii::app()->controller->module) && (Yii::app()->controller->module->id =='store')): ?>
              <li ng-controller="UserCtrl" ng-init="initTimer(<?php if((Yii::app()->controller->action->id=='index') && (Yii::app()->controller->id == 'product')) echo '1000'; else echo '10000';?>)" ng-show="itemsInCart > 0"><a href="/store/product/cart">Shopping bag({{itemsInCart}})</a></li>
            <?php elseif($this->getCart()): ?>
            <li><a href="/store/product/cart"><?php echo Yii::t('menu', 'Shopping bag')?>(<?php echo $this->getCart(); ?>)</a></li>
            <?php endif; ?>
          </ul>
        <?php elseif(isset(Yii::app()->controller->module) && (Yii::app()->controller->module->id =='store')): ?>
          <ul class="login-bar">
            <li ng-controller="UserCtrl" ng-init="initTimer(<?php if((Yii::app()->controller->action->id=='index') && (Yii::app()->controller->id == 'product')) echo '1000'; else echo '10000';?>)"><a href="/store/product/cart" ng-show="itemsInCart > 0">Shopping bag({{itemsInCart}})</a></li>
          </ul>
        <?php elseif($this->getCart()): ?>
          <ul class="login-bar">
            <li><a href="/store/product/cart"><?php echo Yii::t('menu', 'Shopping bag')?>(<?php echo $this->getCart(); ?>)</a></li>
          </ul>
        <?php endif; ?>

        <div class="four columns">
            <h1 class="logo"><a href="/"><img src="/themes/mobispot/images/logo.png" /></a></h1>
        </div>
        <div class="eight columns">
          <?php include('block/menu.php');?>
        </div>
      </div>
    </div>
  </div>
</header>