<?php

class Twp {
	public function enqueue_scripts() {
		wp_register_style('twp-custom', get_bloginfo('stylesheet_directory') . '/custom.css');

		wp_register_script('jquery-colorbox', get_bloginfo('template_url') . '/js/colorbox/colorbox/jquery.colorbox-min.js', array('jquery'), '1.3.18', TRUE );
		wp_register_script('bootstrap-dropdown', get_bloginfo('template_url') . '/bootstrap/js/bootstrap-dropdown.js', array('jquery'), '1.4', TRUE);
		wp_register_script('bootstrap-twipsy', get_bloginfo('template_url') . '/bootstrap/js/bootstrap-twipsy.js', array('jquery'), '1.4', TRUE);
		wp_register_script('bootstrap-popover', get_bloginfo('template_url') . '/bootstrap/js/bootstrap-popover.js', array('jquery'), '1.4', TRUE);
		wp_register_script(
			'twp-behavior', 
			get_bloginfo('template_url') . '/js/behavior.js', 
			array(
				'jquery', 
				'jquery-colorbox',
				'bootstrap-dropdown',
				'bootstrap-twipsy',
				'bootstrap-popover',
			), 
			'1', 
			TRUE 
		);

		wp_enqueue_style('twp-custom');
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-colorbox');
		wp_enqueue_script('bootstrap-dropdown');
		wp_enqueue_script('bootstrap-twipsy');
		wp_enqueue_script('bootstrap-popover');
		wp_enqueue_script('twp-behavior');
	}//end enqueue_scripts

	public function init() {
		add_theme_support( 'menus' );

		register_sidebar( array(
			'name' => 'Hero Widgets',
			'id' => 'sidebar-hero-widgets',
			'before_widget' => '<div id="tweets">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="twitter">',
			'after_title' => '</h3>',
		));
			
		/** This theme uses wp_nav_menu() in one location */
		register_nav_menus( array(
			'primary' => __( 'Primary Menu', 'twp' ),
		) );

		register_nav_menus( array(
			'home_artist' => __( 'Home: Artist', 'twp' ),
		) );

		add_action('wp_enqueue_scripts', array( $this, 'enqueue_scripts') );
	}//end init
}//end class
