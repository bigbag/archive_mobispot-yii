
<div ng-controller="WalletCtrl" ng-init="WalletInit('<?php echo Yii::app()->request->csrfToken; ?>')">
	<h1>Ваш кошелёк</h1>
	<h2><?php echo $message; ?></h2>
	<h3>Баланс: {{wallet.balance}}</h3>
	
	<hr/>
	<input type="text" ng-model="newSumm" placeholder="Сумма"><a class="hide spot-button" ng-click="addByUniteller()">Пополнить</a>
	<form id="unitell" action="https://test.wpay.uniteller.ru/pay/" method="POST">
		<input type="hidden" name="Shop_IDP" value="{{order.idShop}}">
		<input type="hidden" name="Customer_IDP" value="{{order.idCustomer}}">
		<input type="hidden" name="Order_IDP" value="{{order.idOrder}}">
		<input type="hidden" name="Subtotal_P" value="{{order.subtotal}}">
		<input type="hidden" name="Signature" value="{{order.signature}}">
		<input type="hidden" name="URL_RETURN_OK" value="{{order.return_ok}}">
		<input type="hidden" name="URL_RETURN_NO" value="{{order.return_error}}">
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