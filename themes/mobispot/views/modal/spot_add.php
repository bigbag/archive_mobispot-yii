<div id="spot_add_modal" class="reveal-modal medium">
    <div class="cont-pop">
        <a class="close-reveal-modal"><?php echo Yii::t('account', 'Закрыть')?></a>

        <form name="addForm">
            <p>
                <?php echo Yii::t('account', 'Введите код спота')?>
            </p>

            <div class="row">
                <div class="nine columns centered">
                    <input type="text" name="code"
                        autocomplete="off"
                        ng-model="code"
                        ng-minlength="10"
                        ng-maxlength="10"
                        ng-required="true"
                    />
                    <select name="type" ng-model="type" ng-required="true" style="width: 250px;">
                        <option value="8"><?php echo Yii::t('account', 'Инфо-постер')?></option>
                        <option value="4"><?php echo Yii::t('account', 'Купон')?></option>
                        <option value="3"><?php echo Yii::t('account', 'Личный')?></option>
                        <option value="10"><?php echo Yii::t('account', 'Отправка')?></option>
                        <option value="9"><?php echo Yii::t('account', 'Связь')?></option>
                        <option value="5"><?php echo Yii::t('account', 'Ссылка')?></option>
                        <option value="6"><?php echo Yii::t('account', 'Файл')?></option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="six columns centered">
                    <br />
                    <button class="m-button" ng-click="add()" ng-disabled="addForm.$invalid">
                        <?php echo Yii::t('account', 'Сохранить')?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
