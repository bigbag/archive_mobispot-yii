<h4><?php echo Yii::t('spot', 'Корпоративные деньги')?></h4>
<div class="columns large-7 small-7 card-l">
    <div class="card-block<?php if($corp_wallet['balance']<=0 or $corp_wallet['manually_blocked'] != Person::STATUS_VALID) echo ' negative'?>">
    <table class="table table-card">
        <tbody>
            <tr>
                <td nowrap class="card-item-header">
                    <span>
                        <i class="icon coins">
                            <?php if ($corp_wallet['balance']>0): ?>
                                <img width="20" src="/themes/mobispot/img/coins_green.png">
                            <?php else: ?>
                                <img width="20" src="/themes/mobispot/img/coins_red.png">
                            <?php endif; ?>
                        </i>
                    </span>
                    <?php echo Yii::t('spot', 'Корпоративный&nbsp;кошелек')?>
                </td>
                <?php if ($corp_wallet['balance']>0): ?>
                    <td class="txt-right">
                        <?php echo $corp_wallet['balance'] ?> <i class="icon icon-currency10"><img src="/themes/mobispot/img/ruble.png"></i>
                    </td>
                <?php else: ?>
                    <td class="txt-right negative">
                        <?php echo str_replace("-", "- ", $corp_wallet['balance']) ?> <i class="icon icon-currency10"><img src="/themes/mobispot/img/ruble_red.png"></i>
                    </td>
                <?php endif; ?>
            </tr>
            <tr>
                <td colspan="2">
                    <?php echo $corp_wallet['interval_name'] . Yii::t('spot', ' лимит:')?>
                    <?php echo $corp_wallet['limit'] ?> <i class="icon icon-currency10"><img src="/themes/mobispot/img/ruble.png"></i>
                </td>
            </tr>
        </tbody>
    </table>
    <?php if ($corp_wallet['manually_blocked'] != Person::STATUS_VALID):?>
        <div class="cover">
            <i class="icon">&#xe606;</i>
            <div class="cover-descr"><?php echo Yii::t('spot', 'Счет заблокирован<br>работодателем'); ?>
            </div>
        </div>
    <?php endif; ?>
    </div>
</div>
<div class="columns large-5 small-5">
    <div class="m-auto-payment">
    <span class="sub-h">
    <?php if (!empty($corp_wallet['firm_name'])): ?>
        <?php echo Yii::t('spot', 'Корпоративный кошелек предоставляет: ') . $corp_wallet['firm_name']; ?>
    <?php endif; ?>
    </span>
    </div>
</div>
