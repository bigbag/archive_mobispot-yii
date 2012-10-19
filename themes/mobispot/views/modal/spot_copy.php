<div id="spot_copy_modal" class="reveal-modal">
    <div class="cont-pop">
        <a class="close-reveal-modal"><?php echo Yii::t('account', 'Закрыть')?></a>

        <form name="copyForm" ng-init="discodes_from=discodes">
        <p>
            <?php echo Yii::t('account', 'Введите ID-спота, в которую вы хотите скопировать содержимое спота')?> <b>{{discodes}}</b>
        </p>

            <div class="row">
                <div class="six columns centered">
                    <input ng-model="discodes_to" name="discodes_to" type="text" ng-required="true">
                </div>
            </div>
            <div class="row">
                <div class="six columns centered">
                    <button class="m-button" ng-click="copy()" ng-disabled="copyForm.$invalid">
                        <?php echo Yii::t('account', 'Ок')?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>