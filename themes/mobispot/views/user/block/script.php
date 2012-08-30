<script type="text/javascript">
    //аккардеон
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

    //добавление спота
    //модальное окно
    $(document).ready(function () {
        $('.spot_add_modal').click(function () {
            $('#spot_add_modal').reveal();
        });
    });

    //проверка спота на корректность, отображение типов
    $(document).ready(function()
    {
        $("#spot_add_code").keyup(function()
        {
            var code = $(this).val();
            var count = code.length;

            if(count == 10) {
                $(".spot_code input").prop('disabled', true);
                $("#spot_add_modal input.code").val(code);
                $.ajax({
                    url:'/ajax/spotAdd',
                    dataType:"json",
                    type:'POST',
                    data:{code:code},
                    success:function(result){
                        if (result === null) {
                            $(".spot_code input").prop('disabled', false);
                            $('#spot_add_modal span.error').text('<?php echo Yii::t('account', 'Код неверен')?>');
                        }
                        else {
                            $('#spot_add_modal .spot_type_' + result).show();
                            $("#spot_add_modal select").selectBox('destroy');
                            $("#spot_add_modal select").selectBox('create');
                        }
                    }
                });
            }
            else if (count < 10){
                $('#spot_add_modal span.error').empty();
            }
            return false;
        });
    });

    //сохранение спота
    $(document).ready(function () {
        var options = {
            success:showSpotAddResponse,
            clearForm:false,
            url:'/ajax/spotAdd/'
        };

        $('.spot_add_form').submit(function () {
            $(this).ajaxSubmit(options);
            return false;
        });

    });

    function showSpotAddResponse(responseText) {
        if (responseText) {
            $().redirect('/user/account/', null, 'GET');
        }
    }

    //диспенчер выбора операций
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
                    $(".retype select").selectBox('destroy');
                    $(".retype select").selectBox('create');
                }
                else if (action == <?php echo Spot::ACTION_EMPTY; ?>){
                    $('b.spot_clear_id').text(id);
                    $('#spot_clear_modal').reveal();
                }
                else if (action == <?php echo Spot::ACTION_REMOVE; ?>){
                    $('b.spot_clear_id').text(id);
                    $('#spot_remove_modal input').val(id);
                    $('#spot_remove_modal').reveal();
                }

                resetSelect('#foot-cont-block');
                $('input[name=discodes_id]').attr('checked', false);
                $('span.niceCheck').removeClass('niceChecked');
            }
            return false;
        });
    });

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
            if (obj.name){
                var name = obj.name;
                var id = obj.discodes_id;

                $('#name_' + id + ' div.name').html(name);
                $('#name_' + id + ' div.rename').hide();
                $('#name_' + id + ' div.name').show();
                $('.noView').show();
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

            if (obj.spot_type){
                var spot_type = obj.spot_type;
                var id = obj.discodes_id;

                $('#type_' + id + ' div.type').html(spot_type);
                $('#type_' + id + ' div.retype').hide();
                $('#type_' + id + ' div.type').show();
                $('.noView').show();
            }
            return false;
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

            if (obj.discodes_id){
                var id = obj.discodes_id;
                $('#spot_' + id).remove();
                $('.close-reveal-modal').click();
            }

        }
    }
</script>