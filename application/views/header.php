<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php echo $title; ?></title>
<!-- BOOTSTRAP STYLES-->
<?php echo link_tag('assets/css/bootstrap.css'); ?>
     <!-- FONTAWESOME STYLES-->
    <?php echo link_tag('assets/css/font-awesome.css'); ?>
        <!-- CUSTOM STYLES-->
    <?php echo link_tag('assets/css/custom.css'); ?>
     <!-- GOOGLE FONTS-->
<link href='http://fonts.googleapis.com/css?family=Open+Sans'
	rel='stylesheet' type='text/css' />
</head>
<body>
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-cls-top " role="navigation"
			style="margin-bottom: 0">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse"
					data-target=".sidebar-collapse">
					<span class="sr-only">Toggle navigation</span> <span
						class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">PowerSystem</a>
			</div>
			<div
				style="color: white; padding: 15px 50px 5px 50px; float: right; font-size: 16px;"><?php echo shell_exec('uptime');?> <?php echo $apply_button;?>&nbsp;<a href="<?php echo $button_href;?>"
					class="btn btn-danger square-btn-adjust"><?php echo $button;?></a>
					
			</div>
		</nav>
		<!-- /. NAV TOP  -->
		<nav class="navbar-default navbar-side" role="navigation">
			<div class="sidebar-collapse">
				<ul class="nav" id="main-menu">
					<li class="text-center"><!--  <img src="assets/img/find_user.png" class="user-image img-responsive" />--></li>


					<li><a <?php if ($active==='dashboard')  echo 'class="active-menu"';?> href="/dashboard"><i class="fa fa-dashboard fa-3x"></i>
							Dashboard</a></li>
					<li><a <?php if ($active==='configuration')  echo 'class="active-menu"';?> href="/configuration/showConfPowerSocket"><i
							class="fa fa-gears fa-3x"></i>Configuration</a></li>
							<li><a <?php if ($active==='info')  echo 'class="active-menu"';?> href="/info"><i
							class="fa fa-info-circle fa-3x"></i>INFO</a></li>
				</ul>

			</div>

		</nav>
		<!-- /. NAV SIDE  -->