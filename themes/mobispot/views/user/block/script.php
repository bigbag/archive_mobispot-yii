<script type="text/javascript">

//невидимость спота спота
$(document).ready(function () {
    $('#spot_invisible_modal span.invisible').click(function () {
        $('.spot_invisible_form').submit();
    });
});

$(document).ready(function () {
    var options = {
        success:showSpotInvisibleResponse,
        clearForm:false,
        url:'/ajax/spotInvisible/'
    };

    $('.spot_invisible_form').submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });

});

function showSpotInvisibleResponse(responseText) {
    if (responseText) {
        var obj = jQuery.parseJSON(responseText);

        if (obj.discodes_id) {
            var id = obj.discodes_id;
            var status = obj.status;
            $('#status_' + id + ' input').val(status);
            $('.close-reveal-modal').click();
        }
    }
}

//Редактирование спота
$(document).ready(function () {
    var options = {
        success:showSpotEditResponse,
        clearForm:false,
        url:'/ajax/spotEdit/'
    };
    $('body').delegate('.spot_edit_content', 'submit', function () {
        $(this).ajaxSubmit(options);
        return false;
    });
});

function showSpotEditResponse(responseText) {
    if (responseText) {
        var obj = jQuery.parseJSON(responseText);

        if (obj.discodes_id) {
            var id = obj.discodes_id;
            if (id) {
                $('span#message_' + id).text('<?php echo Yii::t('account', 'Изменения успешно сохранены.')?>');
                $('span#message_' + id).show();
                setTimeout(function () {
                    $('span#message_' + id).hide();
                }, 3000);
            }

        }
    }
}

//копирование спота
$(document).ready(function () {
    var options = {
        success:showSpotCopyResponse,
        clearForm:true,
        url:'/ajax/spotCopy/'
    };

    $('.spot_copy_form').submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });

});

function showSpotCopyResponse(responseText) {
    if (responseText) {
        var obj = jQuery.parseJSON(responseText);

        var id = obj.discodes_id;
        var spot_type = obj.spot_type;
        var spot_name = obj.spot_name;

        if (id && spot_type && spot_name){
            $('#name_' + id + ' div.name').html(spot_name);
            $('#type_' + id + ' div.type').html(spot_type);
            $('.close-reveal-modal').click();
        }
    }
}
</script>