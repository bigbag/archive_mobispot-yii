<div class="page">
    <div class="title"><?php echo $model->title;?></div>

    <div class="content">
        <?php if (!empty($model->menu)): ?>
        <div id="page_menu">
            <?php echo $model->body;?>
        </div>
        <?php endif;?>
        <?php echo $model->body;?>
    </div>


</div>
