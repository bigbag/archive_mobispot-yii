<div id="main-container">
    <div id="cont-block" class="center">
        <div id="cont-block-900" class="center">
            <div id="zag-cont-block"><?php echo $model->title;?></div>

            <div id="blockPage">
                <?php if (!empty($model->menu)):?>
                <div id="page_menu">
                    <?php echo $model->body;?>
                </div>
                <?php endif;?>
                <?php echo $model->body;?>
            </div>

            <div class="clear"></div>
        </div>

    </div>
