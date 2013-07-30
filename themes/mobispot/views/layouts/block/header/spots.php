<header class="header-page">
    <div class="row">
        <div class="twelve">
            <div class="header-top">
                <div class="four columns">
                    <h1 class="logo"><a href="/"><img src="/themes/mobispot/images/logo-white.png" /></a></h1>
                </div>
                <div class="eight columns user-menu">
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
            <div class="bubbles-slider" ng-controller="UserCtrl" >
                <div class="personal-cover">
                  <!-- <img src="/themes/mobispot/images/personal-cover2.png" /> -->
                </div>
                <!--         <div class="dropdown-wrapper">
                          <div class="dropdown dropdown__light change-cover">
                            <a class="spot-button" href="javascript:;"><?php echo Yii::t('sign', 'Change cover'); ?></a>
                            <ul class="options">
                               <li><a href="javascript:;" ng-click="uploadCover()"><?php echo Yii::t('account', 'Upload new'); ?></a></li>
                              <li><a href="javascript:;" ng-click="removeCover()"><?php echo Yii::t('account', 'Remove'); ?></a></li>
                            </ul>
                          </div>
                        </div> -->

            </div>
        </div>
    </div>
</header>