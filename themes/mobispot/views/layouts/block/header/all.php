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
						<li><a href="/user/account"><?php echo $userInfo->name;?></a></li>
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
		</div>
	</div>
</header>