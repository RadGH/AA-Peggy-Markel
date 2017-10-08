<?php

function aa_customize_post_taxonomies() {
	global $wp_taxonomies;
	
	// Remove tags, not used with this theme
	if ( $wp_taxonomies['post_tag'] ) {
		$wp_taxonomies['post_tag']->public = false;
		$wp_taxonomies['post_tag']->show_ui = false;
	}
}
add_action( 'init', 'aa_customize_post_taxonomies', 20 );