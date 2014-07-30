<div class="wrapper" ng-controller="UserController" ng-init="user.token='<?php echo Yii::app()->request->csrfToken; ?>';host_type='mobile'">
    <header>
        <ul class="lang">
            <li><a class="<?php echo ('ru' == Yii::app()->language)?'active':'' ?>" href="/service/lang/ru">RU</a></li>
            <li><a class="<?php echo ('en' == Yii::app()->language)?'active':'' ?>" href="/service/lang/en">ENG</a></li>
            <li><a class="<?php echo ('zh_cn' == Yii::app()->language)?'active':'' ?>" href="/service/lang/zh_cn">中文简体</a></li>
            <li><a class="<?php echo ('zh_tw' == Yii::app()->language)?'active':'' ?>" href="/service/lang/zh_tw">中文繁體</a></li>
        </ul>
        <h1><a href="/"><img width="140" src="/themes/mobispot/img/logo_x2.png"></a></h1>
        <a class="full-size" href="<?php echo MHttp::desktopHost()?>"><i class="icon">&#xf108;</i><?php echo Yii::t('spot', 'Full size version'); ?></a>
    </header>
    <section class="content author tabs">
            <article>
                <form name="recoveryForm">
                    <label for="forgotPass" >
                        <?php echo Yii::t('user', 'Forgot password?'); ?>
                    </label>
                    <input style="margin-top:20px;"
                        name='email'
                        type="text"
                        ng-model="user.email"
                        placeholder="<?php echo Yii::t('user', 'E-mail') ?>"
                        ng-keypress="($event.keyCode == 13)?recovery(user, recoveryForm.$valid):''"
                        autocomplete="off"
                        maxlength="300"
                        ng-class="{error: error.email}"
                        ng-pattern="/@+/"
                        required >
                    <a class="form-button" ng-click="recovery(user, recoveryForm.$valid)"><?php echo Yii::t('user', 'Send'); ?></a>
                </form>
            </article>
    </section>
    <div class="fc"></div>
</div>
