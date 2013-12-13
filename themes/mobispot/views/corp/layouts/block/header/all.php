<header class="header-page">
  <?php if (Yii::app()->user->isGuest): ?>
  <div class="m-page-hat">
    <?php include('block/activ.php');?>
    <?php include('block/sign.php');?>
    <?php include('block/recovery.php');?>
  </div>
  <?php endif; ?>

  <div class="row">
      <div class="twelve">
        <div class="header-top">
          <div class="large-4 columns">
            <h1 class="logo"><a href="/"><img src="/themes/mobispot/images/logo.png" /></a></h1>
          </div>
          <div class="large-8 columns">
            <ul class="nav-bar">
              <li>
                <a class="spot-button" href="https://mobispot.com/store/">
                    <?php echo Yii::t('corp_general', 'Магазин') ?>
                </a>
              </li>
              <?php if (Yii::app()->user->isGuest): ?>
              <li>
                <a id="actSpot" class="spot-button toggle-box opacity" href="#actSpotForm">
                  <?php echo Yii::t('corp_general', 'Зарегистрировать карту')?>
                </a>
              </li>
              <li>
                <a id="signIn" class="spot-button toggle-box opacity" href="#signInForm">
                  <?php echo Yii::t('corp_general', 'Войти')?>
                </a>
              </li>
              <?php else:?>
              <li>
                <a class="spot-button opacity" href="/wallet/">
                  <?php echo Yii::t('corp_general', 'Мои карты')?>
                </a>
              </li>
              <li>
                <a class="spot-button opacity" href="/service/logout/">
                  <?php echo Yii::t('corp_general', 'Выйти')?>
                </a>
              </li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
</header>
