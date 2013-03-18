<?php
$this->pageTitle='Error';
$this->breadcrumbs=array(
  'Error',
);
?>
<div id="main-container">
<div style="text-align: center">
<h2>Error <?php echo $code; ?></h2>

<div class="error">
<?php echo CHtml::encode($message); ?>
</div>

</div>
</div>