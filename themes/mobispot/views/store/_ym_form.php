<form id="form-ym-pay" name="ShopForm" method="POST" action="<?php echo Yii::app()->params['ym_pay_url'] ?>">
    <input type="hidden" name="scid" value="<?php echo Yii::app()->params['ym_scid'] ?>">
    <input type="hidden" name="ShopID" value="<?php echo Yii::app()->params['ym_shop_id'] ?>">
    <input type="hidden" name="CustomerNumber" value="<?php echo $order->customer_id ?>">
    <input type="hidden" name="orderNumber" value="<?php echo $order->id ?>">
    <?php if (!empty($order->total)): ?>
        <input type="hidden" name="Sum" size="43" value="<?php echo $order->total ?>">
    <?php else: ?>
        <input type="hidden" name="Sum" size="43" value="<?php echo $order->getSummRub() ?>">
    <?php endif; ?>
    <input type="hidden" name="CustName" size="43" value="<?php echo $order->name ?>">
    <input type="hidden" name="CustAddr" size="43" value="<?php echo $order->address ?>">
    <input type="hidden" name="CustEMail" size="43" value="<?php echo $order->email ?>">
    <input type="hidden" name="OrderDetails" size="43" value="<?php echo $order->details ?>">
    <?php if (!empty($successUrl)): ?>
        <input type="hidden" name="shopSuccessURL" size="43" value="<?php echo $successUrl; ?>">
    <?php endif; ?>
    <?php if (!empty($failUrl)): ?>
        <input type="hidden" name="shopFailURL" size="43" value="<?php echo $failUrl; ?>">
    <?php endif; ?>
    <input name="paymentType" value="<?php echo $action ?>" type="hidden">
</form>
