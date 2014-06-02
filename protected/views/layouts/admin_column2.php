<?php $this->beginContent('//layouts/admin_main'); ?>
<div class="span-19">
  <div id="content">
    <?php echo $content; ?>
  </div>
  <!-- content -->
</div>
<div class="span-5 last">
  <div id="sidebar">
    <?php
    $this->beginWidget('zii.widgets.CPortlet', array(
        'title' => Yii::t('admin', 'Операции'),
    ));
    $this->widget('zii.widgets.CMenu', array(
        'items' => $this->menu,
        'htmlOptions' => array('class' => 'operations'),
    ));
    $this->endWidget();
    ?>
  </div>
  <!-- sidebar -->
</div>
<?php $this->endContent(); ?>
