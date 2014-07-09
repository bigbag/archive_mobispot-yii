<div class="wrapper"
    ng-controller="SpotController"
    ng-init=
        "spot.token='<?php echo Yii::app()->request->csrfToken; ?>';
        user.token='<?php echo Yii::app()->request->csrfToken; ?>';
        general.views='<?php echo $curent_views;?>';
        spot.discodes='<?php echo $spot->discodes_id;?>';
        general.host_mobile=1;
        spot.status=<?php echo $spot->status; ?>
        "
>
        <div id="menu" class="main-menu" ng-init="getSocPatterns()">
            <ul>
                <li><a href="/spot/addSpot"><i>+</i><?php echo Yii::t('user', 'Add New Spot'); ?></a></li>
                <li><a href="/user/profile/"><i class="icon">&#xe60f;</i><?php echo Yii::t('user', 'Profile'); ?></a></li>
                <li><a href="/service/logout/"><i class="icon">&#xe610;</i><?php echo Yii::t('user', 'Log Out'); ?></a></li>
            </ul>
        </div>
        <header>
            <h1><a href="/"><img width="140" src="/themes/mobispot/img/logo_x2.png"></a></h1>
            <a class="full-size" href="<?php echo MHttp::desktopHost()?>"><i class="icon">&#xf108;</i><?php echo Yii::t('spot', 'Full size version'); ?></a>
        </header>
        <div class="control">
                <a href="/spot/list" class="back icon">&#xe602;</a>
                <h4 class="spot-h"><i><img src="<?php echo MHttp::desktopHost();?>/uploads/products/<?php echo $spot->hard->image;?>"></i><?php echo mb_substr($spot->name, 0, 50, 'utf-8') ?></h4>
                <a id="show-menu" class="right"><i class="icon">&#xe611;</i></a>
            </div>
            <section class="content tabs spot">
            <nav>
                <a
                    ng-class="{active: general.views=='spot'}"
                    ng-click="general.views='spot'"
                >
                    <?php echo Yii::t('spot', 'Social links'); ?>
                </a>
                
                <a
                    ng-class="{active: general.views=='wallet'}"
                    ng-click="general.views='wallet'"
                >
                    <?php echo Yii::t('spot', 'Wallet'); ?>
                </a>
                <a
                    ng-class="{active: general.views=='coupon'}"
                    ng-click="general.views='coupon'" >
                    <?php echo Yii::t('spot', 'Coupon'); ?>
                </a>
                <a
                    ng-class="{active: general.views=='settings'}"
                    ng-click="general.views='settings'"
                    class="settings">
                    <i class="icon">&#xe00F;</i>
                </a>
            </nav>
            <section class="author-block" id="spot-block">
            </section>
        </section>
        <div class="fc"></div>
    </div>
    <?php //include(Yii::getPathOfAlias('webroot') . '/themes/mobispot/views/layouts/block/soc-widget.php');
    ?>