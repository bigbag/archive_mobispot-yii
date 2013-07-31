<?php 
$invisible_class = '';
$invisible_ico = false;
if ($data->status == Spot::STATUS_INVISIBLE)
{
	$invisible_class = 'invisible-spot'; 
	$invisible_ico = true; 
}
?>
<li id="<?php echo $data->discodes_id; ?>" class="bg-gray <?php echo $invisible_class;?>" >
    <div class="spot-hat" ng-click="accordion($event, 0)">
        <h3><?php echo mb_substr($data->name, 0, 50, 'utf-8') ?></h3>
        <?php if($invisible_ico):?>
        <a 
	        href="javascript:;" 
	        data-tooltip 
	        title="<?php echo Yii::t('spots', 'Invisible spot'); ?>" 
	        class="invisible-icon settings-button tip-top icon">
	        &#xe012;
	    </a>
	<?php endif;?>
    </div>
</li>