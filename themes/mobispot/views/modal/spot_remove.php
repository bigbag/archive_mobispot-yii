<div id="spot_remove_modal" class="reveal-modal medium">
    <div class="cont-pop">
        <a class="close-reveal-modal"><?php echo Yii::t('account', 'Закрыть')?></a>
        <form name="removeForm" ng-init="discodes = discodes">
            <p>
                <?php echo Yii::t('account', 'Удалить спот ')?> <b>{{discodes}}</b>
            </p>
            <div class="row">
                <div class="six columns centered">
                    <button class="m-button" ng-click="remove()" ng-disabled="removeForm.$invalid">
                        <i class="icon-trash"></i>&nbsp;<?php echo Yii::t('account', 'Удалить')?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>