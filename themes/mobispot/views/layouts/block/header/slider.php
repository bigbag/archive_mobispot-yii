<header class="header-page">
	<?php if (Yii::app()->user->isGuest): ?>
	<?php include('block/activ.php');?>
	<?php include('block/sign.php');?>
	<?php endif; ?>
	<div class="row row__head-slider">
		<div class="twelve">
			<div class="header-top">
				<?php if (!Yii::app()->user->isGuest): ?>
				<?php $userInfo=$this->userInfo()?>
				<ul class="login-bar">
					<li><a href="/user/personal"><?php echo $userInfo->name;?></a></li>
				<!-- <li><a href="#">Shopping bag (2)</a></li> -->
				</ul>
				<?php endif; ?>
				<div class="four columns">
					<h1 class="logo"><a href="/"><img src="/themes/mobispot/images/logo.png" /></a></h1>
				</div>
					<div class="eight columns">
						<?php include('block/menu.php');?>
					</div>
			</div>
			<div class="bubbles-slider">
				<div id="slider">
					<?php if (Yii::app()->controller->id=='site'): ?>
						<img src="/themes/mobispot/images/slider.jpg" />
						<img src="/themes/mobispot/images/slider.jpg" />
						<img src="/themes/mobispot/images/slider.jpg" />
					<?php else:?>
						<img src="/themes/mobispot/images/slider.jpg" />
					<?php endif;?>
				</div>
				<div class="bubbles-content">
				<a href="/personal" class="bubble">
					<h4><?php echo Yii::t('bubbles', 'Personal')?></h4>
					<p><?php echo Yii::t('bubbles', 'personal desc')?></p>
					<b></b>
				</a>
				<a href="/business" class="bubble">
					<h4><?php echo Yii::t('bubbles', 'Business')?></h4>
					<p><?php echo Yii::t('bubbles', 'business desc')?></p>
					<b></b>
				</a>
				<a href="/corporate" class="bubble">
					<h4><?php echo Yii::t('bubbles', 'Corporate')?></h4>
					<p><?php echo Yii::t('bubbles', 'corporate desc')?></p>
					<b></b>
				</a>
				</div>
			</div>
		</div>
	</div>
</header>