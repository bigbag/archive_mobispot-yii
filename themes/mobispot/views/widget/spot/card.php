<div class="contSpot" id="spot_content_<?php echo $data->discodes_id;?>">
    <span class="message" id="message_<?php echo $data->discodes_id;?>"></span>

    <div class="btn-30">
        <div><input type="submit" class="" value="<?php echo Yii::t('account', 'Сохранить');?>"
                    form="spot_edit_content_<?php echo $data->discodes_id;?>"/></div>
    </div>
    <a href="#" class="btn-30">
        <span class="preview-ico ico"></span>
        <span class="btn-30-txt"><?php echo Yii::t('account', 'Предпросмотр');?></span>
    </a>

    <div class="oneSpotInfo">
        <?php echo Yii::t('account', 'Используйте спот, чтобы рассказать больше о своей<br>компании и товаре, который Вы рекламируете.');?>
        <br><br>
        <table class="visitInfoTbl" cellspacing="0">
            <tbody>
            <tr>
                <td class="field"><?php echo Yii::t('account', 'Название бизнеса');?></td>
                <td>
                    <div class="txt-form">
                        <div class="txt-form-cl">
                            <input class="txt" name="inputtext" value="" placeholder=" " type="text">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="field"><?php echo Yii::t('account', 'Веб сайт');?></td>
                <td>
                    <div class="txt-form">
                        <div class="txt-form-cl">
                            <input class="txt" name="inputtext" value="" placeholder=" " type="text">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="field"><?php echo Yii::t('account', 'Контактное лицо');?></td>
                <td>
                    <div class="txt-form">
                        <div class="txt-form-cl">
                            <input class="txt" name="inputtext" value="" placeholder=" " type="text">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="field vatop" rowspan="4"><?php echo Yii::t('account', 'Интересное предложение');?></td>
                <td>
                    <div class="txt-form">
                        <div class="txt-form-cl">
                            <input class="txt" name="inputtext" value="" placeholder="<?php echo Yii::t('account', 'Название');?>" type="text">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="" class="btn-30">
                        <span class="upload-ico ico"></span>
                        <span class="btn-30-txt"><?php echo Yii::t('account', 'Загрузить');?></span>
                    </a>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="txt-form">
                        <div class="txt-form-cl">
                            <input class="txt" name="inputtext" value="" placeholder="<?php echo Yii::t('account', 'Ссылка на веб-страницу');?>"
                                   type="text">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td><a href="" class="r-btn-30"><span><?php echo Yii::t('account', 'Добавить предложение');?></span></a></td>
            </tr>
            <tr>
                <td class="field vatop" rowspan="3"><?php echo Yii::t('account', 'Ближайшие точки продаж');?></td>
                <td>
                    <div class="txt-form">
                        <div class="txt-form-cl">
                            <input class="txt" name="inputtext" value="" placeholder="<?php echo Yii::t('account', 'Название и адрес');?>" type="text">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="txt-form">
                        <div class="txt-form-cl">
                            <input class="txt" name="inputtext" value="" placeholder="<?php echo Yii::t('account', 'Ссылка на карту');?>" type="text">
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td><a href="" class="r-btn-30"><span><?php echo Yii::t('account', 'Добавить точку продаж');?></span></a></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="clear"></div>
    <div>