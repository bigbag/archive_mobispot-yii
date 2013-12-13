<?php
$this->pageTitle = Yii::t('corp_general', 'Мобиспот. Корпоративные сервисы').' - '.
Yii::t('corp_general', 'Помощь');
?>
<div class="row">
  <div class="large-12 columns singlebox-margin">
    <div ng-controller="HelpController" ng-init="user.token='<?php echo Yii::app()->request->csrfToken?>'">
      <div class="row">
        <div class="large-6 columns">
          <h4 class="color two-line"><?php echo Yii::t('corp_help', 'У вас есть вопрос?  Нужна помощь?<br /> Свяжитесь с нами.');?></h4>
          <form id="help-in" name="helpForm">
            <input
              name='name'
              type="text"
              ng-model="user.name"
              placeholder="<?php echo Yii::t('corp_help', 'Имя');?> *"
              maxlength="300"
              ng-minlength="3"
              required >
            <input
              name='phone'
              type="text"
              ng-model="user.phone"
              placeholder="<?php echo Yii::t('corp_help', 'Телефон');?>">
            <input
              name='email'
              type="email"
              ng-model="user.email"
              placeholder="<?php echo Yii::t('corp_help', 'Email');?> *"
              maxlength="300"
              ng-minlength="3"
              required >
            <textarea
              name="question"
              ng-model="user.question"
              style="height: 100px;"
              placeholder="<?php echo Yii::t('corp_help', 'Сообщение');?> *"
              ng-minlength="3"
              required >
            </textarea>
            <div class="form-control">
              <a class="spot-button button-disable" href="javascript:;" ng-click="send(user, helpForm.$valid)">
                <?php echo Yii::t('corp_help', 'Отправить');?>
              </a>
            </div>
          </form>
        </div>
      <div class="large-6 columns">
        <h4 class="color two-line"><?php echo Yii::t('corp_help', 'Реквизиты компании');?></h4>
        <ul class="contact-info">
          <li>Индивидуальный предприниматель Волгин Владимир Юрьевич</li>
          <li><?php echo Yii::t('corp_help', 'ИНН');?> – 772776490647</li>
          <li><?php echo Yii::t('corp_help', 'ОГРН');?> – 313774605900481</li>
          <li>Юридический адрес - г. Москва, ул. Новочеремушкинская, 53 корп. 4</li>
          <li><?php echo Yii::t('corp_help', 'Адрес электронной почты');?> – <a href="mailto:sales@mobispot.com">sales@mobispot.com</a></li>
        </ul>
      </div>
    </div>
    </div>
  </div>
</div>