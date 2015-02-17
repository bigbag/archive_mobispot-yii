<?php $this->pageTitle = Yii::t('user', 'Register spot'); ?>
<?php $this->mainBackground = 'skulls.png'?>

<div class="content-wrapper">
    <div class="content-block single-block">
       <div class="form-block">
            <form class="colum-form custom" name="activForm">
                <div class="wrapper check">
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
                </div>
                <div class="wrapper">
                    <input name='password'
                        type="password"
                        ng-model="user.password"
                        ng-keypress="($event.keyCode == 13)?activation(user, activForm.$valid):''"
                        placeholder="<?php echo Yii::t('user', 'Password') ?>"
                        autocomplete="off"
                        maxlength="300"
                        required >
                </div>
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
                <footer class="form-footer">
                    <a class="left form-button"
                        ng-click="activation(user, activForm.$valid)"
                        href="javascript:;">
                        <?php echo Yii::t('user', 'Registration'); ?>
                    </a>
                </footer>
            </form>
        </div>
    </div>
</div>
