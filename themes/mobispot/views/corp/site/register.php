<div class="row">
  <div class="eight columns centered">
    <div class="singlebox-margin">
      <div class="row">
        <div class="twelve columns">
        <h3 class="color text-center"><?php echo Yii::t('corp', 'Я хочу:');?></h3>
        <ul class="form-list">
          <li id="self" class="toggle-box onlyOpen">
          <a href="javascript:;" class="radio-link choice" ng-click="setAction('connection', $event)">
            <i class="large"></i>
            <?php echo Yii::t('corp', 'Установить Корпоративные сервисы для собственных нужд');?>
          </a>
          <div class="corp-register-form hide">
              <form name="selfForm">
                <input
                  type="text"
                  ng-model="self.name"
                  placeholder="<?php echo Yii::t('corp', 'Название компании');?> *"
                  ng-minlength="2"
                  maxlength="300"
                  required >
                <input
                  type="text"
                  ng-model="self.person"
                  placeholder="<?php echo Yii::t('corp', 'Контактное лицо');?> *"
                  ng-minlength="2"
                  maxlength="500"
                  required >
                <input
                  type="email"
                  ng-model="self.email"
                  placeholder="<?php echo Yii::t('corp', 'E-mail');?> *"
                  ng-minlength="2"
                  maxlength="500"
                  required >
                <input
                  type="text"
                  ng-pattern="/[0-9]+/"
                  ng-model="application.count"
                  placeholder="<?php echo Yii::t('corp', 'Количество сотрудников');?> *"
                  maxlength="10"
                  required >
                <textarea
                  type="text"
                  ng-model="self.address"
                  placeholder="<?php echo Yii::t('corp', 'Адрес размещения оборудования');?> *"
                  ng-minlength="2"
                  maxlength="500"
                  required >
                </textarea>
                <input
                  type="text"
                  ng-model="self.url"
                  placeholder="<?php echo Yii::t('corp', 'Веб-сайт компании');?>"
                  ng-minlength="2"
                  maxlength="500" >
              </form>
            </div>
          </li>
          <li id="rent" class="toggle-box onlyOpen">
            <a href="javascript:;" class="radio-link choice" ng-click="setAction('rent', $event)">
              <i class="large"></i>
              <?php echo Yii::t('corp', 'Установить Корпоративные сервисы для оказания услуг сторонним компаниям');?>
            </a>
            <div class="corp-register-form hide">
              <form name="rentForm">
                <input
                  type="text"
                  ng-model="rent.name"
                  placeholder="<?php echo Yii::t('corp', 'Название компании');?> *"
                  ng-minlength="2"
                  maxlength="300"
                  required >
                <input
                  type="text"
                  ng-model="rent.person"
                  placeholder="<?php echo Yii::t('corp', 'Контактное лицо');?> *"
                  ng-minlength="2"
                  maxlength="500"
                  required >
                <input
                  type="email"
                  ng-model="rent.email"
                  placeholder="<?php echo Yii::t('corp', 'Email');?> *"
                  ng-minlength="2"
                  maxlength="500"
                  required >
                <textarea
                  type="text"
                  ng-model="rent.address"
                  placeholder="<?php echo Yii::t('corp', 'Адрес размещения оборудования');?> *"
                  ng-minlength="2"
                  maxlength="500"
                  required >
                </textarea>
                <input
                  type="text"
                  ng-model="rent.url"
                  placeholder="<?php echo Yii::t('corp', 'Веб-сайт компании');?>"
                  ng-minlength="2"
                  maxlength="500" >
              </form>
            </div>
          </li>
          <li id="connection" class="toggle-box onlyOpen">
            <a href="javascript:;" class="radio-link choice"  ng-click="setAction('connection', $event)">
              <i class="large"></i>
              <?php echo Yii::t('corp', 'Подключиться к уже установленному оборудованию');?>
            </a>
            <div class="corp-register-form hide">
              <form name="connectionForm">
                <input
                  type="text"
                  ng-model="connection.name"
                  placeholder="<?php echo Yii::t('corp', 'Название компании');?> *"
                  ng-minlength="2"
                  maxlength="300"
                  required >
                <input
                  type="text"
                  ng-model="connection.person"
                  placeholder="<?php echo Yii::t('corp', 'Контактное лицо');?> *"
                  ng-minlength="2"
                  maxlength="500"
                  required >
                <input
                  type="email"
                  ng-model="connection.email"
                  placeholder="<?php echo Yii::t('corp', 'Email');?> *"
                  ng-minlength="2"
                  maxlength="500"
                  required >
                <input
                  type="text"
                  ng-pattern="/[0-9]+/"
                  ng-model="connection.count"
                  placeholder="<?php echo Yii::t('corp', 'Количество сотрудников');?> *"
                  maxlength="10"
                  required >
                <p>
                  <?php echo Yii::t('corp', 'connect desc');?>

                </p>
                <input
                  type="text"
                  ng-model="connection.parentName"
                  placeholder="<?php echo Yii::t('corp', 'Название компании-владельца оборудования');?>"
                  ng-minlength="2"
                  maxlength="500" >
                <textarea
                  type="text"
                  ng-model="connection.address"
                  placeholder="<?php echo Yii::t('corp', 'Адрес размещения оборудования');?>"
                  ng-minlength="2"
                  maxlength="500"  >
                </textarea>
                <input
                  type="text"
                  ng-model="application.url"
                  placeholder="<?php echo Yii::t('corp', 'Домен владельца оборудования на mobispot.com');?>"
                  ng-minlength="2"
                  maxlength="500" >
              </form>
            </div>
          </li>
        </ul>
        </div>
      </div>
      <div class="row">
        <div class="large-12 columns text-center toggle-active">
          <br />
          <br />
          <a href="javascript:;" class="go-button button round" ng-click="corpRegister()">
            <?php echo Yii::t('corp', 'Отправить');?>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>