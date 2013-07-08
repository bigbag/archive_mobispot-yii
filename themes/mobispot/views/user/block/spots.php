<li id="<?php echo $data->discodes_id; ?>" class="spot-content_li bg-gray">
    <div class="spot-hat" ng-click="accordion($event, spot.token, 0)">
        <h3><?php echo mb_substr($data->name, 0, 50, 'utf-8') ?></h3>
    </div>
</li>