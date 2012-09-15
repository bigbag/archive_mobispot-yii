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
        <table class="visitInfoTbl" cellspacing="0">
            <tbody>
            <tr>
                <td class="field"><?php echo Yii::t('account', 'Название бизнеса');?></td>
                <td>
                    <div class="txt-form">
                        <div class="txt-form-cl">
                            <?php echo CHtml::activeTextField($content, 'nazvanie-biznesa_8', array('class' => 'txt')); ?>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="field"><?php echo Yii::t('account', 'Веб сайт');?></td>
                <td>
                    <div class="txt-form">
                        <div class="txt-form-cl">
                            <?php echo CHtml::activeTextField($content, 'sayt_8', array('class' => 'txt')); ?>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="field"><?php echo Yii::t('account', 'Контактное лицо');?></td>
                <td>
                    <div class="txt-form">
                        <div class="txt-form-cl">
                            <?php echo CHtml::activeTextField($content, 'kontaktnoe-litso_8', array('class' => 'txt')); ?>
                            <input class="txt" name="inputtext" value="" placeholder=" " type="text">
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <table class="visitInfoTbl" cellspacing="0">
            <tbody>
            <tr>
                <td class="field vatop" rowspan="4"><?php echo Yii::t('account', 'Предложения');?></td>
            </tr>
            </tbody>
        </table>
        <input name="SpotModel[nazvanie_8][]" class="action_name" type="hidden" value="">
        <input name="SpotModel[ssyilka_8][]" class="action_link" type="hidden" value="">
        <input name="SpotModel[kartinka_8][]" class="action_file" type="hidden" value="">
        <?php if (!empty($content->nazvanie_8)): ?>
        <?php $i = 0; ?>
        <?php foreach ($content->nazvanie_8 as $name): ?>
            <?php if (!empty($name)): ?>
                <?php $link = $content->ssyilka_8; ?>
                <?php $file = $content->kartinka_8; ?>
                <?php $file_view = explode('_', $file[$i]) ?>
                <?php $file_view = (isset($file_view[2])) ? $file_view[2] : '' ?>
                <div class="spot_action">
                    <span class="edit"></span>
                    <?php echo $name ?><br/>
                    <?php echo $link[$i]; ?><br/>
                    <?php echo $file_view ?>
                    <input name="SpotModel[nazvanie_8][]" class="action_name" type="hidden" value="<?php echo $name ?>">
                    <input name="SpotModel[ssyilka_8][]" class="action_link" type="hidden"
                           value="<?php echo $link[$i] ?>">
                    <input name="SpotModel[kartinka_8][]" class="action_file" type="hidden"
                           value="<?php echo $file[$i] ?>">
                    <input class="action_file_view" type="hidden" value="<?php echo $file_view ?>">
                </div>
                <?php endif; ?>
            <?php $i = $i + 1; ?>

            <?php endforeach; ?>
        <?php endif;?>
        <span class="view_action"> </span>

        <div class="clear"></div>

        <div class="new_action">

        </div>
        <div class="bnt_action">
            <table class="visitInfoTbl" cellspacing="0">
                <tbody>
                <tr>
                    <td>
                        <span class="r-btn-30" id="add_action">
                            <span><?php echo Yii::t('account', 'Добавить предложение');?></span>
                        </span>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <table class="visitInfoTbl" cellspacing="0">
            <tbody>
            <tr>
                <td class="field vatop"
                    rowspan="3"><?php echo Yii::t('account', 'Ближайшие точки продаж');?></td>

            </tr>
            </tbody>
        </table>

        <?php if (count($content['tochka-nazvanie_8']) > 0): ?>
        <?php $i = 0; ?>
        <?php foreach ($content['tochka-nazvanie_8'] as $name): ?>
            <?php if (isset($name[1])): ?>
                <?php $karta = $content['tochka-karta_8']; ?>
                <div class="place">
                    <span class="remove"></span>
                    <table class="visitInfoTbl" cellspacing="0">
                        <tbody>
                        <tr>
                            <td class="field vatop" rowspan="3"></td>
                            <td>
                                <div class="txt-form">
                                    <div class="txt-form-cl">
                                        <input class="text"
                                               placeholder="<?php echo Yii::t('account', 'Название и адрес');?>"
                                               name="SpotModel[tochka-nazvanie_8][]" value="<?php echo $name;?>"
                                               type="text">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="txt-form">
                                    <div class="txt-form-cl">
                                        <input class="text"
                                               placeholder="<?php echo Yii::t('account', 'Ссылка на карту');?>"
                                               name="SpotModel[tochka-karta_8][]" value="<?php echo $karta[$i];?>"
                                               type="text">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <br/>
                <?php endif; ?>
            <?php $i = $i + 1; ?>
            <?php endforeach; ?>
        <?php endif;?>

        <div class="place add_place">
            <table class="visitInfoTbl" cellspacing="0">
                <tbody>
                <tr>
                    <td class="field vatop" rowspan="3"></td>
                    <td>
                        <div class="txt-form">
                            <div class="txt-form-cl">
                                <?php echo CHtml::activeTextField(
                                $content,
                                'tochka-nazvanie_8[]',
                                array(
                                    'class' => 'txt',
                                    'placeholder' => Yii::t('account', 'Название и адрес'),
                                ));
                                ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="txt-form">
                            <div class="txt-form-cl">
                                <?php echo CHtml::activeTextField(
                                $content,
                                'tochka-karta_8[]',
                                array(
                                    'class' => 'txt',
                                    'placeholder' => Yii::t('account', 'Ссылка на карту'),
                                ));
                                ?>
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <br/>
        </div>
        <table class="visitInfoTbl" cellspacing="0">
            <tbody>
            <tr>
                <td>
                    <a href="" class="r-btn-30 copy" rel=".add_place">
                        <span><?php echo Yii::t('account', 'Добавить точку продаж');?></span>
                    </a>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
