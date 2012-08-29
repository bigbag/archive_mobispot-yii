<div id="main-container">
    <div id="cont-block" class="center">
        <div id="cont-block-760" class="center">
            <div id="zag-cont-block"><?php echo Yii::t('account', 'Управление спотами');?></div>
            <table class="headTable">
                <tr>
                    <td class="td60"></td>
                    <td class="td100p">
                        <center><?php echo Yii::t('account', 'Название');?></center>
                    </td>
                    <td class="td115">
                        <center><?php echo Yii::t('account', 'ID-спота');?></center>
                    </td>
                    <td class="td180">
                        <center><?php echo Yii::t('account', 'Тип спота');?></center>
                    </td>
                </tr>
            </table>

            <div id="table-spots">
                <ul>
                    <?php $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => $dataProvider,
                    'itemView' => 'block/_spots_list',
                    'template' => '{items} {pager}',
                    'cssFile' => false,
                    'id' => 'spotslistview',
                )); ?>
                </ul>
            </div>

            <div class="clear"></div>
            <div id="foot-cont-block">
                <select name='action' class='action'>
                    <option class="noView"><?php echo Yii::t('account', 'Выберите действие');?></option>
                    <option value="<?php echo Spot::ACTION_CHANGE_NAME;?>"><?php echo Yii::t('account', 'Изменить название'); ?></option>
                    <option value="<?php echo Spot::ACTION_CHANGE_TYPE;?>"><?php echo Yii::t('account', 'Изменить тип'); ?></option>
                    <option value="<?php echo Spot::ACTION_COPY;?>"><?php echo Yii::t('account', 'Копировать'); ?></option>
                    <option value="<?php echo Spot::ACTION_EMPTY;?>"><?php echo Yii::t('account', 'Очистить'); ?></option>
                    <option value="<?php echo Spot::ACTION_REMOVE;?>"><?php echo Yii::t('account', 'Удалить'); ?></option>
                </select>
                <a href="#" class="r-btn-30">
                    <span>
                        <span class="plus-ico"></span><?php echo Yii::t('account', 'Добавить спот'); ?>
                    </span>
                </a>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var ACCORDION_MODE = true;
    $(document).ready(function () {
        $('#table-spots>ul>div>div>li>div.oneSpot').click(function (e) {
            th = $(this).parent();
            console.log(e.target);
            if (e.target.tagName == 'INPUT' || e.target.tagName == 'SPAN' || e.target.tagName == 'A')        return;

            if (ACCORDION_MODE && !th.hasClass('active')) {
                th.parent().find('>li>div.contSpot').slideUp(300);
                th.parent().find('>li').removeClass('active');
            }
            th.find('>div.contSpot').slideToggle(300, function () {
                th.toggleClass('active');
            });
            return false;

        });
    });
    $(document).ready(function () {
        $("select").change(function () {
            var action = $(this).val();
            var id = $('input:checked').val()?$('input:checked').val():false;

            if (id){
                if (action == <?php echo Spot::ACTION_CHANGE_NAME; ?>){
                    $('#name_' + id + ' div.rename').show();
                    $('#name_' + id + ' div.name').hide();
                }
                else if (action == <?php echo Spot::ACTION_CHANGE_TYPE; ?>){
                    $('#type_' + id + ' div.retype').show();
                    $('#type_' + id + ' div.type').hide();
                }
            }
        });
    });

    $(document).ready(function () {
        var options = {
            success:showRenameResponse,
            clearForm:false,
            url:'/ajax/spotRename/'
        };

        $('.spot_rename_form').submit(function () {
            $(this).ajaxSubmit(options);
            return false;
        });

    });

    function showRenameResponse(responseText) {
        var obj = jQuery.parseJSON(responseText);
        var id = obj.discodes_id;

        if (responseText) {
            var name = obj.name;

            $('#name_' + id + ' div.name').html(name);
            $('#name_' + id + ' div.rename').hide();
            $('#name_' + id + ' div.name').show();
            $('#id_' + id + ' span').removeClass("niceChecked");
        }
    }
</script>

    