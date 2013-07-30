<header class="header-page">
    <div class="row">
        <div class="twelve">
            <div class="header-top">
                <div class="large-4 columns">
                    <h1 class="logo"><a href="/"><img src="/themes/mobispot/images/logo.png" /></a></h1>
                </div>
                <div class="large-8 columns user-menu">
                    <ul class="nav-bar right">
                        <li class="dropdown toggle-active">
                            <?php $userInfo = $this->userInfo() ?>
                            <a class="spot-button" href="#"><?php echo $userInfo->name; ?></a>
                            <ul class="options">
                                <li><a href="/user/profile"><?php echo Yii::t('account', 'My settings'); ?></a></li>
                                <li><a href="/service/logout/"><?php echo Yii::t('account', 'Logout'); ?></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>