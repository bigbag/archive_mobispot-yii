<?php
$this->breadcrumbs = array(
    Yii::t('user', "Login"),
);
?>

<h1><?php echo Yii::t('user', "Login"); ?></h1>

<?php if (Yii::app()->user->hasFlash('loginMessage')): ?>

<div class="success">
    <?php echo Yii::app()->user->getFlash('loginMessage'); ?>
</div>

<?php endif; ?>

<p><?php echo Yii::t('user', "Please fill out the following form with your login credentials:"); ?></p>

<div class="form">
    <?php echo CHtml::beginForm(); ?>

    <p class="note"><?php echo Yii::t('user', 'Fields with <span class="required">*</span> are required.'); ?></p>

    <?php echo CHtml::errorSummary($model); ?>

    <div class="row">
        <?php echo CHtml::activeLabelEx($model, 'email'); ?>
        <?php echo CHtml::activeTextField($model, 'email') ?>
    </div>

    <div class="row">
        <?php echo CHtml::activeLabelEx($model, 'password'); ?>
        <?php echo CHtml::activePasswordField($model, 'password') ?>
    </div>

    <div class="row rememberMe">
        <?php echo CHtml::activeCheckBox($model, 'rememberMe'); ?>
        <?php echo CHtml::activeLabelEx($model, 'rememberMe'); ?>
    </div>
    <?php $this->widget('CCaptcha', array(
    'clickableImage' => true,
    'showRefreshButton' => true,
    'buttonType' => 'button',
    'buttonOptions' =>
    array('type' => 'image',
        'src' => "/themes/mobispot/images/ico-refresh.png",
        'width' => 21,
    ),
));?><input type="text" class="txt"
            name="LoginCaptchaForm[verifyCode]" value="" placeholder=""/>
    <div class="row submit">
        <?php echo CHtml::submitButton(Yii::t('user', "Login")); ?>
    </div>

    <?php echo CHtml::endForm(); ?>
</div><!-- form -->


<?php
$form = new CForm(array(
    'elements' => array(
        'email' => array(
            'type' => 'text',
            'maxlength' => 32,
        ),
        'password' => array(
            'type' => 'password',
            'maxlength' => 32,
        ),
        'rememberMe' => array(
            'type' => 'checkbox',
        )
    ),

    'buttons' => array(
        'login' => array(
            'type' => 'submit',
            'label' => 'Login',
        ),
    ),
), $model);
?>

