<article>
<div class="tabs-item settings">
    <span ng-init="spot.status=<?php echo $spot->status; ?>"></span>
    <table>
        <tr>
            <td>
                <a ng-click="$event.stopPropagation();ivisibleSpot(spot)" ng-show="spot.status==2"><i class="icon">&#xe60c;</i><?php echo Yii::t('spot', 'Make spot invisible')?></a>
                <a ng-click="$event.stopPropagation();ivisibleSpot(spot)" ng-show="spot.status==6"><i class="icon">&#xe60c;</i><?php echo Yii::t('spot', 'Make spot visible')?></a>
            </td>
            <td class="details">
                <?php echo Yii::t('spot', 'Make your spot invisible/visible for the handsets')?>
            </td>
        </tr>
        <tr>
            <td><a ng-click="$event.stopPropagation();cleanSpot(spot)"><i class="icon">&#xe609;</i><?php echo Yii::t('spot', 'Clean spot')?></a></td>
            <td class="details">
                <?php echo Yii::t('spot', 'Clean all the content from your spot.<br /> Will be impossible to restore.')?>
            </td>
        </tr>
        <tr>
            <td><a ng-click="$event.stopPropagation();removeSpot(spot)"><i class="icon">&#xe60a;</i><?php echo Yii::t('spot', 'Delete spot')?></a></td>
            <td class="details">
                <?php echo Yii::t('spot', 'Delete the spot from your account.<br /> Attention: Will be impossible to restore.')?>
            </td>
        </tr>
    </table>
</div>
</article>
