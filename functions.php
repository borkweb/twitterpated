<?php

require 'includes/TWP_DropDown_Walker.class.php';

function twp_theme_setup() {
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
}//end twp_theme_setup

twp_theme_setup();

/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own twitterpated_posted_on to override in a child theme
 *
 * @since Twenty Eleven 1.0
 */
function twitterpated_posted_on() {
	printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'twitterpated' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		sprintf( esc_attr__( 'View all posts by %s', 'twitterpated' ), get_the_author() ),
		esc_html( get_the_author() )
	);
}

function check_for_submenu($classes, $item) {
	global $wpdb;
	$has_children = $wpdb->get_var("SELECT COUNT(meta_id) FROM wp_postmeta WHERE meta_key='_menu_item_menu_item_parent' AND meta_value='".$item->ID."'");
	if ($has_children > 0) array_push($classes,'has_children');
	return $classes;
}

add_filter( 'nav_menu_css_class', 'check_for_submenu', 10, 2);

if ( ! function_exists( 'twitterpated_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twitterpated_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments. Taken from TwentyEleven
 *
 * @since Twenty Eleven 1.0
 */
function twitterpated_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'twentyeleven' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
						$avatar_size = 68;
						if ( '0' != $comment->comment_parent )
							$avatar_size = 39;

						echo get_avatar( $comment, $avatar_size );

						/* translators: 1: comment author, 2: date and time */
						printf( __( '%1$s on %2$s <span class="says">said:</span>', 'twentyeleven' ),
							sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
							sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s at %2$s', 'twentyeleven' ), get_comment_date(), get_comment_time() )
							)
						);
					?>

					<?php edit_comment_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-author .vcard -->

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentyeleven' ); ?></em>
					<br />
				<?php endif; ?>

			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'twentyeleven' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for twitterpated_comment()
