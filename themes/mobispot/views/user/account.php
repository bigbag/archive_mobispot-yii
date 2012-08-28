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
                <select>
                    <option class="noView"><?php echo Yii::t('account', 'Выберите действие');?></option>
                    <option><?php echo Yii::t('account', 'Копировать');?></option>
                    <option><?php echo Yii::t('account', 'Очистить');?></option>
                    <option><?php echo Yii::t('account', 'Удалить');?></option>
                    <option><?php echo Yii::t('account', 'Изменить название');?></option>
                    <option><?php echo Yii::t('account', 'Изменить тип');?></option>
                </select>
                <a href="" class="r-btn-30"><span><span
                    class="plus-ico"></span><?php echo Yii::t('account', 'Добавить спот');?></span></a>
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

    $("#activate_btn, #delete_btn").click(function () {
        var url;
        var action = $(this).attr('id');
        var selected = $("#spot-grid").selGridView("getAllSelection");
        var id = selected.join("|");

        if (action === 'activate_btn') url = '/admin/spot/activate/';
        else if (action === 'delete_btn') url = '/admin/spot/delete/';

        if (id[0]) {
            $.ajax({
                url:url,
                dataType:"json",
                type:'GET',
                data:{id:id, ajax:1},
                success:function (data, textStatus) {
                    $().redirect('/admin/spot/');
                }
            });
        }
        return false;
    });
</script>

    