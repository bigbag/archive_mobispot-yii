<?php Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl . '/themes/mobispot/js/storeOrder.js'); ?>
<div id="orderBody">
    <h1><?php echo Yii::t('store', 'Thank you for'); ?> <img id="thankImg" src="http://mobispot.com/themes/mobispot/images/mail/store/spot1.png"/></h1>
    <table id="orderTable" cellspacing="0">
        <tr class="borderTop">
            <th id="orderNo">
                <?php echo Yii::t('store', 'Order'); ?> #<?php echo $order["id"]; ?>
            </th>
            <th colspan="4" class="borderTop"></th>
        </tr>
        <tr>
            <td class="borderTop">
                <?php echo Yii::t('store', 'SHIP TO'); ?>
            </td>
            <td colspan="2" class="borderTop">
                <?php echo Yii::t('store', 'SHIPPING METHOD'); ?>
            </td>
            <td colspan="2" class="borderTop">
                <?php echo Yii::t('store', 'TRACKING NUMBER'); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $order["target_first_name"]; ?> <?php echo $order["target_last_name"]; ?><br />
                <?php echo $order["address"]; ?>, <?php echo $order["city"]; ?>,<br />
                <?php echo $order["zip"]; ?>
            </td>
            <td colspan="2" class="vTop"><?php echo $order["delivery"]; ?></td>
            <td colspan="2" class="vTop"><?php $order["delivery_id"] ?></td>
        </tr>
        <tr>
            <td class="borderTop">
                <?php echo Yii::t('store', 'ITEM'); ?>
            </td>
            <td class="borderTop">
                <?php echo Yii::t('store', 'COLOR'); ?>
            </td>
            <td class="borderTop">
                <?php echo Yii::t('store', 'SIZE'); ?>
            </td>
            <td class="borderTop">
                <?php echo Yii::t('store', 'PRICE'); ?>
            </td>
            <td class="borderTop">
                <?php echo Yii::t('store', 'QTY.'); ?>
            </td>
        </tr>
        <?php foreach ($order["items"] as $item):?>
            <tr>
                <td class="borderTop itemName">
                    <?php echo $item["name"]; ?>
                </td>
                <td class="borderTop">
                    <?php if(!empty($item["color"])):?>
                    <img src="http://mobispot.com/themes/mobispot/images/mail/store/color-<?php echo $item["color"]; ?>.png" />
                    <?php endif;?>
                </td>
                <td class="borderTop"><?php echo $item["size_name"]; ?></td>
                <td class="borderTop"><?php echo $item["price"]; ?></td>
                <td class="borderTop"><?php echo $item["quantity"]; ?></td>
            </tr>
        <?php endforeach ?>
        <tr>
            <td class="borderTop"><?php echo Yii::t('store', 'Subtotal'); ?></td>
            <td class="borderTop"><?php echo $order["subtotal"]; ?></td>
            <td colspan="3" class="borderTop"></td>
        </tr>
        <tr>
            <td>
                <?php echo Yii::t('store', 'Tax'); ?></td>
                <td><?php echo $order["tax"]; ?></td>
                <td colspan="3"></td>
        </tr>
        <tr>
            <td>
                <?php echo Yii::t('store', 'Shipping'); ?></td>
                <td><?php echo $order["shipping"]; ?></td>
                <td colspan="3"></td>
        </tr>
        <tr>
            <td>
                <?php echo Yii::t('store', 'Total'); ?></td>
                <td><?php echo $order["total"]; ?></td>
                <td colspan="3"></td>
        </tr>
    </table>
</div>
