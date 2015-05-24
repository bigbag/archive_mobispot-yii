<div class="spot-content">
    <section class="spot-wrapper active">
        <div class="spot-hat">
            <?php include('block/menu.php'); ?>
        </div>
        <div class="tabs-block">
            <section class="settings-block spot-content_row tabs-item">
                <?php include('block/settings_action.php'); ?>
                <?php if ($spot->isPhonesEnabled()): ?>
                    <?php include('block/phones_settings.php'); ?>
                <?php endif;?>
            </section>
        </div>
    </section>
</div>
