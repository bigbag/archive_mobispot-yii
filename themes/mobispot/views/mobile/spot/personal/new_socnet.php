<?php $socInfo = new SocInfo;?>
<article id="block-<?php echo $key;?>" class="spot-item" ng-init="loadSocContent(<?php echo $key;?>)">
    <div class="item-area type-itembox">
        <div class="item-head">
            <a href="<?php echo CHtml::encode($content); ?>" class="type-link">
                <img class="soc-icon" src="<?php echo $this->desctopHost(); ?>/themes/mobispot/socialmediaicons/<?php echo $socInfo->getSmallIcon(CHtml::encode($content));?>" height="18"> <span class="link"><?php echo CHtml::encode($content); ?></span>
            </a>
        </div>
        <div class="type-mess item-body">
        </div>
    </div>
</article>