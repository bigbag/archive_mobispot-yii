<?php 
$invisible_class = '';
$invisible_ico = 'none';
if ($data->status == Spot::STATUS_INVISIBLE)
{
    $invisible_class = 'invisible-spot'; 
    $invisible_ico = 'block'; 
}
?>
<li id="<?php echo $data->discodes_id; ?>" class="bg-gray <?php echo $invisible_class;?> spot-content_li" >
    <div class="spot-hat" ng-click="accordion($event, 0)">
        <h3><?php echo mb_substr($data->name, 0, 50, 'utf-8') ?></h3>
        <a 
            href="javascript:;" 
            data-tooltip 
            title="<?php echo Yii::t('spots', 'Invisible spot'); ?>" 
            class="invisible-icon tip-top icon"
            style="display: <?php echo $invisible_ico; ?>">
            &#xe012;
        </a>
    </div>
</li>