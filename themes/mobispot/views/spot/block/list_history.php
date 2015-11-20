        <div class="message-for-empty" ng-show="wallet_history.date && wallet_history.empty_date"
        >
            <?php echo Yii::t('spot', 'There are no transactions for the picked date'); ?>
        </div>
        <table class="m-spot-table">
            <tbody>
            <?php foreach ($history as $row): ?>
            <tr
                <?php if ($row->isFailure()):?> 
                class="fail"
                <?php endif; ?>  
            >
                <td><div class="date-time"><?php echo $row->creation_date; ?></div></td>
                <td><div class="text-center"><?php echo $row->term->name; ?>
                    <?php if ($row->isFailure()):?> 
                    <span class="fail-description">
                        <?php echo Yii::t('spot', 'Failed to charge your bank card. Please, top up the balance or select another card as active.');?>
                    </span>
                    <?php endif; ?>  
                </div></td>
                <td>
                    <div class="txt-right">
                    <?php if (Report::CORP_TYPE_ON == $row->corp_type): ?>
                        <?php if ($row->isFailure()):?> 
                            <i class="icon coins"><img width="20" src="/themes/mobispot/img/coins_red.png"></i>
                        <?php else: ?>
                            <i class="icon coins"><img width="20" src="/themes/mobispot/img/coins_gray.png"></i>
                        <?php endif; ?>
                    <?php else: ?>
                        <i class="icon card">&#xe60d;</i>
                    <?php endif; ?>
                    - <?php echo $row->amount; ?> 
                    <?php if ($row->isFailure()):?>
                        <i class="icon icon-currency10"><img src="/themes/mobispot/img/ruble_red.png"></i>
                    <?php else: ?>
                        <i class="icon icon-currency10"><img src="/themes/mobispot/img/ruble.png"></i>
                    <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach ?>
            </tbody>
        </table>
