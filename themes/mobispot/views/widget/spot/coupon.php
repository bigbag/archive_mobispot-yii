<div class="oneSpot">
    <div class="contSpot">
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
            <form action="" method="post" class="spot_edit_content"
                  id="spot_edit_content_<?php echo $content->spot_id?>">
                <?php echo CHtml::activeHiddenField($content, 'spot_id'); ?>
                <?php echo CHtml::activeHiddenField($content, 'spot_type_id'); ?>
                <?php echo CHtml::activeHiddenField($content, 'kupon_4', array('id' => 'spot_coupon_field')); ?>
            </form>
            <?php include('block/_coupon_simple.php'); ?>
            <?php include('block/_coupon_desinger.php'); ?>
        </div>
        <div class="clear"></div>
    </div>
</div>
<script type="text/javascript">

    $('#body_color').miniColors();
    $('#text_color').miniColors();

    $(document).ready(function () {
        $('a#desinger').click(function () {
            $('.coupon_simple').hide();
            $('.coupon_desinger').show();
            return false;
        });
    });

    $(document).ready(function () {
        $('.upload-img').click(function () {
            $('.coupon_simple').show();
            $('.coupon_desinger').hide();
            return false;
        });
    });

    $(function () {
        $('body').delegate('.noUploadImg span.cancel', 'click', function () {
            $('#spot_coupon_field').val('');
            $('.noUploadImg').html('<img src="/themes/mobispot/images/coupon_no_image.png" alt="coupon"/>');
        });
        return false;
    });

    $(function () {
        $("#add_file_simple").uploadifive({
            'width':'120',
            'height':'28',
            'fileTypeExts':'*.pdf; *.gif; *.jpg; *.png',
            uploadScript:'/user/uploadFile/',
            'formData':{'spot_id':<?php echo($data->discodes_id)?>},
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

    $(function () {
        $('body').delegate('.result_upload span.cancel', 'click', function () {
            $('.coupon_logo').val('');
            $('.result_upload').empty();
        });
        return false;
    });

    $(function () {
        $("#add_file_desinger").uploadifive({
            'width':'120',
            'height':'28',
            'fileTypeExts':'*.pdf; *.gif; *.jpg; *.png',
            uploadScript:'/user/uploadFile/',
            'formData':{'spot_id':<?php echo($data->discodes_id)?>},
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
                    $('.coupon_logo').val(file_name);
                    $('.result_upload').html(file.name + '<span class="cancel"></span>');
                }
                if (error) alert(error);
            }
        });
    });

    //Генерация купона
    $(document).ready(function () {
        var options = {
            success:showCouponGenerateResponse,
            clearForm:true,
            url:'/ajax/couponGenerate/'
        };

        $('.generation_coupon').submit(function () {
            $(this).ajaxSubmit(options);
            return false;
        });
    });

    function showCouponGenerateResponse(responseText) {
        var obj = jQuery.parseJSON(responseText);
        var file_name = obj.file;
        if (file_name) {
            $('#spot_coupon_field').val(file_name);
            $('.time-form .fright').html('<img src="/uploads/spot/' + file_name + '" alt="coupon"/>');
        }
    }
</script>