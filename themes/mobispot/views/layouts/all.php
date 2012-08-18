<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php include('block/header.php');?>
<body>
<div id="wrapper">
    <div id="header">
        <?php include('block/menu.php');?>
    </div>
    <?php echo $content; ?>
</div>
<div class="center-rel">
    <?php include('block/footer.php');?>
</div>
<?php include('block/script.php');?>
<?php include('modal/recovery.php');?>
</body>
</html>