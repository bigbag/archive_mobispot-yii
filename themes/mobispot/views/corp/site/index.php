<?php $this->pageTitle = Yii::t('general', 'Мобиспот. Кампусные решения'); ?>

<div class="content-slider">
  <div id="slider">
    <div class="text-center main-img">
      <div class="h-title">
        <h1><?php echo Yii::t('general', 'Плашка на картинке')?></h1>
        <p><?php echo Yii::t('general', 'Плашка на картинке, описание')?></p>
      </div>
      <div class="row">
        <div class="large-12 column">
            <ul class="main-list-menu">
              <li>
                <a>
                  <?php echo Yii::t('general', 'Меню 1')?>
                  <span><?php echo Yii::t('general', 'Меню 1, описание')?></span>
                </a>
              </li>
              <li>
                <a>
                  <?php echo Yii::t('general', 'Меню 2')?>
                  <span><?php echo Yii::t('general', 'Меню 2, описание')?></span>
                </a>
              </li>
              <li>
                <a>
                  <?php echo Yii::t('general', 'Меню 3')?>
                  <span><?php echo Yii::t('general', 'Меню 3, описание')?></span>
                </a>
              </li>
              <li>
                <a>
                  <?php echo Yii::t('general', 'Меню 4')?>
                  <span><?php echo Yii::t('general', 'Меню 4, описание')?></span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      <img src="/themes/mobispot/images/slider_corp.jpg" />
    </div>
  </div>
</div>
<div class="row spots-description">

  <div class="large-12 columns">
    <div class="description-img">
      <img src="/themes/mobispot/images/icons/i-spot.2x.png" height="115" />
    </div>
    <h3 class="color"><?php echo Yii::t('general', 'Кейс 1')?></h3>
    <p><?php echo Yii::t('general', 'Кейс 1, описание')?></p>
  </div>

  <div class="large-12 columns">
    <div class="description-img">
      <img src="/themes/mobispot/images/icons/i-cup.2x.png" height="115" />
    </div>
    <h3 class="color"><?php echo Yii::t('general', 'Кейс 2')?></h3>
    <p><?php echo Yii::t('general', 'Кейс 2, описание')?></p>
  </div>

  <div class="large-12 columns">
    <div class="description-img">
      <img src="/themes/mobispot/images/icons/i-plus.2x.png" height="115"  />
    </div>
    <h3 class="color"><?php echo Yii::t('general', 'Кейс 3')?></h3>
    <p><?php echo Yii::t('general', 'Кейс 3, описание')?> 
      <a class="color" href="/site/register"><?php echo Yii::t('general', 'Отправить заявку')?></a>.</p>
  </div>
</div>