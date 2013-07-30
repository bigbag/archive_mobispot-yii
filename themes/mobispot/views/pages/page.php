<div class="row">
    <div class="large-12 columns">
        <h1 class="color text-center"><?php echo $model->title; ?></h1>

        <div class="content">
            <?php if (!empty($model->menu)): ?>
                <div id="page_menu">
                    <?php echo $model->body; ?>
                </div>
            <?php endif; ?>
            <?php echo $model->body; ?>
        </div>
    </div>
</div>