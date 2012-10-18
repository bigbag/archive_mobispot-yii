<div id="spot_add_modal" class="reveal-modal">
    <div class="cont-pop">
        <a class="close-reveal-modal"><?php echo Yii::t('account', 'Закрыть')?></a>

        <form action="" method="post" class="spot_add_form">
            <p>
                <?php echo Yii::t('account', 'Введите код спота')?>
            </p>
            <span class="error"></span>

            <div class="row">
                <div class="seven columns centered">
                    <input type="text" maxlength="10" id="spot_add_code" name="code" value="" placeholder="" autocomplete="off"/>
                </div>
            </div>
            <div class="row spot_type_all" style="display: none">
                <div class="seven columns centered">
                    <select name="type">
                        <?foreach ($spot_type_all as $key => $value): ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="seven columns centered">
                    <button class="m-button">
                        <?php echo Yii::t('account', 'Сохранить')?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>