<?php
#$this->pageTitle=Yii::t('user', 'Мобиспот. Восстановление пароля');
?>
<div id="changePassForm" class="row header-page recovery m-content-form" ng-controller="UserCtrl" >
    <div class="five columns centered">
        <h3><?php echo Yii::t('user', 'Password recovery') ?></h3>
        <form id="change-pass" name="changeForm" ng-init="user.email='<?php echo $email; ?>'; user.activkey='<?php echo $activkey; ?>'">
            <input
                name="password"
                type="password"
                ng-model="user.password"
                placeholder="<?php echo Yii::t('user', 'Password') ?>"
                autocomplete="off"
                maxlength="300"
                required >
            <input
                name="confirmPassword"
                type="password"
                ng-model="user.confirmPassword"
                placeholder="<?php echo Yii::t('user', 'Confirm password') ?>"
                autocomplete="off"
                maxlength="300"
                required >

            <div class="form-control">
                <a class="spot-button button-disable" href="javascript:;"  ng-click="change(user, changeForm.$valid)">
                    <?php echo Yii::t('user', 'Send') ?>
                </a>
            </div>
        </form>
    </div>
</div>