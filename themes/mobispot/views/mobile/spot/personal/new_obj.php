<article id="block-<?php echo $key;?>" class="spot-item">
    <div class="item-area type-itembox">
        <div class="item-head">
            <a href="#" class="type-link">
                <img class="file-icon" src="/themes/mobile/images/icons/i-files.2x.png" height="18"> <span class="link"><?php echo CHtml::encode(substr(strchr($content, '_'), 1)) ?></span>
            </a>
        </div>

        <div class="item-download">
            <table class="j-list">
                <tr>
                    <!--
                    <td>PDF</td>
                    <td>Текстовый контент</td>
                    <td>25mb</td>
                    -->
                </tr>
                <tr>
                    <td><a href="<?php echo $this->desktopHost(); ?>/uploads/spot/<?php echo CHtml::encode($content) ?>"><?php echo Yii::t('eauth', 'Download'); ?></a></td>
                    <td></td><td></td>
                </tr>
            </table>
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
    </div>
</article>
