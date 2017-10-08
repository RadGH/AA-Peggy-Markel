<?php

/**
 * Hides post "Tags" which aren't used in the theme
 */
function aa_hide_post_tags() {
	global $wp_taxonomies;
	
	// Remove tags, not used with this theme
	if ( $wp_taxonomies['post_tag'] ) {
		$wp_taxonomies['post_tag']->public = false;
		$wp_taxonomies['post_tag']->show_ui = false;
	}
}
add_action( 'init', 'aa_hide_post_tags', 20 );

/**
 * Truncate lists of categories if there are 5 or more categories on a single item.
 *
 * @param $categories
 * @param $post_id
 *
 * @return array
 */
function aa_truncate_category_list( $categories, $post_id ) {
	global $aa_truncated_count;
	$trim_amount = 3;
	
	// If there are at least two categories more than we should keep, truncate the list.
	if ( count($categories) > $trim_amount + 1 ) {
		$aa_truncated_count = count($categories) - $trim_amount;
		
		$categories = array_slice( $categories, 0, $trim_amount );
		
		// This hook will append "and X other categories" to the list.
		add_filter( 'the_category', '_aa_append_list_truncation_tag', 10, 3 );
	}
	return $categories;
}
add_filter( 'the_category_list', 'aa_truncate_category_list', 10, 2 );

/**
 * Add a suffix to the category list, if the list was truncated by aa_truncate_category_list()
 *
 * @param $list
 * @param $separator
 * @param $parents
 *
 * @return string
 */
function _aa_append_list_truncation_tag( $list, $separator, $parents ) {
	global $aa_truncated_count;
	
	// Remove this hook immediately so it doesn't affect other posts.
	remove_filter( 'the_category', '_aa_append_list_truncation_tag' );
	
	return $list . $separator . ' and ' . $aa_truncated_count . ' other categories';
}