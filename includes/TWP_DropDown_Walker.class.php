<?php
class TWP_DropDown_Walker extends Walker_Nav_Menu {
	var $link_counter=0;

	function start_lvl(&$output, $depth) {
		global $link_counter;

		$indent = str_repeat("\t",$depth);
		$output .= "\n$indent<ul class=\"dropdown-menu\">\n";
	}

	function start_el(&$output, $item, $depth, $args) {
		global $wp_query;
		global $link_counter;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$classes = apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item );

		if (in_array('has_children',$classes)) {
			$classes[] = 'dropdown';
		}//end if

		if (in_array('current-menu-item', $classes) || in_array('current-menu-parent',$classes)) {
			$classes[] = 'active';
		}//end if

		$class_names = join( ' ', $classes );
		$class_names = ' class="'. esc_attr( $class_names ) . '"';
		if (in_array('has_children',$classes)) $counter++;

		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		if (strpos($class_names,'has_children')) {
			$link_counter++;
			$attributes .= ' class="dropdown-toggle" id="link-'.$link_counter.'"';
		}

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before .apply_filters( 'the_title', $item->title, $item->ID );
		$item_output .= $description.$args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

	}
}
