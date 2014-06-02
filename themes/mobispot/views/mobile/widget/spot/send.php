<div class="spot-item">
    <div class="item-area type-mess">
        <div class="item-type__text">
            The following files will be sent to you:
            <ul class="file-list">
                <?php foreach ($content['data'] as $key => $value): ?>
                    <li><img height="40" src="/themes/mobile/images/i-files.2x.png"><?php echo $value; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<div class="spot-item">
    <input type="email" placeholder="Email">
    <label class="checkbox agree">
        <input id="se" type="checkbox">
        <i></i>
        I agree to Terms&Conditions
    </label>
</div>
<ul class="item-footer">
    <li><a class="spot-button active" href="#"><span>Send</span></a></li>
    <li><a class="spot-button" href="#"><span>Cansel</span></a></li>
</ul>
