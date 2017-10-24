<?php

/*-----------------------------------------------------------------------------------*/
/*  CUSTOM POST TYPE REGISTRATION
/*-----------------------------------------------------------------------------------*/

function aa_register_destinations_post_type() {
	$labels = array(
		'name'                  => 'Destinations',
		'singular_name'         => 'Destination',
		'menu_name'             => 'Destinations',
		'name_admin_bar'        => 'Destination',
		'archives'              => 'Destination Archives',
		'parent_item_colon'     => 'Parent Destination:',
		'all_items'             => 'All Destinations',
		'add_new_item'          => 'Add New Destination',
		'add_new'               => 'Add Destination',
		'new_item'              => 'New Destination',
		'edit_item'             => 'Edit Destination',
		'update_item'           => 'Update Destination',
		'view_item'             => 'View Destination',
		'search_items'          => 'Search Destination',
		'not_found'             => 'No destinations found',
		'not_found_in_trash'    => 'Not found in Trash',
		'featured_image'        => 'Featured Image',
		'set_featured_image'    => 'Set featured image',
		'remove_featured_image' => 'Remove featured image',
		'use_featured_image'    => 'Use as featured image',
		'insert_into_item'      => 'Add into Destination',
		'uploaded_to_this_item' => 'Uploaded to this Destination',
		'items_list'            => 'Destination list',
		'items_list_navigation' => 'Destination list navigation',
		'filter_items_list'     => 'Filter Destination list',
	);
	
	$args = array(
		'label'                 => 'Destination',
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'revisions' ),
		'taxonomies'            => array(),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_icon'             => 'dashicons-location-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false, // Use the flexible field instead
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => true,
	);
	
	register_post_type( 'destination', $args );
}
add_action( 'init', 'aa_register_destinations_post_type' );

/**
 * Return the date range in a string format, eg: August 7 - 15, 2016
 */
function aa_destination_next_date() {
	$programs = get_field('available_programs');
	
	if ( !empty($programs) ) foreach( $programs as $p ) {
		return aa_format_program_date( $p['date_text'] );
	}
	
	return false;
}