<header class="header-page">
    <?php if (Yii::app()->user->isGuest): ?>
        <?php include('activ.php');?>
        <?php include('sign.php');?>
    <?php endif; ?>
  <div class="row row__head-slider">
    <div class="twelve">
        <div class="header-top">
            <?php if (!Yii::app()->user->isGuest): ?>
            <?php $userInfo=$this->userInfo()?>
            <ul class="login-bar">
                <li><a href="#"><?php echo $userInfo->name;?></a></li>
                <!-- <li><a href="#">Shopping bag (2)</a></li> -->
            </ul>
            <?php endif; ?>
          <div class="four columns">
            <h1 class="logo"><a href="/"><img src="/themes/mobispot/images/logo.png" /></a></h1>
          </div>
            <div class="eight columns">
                <ul class="nav-bar right">
                <?php if (Yii::app()->controller->id!='site' and Yii::app()->controller->action->id!='index'): ?>
                    <li>
                        <a class="spot-button" href="/pages/business"><?php echo Yii::t('general', 'Business')?></a>
                    </li>
                    <li>
                        <a class="spot-button" href="/pages/corporate"><?php echo Yii::t('general', 'Corporate')?></a>
                    </li>
                <?php endif; ?>
                    <li>
                        <a class="spot-button" href="http://store.mobispot.com"><?php echo Yii::t('general', 'Store')?></a>
                    </li>
                <?php if (Yii::app()->user->isGuest): ?>
                    <li>
                        <a id="actSpot" class="spot-button toggle-box" href="#actSpotForm"><?php echo Yii::t('general', 'Activate spot')?></a>
                    </li>
                    <li>
                        <a id="signIn" class="spot-button toggle-box" href="#signInForm"><?php echo Yii::t('general', 'Sign in')?></a>
                    </li>
                <?php else:?>
                    <li>
                        <a class="spot-button" href="/service/logout/"><?php echo Yii::t('general', 'Logout')?></a>
                    </li>
                <?php endif; ?>
                <?php foreach(Lang::getLang() as $row):?>
                    <?php if($row['name'] != Yii::app()->language):?>
                    <li>
                        <a class="spot-button" href="/service/lang/<?php echo $row['name']?>"><?php echo $row['desc']?></a>
                    </li>
                    <?php endif;?>
                <?php endforeach;?>
                </ul>
            </div>
        </div>
        <div class="bubbles-slider">
                  <div id="slider">
                    <?php if (Yii::app()->controller->id=='site' and Yii::app()->controller->action->id=='index'): ?>
                        <img src="/themes/mobispot/images/slider.jpg" />
                        <img src="/themes/mobispot/images/slider.jpg" />
                        <img src="/themes/mobispot/images/slider.jpg" />
                    <?php else:?>
                        <img src="/themes/mobispot/images/slider.jpg" />
                    <?php endif;?>
                  </div>
                  <div class="bubbles-content">
                        <a href="personal.html" class="bubble">
                            <h4>Personal</h4>
                            <p>Has millions of songs, from massive hits to rare gems to cult classic</p>
                            <b></b>
                        </a>
                        <a href="#" class="bubble">
                            <h4>Business</h4>
                            <p>Has millions of songs, from massive hits to rare gems to cult classic</p>
                            <b></b>
                        </a>
                        <a href="#" class="bubble">
                            <h4>Corporate</h4>
                            <p>Has millions of songs, from massive hits to rare gems to cult classic</p>
                            <b></b>
                        </a>
                  </div>
            </div>
        </div>
    </div>
</header>