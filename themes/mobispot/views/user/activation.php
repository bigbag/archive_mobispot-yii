<?php
$this->pageTitle = $title;

?>
<div style="text-align: center">
    <h2><?php echo $title; ?></h2>

    <div class="error">
        <?php echo CHtml::encode($content); ?>
    </div>

</div>
