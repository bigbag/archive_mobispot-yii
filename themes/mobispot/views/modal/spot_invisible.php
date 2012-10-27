<div id="spot_invisible_modal" class="reveal-modal">
    <div class="cont-pop">
        <a class="close-reveal-modal"><?php echo Yii::t('account', 'Закрыть')?></a>

        <form name="invisibleForm" ng-init="discodes=discodes">
            <p>
                <?php if ($spot->status != 6): ?>
                    <?php echo Yii::t('account', 'Данное действие приведет к тому, что информация в Вашем споте не будет видима никому.<br /> При попытке сканирования пользователи будут попадать на главную страницу сайта. ')?>
                <?php else: ?>
                    <?php echo Yii::t('account', 'Данное действие приведет к тому,<br /> что информация в Вашем споте опять станет видимой для всех. ')?>
                <?php endif; ?>
            </p>
            <button class="m-button" ng-click="invisible()">
                <?php echo Yii::t('account', 'Продолжить')?>
            </button>
        </form>
    </div>
</div>
