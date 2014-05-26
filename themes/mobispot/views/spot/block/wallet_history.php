<div class="item-area_table">
    <h4><?php echo Yii::t('spot', 'Recent operations')?></h4>
    <div class="m-table-wrapper">
        <table class="m-spot-table">
            <tbody>
            <?php foreach ($history as $row): ?>
            <tr>
                <td><div><?php echo $row->creation_date; ?></div></td>
                <td><div><?php echo $row->term->name; ?></div></td>
                <td><div class="txt-right"><?php echo $row->amount; ?></div></td>
            </tr>
            <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <!-- <a href="javascripts:;" class="link-report">
        <i class="icon">&#xe608;</i><?php echo Yii::t('spot', 'Statement of Account')?>
    </a> -->
</div>