BEGIN:VCARD<?php echo "\r\n" ?>
VERSION:3.0<?php echo "\r\n" ?>
FN:<?php echo $content->imya_3; ?><?php echo "\r\n" ?>
N:<?php echo $content->imya_3; ?><?php echo "\r\n" ?>
<?php if (!empty($content->fotografiya_3)): ?>
<?php $filename = Yii::getPathOfAlias('webroot.uploads.spot.').'/'.$content['fotografiya_3'];?>
<?php if (file_exists($filename)):?>
<?php $photo=base64_encode(file_get_contents($filename));?>
PHOTO;TYPE=JPEG;ENCODING=B:<?php echo $photo . "\r\n";?>
<?php endif;?>
<?php endif; ?>
<?php if (!empty($content->kontaktyi_3) and !empty($content['kontaktyi_3'][2])): ?>
EMAIL;TYPE=INTERNET:<?php echo $content['kontaktyi_3'][2]; ?><?php echo "\r\n" ?>
<?php endif; ?>
<?php if (!empty($content->kontaktyi_3) and !empty($content['kontaktyi_3'][1])): ?>
TEL:<?php echo $content['kontaktyi_3'][1]; ?><?php echo "\r\n" ?>
<?php endif; ?>
<?php if (!empty($content->kontaktyi_3) and !empty($content['kontaktyi_3'][15])): ?>
URL:<?php echo YText::formatUrl($content['kontaktyi_3'][15]) ?><?php echo "\r\n" ?>
<?php endif; ?>
<?php if (!empty($content->kontaktyi_3) and !empty($content['kontaktyi_3'][13])): ?>
X-ICQ:<?php echo $content['kontaktyi_3'][13]; ?><?php echo "\r\n" ?>
<?php endif; ?>
END:VCARD
