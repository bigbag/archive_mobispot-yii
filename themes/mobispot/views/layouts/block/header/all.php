<header class="header-page">
    <?php if (Yii::app()->user->isGuest): ?>
        <div class="m-page-hat">
            <?php include('block/activ.php'); ?>
            <?php include('block/sign.php'); ?>
            <?php include('block/recovery.php'); ?>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="twelve">
            <div class="header-top">
                <?php
                    if ((Yii::app()->controller->action->id == 'index') 
                        && (Yii::app()->controller->id == 'product'))
                    {
                        $timer = 1000;
                    }
                    else
                    {
                        $timer = 10000;
                    }
                ?>
                <ul class="login-bar">
                    <?php if (!Yii::app()->user->isGuest): ?>
                    <li>
                        <a href="/user/personal">
                            <?php echo Yii::t('menu', 'To my spots') ?>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php if (isset(Yii::app()->controller->module) 
                        && (Yii::app()->controller->module->id == 'store')): ?>
                        <li ng-controller="UserController" 
                            ng-init="initTimer(<?php echo $timer; ?>)"
                            ng-show="itemsInCart > 0">
                            <a href="/store/product/cart">
                                <?php echo Yii::t('menu', 'Shopping bag') ?>({{itemsInCart}})
                            </a>
                        </li>
                    <?php elseif ($this->getCart()): ?>
                        <li><a href="/store/product/cart">
                                <?php echo Yii::t('menu', 'Shopping bag') ?>(<?php echo $this->getCart(); ?>)
                            </a>
                        </li>
                   
                    <?php endif; ?>
                 </ul>                    

                <div class="four columns">
                    <h1 class="logo">
                        <a href="/">
                            <img src="/themes/mobispot/images/logo.png" />
                        </a>
                    </h1>
                </div>
                <div class="eight columns">
                    <?php include('block/menu.php'); ?>
                </div>
            </div>
        </div>
    </div>
</header>