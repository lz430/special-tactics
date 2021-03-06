<?php
/**
 * The Header for your theme.
 *
 * Displays all of the <head> section and everything up until <div id="main">
 *
 * @package WordPress
 * @subpackage Boss
 * @since Boss 1.0.0
 */
?><!DOCTYPE html>

<html <?php language_attributes(); ?>>

	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="msapplication-tap-highlight" content="no"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<!-- BuddyPress and bbPress Stylesheets are called in wp_head, if plugins are activated -->
		<?php wp_head(); ?>

		<meta name="google-site-verification" content="wR9E91XMcYFfow8XyUa6Me9RUqGVZxKkwrAu1Kqe3KU" /> 
		
		
		<script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');ga('create', 'UA-102594572-2', 'auto');ga('send', 'pageview');</script>

		<!-- Facebook Pixel Code -->
		<script>
			!function(f,b,e,v,n,t,s)
			{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
			n.callMethod.apply(n,arguments):n.queue.push(arguments)};
			if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
			n.queue=[];t=b.createElement(e);t.async=!0;
			t.src=v;s=b.getElementsByTagName(e)[0];
			s.parentNode.insertBefore(t,s)}(window,document,'script',
			'https://connect.facebook.net/en_US/fbevents.js');
			 fbq('init', '1948214622081456'); 
			fbq('track', 'PageView');
		</script>
		<noscript>
			 <img height="1" width="1" src="https://www.facebook.com/tr?id=1948214622081456&ev=PageView&noscript=1"/>
		</noscript>
		<!-- End Facebook Pixel Code -->
		<script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/867246e249b67475bd1a0f5b6/3cf81ecdde96501624c6c667e.js");</script>

	</head>

	<?php
	global $rtl;
	$logo	 = ( boss_get_option( 'logo_switch' ) && boss_get_option( 'boss_logo', 'id' ) ) ? '1' : '0';
	$inputs	 = ( boss_get_option( 'boss_inputs' ) ) ? '1' : '0';
	$boxed	 = boss_get_option( 'boss_layout_style' );

    $header_style = boss_get_option('boss_header');
//    $boxed	 = 'fluid';
	?>

	<body <?php body_class(); ?> data-logo="<?php echo $logo; ?>" data-inputs="<?php echo $inputs; ?>" data-rtl="<?php echo ($rtl) ? 'true' : 'false'; ?>" data-header="<?php echo $header_style; ?>">
		<script async	src="https://www.googletagmanager.com/gtag/js?id=UA-102594572-2"></script>
		<script>
		  window.dataLayer = window.dataLayer || [ ] ;
		  function gtag(){dataLayer.push(arguments);}
		  gtag( 'js', new Date () ) ;
		  gtag( 'config', 'UA-102594572-2');
		  gtag( 'config', '815919970');
		</script>


		<?php do_action( 'buddyboss_before_header' ); ?>

		<div id="scroll-to"></div>

		<header id="masthead" class="site-header" data-infinite="<?php echo ( boss_get_option( 'boss_activity_infinite' ) ) ? 'on' : 'off'; ?>">

			<div class="header-wrap">
				<div class="header-outher">
					<div class="header-inner">
						<?php get_template_part( 'template-parts/header-fluid-layout-column' ); ?>
						<?php if( '1' == $header_style ){ ?>
						<?php get_template_part( 'template-parts/header-middle-column' ); ?>
						<?php } ?>
						<?php get_template_part( 'template-parts/header-profile' ); ?>
					</div><!-- .header-inner -->
				</div><!-- .header-wrap -->
			</div><!-- .header-outher -->

			<div id="mastlogo">
				<?php get_template_part( 'template-parts/header-logo' ); ?>
				<p class="site-description"><?php bloginfo( 'description' ); ?></p>
			</div><!-- .mastlogo -->

		</header><!-- #masthead -->

		<?php do_action( 'buddyboss_after_header' ); ?>

		<?php get_template_part( 'template-parts/header-mobile' ); ?>

		<!-- #panels closed in footer-->
		<div id="panels" class="<?php echo (boss_get_option( 'boss_adminbar' )) ? 'with-adminbar' : ''; ?>">

			<!-- Left Panel -->
			<?php get_template_part( 'template-parts/left-panel' ); ?>
			<!-- Left Mobile Menu -->
			<?php get_template_part( 'template-parts/left-mobile-menu' ); ?>

			<div id="right-panel">
				<div id="right-panel-inner">
					<div id="main-wrap"> <!-- Wrap for Mobile content -->
						<div id="inner-wrap"> <!-- Inner Wrap for Mobile content -->

							<?php do_action( 'buddyboss_inside_wrapper' ); ?>

							<div id="page" class="hfeed site">
								<div id="main" class="wrapper">