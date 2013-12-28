<div class="row" >
  <div class="large-12 columns singlebox-margin">
    <div class="row">
      <div class="large-12 column spot-desc">
        <p class="text-center">
          Здесь вы можете пополнить баланс кампусной карты "Мобиспот".<br />
          Кликните на название кампусной карты,
          чтобы сделать одиночное пополнение или привязать к ней банковскую карту.
        </p>
      </div>
    </div>
    <div class="row">
      <div id="wallets" class="large-12 columns">
          <div class="large-12 column">
            <div id="walletlistview" class="list-view">
              <ul class="spot-list">
              <?php foreach($wallets as $wallet): ?>
                <li id="<?php echo $wallet->id;?>" 
                  class="spot-content_li bg-gray <?php echo ($wallet->status==PaymentWallet::STATUS_ACTIVE)?'':'invisible-spot'?>">
                  <div class="spot-hat" 
                    ng-click="accordion($event, payment)">
                    <h3><?php echo $wallet->name?></h3>
                  <ul class="spot-hat-button">
                    <li>
                      <div>
                        <a data-tooltip title="<?php echo Yii::t('corp_wallet', 'Settings'); ?>" 
                          id="j-settings" 
                          class="tip-top icon-spot-button right text-center toggle-box icon" >
                          &#xe00f;
                        </a>
                      </div>
                    </li>
                  </ul>
                  </div>
                </li>
              <?php endforeach ;?>
              </ul>
            </div>
          </div>
      </div>
    </div>
    <div class="row">
      <div class="large-12 column text-center toggle-active">
        <a href="#actSpotForm" id="actSpot" class="add-spot toggle-box button round slideToThis">
          <i class="icon">&#xe015;</i>
          <span class="m-tooltip m-tooltip-open">
            <?php echo Yii::t('corp_wallet', 'Добавить карту')?>
          </span>
          <span class="m-tooltip m-tooltip-close">
            <?php echo Yii::t('corp_wallet', 'Закрыть')?>
          </span>
        </a>
      </div>
    </div>

    <div id="actSpotForm" class="slide-box add-spot-box">
      <div class="row popup-content">
        <div class="large-4 columns">
          &nbsp;
        </div>
        <div class="large-4 columns small-centered">
          <form id="add-spot" name="addSpotForm">
          <input type="text"
            ng-model="payment.code"
            name="code"
            placeholder="<?php echo Yii::t('corp_wallet', 'Код активации')?>"
            autocomplete="off"
            maxlength="10"
            required>
          <input type="text"
            name="name"
            ng-model="payment.name"
            placeholder="<?php echo Yii::t('corp_wallet', 'Название')?>"
            autocomplete="off">
          <div class="form-row toggle-active">
            <a class="checkbox agree"  ng-click="setTerms(payment)">
              <i></i>
              <?php echo Yii::t('corp_spot', 'Я согласен с условиями использования сервиса')?>
            </a>
          </div>
          <div class="form-control">
            <a class="spot-button button-disable"  ng-click="addWallet(payment)">
              <?php echo Yii::t('corp_spot', 'Добавить')?>
            </a>
          </div>
          </form>
        </div>
        <div class="large-4 columns">
          &nbsp;
        </div>
      </div>
    </div>
  </div>
</div>