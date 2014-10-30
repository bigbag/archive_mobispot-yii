<p>Заказ успешно оформлен.</p>
<p>Ваша карта:</p>
<table>
<tr>
<td style="vertical-align:top">
<div style="background-image: url('<?php echo $this->getBaseUrl(); ?>/uploads/transport/<?php echo $back_img; ?>');
width: 513px;height: 321px;background-color: #FFF;border: 1px solid #E9EDF2;
overflow: hidden;text-align: center;border-radius: 30px;position: relative;
background-size: cover;margin: 0px;padding: 0px;">
<img style="position:absolute;top:104px;left:30px;"src="<?php echo $this->getBaseUrl(); ?>/themes/mobispot/img/mail/card_vertical_arm.png">
</div>
</td>
<td>
<div style="width: 321px;
height: 513px;
border-radius: 30px;
background: none repeat scroll 0% 0% #E9EDF2;background-color: #FFF;border: 1px solid #E9EDF2;overflow: hidden;text-align: center;border-radius: 30px;position: relative;
background-size: cover;">
    <img style="position:absolute;top:30px;left:104px;"src="<?php echo $this->getBaseUrl(); ?>/themes/mobispot/img/mail/card_horizontal_arm.png">
    <div style="border: 1px solid #E9EDF2;border-radius: 50%;display: inline-block;
vertical-align: middle;height: 165px;width: 165px;line-height: 166px;
text-align: center;margin-top: 115px;overflow: hidden;position: relative;box-sizing: border-box;"> 
<img style="width:100%" src="<?php echo $this->getBaseUrl(); ?><?php echo $photo; ?>">
    </div>
    <div style="margin: 21px 0px 11px;height: 157px;font-family:museo_sans_cyrl100,Arial,Helvetica,sans-serif;">
        <div style="font-size: 33px;color: rgba(0, 0, 0, 0.75);
padding: 11px 35px;">
            <?php echo $name; ?>
        </div>
        <div style="overflow: hidden;word-wrap: break-word;resize: none;height: 50px;font-size: 18px;padding: 11px 50px;height: 50px;color: #8D9095;text-align: center;border: 0px none;position:relative;top:-15px">
            <?php echo $position; ?>
        </div>
    </div>
    <div style="display: block;margin: 0px auto;line-height: 17px;overflow:hidden;width:230px;height:60px;padding:0px;position:relative;top:-25px;">
        <img style="width:100%" src="<?php echo $this->getBaseUrl(); ?><?php echo $logo; ?>">
    </div>
</div>
</td>
</tr>
</table>
<p>Данные доставки:</p>
<table>
<tr>
<td>Имя:
</td>
<td>
<?php echo $shipping_name; ?>
</td>
</tr>
<tr>
<td>Телефон:
</td>
<td>
<?php echo $phone; ?>
</td>
</tr>
<tr>
<td>Адрес:
</td>
<td>
<?php echo $address; ?>
</td>
</tr>
<tr>
<td>Город:
</td>
<td>
<?php echo $city; ?>
</td>
</tr>
<tr>
<td>Индекс:
</td>
<td>
<?php echo $zip; ?>
</td>
</tr>
</table>
<p><br></p>
<p>&copy;  Mobispot Social Systems Pte. Ltd.<br>
<a href="mailto:hola@mobispot.com">hola@mobispot.com</a></p>
<p>Follow us in <a href="https://www.facebook.com/heyMobispot" target="_blank">Facebook</a> or  <a href="https://twitter.com/heymobispot" target="_blank">Twitter</a></p>