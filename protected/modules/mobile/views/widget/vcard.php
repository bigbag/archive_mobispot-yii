BEGIN:VCARD<?php echo "\r\n" ?>
VERSION:3.0<?php echo "\r\n" ?>
FN:<?php echo $content->imya_3; ?><? echo "\r\n" ?>
N:<?php echo $content->imya_3; ?><? echo "\r\n" ?>
<?php if (!empty($content->fotografiya_3)): ?>
  PHOTO;ENCODING=BASE64;JPEG:<?php
  $filename = Yii::getPathOfAlias('webroot.uploads.spot.') . '/' . $content['fotografiya_3'];
  if (fopen($filename, "rb")) {
    $handle = fopen($filename, "rb");
    $img = fread($handle, filesize($filename));
    fclose($handle);
    echo base64_encode($img);
  }
  ?>
  <? echo "\r\n" ?>
<?php endif; ?>
<?php if (!empty($content->kontaktyi_3) and !empty($content['kontaktyi_3'][2])): ?>
  EMAIL;TYPE=INTERNET:<?php echo $content['kontaktyi_3'][2]; ?><? echo "\r\n" ?>
<?php endif; ?>
<?php if (!empty($content->kontaktyi_3) and !empty($content['kontaktyi_3'][1])): ?>
  TEL:<?php echo $content['kontaktyi_3'][1]; ?><? echo "\r\n" ?>
<?php endif; ?>
<?php if (!empty($content->kontaktyi_3) and !empty($content['kontaktyi_3'][15])): ?>
  URL:<?php echo YText::formatUrl($content['kontaktyi_3'][15]) ?><? echo "\r\n" ?>
<?php endif; ?>
<?php if (!empty($content->kontaktyi_3) and !empty($content['kontaktyi_3'][13])): ?>
  X-ICQ:<?php echo $content['kontaktyi_3'][13]; ?><? echo "\r\n" ?>
<?php endif; ?>
END:VCARD