<form id="payUniteller" action="<?php echo Yii::app()->ut->getPayUrl(); ?>">
	<input type="hidden" name="Shop_IDP" value="<?php echo $order['shopId'];?>">
	<input type="hidden" name="Customer_IDP" value="<?php echo $order['customerId'];?>">
	<input type="hidden" name="Order_IDP" value="<?php echo $order['orderId'];?>">
	<input type="hidden" name="Subtotal_P" value="<?php echo $order['amount'];?>">
	<input type="hidden" name="Signature" value="<?php echo $order['signature'];?>">
	<input type="hidden" name="URL_RETURN_OK" value="<?php echo $order['return_ok'];?>">
	<input type="hidden" name="URL_RETURN_NO" value="<?php echo $order['return_error'];?>">
</form>