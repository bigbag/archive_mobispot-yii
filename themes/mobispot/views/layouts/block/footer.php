<div class="row">
    <div class="three columns">
        <?php $all_link = ContentLinksFooter::getLinks();?>
        <?php foreach ($all_link as $row):?>
        <span><a href="<?php echo $row['link'];?>"><?php echo $row['name'];?></a></span>
        <?php endforeach;?>
    </div>
    <div class="three columns">
        <span><a href="<?php echo Yii::app()->par->load('urlFacebook'); ?>" id="fut-facebook">Facebook</a></span>
        <span><a href="<?php echo Yii::app()->par->load('urlTwitter'); ?>" id="fut-twitter">Twitter</a></span>
    </div>
    <div class="six columns">

    </div>
</div>
<div class="row">
    <div class="eleven columns centered copyright">
        &copy; <?php echo Yii::app()->par->load('copyright'); ?>
        <div class="set_like">
            <div id="fb-root"></div>
            <div class="fb-like" data-href="http://www.mobispot.com" data-send="false" data-layout="button_count"
                 data-width="90" data-show-faces="false" data-font="lucida grande"></div>

        </div>
    </div>
</div>


