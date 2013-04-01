<header class="header-page">
	<?php if (Yii::app()->user->isGuest): ?>
		<?php include('block/activ.php');?>
		<?php include('block/sign.php');?>
	<?php endif; ?>
	<div class="row row__head-slider">
		<div class="twelve">
			<div class="header-top">
				<?php if (!Yii::app()->user->isGuest){ ?>
					<?php $userInfo=$this->userInfo()?>
					<ul class="login-bar">
						<li><a href="#"><?php echo $userInfo->name;?></a></li>
						<?php if(Yii::app()->controller->module->id == 'store'){ ?>
							<li ng-controller="UserCtrl" ng-init="initTimer('<?php echo Yii::app()->request->csrfToken; ?>')"><a href="/store/product/cart">Shopping bag({{itemsInCart}})</a></li>
						<?php }elseif(isset(Yii::app()->session['itemsInCart']) && (Yii::app()->session['itemsInCart'] > 0)) { ?>
						<li><a href="/store/product/cart">Shopping bag(<?php echo Yii::app()->session['itemsInCart']; ?>)</a></li>
						<?php } ?>
					</ul>
				<?php }elseif(Yii::app()->controller->module->id == 'store'){ ?>
					<ul class="login-bar">
						<li ng-controller="UserCtrl" ng-init="initTimer('<?php echo Yii::app()->request->csrfToken; ?>')"><a href="/store/product/cart">Shopping bag({{itemsInCart}})</a></li>
					</ul>
				<?php }elseif(isset(Yii::app()->session['itemsInCart']) && (Yii::app()->session['itemsInCart'] > 0)) { ?>
					<ul class="login-bar">
						<li><a href="/store/product/cart">Shopping bag(<?php echo Yii::app()->session['itemsInCart']; ?>)</a></li>
					</ul>				
				<?php } ?>
				
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