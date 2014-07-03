<div bgcolor="#ffffff" style="padding:30px 0;margin:0; width:660px;  font-family:Arial, sans-serif;font-size:12pt;">
    <div id="logo">
        <img src="http://mobispot.com/themes/mobispot/images/mail/store/mobispot.png"/>
    </div>
    <div style="margin:40px 0 30px 0;">
        <img src="http://mobispot.com/themes/mobispot/images/mail/store/thank.png" style="margin-right:20px"/> <img src="http://mobispot.com/themes/mobispot/images/mail/store/spot1.png" />
    </div>
    <table style="width:100%;border:0;" cellspacing="0">
        <tr style="border-top:1px solid #bfbfbf;">
            <th style="color: #0062ff; text-align:left; border-top:1px solid #bfbfbf;padding:20px 0;">
                <img src="http://mobispot.com/themes/mobispot/images/mail/store/order.png" /> 
                #<?php echo $order["id"]; ?> 
            </th>
            <th colspan="4" style="border-top:1px solid #bfbfbf;"></th>
        </tr>
        <tr>
            <td style="border-top:1px solid #bfbfbf; padding:15px 0 5px 0">
                <img src="http://mobispot.com/themes/mobispot/images/mail/store/ship_to.png" />
            </td>
            <td colspan="2" style="border-top:1px solid #bfbfbf;">
                <img src="http://mobispot.com/themes/mobispot/images/mail/store/shipping_method.png" />
            </td>
            <td colspan="2" style="border-top:1px solid #bfbfbf;">
                <img src="http://mobispot.com/themes/mobispot/images/mail/store/tracking_number.png" />
            </td>
        </tr>
        <tr>
            <td style="text-align:left; padding-bottom:20px;">
                <?php echo $order["target_first_name"]; ?> <?php echo $order["target_last_name"]; ?><br />
                <?php echo $order["phone"]; ?>,<br />
                <?php echo $order["email"]; ?>,<br />
                <?php echo $order["address"]; ?>, <?php echo $order["city"]; ?>,<br />
                <?php echo $order["zip"]; ?>
            </td>
            <td colspan="2" style="vertical-align:top;"><?php echo $order["delivery"]; ?></td>
            <td colspan="2" style="vertical-align:top;"><?php $order["delivery_id"] ?></td>
        </tr>
        <tr>
            <td style="border-top:1px solid #bfbfbf; padding:20px 0;">
                <img src="http://mobispot.com/themes/mobispot/images/mail/store/item.png" />
            </td>
            <td style="border-top:1px solid #bfbfbf;">
                <img src="http://mobispot.com/themes/mobispot/images/mail/store/color.png" />
            </td>
            <td style="border-top:1px solid #bfbfbf;">
                <img src="http://mobispot.com/themes/mobispot/images/mail/store/size.png" />
            </td>
            <td style="border-top:1px solid #bfbfbf;">
                <img src="http://mobispot.com/themes/mobispot/images/mail/store/price.png" />
            </td>
            <td style="border-top:1px solid #bfbfbf;">
                <img src="http://mobispot.com/themes/mobispot/images/mail/store/qty.png" />
            </td>
        </tr>
        <?php foreach ($order["items"] as $item):?>
            <tr>
                <td style="border-top:1px solid #bfbfbf; padding:20px 0;">
                    <?php echo $item["name"]; ?>
                </td>
                <td style="border-top:1px solid #bfbfbf;">
                    <?php if (!empty($item["color"])): ?>
                    <img src="http://mobispot.com/themes/mobispot/images/mail/store/color-<?php echo $item["color"]; ?>.png" />
                    <?php endif; ?>
                </td>
                <td style="border-top:1px solid #bfbfbf;"><?php echo $item["size_name"]; ?></td>
                <td style="border-top:1px solid #bfbfbf;"><?php echo $item["price"]; ?></td>
                <td style="border-top:1px solid #bfbfbf;"><?php echo $item["quantity"]; ?></td>
            </tr>   
        <?php endforeach ?>     
        <tr>
            <td style="border-top:1px solid #bfbfbf; padding-top:20px;"><img src="http://mobispot.com/themes/mobispot/images/mail/store/subtotal.png" /></td><td style="border-top:1px solid #bfbfbf; padding-top:20px;"><?php echo $order["subtotal"]; ?></td><td colspan="3" style="border-top:1px solid #bfbfbf;"></td>
        </tr>
        <tr>
            <td>
                <img src="http://mobispot.com/themes/mobispot/images/mail/store/tax.png" /></td>
                <td><?php echo $order["tax"]; ?></td>
                <td colspan="3"></td>
        </tr>
        <tr>
            <td>
                <img src="http://mobispot.com/themes/mobispot/images/mail/store/shipping.png" /></td>
                <td><?php echo $order["shipping"]; ?></td>
                <td colspan="3"></td>
        </tr>
        <tr>
            <td>
                <img src="http://mobispot.com/themes/mobispot/images/mail/store/total.png" /></td>
                <td><?php echo $order["total"]; ?></td>
                <td colspan="3"></td>
        </tr>
    </table>

    <div style="margin-top:70px;"><b>Sharing never stops</b></div>
    <table style="margin-top:40px; width:660px; padding:0 30px" >
        <tr>
            <td rowspan="2" style="text-align:left;align:left;">&copy; Mobispot Social Systems. All rights reserved<br>
                sales@mobispot.com<br>
            </td>
        </tr>
    </table>
</div>