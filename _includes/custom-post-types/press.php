<?php

/*-----------------------------------------------------------------------------------*/
/*  CUSTOM POST TYPE REGISTRATION
/*-----------------------------------------------------------------------------------*/

function aa_register_press_post_type() {
	$labels = array(
		'name'                  => 'Press',
		'singular_name'         => 'Press',
		'menu_name'             => 'Press',
		'name_admin_bar'        => 'Press',
		'archives'              => 'Press Archives',
		'parent_item_colon'     => 'Parent Press:',
		'all_items'             => 'All Press',
		'add_new_item'          => 'Add New Press',
		'add_new'               => 'Add Press',
		'new_item'              => 'New Press',
		'edit_item'             => 'Edit Press',
		'update_item'           => 'Update Press',
		'view_item'             => 'View Press',
		'search_items'          => 'Search Press',
		'not_found'             => 'No press found',
		'not_found_in_trash'    => 'Not found in Trash',
		'featured_image'        => 'Featured Image',
		'set_featured_image'    => 'Set featured image',
		'remove_featured_image' => 'Remove featured image',
		'use_featured_image'    => 'Use as featured image',
		'insert_into_item'      => 'Add into Press',
		'uploaded_to_this_item' => 'Uploaded to this Press',
		'items_list'            => 'Press list',
		'items_list_navigation' => 'Press list navigation',
		'filter_items_list'     => 'Filter Press list',
	);
	
	$args = array(
		'label'                 => 'Press',
		'labels'                => $labels,
		'supports'              => array( 'title', 'author', 'thumbnail', 'revisions' ),
		'taxonomies'            => array(),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_icon'             => 'dashicons-format-aside',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false, // Use the flexible field instead
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => true,
	);
	
	register_post_type( 'press', $args );
}
add_action( 'init', 'aa_register_press_post_type' );


// Save associated destinations as separate meta keys for wp_query compatibility
function aa_press_save_destination_meta_separately( $post_id ) {
	if ( get_post_type( $post_id ) != 'press' ) return;
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
	
	$destinations = get_field( 'destinations', $post_id );
	delete_post_meta( $post_id, 'destination_id' );
	
	if ( $destinations ) foreach( $destinations as $id ) {
		add_post_meta( $post_id, 'destination_id', (int) $id );
	}
}
add_action( 'acf/save_post', 'aa_press_save_destination_meta_separately', 30 );