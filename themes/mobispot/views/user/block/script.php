<script type="text/javascript">
//аккардеон
$(document).ready(function () {

    $('body').delegate('div.spot-title>div.six.columns', 'click', function (e) {
        var spot = $(this).parent().parent();
        var spot_content = spot.find('div.twelve.columns.spot-content');
        if (e.target.tagName == 'INPUT' || e.target.tagName == 'SPAN' || e.target.tagName == 'A')        return;

        if (spot_content.is(":hidden")) {
            var id = spot.attr('id');
            //загрузка содержимого спота
            if (id) {
                $.ajax({
                    url:'/ajax/spotView',
                    type:'POST',
                    data:{discodes_id:id},
                    success:function (result) {
                        $('#' + id  + ' .spot-content-body').html(result);
                    }
                });
            }
            $('div.twelve.columns.spot-content').hide();
            spot_content.slideToggle(300);


        }
        else spot_content.slideUp(300);
        return false;

    });
});



//добавление спота
//модальное окно
$(document).ready(function () {
    $('.add-spot').click(function () {
        $('#spot_add_modal').reveal({animation:'none'});
    });
});

//проверка спота на корректность, отображение типов
$(document).ready(function () {
    $("#spot_add_code").keyup(function () {
        var code = $(this).val();
        var count = code.length;

        if (count == 10) {
            $(".spot_code input").prop('disabled', true);
            $("#spot_add_modal input.code").val(code);
            $.ajax({
                url:'/ajax/spotAdd',
                dataType:"json",
                type:'POST',
                data:{code:code},
                success:function (result) {
                    if (result === null) {
                        $(".spot_code input").prop('disabled', false);
                        $('#spot_add_modal span.error').text('<?php echo Yii::t('account', 'Код неверен')?>');
                    }
                    else {
                        $('#spot_add_modal .spot_type_all').show();
                    }
                }
            });
        }
        else if (count < 10) {
            $('#spot_add_modal span.error').empty();
        }
        return false;
    });
});

//сохранение спота
$(document).ready(function () {
    var options = {
        success:showSpotAddResponse,
        clearForm:true,
        url:'/ajax/spotAdd/'
    };

    $('.spot_add_form').submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });

});

function showSpotAddResponse(responseText) {
    if (responseText) {
        $('#spotslistview').prepend(responseText);
        jQuery(".niceCheck").each(
                function () {
                    changeCheckStart(jQuery(this));
                });
        $('.close-reveal-modal').click();
    }
}

//переименование спота
$(document).ready(function () {
    var options = {
        success:showSpotRenameResponse,
        clearForm:false,
        url:'/ajax/spotRename/'
    };

    $('.spot_rename_form').submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });

});

function showSpotRenameResponse(responseText) {
    var obj = jQuery.parseJSON(responseText);

    if (responseText) {
        if (obj.name) {
            var name = obj.name;
            var id = obj.discodes_id;

            $('#' + id + ' .spot-name div.name').html(name);
            $('#' + id + ' .spot-name div.rename').hide();
            $('#' + id + ' .spot-name div.name').show();
        }
        return false;
    }
}

//изменение типа спота
$(document).ready(function () {
    var options = {
        success:showSpotRetypeResponse,
        clearForm:false,
        url:'/ajax/spotRetype/'
    };

    $('.spot_retype_form').submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });

});

function showSpotRetypeResponse(responseText) {
    if (responseText) {
        var obj = jQuery.parseJSON(responseText);

        if (obj.spot_type) {
            var spot_type = obj.spot_type;
            var spot_type_id = obj.spot_type_id;
            var id = obj.discodes_id;

            $("#" + id + " .spot-type #Spot_spot_type_id [value='" + spot_type_id + "']").attr("selected", "selected");

            $('#' + id + ' .spot-type div.retype').hide();
            $('#' + id + ' .spot-type div.type').html(spot_type);
            $('#' + id + ' .spot-type div.type').show();
        }
        return false;
    }
}

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

//очистка спота
$(document).ready(function () {
    $('#spot_clear_modal span.clear').click(function () {
        $('.spot_clear_form').submit();
    });
});

$(document).ready(function () {
    var options = {
        success:showSpotClearResponse,
        clearForm:false,
        url:'/ajax/spotClear/'
    };

    $('.spot_clear_form').submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });

});

function showSpotClearResponse(responseText) {
    if (responseText) {
        var obj = jQuery.parseJSON(responseText);

        if (obj.discodes_id) {
            var id = obj.discodes_id;
            $('.close-reveal-modal').click();
        }
    }
}

//удаление спота
$(document).ready(function () {
    $('#spot_remove_modal span.remove').click(function () {
        $('.spot_remove_form').submit();
    });
});

$(document).ready(function () {
    var options = {
        success:showSpotRemoveResponse,
        clearForm:false,
        url:'/ajax/spotRemove/'
    };

    $('.spot_remove_form').submit(function () {
        $(this).ajaxSubmit(options);
        return false;
    });

});

function showSpotRemoveResponse(responseText) {
    if (responseText) {
        var obj = jQuery.parseJSON(responseText);

        if (obj.discodes_id) {
            var id = obj.discodes_id;
            $('#' + id).remove();
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