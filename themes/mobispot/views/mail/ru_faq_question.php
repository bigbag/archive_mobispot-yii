<table cellpadding="0" cellspacing="0" border="0" align="center">
    <tr>
        <td align="center">
          <a href="http://mobispot.com">
                <img src="http://mobispot.com/themes/mobispot/images/mail/logotype.png"
                     alt=""/>
            </a>
        </td>
    </tr>
    <tr>
        <td align="center" height="40" valign="middle">
          Новый вопрос от пользователя.
        </td>
    </tr>
    <tr>
        <td width="700" height=""
            style="font-size:14px; font-family:Helvetica; color:#707070; border:0px solid;border-radius:25px;background:#efefef;padding:30px;">
              Пользователь <?php echo $name?>, <?php echo $email?> оставил следующий вопрос:<br />
          <p><?php echo nl2br(CHtml::encode($question))?></p>
              
        </td>
    </tr>
    <tr>
        <td align="center" height="40" valign="middle"
            style="color: #999999;font-size: 10px;font-weight: bold;font-family:Helvetica;">
            <?php echo Yii::t('mail', 'С УВАЖЕНИЕМ, КОМАНДА ПРОЕКТА "МОБИСПОТ"')?>
        </td>
    </tr>
</table>