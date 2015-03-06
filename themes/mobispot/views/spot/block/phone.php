<tr class="phone-row">
    <td class="phone-icon"><img src="/themes/mobispot/img/icons/phone.jpg"></td>
    <td><?php echo $phone->phone; ?></td>
    <td class="phone-ctrl">
        <a class="button round remove-button" ng-click="removePhone('<?php echo $phone->phone; ?>', $event)">&#xe00b;</a>
    </td>
</tr>