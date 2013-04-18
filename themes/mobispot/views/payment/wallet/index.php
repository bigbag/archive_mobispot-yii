<div class="row">
  <div class="twelve columns">
    <h3 class="color">Кошельки</h3>
    <table>
        <tr><th>Кошелек</th><th>Остаток</th></tr>
        <?php foreach ($wallets as $wallet):?>
        <tr>
          <td><?php echo ($wallet->discodes_id!=0)?$wallet->spot->name:'Corp';?></td>
          <td ><?php echo $wallet->balance;?></td>
        </tr>
        <?php endforeach;?>
    </table>
  </div>
</div>
  <div id="setPayment" class="row">
    <div class="five columns">
      <form name="paymentForm" class="custom" action="https://test.wpay.uniteller.ru/pay/" >
        <input id="unitell_shop_id" type="hidden" name="Shop_IDP" value="">
        <input id="unitell_customer"  type="hidden" name="Customer_IDP" value="">
        <input id="unitell_order_id"  type="hidden" name="Order_IDP" value="">
        <input id="unitell_subtotal"  type="hidden" name="Subtotal_P" value="">
        <input id="unitell_signature" type="hidden" name="Signature" value="">
        <input id="unitell_url_ok"  type="hidden" name="URL_RETURN_OK" value="">
        <input id="unitell_url_no"  type="hidden" name="URL_RETURN_NO" value="">

       <select ng-model="payment.wallet" required>
       <?php foreach ($wallets as $wallet):?>
          <option value="<?php echo $wallet->id;?>"><?php echo ($wallet->discodes_id!=0)?$wallet->spot->name:'Corp';?></option>
        <?php endforeach;?>
        </select>
        <input
          type="text"
          ng-pattern="/[0-9]+/"
          ng-model="payment.summ"
          placeholder="Сумма (больше 200 рублей)"
          maxlength="10"
          required>
        <a class="spot-button button-disable" href="javascript:;" ng-click="addSumm(payment, $event)">Пополнить</a>
      </form>
    </div>
  </div>
</div>
