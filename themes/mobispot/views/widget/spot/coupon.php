<form action="" method="post" class="spot_edit_content"
      id="spot_edit_content_<?php echo $content->spot_id ?>">
          <?php echo CHtml::activeHiddenField($content, 'spot_id'); ?>
          <?php echo CHtml::activeHiddenField($content, 'spot_type_id'); ?>
          <?php echo CHtml::activeHiddenField($content, 'kupon_4', array('id' => 'spot_coupon_field')); ?>
</form>
<div class="coupon">
    <?php include('block/_coupon_simple.php'); ?>
    <?php include('block/_coupon_desinger.php'); ?>
</div>

<script type="text/javascript">

    $('#body_color').miniColors();
    $('#text_color').miniColors();

    $(document).ready(function() {
        $('.constr').click(function() {
            alert(1);

            $('.coupon-simple').hide();
            $('.coupon-desinger').show();
            return false;
        });
    });

    $(document).ready(function() {
        $('.upload-img').click(function() {
            $('.coupon-simple').show();
            $('.coupon-desinger').hide();
            return false;
        });
    });

    $(function() {
        $('body').delegate('.coupon-simple .image i.icon-remove', 'click', function() {
            $('#spot_coupon_field').val('');
            $('.coupon-simple .image').html('<img src="/themes/mobispot/images/coupon_no_image.png" alt="coupon"/>');
        });
        return false;
    });

    $(function() {
        $("#add-file").uploadifive({
            'width': '120px',
            'height': '30px',
            'fileTypeExts': '*.pdf; *.gif; *.jpg; *.png',
            uploadScript: '/user/uploadFile/',
            'formData': {'spot_id':<?php echo($data->discodes_id) ?>},
            'fileSizeLimit': '512KB',
            'removeTimeout': 10,
            'multi': false,
            'buttonClass': 'm-button',
            'buttonText': '<i class="icon-upload"></i>&nbsp;<?php echo Yii::t('profile', 'Загрузить'); ?>',
            'onError': function(errorType) {
                $('#messages_modal div.messages').html('The file could not be uploaded: ' + errorType);
                $('#messages_modal').reveal({animation: 'none'});
            },
            'onUploadComplete': function(file, data, response) {
                var obj = jQuery.parseJSON(data);
                var file_name = obj.file;
                var error = obj.error;
                if (file_name) {
                    $('#spot_coupon_field').val(file_name);
                    $('.coupon-simple .image').html('<img src="/uploads/spot/' + file_name + '" width="321px"  alt="coupon"/>' +
                            '<i class="icon-large icon-remove"></i>');
                }
                if (error)
                    alert(error);
            }
        });
    });

    $(function() {
        $('body').delegate('.result_upload i.icon-remove', 'click', function() {
            $('.coupon_logo').val('');
            $('.result_upload').empty();
        });
        return false;
    });

    $(function() {
        $("#add_file_desinger").uploadifive({
            'width': '120px',
            'height': '30px',
            'fileTypeExts': '*.pdf; *.gif; *.jpg; *.png',
            uploadScript: '/user/uploadCouponLogo/',
            'formData': {'spot_id':<?php echo($data->discodes_id) ?>},
            'fileSizeLimit': '512KB',
            'removeTimeout': 10,
            'multi': false,
            'buttonClass': 'm-button',
            'buttonText': '<i class="icon-upload"></i>&nbsp;<?php echo Yii::t('profile', 'Загрузить'); ?>',
            'onError': function(errorType) {
                $('#messages_modal div.messages').html('The file could not be uploaded: ' + errorType);
                $('#messages_modal').reveal({animation: 'none'});
            },
            'onUploadComplete': function(file, data, response) {
                var obj = jQuery.parseJSON(data);
                var file_name = obj.file;
                var error = obj.error;
                if (file_name) {
                    $('.coupon_logo').val(file_name);
                    $('.result_upload').html(file.name + '<i class="icon-large icon-remove"></i>');
                }
                if (error)
                    alert(error);
            }
        });
    });

//Генерация купона
    $(document).ready(function() {
        var options = {
            success: showCouponGenerateResponse,
            clearForm: false,
            url: '/ajax/couponGenerate/'
        };

        $('.generation_coupon').submit(function() {
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

    $('input.txt').bind('focus', function() {
        $(this).parent().css('background-position', '100% -105px');
        $(this).parent().parent().css('background-position', '0 -70px');
    });
    $('input.txt').bind('blur', function() {
        $(this).parent().css('background-position', '100% -35px');
        $(this).parent().parent().css('background-position', '0 0');
    });
</script>