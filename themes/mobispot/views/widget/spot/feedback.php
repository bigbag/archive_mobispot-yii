<p>
    <?php echo Yii::t('account', 'Используйте этот спот, чтобы получить жалобу, вопрос или похвалу от <br />
    Вашего клиента. Отметьте ниже, какие поля ему нужно заполнить, а также<br />
    поясните, зачем Вы собираете эту информацию.<br />');?>
</p>
<table class="feedbackInfoTbl" cellspacing="0">
    <tr>
        <td colspan="2">
            <div class="txt-form">
                <div class="txt-form-cl">
                    <input type="text" class="txt" name="inputtext" value=""
                           placeholder="<?php echo Yii::t('account', 'Введите здесь поясняющий текст к Вашему споту');?>"/>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td class="field"><?php echo Yii::t('account', 'Имя');?></td>
        <td><input type="checkbox" class="niceCheck"></td>
    </tr>
    <tr>
        <td class="field"><?php echo Yii::t('account', 'Телефон');?></td>
        <td><input type="checkbox" class="niceCheck"></td>
    </tr>
    <tr>
        <td class="field"><?php echo Yii::t('account', 'Электронная почта');?></td>
        <td><input type="checkbox" class="niceCheck"></td>
    </tr>
    <tr>
        <td class="field"><?php echo Yii::t('account', 'Комментарий');?></td>
        <td><input type="checkbox" class="niceCheck"></td>
    </tr>
    <tr>
        <td colspan="2"><a href="" class="btn-30"><span
            class="btn-30-txt"><?php echo Yii::t('account', 'Смотреть отзывы к этому споту');?></span></a></td>
    </tr>
</table>
