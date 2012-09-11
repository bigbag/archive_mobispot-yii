<div class="coupon_desinger" style="display: none">
    <a href="" class="upload-img"><?php echo Yii::t('account', 'Загрузка картинки');?></a>
    <span class="constr active"><?php echo Yii::t('account', 'Конструктор');?></span>
    <br>
    <br>

    <p><?php echo Yii::t('account', 'Создайте здесь купон, который Вы хотите использовать в своей промо-акции. Выберите его фон,<br>текст,
        сроки действия, а также подгрузите Ваш логотип (jpg, png, gif, не более 100 Кб). <br>Нажмите
        «Сгенерировать» и
        посмотрите, что получилось.');?>
    </p>
    <br>
    <br>

    <form action="" method="post" class="generation_coupon">
        <input type="hidden" name="Coupon[spot_id]" value="<?php echo $data->discodes_id;?>">
        <table class="couponInfoTbl" cellspacing="0">
            <tbody>
            <tr>
                <td class="field"><?php echo Yii::t('account', 'Текст на купоне');?></td>
                <td>
                    <div class="txt-form">
                        <div class="txt-form-cl">
                            <input class="txt" name="Coupon[text]" value="" placeholder=" " type="text">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="field"><?php echo Yii::t('account', 'Ваш лого');?></td>
                <td>
                    <table>
                        <tr>
                            <td>
                                <div class="round-btn-new">
                                    <input type="hidden" class="coupon_logo" name="Coupon[logo]" value="">
                                    <input type="submit" id="add_file_desinger"
                                           value="<?php echo Yii::t('profile', 'Загрузить');?>"/>
                                </div>
                            </td>
                            <td>
                                <div class="result_upload">
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="field"><?php echo Yii::t('account', 'Период действия');?></td>
                <td>
                    <div class="date_select">
                        <select name="Coupon[day_up]">
                            <option></option>
                            <?php for ($i = 1; $i <= 31; $i++): ?>
                            <option value="<?php echo $i?>"><?php echo $i?></option>
                            <?php endfor;?>
                        </select>
                        <select name="Coupon[month_up]">
                            <option></option>
                            <?php foreach (MDate::month() as $key => $value): ?>
                            <option value="<?php echo $key?>"><?php echo $value?></option>
                            <?php endforeach;?>
                        </select>
                        <select name="Coupon[year_up]">
                            <option></option>
                            <?php for ($i = date("Y"); $i <= date("Y") + 5; $i++): ?>
                            <option value="<?php echo $i?>"><?php echo $i?></option>
                            <?php endfor;?>
                        </select>
                        <span class="big">&nbsp;&nbsp;‒&nbsp;&nbsp;</span>
                        <select name="Coupon[day_down]">
                            <option></option>
                            <?php for ($i = 1; $i <= 31; $i++): ?>
                            <option value="<?php echo $i?>"><?php echo $i?></option>
                            <?php endfor;?>
                        </select>
                        <select name="Coupon[month_down]">
                            <option></option>
                            <?php foreach (MDate::month() as $key => $value): ?>
                            <option value="<?php echo $key?>"><?php echo $value?></option>
                            <?php endforeach;?>
                        </select>
                        <select name="Coupon[year_down]">
                            <option></option>
                            <?php for ($i = date("Y"); $i <= date("Y") + 5; $i++): ?>
                            <option value="<?php echo $i?>"><?php echo $i?></option>
                            <?php endfor;?>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="field"><?php echo Yii::t('account', 'Время действия');?></td>
                <td class="time-form">
                    <div class="txt-form">
                        <div class="txt-form-cl">
                            <input class="txt" maxlength="2" name="Coupon[time_up][]" value="" placeholder=" "
                                   type="text">
                        </div>
                    </div>
                    <span class="big">&nbsp;&nbsp;:&nbsp;&nbsp;</span>

                    <div class="txt-form">
                        <div class="txt-form-cl">
                            <input class="txt" maxlength="2" name="Coupon[time_up][]" value="" placeholder=" "
                                   type="text">
                        </div>
                    </div>
                    <span class="big">&nbsp;&nbsp;‒&nbsp;&nbsp;</span>

                    <div class="txt-form">
                        <div class="txt-form-cl">
                            <input class="txt" maxlength="2" name="Coupon[time_down][]" value="" placeholder=" "
                                   type="text">
                        </div>
                    </div>
                    <span class="big">&nbsp;&nbsp;:&nbsp;&nbsp;</span>

                    <div class="txt-form">
                        <div class="txt-form-cl">
                            <input class="txt" maxlength="2" name="Coupon[time_down][]" value="" placeholder=" "
                                   type="text">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>

                <td class="field" style="vertical-align:top">
                    <div class="color-palit" >
                        <div class="color color-palit-cl"><?php echo Yii::t('account', 'Выберите фон');?>
                            <input type="hidden" name="Coupon[body_color]" class="color-picker" size="7" value="#FFFFFF" id="body_color"/>
                        </div>
                    </div>
                    <div class="color-palit">
                        <div class="color-palit-cl color-alpha"><?php echo Yii::t('account', 'Цвет текста');?>
                            <input type="hidden" name="Coupon[text_color]" class="color-picker" size="7" value="#000000" id="text_color"/>
                        </div>
                    </div>
                </td>
                <td class="time-form">
                    <div class="fright" style="margin-top:10px">

                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="btn-30" style="float: right;">
            <div>
                <input type="submit" value="<?php echo Yii::t('account', 'Сгенерировать');?>"/>
            </div>
        </div>
    </form>
</div>
