<?php foreach ($actions['loyalties'] as $row):?>
    <tr<?php echo ($row->isActual())?'':' class="past"'; ?>>
        <td class="t-store"><div>
            <?php if (!empty($row->img)) :?>
                <a><img src="/uploads/action/<?php echo $row->img;?>"></a>
            <?php endif;?>
        </div></td>
        <td class="t-condition"><div>
            <h2><?php echo $row->amount; ?><i class="icon rub">&#xe019;</i></h2>
            <p><?php echo $row->getRulesDesc(); ?></p>
        </div></td>
        <td class="t-descript"><div>
            <?php echo $row->desc; ?>
        </div></td>
        <td>
            <div>
                <?php echo date('d.m.y', strtotime($row->start_date)).' - '.date('d.m.y', strtotime($row->stop_date));?>
            </div>
        </td>
        <td class="t-bonus">
            <?php if (!empty($actions['userActions'][$row->id])): ?>
            <div>
                <?php echo $actions['userActions'][$row->id]?><i class="icon">&#xe019;</i> 
            </div> 
            <?php endif; ?>
        </td>
    </tr>
<?php endforeach;?>

<?php if (isset($actions['pagination']) && isset($actions['pagination']['pages']) && $actions['pagination']['pages'] > 1):?>
<tr class="m-table-bottom">
    <td class="line-pagination" colspan="5">
        <div>
            <ul class="pagination">
                <?php for ($i=1; $i <= $actions['pagination']['pages']; $i++):?>
                    <li <?php echo ($actions['pagination']['current'] == $i)?'class="current"':''; ?>>
                        <a  ng-click="getAllActions(<?php echo $actions['status']; ?>, <?php echo $i; ?><?php echo (empty($actions['search']))?'':', '.$actions['search'];?>)">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor;?>
            </ul>
        </div>
    </td>
</tr>
<?php endif; ?>