<h3><?php echo Yii::t('store', 'Shipping')?> <span>(<?php echo Yii::t('store', 'Worldwide')?>)</span></h3>
<div class="shipping-form">
<?php foreach ($config['shipping'] as $shipping):?> 
    <div class="row" ng-init="registerShipping(<?php echo $shipping['id'] ?>, <?php echo $shipping['price'] ?>)">
        <div class="radio">  
        <input
            id="shiping<?php echo $shipping['id'] ?>"
            type="radio"
            name="shipping"
            value="<?php echo $shipping['id'] ?>"
            <?php if ($shipping['id'] == $config['shipping'][0]['id']):?>
                checked
                ng-init="setShipping(<?php echo $shipping['id'] ?>)"
            <?php endif ?>
        > 
        <label
            for="shiping<?php echo $shipping['id'] ?>"
            ng-click="setShipping(<?php echo $shipping['id'] ?>)"
        >
            <?php echo $shipping['name'] ?> |
            <?php echo $shipping['descr'] ?>
        </label>
        </div> 
    </div>
    <?php endforeach ?>
</div>