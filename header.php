<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twitterpated' ), max( $paged, $page ) );

	?></title>
	<meta name="description" content="<?php echo $site_description; ?>">
  <meta name="author" content="Matthew Batchelder">

  <meta name="viewport" content="width=device-width,initial-scale=1">

	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/js/colorbox/example2/colorbox.css">
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />

  <script src="<?php bloginfo('template_url'); ?>/js/libs/modernizr-2.0.6.min.js"></script>
<?php
	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
</head>
<body <?php body_class(); ?>>

<div id="container">
	<div class="topbar">
		<div class="fill">
			<div class="container">
				<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
				<?php 
					wp_nav_menu( array( 
						'container' => 'nav',
						'container_class' => 'menu-{menu slug}-container',
						'menu_class' => 'nav menu',
						'theme_location' => 'primary', 
						'fallback_cb' => 'wp_page_menu',
						'walker' => new TWP_DropDown_Walker,
					) ); 
				?>
				<form method="get" class="pull-right" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<input type="search" class="field" name="s" id="s" placeholder="<?php esc_attr_e( 'Search', 'twitterpated' ); ?>" />
				</form>
			</div>
		</div>
	</div>
