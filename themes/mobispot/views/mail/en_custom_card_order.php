<html>
<head>
    <style type="text/CSS">
        body, #body_style {
            background:#f4f4f4;
            font-family:Helvetica, Arial, sans-serif;
            color:#000000;
            font-size:15pt;} 
         
        .ExternalClass {width:100%;}
        .yshortcuts {color: #F00;}
    </style>
    <meta charset="utf-8" />
</head>

<body style="background:#f4f4f4;font-family:Helvetica, Arial, sans-serif;
   font-size:15pt" alink="#FF0000" link="#FF0000" bgcolor="#f4f4f4" text="#FFFFFF">
   
<div id="body_style"> 

<table style="background-color:#f4f4f4;width:100%;padding:30px 0 0 0;margin:0; font-family:Helvetica, Arial, sans-serif;font-size:15pt;border-collapse:collapse;color:#000000" border="0" cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td style="padding:60px 90px;width:100%;border-collapse:collapse;">
    <img width=198 alt="mobispot" src="http://mobispot.com/themes/mobispot/images/mail/mobispot2.png"/>
<div style="padding-top:30px">
    <p><?php echo $shipping_name; ?>, здравствуйте.</p>
    <p style="line-height: 1.2">Заказ на вашу карту с индивидуальным дизайном был успешно оформлен. Как только дизайн будет одобрен, карта будет передана в производство и отправлена на указанный вами адрес.</p>
    
    <p style="line-height: 1.2">
        Данные доставки:<br>
    </p>
    <p style="line-height: 1.2">
        Имя: <?php echo $shipping_name; ?><br>
        <?php if (!empty($phone)):?>
            Телефон: <?php echo $phone; ?><br>
        <?php endif; ?>
        Адрес: <?php echo $address; ?><br>
        Город: <?php echo $city; ?><br>
        Индекс: <?php echo $zip; ?>
    </p>
    
    <div style="position:relative;width:321px;height:513px;">
        <?php if (!empty($draw_hole)): ?>
            <div style="position:absolute;width:92px;height:23px;
                left:115px;top:24px;border-radius:30px;
                background:#E9EDF2 none repeat scroll 0% 0%;">
            </div>
        <?php endif; ?>
        <img width="321" height="513" style="border-radius:30px;-webkit-border-radius:30px;-moz-border-radius:30px;" src="<?php echo $this->getBaseUrl(); ?>/uploads/custom_card/<?php echo $front_img; ?>">
    </div>

</div>

<p style="line-height: 1.2">
    Спасибо,<br>
    Команда Мобиспот
</p>
</td>
</tr>
<tr>
<td style="margin:0; width:100%; height:2px;padding:0; background-color:#dbdbdb;border-collapse:collapse" >
</td>
</tr>
<tr>
<td style="margin-top:80px; width:100%; padding:80px 30px;" >
        <div style="width:100%;text-align:center;">
            <a href="https://www.facebook.com/heyMobispot" style="text-decoration:none" target="_blank">
                <img width=41 height=41 alt="Facebook" width=50 height=50 src="http://mobispot.com/themes/mobispot/images/mail/facebook.jpg"/>
            </a>
            <div style="display:inline-block;width:35px;"></div>
            <a href="https://twitter.com/heymobispot" style="text-decoration:none" target="_blank">
                <img width=41 height=41 alt="Twitter" width=50 height=50 src="http://mobispot.com/themes/mobispot/images/mail/twitter.jpg"/>
            </a>
        </div>
        <div style="margin-top:30px;width:100%;text-align:center;font-size:12pt;color:#7f7f7f">&copy; 2015 ООО "Мобиспот Рус"/Mobispot Rus LLC<br>
            hola@mobispot.com<br>
        </div>
</td>
</tr>
</tbody>
</table>

</div>
</body>
</html>