<div id="block-<?php echo $key;?>" class="spot-item item-area">
    <div class="type-mess text-center">
        <img src="/uploads/spot/<?php echo $content ?>">
    </div>
    <div class="item-control">
        <span class="move move-top"></span>
            <div class="spot-activity">
                <a class="button round"
                    ng-click="removeContent(spot, <?php echo $key; ?>, $event)">
                    &#xe00b;
                </a>
            </div>
        <span class="move move-bottom"></span>
    </div>
</div>