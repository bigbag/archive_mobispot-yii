<div id="recovery_modal" class="reveal-modal" ng-controller="UserController" ng-init="user.token='<?php echo Yii::app()->request->csrfToken?>'">
    <div class="cont-pop">
        <a class="close-reveal-modal"><?php echo Yii::t('user', 'Закрыть')?></a>
        <form action="#" method="post" name="rform">
            <p>
                    <?php echo Yii::t('user', 'Если Вы забыли свой пароль и хотите его восстановить,<br /> введите адрес электронной почты,<br /> который Вы использовали при регистрации.')?>
            </p>
            <div class="row">
                <div class="seven columns centered">
                        <input type="email"  autocomplete="off" ng-model="user.email" name="email" value="" placeholder="E-mail" autocomplete="off" required />
                </div>
            </div>
            <div class="send">
                <button class="m-button" ng-click="recovery(user)" ng-disabled="rform.$invalid">
                        <?php echo Yii::t('user', 'Восстановить')?>
                </button>
            </div>
        </form>
    </div>
</div>
