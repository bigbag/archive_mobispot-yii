<div id="recovery_modal" class="reveal-modal" ng-controller="UserController" ng-init="rUser.token='<?php echo Yii::app()->request->csrfToken?>'">
    <div class="cont-pop">
        <a class="close-reveal-modal"><?php echo Yii::t('user', 'Закрыть')?></a>
        <form name="rForm">
            <div class="alert-box alert messages" style="display: none;">
                <?php echo Yii::t("user", "Hа сайте не зарегистрирован пользователь с таким Email.")?>
            </div>

            <p>
                    <?php echo Yii::t('user', 'Если Вы забыли свой пароль и хотите его восстановить,<br /> введите адрес электронной почты,<br /> который Вы использовали при регистрации.')?>
            </p>
            <div class="row">
                <div class="seven columns centered">
                        <input type="email"  autocomplete="off" ng-model="rUser.email" name="email" value="" placeholder="E-mail" autocomplete="off" required />
                </div>
            </div>
            <div class="send">
                <button class="m-button" ng-click="recovery(rUser)" ng-disabled="rForm.$invalid">
                        <?php echo Yii::t('user', 'Восстановить')?>
                </button>
            </div>
        </form>
    </div>
</div>

