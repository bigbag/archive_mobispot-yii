<div id="block-<?php echo $key;?>" class="spot-item">
    <div class="item-area type-itembox">
        <div class="item-head">
            <a href="#" class="type-link">
                <img class="file-icon" src="/themes/mobispot/img/icons/i-files.2x.png" height="36">
                <span class="link">
                    <?php echo CHtml::encode(substr(strchr($content, '_'), 1)) ?>
                </span>
            </a>
        </div>

        <div class="item-download">
            <table class="j-list">
                <tr>
                    <!-- <td>PDF</td>
                    <td>Текстовый контент</td>
                    <td>25mb</td> -->
                    <td>
                    <a href="/uploads/spot/<?php echo CHtml::encode($content) ?>">
                        <?php echo Yii::t('spot', 'Download'); ?>
                    </a>
                    </td>
                    <!-- <td><a href="#">Send to email</a></td> -->
                </tr>
            </table>
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
</div>
