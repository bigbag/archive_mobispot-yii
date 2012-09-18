<?php $this->beginContent('layouts/all'); ?>
<div id="main-container">
    <div id="cont-block" class="center">
        <div id="video-block">
            <h2 style="text-align: center"><?php echo Yii::t('general', 'Храните и передавайте информацию<br /> по-новому. С помощью NFC')?></h2>

            <div id="video-present">
                <div id="video-shadow">
                    <iframe
                            src="<?php echo Yii::app()->par->load('videoDesktopUrl'); ?>?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff"
                            width="390" height="220" frameborder="0" webkitAllowFullScreen mozallowfullscreen
                            allowFullScreen></iframe>
                </div>
            </div>
        </div>
        <div id="registration-block">
            <div id="registration-form">
                <?php echo $content;?>
                <div class="clear"></div>
            </div>
        </div>
        <div class="clear"></div>
        <div id="cap" style="margin-top: 50px;"></div>
        <div class="prev" id="foo_prev" style="display: none;"></div>
        <div id="circle">
            <div id="carousel">
                <?php $carousel = ContentCarousel::getCarousel()?>
                <?php $count_carousel = count($carousel)?>
                <?php $i= 1;?>
                <?php foreach ($carousel as $row): ?>
                <div class="circle_image" id="<?php echo $i ?>" style="<?php echo ($i > 5)?'display: none;':'';?>">
                    <img src="/uploads/blocks/<?php echo $row['image']; ?>" alt="fruit1" width="82" height="82"/><br/>
                    <?php echo $row['name']; ?>
                    <span><h3><?php echo $row['name']; ?></h3>
                        <?php echo $row['desc']; ?></span>
                </div>
                <?php $i = $i + 1;?>
                <?php endforeach;?>

            </div>
        </div>

        <div class="next" id="foo_next" style="<?php echo ($count_carousel< 6)?'display: none;':'';?>"></div>
    </div>
    <input type="hidden" id="counter" value="1">

    <div class="clear"></div>

    <div id="bottom-menu">
        <ul>
            <?php $all_banner = ContentBannerFooter::getBanner()?>
            <?php foreach ($all_banner as $row): ?>
            <li>
                <a href="<?php echo $row['link']; ?>" title="<?php echo $row['title']; ?>">
                    <img src="/uploads/blocks/<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?>" width="271" height="82"/>
                </a>
            </li>
            <?php endforeach;?>
        </ul>
    </div>
    <div class="clear"></div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('div#foo_prev').click(function () {
            $('div#foo_next').show();
            var counter = $('input#counter').val() - 1;
            $('#carousel div#' + counter).show();
            $('#carousel div#' + (counter * 1 + 5)).hide();
            $('input#counter').val(counter);
            if (counter == 1) {
                $('div#foo_prev').hide();
                $('div#cap').show();
            }
            else $('div#foo_prev').show();
        });
        return false;
    });

    $(document).ready(function () {
        $('div#foo_next').click(function () {
            $('div#cap').hide();
            $('div#foo_prev').show();
            var counter = $('input#counter').val();
            $('#carousel div#' + counter).hide();
            $('#carousel div#' + (counter * 1 + 5)).show();
            $('input#counter').val(counter * 1 + 1);
            if (counter == <?php echo $count_carousel?> - 5) $('div#foo_next').hide();
        });
        return false;
    });
</script>
<?php $this->endContent(); ?>