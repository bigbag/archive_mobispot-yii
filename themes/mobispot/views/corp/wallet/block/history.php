            <?php if($history):?>
            <?php foreach ($history as $row):?>
            <tr>
              <td><div><?php echo $row->id;?></div></td>
              <td><div><?php echo $row->getPaymentDesc();?></div></td>
              <td><div><?php echo $row->creation_date;?></div></td>
              <td><div><?php echo $row->getType();?></div></td>
              <td><div><?php echo $row->amount;?></div></td>
            </tr>
            <?php endforeach;?>
            <?php else: ?>
            <tr>
              <td><div></div></td>
              <td><div></div></td>
              <td><div></div></td>
              <td><div></div></td>
              <td><div></div></td>
            </tr>
            <?php endif;?>
            <?php if (isset($pagination) && isset($pagination['pages']) && $pagination['pages'] > 1):?>
            <tr class="m-table-bottom"><td class="line-pagination" colspan="5"><div><ul class="pagination">
                <?php for ($i=1; $i <= $pagination['pages']; $i++):?>
                  <li <?php echo ($pagination['current'] == $i)?'class="current"':''; ?>>
                    <a ng-click="getHistory(<?php echo $wallet->id.', '.$i; ?>)">
                      <?php echo $i; ?>
                    </a>
                  </li>
                <?php endfor;?>
            </ul></div></td></tr>
            <?php endif;?>
            <?php if(isset($filter)): ?>
                <input type="hidden" ng-init="history.term='<?php echo $filter['term']; ?>';history.date='<?php echo $filter['date']; ?>'">
            <?php endif;?>
