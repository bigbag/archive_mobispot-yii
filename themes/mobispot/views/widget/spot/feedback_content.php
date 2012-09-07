<div style="display: block;" class="contSpot">
    <div id="feedback">
        <a href="<?php echo $discodes_id;?>" class="btn-30">
            <span class="back-ico ico"></span>
            <span class="btn-30-txt">Вернуться в спот</span>
        </a>
    </div>

    <div class="oneSpotInfo">

        <table class="feedbackMailInfo" cellpadding="6" cellspacing="0">
            <tbody>
            <tr class="headTBL">
                <td>Дата и время</td>
                <td>Имя</td>
                <td>Телефон</td>
                <td>E-mail</td>
                <td>Комментарий</td>
            </tr>
            <?php foreach($spot as $row):?>
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