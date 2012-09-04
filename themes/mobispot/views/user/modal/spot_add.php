<div id="spot_add_modal" class="reveal-modal">
    <div class="cont-pop">
        <a class="close-reveal-modal"><?php echo Yii::t('account', 'Закрыть')?></a>

        <form action="" method="post" class="spot_add_form">
            <?php echo Yii::t('account', 'Введите код спота')?><br/>
            <span class="error"></span>

            <div class="txt-form spot_code">
                <div class="txt-form-cl">
                    <input type="text" style="width:100%;" maxlength="10" class="txt" id="spot_add_code"
                           name="code" value="" placeholder=""/>
                </div>
            </div>
            <br/>

            <input type="hidden" name="code" class="code" value="">

            <div class="spot_type_all" style="display: none">
                <select name="type">
                    <option class="noView">Тип</option>
                    <?foreach ($spot_type_all as $key => $value): ?>
                    <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <br/>

            <div class="round-btn" style="float:left">
                <div class="round-btn-cl"><input type="submit" class=""
                                                 value="<?php echo Yii::t('account', 'Сохранить')?>"/>
                </div>
            </div>
            <div class="clear"></div>
        </form>
    </div>
</div>