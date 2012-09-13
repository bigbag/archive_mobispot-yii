BEGIN:VCARD
VERSION:3.0
FN:<?php echo $content->imya_3; ?>
N:<?php echo $content->imya_3; ?>
<?php foreach ($all_field as $row): ?>
<?php if (in_array($row['id'], $select_field)): ?>
<?php echo $row['vcard']; ?>:<?php echo $data[$row['id']]; ?><? echo "\r\n" ?>
<?php endif; ?>
<?php endforeach; ?>
END:VCARD
