        <div ng-show="wallet_history.date && wallet_history.empty_date"
        style="border-radius:10px;border:1px solid #E9EDF2;color: #8D9095;width: 100%;height:36px;text-align:center;line-height:36px;">
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
                <td><div class="txt-right"><?php echo $row->amount; ?></div></td>
            </tr>
            <?php endforeach ?>
            </tbody>
        </table>
