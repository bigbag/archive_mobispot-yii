<table cellpadding="0" cellspacing="0" border="0" align="center">
    <tr>
        <td align="center">
            <a href="<?php echo Yii::app()->request->getBaseUrl(true);?>">
                <img src="<?php echo Yii::app()->request->getBaseUrl(true);?>/themes/mobispot/images/mail/logotype.png"
                     alt=""/>
            </a>
        </td>
    </tr>
    <tr>
        <td align="center" height="40" valign="middle">
            <?php echo $title?>
        </td>
    </tr>
    <tr>
        <td width="700" height=""
            style="font-size:14px; font-family:Helvetica; color:#707070; border:0px solid;border-radius:25px;background:#efefef;padding:30px;">
            <?php echo $message?>
        </td>
    </tr>
    <tr>
        <td align="center" height="40" valign="middle"
            style="color: #999999;font-size: 10px;font-weight: bold;font-family:Helvetica;">
            <?php echo Yii::t('mail', 'С УВАЖЕНИЕМ, КОМАНДА ПРОЕКТА "МОБИСПОТ"')?>
        </td>
    </tr>
</table>