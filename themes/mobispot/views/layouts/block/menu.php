<?php $all_lang = Lang::getLangArray()?>

<div class="center-rel">
    <div id="sel-lang">
        <div class="curent-lang" id="lang-select">
            <span><?php echo $all_lang[Yii::app()->language];?></span>
        </div>
        <div class="lang-hint">
            <div>
                <?php foreach(Lang::getLang() as $row):?>
                    <?php if($row['name'] != Yii::app()->language):?>
                        <a href="/service/lang/<?php echo $row['name']?>"><?php echo $row['desc']?></a><br/>
                    <?php endif;?>
                <?php endforeach;?>
            </div>
        </div>
    </div>

    <div id="logo"><a href="/"><img src="/themes/mobispot/images/logo.png" alt="mobispot"></a></div>
    <?php ?>
    <div id="authorization">
        <div id="user_menu">
            <?php if (Yii::app()->user->isGuest): ?>
            <form action="#" method="post" id="login_form">
                <div id="button-auth">
                    <span><?php echo Yii::t('user', 'Войти')?></span>
                </div>
                <?php include('auth.php'); ?>
            </form>
            <?php else: ?>
            <?php $user_info = $this->userInfo(); ?>
            <div id="auth-on">
                <span id="auth-user-name"><?php echo $user_info->name;?></span>

                <div class="user-menu-hint">
                    <div>
                        <?php echo CHtml::encode(Yii::app()->user->name)?>
                    </div>
                    <div>
                        <a href="/user/profile/" title="<?php echo Yii::t('user', 'Личные данные')?>" target="_blank">
                            <?php echo Yii::t('user', 'Личные данные')?>
                        </a>
                    </div>
                    <div>
                        <a href="/service/logout/" title="<?php echo Yii::t('user', 'Выйти')?>">
                            <strong><?php echo Yii::t('user', 'Выйти')?></strong>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif;?>
        </div>
    </div>
</div>