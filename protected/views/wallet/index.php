
<div ng-controller="WalletCtrl" ng-init="WalletInit('<?php echo Yii::app()->request->csrfToken; ?>')">
	<h1>Ваш кошелёк</h1>
	<h2><?php echo $message; ?></h2>

<?php
	if(isset($_POST["Order_ID"]))
		echo '<h1>[Order_ID :'.$_POST["Order_ID"].']</h1>';

	if(isset($_POST["Status"]))
		echo '<h1>[Status :'.$_POST["Status"].']</h1>';

	if(isset($_POST["Signature"]))
		echo '<h1>[Signature :'.$_POST["Signature"].']</h1>';


?>
	<h3>Баланс: {{wallet.balance}}</h3>

	<hr/>
	<input type="text" ng-model="newSumm" placeholder="Сумма"><a class="hide spot-button" ng-click="addByUniteller()">Пополнить</a>
	<form id="unitell" action="https://test.wpay.uniteller.ru/pay/" method="POST">
		<input id="unitell_shop_id" 	type="hidden" name="Shop_IDP" value="">
		<input id="unitell_customer" 	type="hidden" name="Customer_IDP" value="">
		<input id="unitell_order_id" 	type="hidden" name="Order_IDP" value="">
		<input id="unitell_subtotal" 	type="hidden" name="Subtotal_P" value="">
		<input id="unitell_signature" 	type="hidden" name="Signature" value="">
		<input id="unitell_url_ok" 		type="hidden" name="URL_RETURN_OK" value="">
		<input id="unitell_url_no" 		type="hidden" name="URL_RETURN_NO" value="">
		<div style="visibility: hidden">
			<input type="submit" id="submitUnitell" value="Пополнить">
		</div>
	</form>

	<h3>История операций:</h3>
	<table>
		<tr><th>№</th><th>Операция</th><th>Дата</th><th>Тип</th><th>Сумма</th></tr>
		<tr ng-repeat="oper in history">
			<td>{{oper.id}}</td>
			<td>{{oper.description}}</td>
			<td>{{oper.oper_date}}</td>
			<td>{{oper.oper_type}}</td>
			<td>{{oper.summ}}</td>

		</tr>
	</table>
</div>