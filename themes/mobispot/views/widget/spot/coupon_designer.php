<a href="" class="upload-img">Загрузка картинки</a><span class="constr active">Конструктор</span>
<br><br>

<p>Создайте здесь купон, который Вы хотите использовать в своей промо-акции. Выберите его фон,<br>текст,
    сроки действия, а также подгрузите Ваш логотип (jpg, png, gif, не более 100 Кб). <br>Нажмите «Сохранить» и
    посмотрите, что получилось.
</p>
<br><br>
<table class="couponInfoTbl" cellspacing="0">
    <tbody>
    <tr>
        <td class="field">Текст на купоне</td>
        <td>
            <div class="txt-form">
                <div class="txt-form-cl"><input class="txt" name="inputtext" value="" placeholder=" "
                                                type="text"></div>
            </div>
        </td>
    </tr>
    <tr>
        <td class="field">Ваш лого</td>
        <td>
            <div class="round-btn-new">
                <input type="submit" id="add_logo" value="<?php echo Yii::t('profile', 'Загрузить');?>"/>
            </div>
        </td>
    </tr>
    <tr>
        <td class="field">Период действия</td>
        <td>
            <select style="display: none;" class="selectBox">
                <option>01</option>
                <option>02</option>
                <option>03</option>
            </select><a tabindex="0" title="" style="display: inline-block; -moz-user-select: none;"
                        class="selectBox  selectBox-dropdown"><span class="selectBox-label">01</span><span
            class="selectBox-arrow"></span></a>
            <select style="display: none;" class="selectBox">
                <option label="none">Июнь</option>
                <option>Сентябрь</option>
                <option>Март</option>
            </select><a tabindex="0" title="" style="display: inline-block; -moz-user-select: none;"
                        class="selectBox  selectBox-dropdown"><span class="selectBox-label">Июнь</span><span
            class="selectBox-arrow"></span></a>
            <select style="display: none;" class="selectBox">
                <option>2012</option>
                <option>2013</option>
                <option>2014</option>
            </select><a tabindex="0" title="" style="display: inline-block; -moz-user-select: none;"
                        class="selectBox  selectBox-dropdown"><span class="selectBox-label">2012</span><span
            class="selectBox-arrow"></span></a>
            <span class="big">&nbsp;&nbsp;‒&nbsp;&nbsp;</span>
            <select style="display: none;" class="selectBox">
                <option>01</option>
                <option>02</option>
                <option>03</option>
            </select><a tabindex="0" title="" style="display: inline-block; -moz-user-select: none;"
                        class="selectBox  selectBox-dropdown"><span class="selectBox-label">01</span><span
            class="selectBox-arrow"></span></a>
            <select style="display: none;" class="selectBox">
                <option>Июнь</option>
                <option>Сентябрь</option>
                <option>Март</option>
            </select><a tabindex="0" title="" style="display: inline-block; -moz-user-select: none;"
                        class="selectBox  selectBox-dropdown"><span class="selectBox-label">Июнь</span><span
            class="selectBox-arrow"></span></a>
            <select style="display: none;" class="selectBox">
                <option>2012</option>
                <option>2013</option>
                <option>2014</option>
            </select><a tabindex="0" title="" style="display: inline-block; -moz-user-select: none;"
                        class="selectBox  selectBox-dropdown"><span class="selectBox-label">2012</span><span
            class="selectBox-arrow"></span></a>
        </td>
    </tr>
    <tr>
        <td class="field">Время действия</td>
        <td class="time-form">
            <div class="txt-form">
                <div class="txt-form-cl"><input class="txt" name="inputtext" value="" placeholder=" "
                                                type="text"></div>
            </div>
            <span class="big">&nbsp;&nbsp;:&nbsp;&nbsp;</span>

            <div class="txt-form">
                <div class="txt-form-cl"><input class="txt" name="inputtext" value="" placeholder=" "
                                                type="text"></div>
            </div>
            <span class="big">&nbsp;&nbsp;‒&nbsp;&nbsp;</span>

            <div class="txt-form">
                <div class="txt-form-cl"><input class="txt" name="inputtext" value="" placeholder=" "
                                                type="text"></div>
            </div>
            <span class="big">&nbsp;&nbsp;:&nbsp;&nbsp;</span>

            <div class="txt-form">
                <div class="txt-form-cl"><input class="txt" name="inputtext" value="" placeholder=" "
                                                type="text"></div>
            </div>
        </td>
    </tr>
    <tr>
        <td class="field" style="vertical-align:top">
            <div class="color-palit">
                <div class="color-palit-cl">Выберите фон<span></span></div>
            </div>
            <div class="color-palit">
                <div class="color-palit-cl color-alpha">Цвет текста<span></span></div>
            </div>
        </td>
        <td class="time-form">
            <div class="fright" style="margin-top:10px">
                <img src="images/temp/coupon.png">
            </div>
        </td>
    </tr>
    </tbody>
</table>

<script type="text/javascript">
    $(function () {
        $("#add_logo").uploadifive({
            'width':'120',
            'height':'28',
            'fileTypeExts':'*.pdf; *.gif; *.jpg; *.png',
            uploadScript:'/user/uploadFile/',
            'formData':{'spot_id':1},
            'fileSizeLimit':'512KB',
            'removeTimeout':10,
            'multi':false,
            'buttonClass':'uploadify_personal',
            'buttonText':'<?php echo Yii::t('profile', 'Загрузить');?>',

            'onError':function (errorType) {
                $('#messages_modal div.messages').html('The file could not be uploaded: ' + errorType);
                $('#messages_modal').reveal({animation:'none'});
            },
            'onUploadComplete':function (file, data, response) {
                var obj = jQuery.parseJSON(data);
                var file_name = obj.file;
                var error = obj.error;
                if (file_name) {
                    $('#spot_coupon_field').val(file_name);
                    $('.noUploadImg').html('<img src="/uploads/spot/' + file_name + '" width="321px"  alt="coupon"/>' +
                        '<span class="cancel"></span>');
                }
                if (error) alert(error);
            }
        });
    });

    $(document).ready(function () {
        $('.upload-img').click(function () {
            var id = $(this).attr("href");

            if (id) {
                $.ajax({
                    url:'/ajax/spotView',
                    type:'POST',
                    data:{discodes_id:id},
                    success:function (result) {
                        $('#spot_content_' + id).html(result);
                    }
                });
            }
            return false;
        });
    });

</script>
