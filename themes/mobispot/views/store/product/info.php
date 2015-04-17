<div class="content-wrapper">
    <div class="content-block m-content-block store-content" ng-controller="ProductController">
        <?php if (!empty($message)): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        
        <p><?php echo Yii::t('store', 'Вы можете вернуться '); ?>
            <a href="/store"><?php echo Yii::t('store', 'в магазин '); ?></a>
            <?php echo Yii::t('store', 'или '); ?>
            <a href="/"><?php echo Yii::t('store', 'на главную страницу'); ?></a>
        </p>
    </div>
</div>