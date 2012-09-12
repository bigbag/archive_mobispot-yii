<?php $select_field = UserPersonalField::getField($data->discodes_id); ?>
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
        <form action="" method="post" class="spot_edit_content" id="spot_edit_content_<?php echo $content->spot_id?>">
            <?php echo CHtml::activeHiddenField($content, 'spot_id'); ?>
            <?php echo CHtml::activeHiddenField($content, 'spot_type_id'); ?>
            <div class="yourPhoto">
                <div class="photo-cont">
                </div>
                <div class="round-btn">
                    <div class="round-btn-cl">
                        <input type="submit" class="" value="<?php echo Yii::t('account', 'Загрузить');?>"/>
                    </div>
                </div>
                <a href=""><?php echo Yii::t('account', 'Показать все');?></a>
            </div>
            <div class="yourName">
                <div class="txt-form">
                    <div class="txt-form-cl">
                        <?php echo CHtml::activeTextField($content, 'imya_3', array('placeholder' => 'Your Name', 'class' => 'txt')); ?>
                    </div>
                </div>
            </div>
            <div class="oneBlockSpotInfo">
                <div class="top-border ">
                    <?php echo Yii::t('account', 'Контактные данные');?>
                    <?php foreach (SpotPersonalField::getPersonalField(0) as $row): ?>
                    <?php if (in_array($row['id'], $select_field)):?>
                        <div class="txt-form">
                            <div class="txt-form-cl">
                            <span><img src="/uploads/ico/<?php echo $row['ico']?>" alt="" width="23"
                                       height="23"> </span>
                                <?php echo CHtml::activeTextField(
                                $content,
                                'kontaktyi_3[' . $row['id'] . ']',
                                array(
                                    'placeholder' => $row['placeholder'],
                                    'class' => 'txt'
                                )); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endforeach;?>
                    <div class="add_field">
                        <a href="0" class="r-btn-30">
                            <span><?php echo Yii::t('account', 'Добавить');?></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="oneBlockSpotInfo">
                <div class="top-border ">
                    <?php echo Yii::t('account', 'Социальные сети');?>
                    <?php foreach (SpotPersonalField::getPersonalField(1) as $row): ?>
                    <?php if (in_array($row['id'], $select_field)):?>
                        <div class="txt-form">
                            <div class="txt-form-cl">
                            <span><img src="/uploads/ico/<?php echo $row['ico']?>" alt="" width="23"
                                       height="23"> </span>
                                <?php echo CHtml::activeTextField(
                                $content,
                                'sotsseti_3[' . $row['id'] . ']',
                                array(
                                    'placeholder' => $row['placeholder'],
                                    'class' => 'txt'
                                )); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endforeach;?>
                    <div class="add_field">
                        <a href="1" class="r-btn-30">
                            <span><?php echo Yii::t('account', 'Добавить');?></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="oneBlockSpotInfo" style="width:431px;margin:0">
                <div class="top-border ">
                    <table class="oneBlockSpotInfoTbl" cellspacing="0">
                        <?php foreach (SpotPersonalField::getPersonalField(2) as $row): ?>
                        <?php if (in_array($row['id'], $select_field)):?>
                            <tr>
                                <td class="field"><?php echo Yii::t('account', $row['name']);?></td>
                                <td>
                                    <div class="txt-form">
                                        <div class="txt-form-cl">
                                            <?php echo CHtml::activeTextField(
                                            $content,
                                            'opisanie_3[' . $row['id'] . ']',
                                            array(
                                                'placeholder' => $row['placeholder'],
                                                'class' => 'txt'
                                            )); ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                        <?php endforeach;?>
                    </table>

                    <div class="add_field">
                        <a href="2" class="r-btn-30">
                            <span><?php echo Yii::t('account', 'Добавить');?></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="oneBlockSpotInfo">
                <div class="top-border ">
                    <?php echo Yii::t('account', 'Язык отображения спота');?>
                    <select>
                        <option><?php echo Yii::t('account', 'Русский');?></option>
                        <option><?php echo Yii::t('account', 'Английский');?></option>
                    </select>
                    <table class="oneBlockSpotInfoTbl">
                        <tr>
                            <td><?php echo Yii::t('account', 'Разрешить комментарии к споту');?></td>
                            <td><input type="checkbox" class="niceCheck"></td>
                        </tr>
                        <tr>
                            <td><?php echo Yii::t('account', 'Разрешить скачивать визитку');?></td>
                            <td><input type="checkbox" class="niceCheck"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </form>
    </div>
    <div class="clear"></div>
    <div>
        <script type="txt/javascript">
            $("select").selectBox('create');
            $('input.txt').bind('focus', function () {
                $(this).parent().css('background-position', '100% -105px');
                $(this).parent().parent().css('background-position', '0 -70px');
            });

            $('input.txt').bind('blur', function () {
                $(this).parent().css('background-position', '100% -35px');
                $(this).parent().parent().css('background-position', '0 0');
            });

            $(document).ready(function () {
                $('.add_field').click(function () {
                    var id = <?php echo $data->discodes_id;?>;
                    var type_id = $(this).children('a').attr("href");

                    if (id && type_id) {
                        $.ajax({
                            url:'/ajax/spotPersonalContent',
                            type:'POST',
                            data:{discodes_id:id, type_id:type_id},
                            success:function (result) {
                                $('#spot_content_' + id).html(result);
                            }
                        });
                    }
                    return false;
                });
            });
        </script>