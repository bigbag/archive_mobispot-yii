<?php $this->pageTitle = Yii::t('user', 'Password change'); ?>
<?php $this->mainBackground = 'skulls.png'?>

<div class="content-wrapper">
    <div class="content-block single-block">
        <div class="row">
            <div class="large-12 columns">
                 <form name="changeForm" class="custom">
                    <h3 class="single-form-h">New password</h3>
                    <input
                        name="password"
                        type="text"
                        ng-model="user.password"
                        placeholder="<?php echo Yii::t('user', 'Password') ?>"
                        autocomplete="off"
                        ng-keypress="($event.keyCode == 13)?change(user, changeForm.$valid:''"
                        maxlength="300"
                        required >
                    <div class="form-item-buton">
                        <a class="form-button toggle-box"  ng-click="change(user, changeForm.$valid)">
                            <?php echo Yii::t('user', 'Send') ?>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
        