<div class="contSpot">
    <div id="feedback">
        <a href="<?php echo $discodes_id;?>" class="btn-30">
            <span class="back-ico ico"></span>
            <span class="btn-30-txt"><?php echo Yii::t('account', 'Вернуться в спот');?></span>
        </a>
    </div>

    <div class="oneSpotInfo">

        <table class="feedbackMailInfo" cellpadding="6" cellspacing="0">
            <tbody>
            <tr class="headTBL">
                <td><?php echo Yii::t('account', 'Дата и время');?></td>
                <td><?php echo Yii::t('account', 'Имя');?></td>
                <td><?php echo Yii::t('account', 'Телефон');?></td>
                <td><?php echo Yii::t('account', 'E-mail');?></td>
                <td><?php echo Yii::t('account', 'Комментарий');?></td>
            </tr>
            <?php foreach ($spot as $row): ?>
            <tr>
                <td><?php echo Yii::app()->dateFormatter->format("dd.MM.yyyy", $row['creation_date']);?>
                <td><?php echo mb_substr($row['name'], 0, 45, 'utf-8'); ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo CHtml::encode($row['comment'])?></td>
            </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="clear"></div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#feedback').click(function () {
            var id = $('#feedback a').attr("href");

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