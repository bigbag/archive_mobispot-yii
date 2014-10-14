<?php $info = User::userInfo(); ?>
<header class="header-page" ng-init="host_type='desktop';">
    <div class="hat-bar content">
        <h1 class="logo">
            <a href="/">
                <img itemprop="logo" alt="Mobispot" src="/themes/mobispot/img/logo_x2.png">
            </a>
        </h1>
        <ul class="right">
            <li>
                <a class="show" href="/user/profile/">
                <?php echo Yii::t('general', 'My profile & Security') ?>
                <?php if ($info and !empty($info['name'])):?> (<?php echo $info['name']?>)<?php endif;?>
                </a>
            </li>
            <li>
                <a class="show" href="/service/logout/">
                <?php echo Yii::t('general', 'Sign Out') ?>
                </a>
            </li>
        </ul>
    </div>
    <div id="message" class="show-block b-message" ng-class="{active: (modal=='message')}">
        <p>{{result.message}}
        </p>
    </div>
    <div id="b-dialog" class="show-block b-message"> 
    <?php // <!-- .alert (bg grey), .negative (bg red) --> ?>
            <p>
            </p>
                    
            <form class="custom">
                <footer class="form-footer">
                    <a class="form-button yes-button">Yes</a>
                    <a class="form-button no-button">No</a>
                </footer>
            </form>
    </div>
</header>
