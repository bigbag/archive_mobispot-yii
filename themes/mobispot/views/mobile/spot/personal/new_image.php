<article id="block-<?php echo $key;?>" class="spot-item item-area">
    <div class="type-mess text-center">
        <img src="<?php echo MHttp::desktopHost(); ?>/uploads/spot/<?php echo $content ?>">
    </div>
        <div class="item-control">
            <div class="spot-activity">
                <a
                    class="button round"
                    href=""
                    ng-click="removeContent(spot, <?php echo $key; ?>, $event)"
                >
                &#xe00b;
                </a>
            </div>
        </div>
</article>
