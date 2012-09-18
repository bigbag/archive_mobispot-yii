<div id="footer">
    <div id="foot-menu">
        <?php $all_link = ContentLinksFooter::getLinks();?>
        <?php $count_links = count($all_link);?>
        <?php $i = 1;?>
        <?php foreach ($all_link as $row):?>
            <a href="<?php echo $row['link'];?>" target="_blank"><?php echo $row['name'];?></a>
             <?php echo ($i < $count_links)?'|':''?>
        <?php $i = $i + 1;?>
        <?php endforeach;?>
    </div>
    <div id="foot-copyright"><?php echo Yii::app()->par->load('copyright'); ?></div>
    <span id="soc-seti">
        <a href="<?php echo Yii::app()->par->load('urlFacebook'); ?>" id="fut-facebook" target="_blank"></a>
        <a href="<?php echo Yii::app()->par->load('urlTwitter'); ?>" id="fut-twitter" target="_blank"></a></span>

    <div id="set_like">
        <div id="fb-root"></div>
        <div class="fb-like" data-href="http://www.mobispot.com" data-send="false" data-layout="button_count"
             data-width="90" data-show-faces="false" data-font="lucida grande"></div>

    </div>
</div>
