<div id="personal">
    <a href="<?php echo $discodes_id;?>" class="btn-30">
        <span class="back-ico ico"></span>
        <span class="btn-30-txt"><?php echo Yii::t('account', 'Вернуться в спот');?></span>
    </a>
</div>
<div id="add_field">
    <a href="<?php echo $discodes_id;?>" class="btn-30">
        <span class="btn-30-txt"><?php echo Yii::t('account', 'Добавить в спот');?></span>
    </a>
</div>
<div class="oneSpotInfo">
    <form action="" method="post" class="add_field">
        <input type="hidden" name="discodes_id" value="<?php echo $discodes_id;?>">
        <input type="hidden" name="type_id" value="<?php echo $type_id;?>">
        <ul class="addSocSet">
            <?php foreach ($all_field as $row): ?>
            <li>
                <?php if(isset($select_field[$row['id']])):?>
                    <input type="checkbox" class="niceCheck" name="Fields[<?php echo $row['id'];?>]" checked="checked">
                <?php else:?>
                    <input type="checkbox" class="niceCheck" name="Fields[<?php echo $row['id'];?>]">
                <?php endif;?>

            <span>
                <img src="/uploads/ico/<?php echo $row['ico']?>" alt="" width="23" height="23">
            </span><?php echo $row['name']; ?>
            </li>
            <?php endforeach;?>
        </ul>
    </form>
</div>
<div class="clear"></div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#personal').click(function () {
            var id = $('#personal a').attr("href");

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

    $(document).ready(function () {
        $('#add_field').click(function () {
            $('.add_field').submit();
            return false;
        });
    });

    $(document).ready(function () {
        var options = {
            success:showFieldResponse,
            clearForm:false,
            url:'/ajax/spotPersonalField/'
        };

        $('.add_field').submit(function () {
            $(this).ajaxSubmit(options);
            return false;
        });
    });

    function showFieldResponse(responseText) {

    }

</script>