<div class="clear"></div>
<div>

    <script type="text/javascript">
        $('a.copy').relCopy({
            'clearInputs':true
        });

        $(function () {
            $('body').delegate('.place .remove', 'click', function () {
                $(this).parent().remove();
            });
            return false;
        });

        $(function () {
            $('.bnt_action #add_action').live("click", function () {
                $.ajax({
                    url:'/ajax/getContent',
                    type:'POST',
                    data:{content:'card_action', discodes_id:<?php echo $data->discodes_id;?>},
                    success:function (result) {
                        $('.bnt_action').hide();
                        $('.new_action').html(result);
                    }
                });
            });
            return false;
        });

        $(function () {
            $('.spot_action span.edit').live("click", function () {
                var general = $(this).parent();
                if (general) {
                    var file = general.find('.action_file').val();
                    var file_view = general.find('.action_file_view').val();
                    var name = general.find('.action_name').val();
                    var link = general.find('.action_link').val();

                    $.ajax({
                        url:'/ajax/getContent',
                        type:'POST',
                        data:{
                            content:'card_action',
                            file:file,
                            file_view:file_view,
                            name:name,
                            link:link,
                            discodes_id:<?php echo $data->discodes_id;?>
                        },
                        success:function (result) {
                            $('.bnt_action').hide();
                            $('.new_action').html(result);
                        }
                    });
                }

                $(this).parent().remove();
            });
            return false;
        });

        $(function () {
            $('body').delegate('#remove_action', 'click', function () {
                $('.new_action').empty();
                $('.bnt_action').show();
            });
            return false;
        });


        $(function () {
            $('#save_action').live("click", function () {
                var action_name = $('.new_action input.name').val();
                var action_link = $('.new_action input.link').val();
                var action_file = $('.new_action input.spot_card_file').val();
                var action_file_view = $('.new_action input.spot_card_file_view').val();

                var action = '';
                if (action_name || action_link || action_file) {
                    action = '<div class="spot_action"><span class="edit"></span>' +
                            '<input name="SpotModel[nazvanie_8][]" class="action_name" type="hidden" value="' + action_name + '">' +
                            '<input name="SpotModel[kartinka_8][]" class="action_file" type="hidden" value="' + action_file + '">' +
                            '<input name="SpotModel[ssyilka_8][]" class="action_link" type="hidden" value="' + action_link + '">' +
                            '<input class="action_file_view" type="hidden" value="' + action_file_view + '">' +
                            action_name + '<br />' +
                            action_link + '<br />' +
                            action_file_view + '</div>';
                }
                $('.view_action').before(action);
                $('.new_action').empty();
                $('.bnt_action').show();
            });
            return false;
        });

        $('input.txt').bind('focus', function () {
            $(this).parent().css('background-position', '100% -105px');
            $(this).parent().parent().css('background-position', '0 -70px');
        });
        $('input.txt').bind('blur', function () {
            $(this).parent().css('background-position', '100% -35px');
            $(this).parent().parent().css('background-position', '0 0');
        });
    </script>