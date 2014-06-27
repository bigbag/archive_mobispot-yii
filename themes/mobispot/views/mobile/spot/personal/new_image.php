<article id="block-<?php echo $key;?>" class="spot-item item-area">
    <div class="type-mess text-center">
        <img src="<?php echo $this->desctopHost(); ?>/uploads/spot/<?php echo $content ?>">
    </div>
        <div class="item-control">
            <div class="spot-activity">
                <a 
                    class="button round" 
                    href="javascripts:;"
                    ng-click="removeContent(spot, <?php echo $key; ?>, $event)"
                >
                &#xe00b;
                </a>
            </div>
        </div>
</article>