<div class="row" >
  <div class="large-12 columns singlebox-margin">
    <div class="row">
      <div class="large-12 column spot-desc">
        <h3>Уважаемые пользователи!</h3>
        <h5>Мы рады представить вам новый, полностью переработанный личный кабинет!</h5>
        <h6>Что нового?<br/>
        Теперь все функции «Мобиспот» объединены в едином удобном интерфейсе
        по адресу <a href="http://mobispot.com/spot/list">www.mobispot.com</a>.<br/>
        Больше нет нужды в постоянном пополнении счета.<br/>
        Все что требуется - это привязать банковскую карту к вашему споту с
        помощью сервиса Яндекс.Деньги.<br/>
        Все платежи, сделанные вашей кампусной картой, будут автоматически
        списываться с привязанной банковской карты.</h6>
        <h5><a href="http://mobispot.com/spot/list">Быстро, удобно и безопасно. Попробуйте прямо сейчас!</a></h5>
      </div>
    </div>
    <div class="row">
      <div id="wallets" class="large-12 columns">
          <div class="large-12 column">
            <ul class="spot-list">
            <?php foreach ($wallets as $wallet):?>
              <li id="<?php echo $wallet->id;?>"
                class="spot-content_li bg-gray">
                <div class="spot-hat" ng-click="accordion($event, payment)">
                  <h3><?php echo $wallet->name?></h3>
                </div>
              </li>
            <?php endforeach;?>
            </ul>
          </div>
      </div>
    </div>
  </div>
</div>
