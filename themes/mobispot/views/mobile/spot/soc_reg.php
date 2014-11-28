<div class="wrapper" ng-controller="UserController" ng-init="user.token='<?php echo Yii::app()->request->csrfToken; ?>'">
    <header>
        <ul class="lang">
            <li><a class="<?php echo ('ru' == Yii::app()->language)?'active':'' ?>" href="/service/lang/ru">RU</a></li>
            <li><a class="<?php echo ('en' == Yii::app()->language)?'active':'' ?>" href="/service/lang/en">ENG</a></li>
            <!-- <li><a class="<?php //echo ('zh_cn' == Yii::app()->language)?'active':'' ?>" href="/service/lang/zh_cn">中文简体</a></li> -->
            <!-- <li><a class="<?php //echo ('zh_tw' == Yii::app()->language)?'active':'' ?>" href="/service/lang/zh_tw">中文繁體</a></li> -->
        </ul>
        <h1><a href="/"><img width="140" src="/themes/mobispot/img/logo_x2.png"></a></h1>
        <a class="full-size" href="/service/setFullView"><i class="icon">&#xf108;</i><?php echo Yii::t('spot', 'Full size version'); ?></a>
    </header>
    
    <section class="content author tabs">
        <form name="activForm">
                 <input
                    name='email'
                    type="email"
                    ng-init="user.email='<?php echo (isset($info['email']))?$info['email']:''; ?>'"
                    ng-model="user.email"
                    placeholder="<?php echo Yii::t('user', 'E-mail') ?>"
                    ng-keypress="($event.keyCode == 13)?activation(user, activForm.$valid):''"
                    autocomplete="off"
                    maxlength="300"
                    ng-class="{error: error.email}"
                    required >

                <input name='password'
                    type="password"
                    ng-model="user.password"
                    ng-keypress="($event.keyCode == 13)?activation(user, activForm.$valid):''"
                    placeholder="<?php echo Yii::t('user', 'Password') ?>"
                    autocomplete="off"
                    maxlength="300"
                    required >

                <input
                    name='code'
                    type="text"
                    ng-model="user.activ_code"
                    ng-keypress="($event.keyCode == 13)?activation(user, activForm.$valid):''"
                    placeholder="<?php echo Yii::t('user', 'Spot activation code') ?>"
                    autocomplete="off"
                    maxlength="10"
                    ng-minlength="10";
                    ng-maxlength="10"
                    ng-class="{error: error.code}"
                    required >

            <div class="checkbox">
            <input
                id="formReg_agree"
                type="checkbox"
                name="formReg_agree"
                ng-model="user.terms"
                ng-true-value="1"
                ng-false-value="0">
                <label for="formReg_agree"><?php echo Yii::t('user', 'I agree to Terms and Conditions'); ?></label>
            </div>

                <a class="left form-button"
                    ng-click="activation(user, activForm.$valid)"
                    href="javascript:;">
                    <?php echo Yii::t('user', 'Activate spot'); ?>
                </a>

        </form>
    </section>
    <div class="fc"></div>
</div>
