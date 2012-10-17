<?php $all_lang = Lang::getLangArray() ?>

<div class="twelve columns centered menu" ng-controller="MenuController">
    <div class="row">
        <div class="three columns lang">
            <div class="curent-lang" ng-click="lang()">
                <span><?php echo $all_lang[Yii::app()->language];?></span>
            </div>
            <div class="lang-hint">
                <?php foreach (Lang::getLang() as $row): ?>
                <?php if ($row['name'] != Yii::app()->language): ?>
                    <a href="/service/lang/<?php echo $row['name']?>"><?php echo $row['desc']?></a><br/>
                    <?php endif; ?>
                <?php endforeach;?>
            </div>
        </div>
        <div class="six columns logo">
            <a href="/"><img src="/themes/mobispot/images/logo.png" alt="mobispot"></a>
        </div>
        <div class="three columns user">
            <?php if (Yii::app()->user->isGuest): ?>
            <div class="m-button"  ng-click="auth()"><?php echo Yii::t('user', 'Войти')?></div>
            <?php include('auth.php'); ?>
            <?php else: ?>
            <?php $user_info = $this->userInfo(); ?>
            <div class="auth-on">
                <span class="auth-user-name" ng-click="menu()"><?php echo $user_info->name;?></span>

                <div class="user-menu-hint">
                    <?php echo CHtml::encode(Yii::app()->user->name)?><br />

                    <a href="/user/profile/" title="<?php echo Yii::t('user', 'Личные данные')?>">
                        <?php echo Yii::t('user', 'Личные данные')?>
                    </a><br />

                    <a href="/service/logout/" title="<?php echo Yii::t('user', 'Выйти')?>">
                        <strong><?php echo Yii::t('user', 'Выйти')?></strong>
                    </a>
                </div>
            </div>
            <?php endif;?>
        </div>
    </div>
</div>

