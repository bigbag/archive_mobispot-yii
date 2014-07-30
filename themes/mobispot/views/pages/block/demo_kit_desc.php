<div class="row tab-item active">
    <div class="small-9 large-9 column">
        <h2><?php echo Yii::t('store', 'Mobispot demo-kit')?></h2>
        <p class="form-h clearfix">
            <?php echo Yii::t('store', 'With our demo-kit you can create really stunning applications. Bring the magic of one tap to your apps for NFC handsets, POS terminals and simple contactless readers.')?> <br>

        </p>
        <div class="kit-items">
            <table class="table">
                <?php foreach ($config['product'] as $product): ?>
                <tr ng-init="registerProduct(<?php echo $product['id']?>, <?php echo $product['price']?>)">
                    <td>
                        <div class="img-w">
                            <img src="<?php echo $product['img'] ?>">
                            <span>x<?php echo $config['defalutCountForAll']?>
                        </div>
                    <td>
                        <?php echo $product['descr'] ?>
                    </td>
                    <?php if ($product['id'] == $config['product'][0]['id']): ?>
                    <td rowspan="3" class="table-info"><a href="javascript:;"><?php echo Yii::t('store', 'API description in.pdf')?></a> <br>
                        <?php echo Yii::t('store', 'If you need a description how to handle Spots in your application download this file.')?>
                    </td>
                    <?php endif ?>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
    <div>
        <div class="small-3 large-3 column">
            <div class="next-step" ng-init="summ=<?php echo $config['price']?>">
                <h3><?php echo Yii::t('store', 'Price:')?> {{summ}} <?php echo Yii::t('store', 'USD')?></h3>
                <p><?php echo Yii::t('store', 'Worldwide')?></p>
                <a class="form-button button button-round" href="javascript:;" ng-click="dkitForm($event, '2')"><?php echo Yii::t('store', 'Make an order')?> >></a>
            </div>
        </div>
    </div>
</div>