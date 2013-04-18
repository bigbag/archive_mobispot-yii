<div class="row">
  <div id="wallets" class="bg-gray twelve columns">
    <div class="row">
      <div class="m-table-wrapper seven columns">
        <h3>Кошельки:</h3>
        <table class="m-spot-table">
          <thead>
          <tr>
            <th>Кошелек</th>
            <th>Остаток</th>
          </tr>
          </thead>
          <tbody>
          <?php foreach ($wallets as $wallet):?>
          <tr class="m-t-cont-row">
            <td><?php echo ($wallet->discodes_id!=0)?$wallet->spot->name:'Corp';?></td>
            <td ><?php echo $wallet->balance;?></td>
          </tr>
          <?php endforeach;?>
          </tbody>
        </table>
      </div>
    </div>
    <div id="setPayment" class="row">
      <div class="twelve columns">
        <form name="paymentForm" class="custom clearfix" action="https://test.wpay.uniteller.ru/pay/" >
          <input id="unitell_shop_id" type="hidden" name="Shop_IDP" value="">
          <input id="unitell_customer"  type="hidden" name="Customer_IDP" value="">
          <input id="unitell_order_id"  type="hidden" name="Order_IDP" value="">
          <input id="unitell_subtotal"  type="hidden" name="Subtotal_P" value="">
          <input id="unitell_signature" type="hidden" name="Signature" value="">
          <input id="unitell_url_ok"  type="hidden" name="URL_RETURN_OK" value="">
          <input id="unitell_url_no"  type="hidden" name="URL_RETURN_NO" value="">

          <div class="content-row large-6 left g-clearfix">
            <select id="wallet" class="medium">
            <?php foreach ($wallets as $wallet):?>
              <option value="<?php echo $wallet->id;?>"><?php echo ($wallet->discodes_id!=0)?$wallet->spot->name:'Corp';?></option>
            <?php endforeach;?>
            </select>
            <br />
            <input
            type="text"
            ng-pattern="/[0-9]+/"
            ng-model="payment.summ"
            placeholder="Сумма (больше 200 рублей)"
            maxlength="10"
            required>

            <a class="spot-button button-disable" href="javascript:;" ng-click="addSumm(payment, $event)">Пополнить</a>
          </div>
        </form>
      </div>
    </div>
    <div class="row">
      <div class="m-table-wrapper twelve columns">
        <h3>История операций:</h3>
        <table class="m-spot-table">
          <thead>
          <tr>
            <th>№</th>
            <th>Операция</th>
            <th>Дата</th>
            <th>Тип</th>
            <th>Сумма</th>
          </tr>
          </thead>
          <tbody>
          <?php foreach ($history as $row):?>
          <tr class="m-t-cont-row">
            <td><?php echo $row->id;?></td>
            <td><?php echo $row->desc;?></td>
            <td><?php echo Yii::app()->dateFormatter->format("dd.MM.yy HH:ss", $row->creation_date);?></td>
            <td><?php echo $row->getType();?></td>
            <td><?php echo $row->summ;?></td>
          </tr>
          <?php endforeach;?>
          </tbody>
        </table>
        </div>
      </div>
  </div>
</div>