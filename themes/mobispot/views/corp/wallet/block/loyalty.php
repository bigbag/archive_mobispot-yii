                        <?php foreach ($actions['loyalties'] as $row):?>
                            <tr>
                                <td class="t-store"><div>
                                    <?php if (!empty($row->loyalty->img)) :?>
                                        <a><img src="/uploads/action/<?php echo $row->loyalty->img;?>"></a>
                                    <?php endif;?>
                                </div></td>
                                <td class="t-condition"><div>
                                    <h2><?php echo $row->loyalty->amount; ?><i class="icon rub">&#xe019;</i></h2>
                                    <p><?php echo $row->getRulesDesc(); ?></p>
                                </div></td>
                                <td class="t-descript"><div>
                                    <?php echo $row->loyalty->desc; ?>
                                </div></td>
                                <td><div><?php echo date('d.m.y', strtotime($row->loyalty->start_date)).' - '.date('d.m.y', strtotime($row->loyalty->stop_date));?></div></td>
                                <td class="t-bonus"><div><?php echo $row->summ; ?><i class="icon">&#xe019;</i> </div></td>
                            </tr>
                        <?php endforeach;?>
                        
                        <?php if (isset($actions['pagination']) && isset($actions['pagination']['pages']) && $actions['pagination']['pages'] > 1):?>
                        <tr class="m-table-bottom">
                            <td class="line-pagination" colspan="5">
                                <div>
                                    <ul class="pagination">
                                        <?php for ($i=1; $i <= $actions['pagination']['pages']; $i++):?>
                                            <li <?php echo ($actions['pagination']['current'] == $i)?'class="current"':''; ?>><a ng-click="getSpecialActions(<?php echo $wallet->id.', '.$i; ?>)"><?php echo $i; ?></a></li>
                                        <?php endfor;?>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>