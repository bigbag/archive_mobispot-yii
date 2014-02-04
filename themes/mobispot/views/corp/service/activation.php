<?php
$this->pageTitle=$title;

?>
<div id="changePassForm" class="row header-page recovery m-content-form">
  <div class="twelve columns">
    <div  class="row">
      <div class="seven columns centered">
        <h3><?php echo $title;?></h3>
      </div>
    </div>
    <div class="row">
      <div class="five columns centered">
        <?php echo CHtml::encode($content); ?>
      </div>
    </div>
  </div>
</div>