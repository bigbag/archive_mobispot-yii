<div class="wrapper">
    <div id="menu" class="main-menu">
        <ul ng-controller="UserCtrl" ng-init="user.token='<?php echo Yii::app()->request->csrfToken; ?>'">
            <li><a href="/spot/addSpot"><i>+</i><?php echo Yii::t('user', 'Add New Spot'); ?></a></li>
            <li><a href="/user/profile/"><i class="icon">&#xe60f;</i><?php echo Yii::t('user', 'Profile'); ?></a></li>
            <li><a href="/service/logout/"><i class="icon">&#xe610;</i><?php echo Yii::t('user', 'Log Out'); ?></a></li>
            <li><a class="main-back" href="javascript:;"><i class="icon">&#xe603;</i></a></li>
        </ul>
    </div>
    <header>
        <h1><a href="/"><img width="140" src="/themes/mobispot/img/logo_x2.png"></a></h1>
        <a class="full-size" href="<?php echo MHttp::desktopHost()?>"><i class="icon">&#xf108;</i><?php echo Yii::t('spot', 'Full size version'); ?></a>
    </header>
    <div class="control">
            <h4><?php echo Yii::t('user', 'Spot List'); ?></h4>
            <a href="javascript:;" id="show-menu" class="right"><i class="icon">&#xe611;</i></a>
        </div>
    <section class="content">
        <ul class="spot-list">
        <?php foreach ($spots as $spot): ?>
            <li
                <?php if (Spot::STATUS_INVISIBLE == $spot->status):?>
                class="invisible"
                <?php endif; ?>
                onclick="document.location.href = '/spot/view/<?php echo $spot->url; ?>'"
            >
            <i class="icon i-invisible">&#xe60b;</i>
                <div class="spot-pic">
                    <img src="<?php echo MHttp::desktopHost();?>/uploads/products/<?php echo $spot->hard->image;?>">
                </div>
                <div class="spot-name">
                    <h3><?php echo mb_substr($spot->name, 0, 50, 'utf-8') ?></h3>
                    <span><?php echo $spot->code;?></span>
                </div>
            </li>
        <?php endforeach; ?>
        </ul>
            <a href="/spot/addSpot" class="add-button"><i class="icon">&#xe015;</i></a>
    </section>
    <div class="fc"></div>
</div>
