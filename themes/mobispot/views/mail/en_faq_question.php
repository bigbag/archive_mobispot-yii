<div bgcolor="#ffffff" style="padding:30px 0;margin:0; width:660px;  font-family:Arial, sans-serif;font-size:12pt;">
<div style="padding-left:30px">
    <img src="http://mobispot.com/themes/mobispot/images/mail/mobispot.png"/>
</div>
<br /><br />
<div style="background:#f1f3f4; padding:30px; width:600px;">
    <h2 style="color: #0062ff;font-size:1.5em;">New question from the user.</h2>

    <p>User <?php echo $name;?>, <?php echo ($phone)?$phone.',':'';?> <?php echo $email;?> left the next question:</p>
    <p><?php echo nl2br(CHtml::encode($question))?></p>
</div>
<table style="margin-top:40px; width:660px; padding:0 30px" >
    <tr>
        <td rowspan="2" style="text-align:left;align:left;">&copy; Mobispot Social Systems. All rights reserved<br>
            hola@mobispot.com<br>
        </td>
    </tr>
</table>
</div>
