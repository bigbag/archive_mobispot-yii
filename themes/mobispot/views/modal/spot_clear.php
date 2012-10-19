<div id="spot_clear_modal" class="reveal-modal medium">
    <div class="cont-pop">
        <a class="close-reveal-modal"><?php echo Yii::t('account', 'Закрыть')?></a>
        <form name="clearForm" ng-init="discodes=discodes">
            <p>
                <?php echo Yii::t('account', 'Указанное действие уничтожит всю информацию в споте')?> <b>{{discodes}}</b>
            </p>
            <div class="row">
                <div class="six columns centered">
                    <button class="m-button" ng-click="clear()" ng-disabled="clearForm.$invalid">
                        <?php echo Yii::t('account', 'Продолжить')?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
