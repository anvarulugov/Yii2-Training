<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?= Html::csrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
</head>
<body class="skin-blue">
	<?php $this->beginBody() ?>
	<div class="wrapper">

		<header class="main-header">
			<a href="<?php echo Yii::$app->homeUrl; ?>" class="logo">
				<?php echo Yii::t('app','Dashboard'); ?>
			</a>
			<!-- Header Navbar: style can be found in header.less -->
			<nav class="navbar navbar-static-top" role="navigation">
				<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
					<span class="sr-only">Toggle navigation</span>
				</a>
				<!-- Navbar Right Menu -->
				<div class="navbar-custom-menu">
				  <ul class="nav navbar-nav">
					<!-- Messages: style can be found in dropdown.less-->
					<li class="dropdown messages-menu">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-envelope-o"></i>
						<span class="label label-success">4</span>
					  </a>
					  <ul class="dropdown-menu">
						<li class="header">You have 4 messages</li>
						<li>
						  <!-- inner menu: contains the actual data -->
						  <ul class="menu">
							<li><!-- start message -->
							  <a href="#">
								<div class="pull-left">
								  <img src="media/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
								</div>
								<h4>
								  Sender Name
								  <small><i class="fa fa-clock-o"></i> 5 mins</small>
								</h4>
								<p>Message Excerpt</p>
							  </a>
							</li><!-- end message -->
							...
						  </ul>
						</li>
						<li class="footer"><a href="#">See All Messages</a></li>
					  </ul>
					</li>
					<!-- Notifications: style can be found in dropdown.less -->
					<li class="dropdown notifications-menu">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-bell-o"></i>
						<span class="label label-warning">10</span>
					  </a>
					  <ul class="dropdown-menu">
						<li class="header">You have 10 notifications</li>
						<li>
						  <!-- inner menu: contains the actual data -->
						  <ul class="menu">
							<li>
							  <a href="#">
								<i class="ion ion-ios-people info"></i> Notification title
							  </a>
							</li>
							...
						  </ul>
						</li>
						<li class="footer"><a href="#">View all</a></li>
					  </ul>
					</li>
					<!-- Tasks: style can be found in dropdown.less -->
					<li class="dropdown tasks-menu">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-flag-o"></i>
						<span class="label label-danger">9</span>
					  </a>
					  <ul class="dropdown-menu">
						<li class="header">You have 9 tasks</li>
						<li>
						  <!-- inner menu: contains the actual data -->
						  <ul class="menu">
							<li><!-- Task item -->
							  <a href="#">
								<h3>
								  Design some buttons
								  <small class="pull-right">20%</small>
								</h3>
								<div class="progress xs">
								  <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
									<span class="sr-only">20% Complete</span>
								  </div>
								</div>
							  </a>
							</li><!-- end task item -->
							...
						  </ul>
						</li>
						<li class="footer">
						  <a href="#">View all tasks</a>
						</li>
					  </ul>
					</li>
					<!-- User Account: style can be found in dropdown.less -->
					<li class="dropdown user user-menu">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img src="media/img/user2-160x160.jpg" class="user-image" alt="User Image"/>
						<span class="hidden-xs">Alexander Pierce</span>
					  </a>
					  <ul class="dropdown-menu">
						<!-- User image -->
						<li class="user-header">
						  <img src="media/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
						  <p>
							Alexander Pierce - Web Developer
							<small>Member since Nov. 2012</small>
						  </p>
						</li>
						<!-- Menu Body -->
						<li class="user-body">
						  <div class="col-xs-4 text-center">
							<a href="#">Followers</a>
						  </div>
						  <div class="col-xs-4 text-center">
							<a href="#">Sales</a>
						  </div>
						  <div class="col-xs-4 text-center">
							<a href="#">Friends</a>
						  </div>
						</li>
						<!-- Menu Footer-->
						<li class="user-footer">
						  <div class="pull-left">
							<a href="#" class="btn btn-default btn-flat">Profile</a>
						  </div>
						  <div class="pull-right">
							<a href="#" class="btn btn-default btn-flat">Sign out</a>
						  </div>
						</li>
					  </ul>
					</li>
				  </ul>
				</div>
			</nav>
		</header>

		<!-- =============================================== -->

		<!-- Left side column. contains the sidebar -->
		<aside class="main-sidebar">
			<!-- sidebar: style can be found in sidebar.less -->
			<section class="sidebar">
				<!-- sidebar menu: : style can be found in sidebar.less -->
				<ul class="sidebar-menu">
				</ul>
			</section>
			<!-- /.sidebar -->
		</aside>

		<!-- =============================================== -->

		<!-- Right side column. Contains the content of the page -->
		<div class="content-wrapper">
			<section class="content-header">
				<!-- Page title and breadcrumbs go here -->
				<?php // echo Breadcrumbs::widget([
					//'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
				//]) ?>
			</section><!-- /.content-header -->

			<!-- Main content -->
			<section class="content">
				<?= $content ?>
			</section><!-- /.content -->
		</div><!-- /.right-side -->

		<footer class="main-footer">
			<div class="pull-right hidden-xs">
				<b>Version</b> 2.0
			</div>
			<strong>Copyright © 2014-2015 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights reserved.
		</footer>

	</div><!-- ./wrapper -->

	<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
