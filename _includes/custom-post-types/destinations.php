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
		'supports'              => array( 'title', 'author', 'revisions' ),
		'taxonomies'            => array(),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_icon'             => 'dashicons-location-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => 'destinations', // Plural
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => true,
	);
	
	register_post_type( 'destination', $args );
}
add_action( 'init', 'aa_register_destinations_post_type' );

/*-----------------------------------------------------------------------------------*/
/*  CONTEXTUAL HELP (optional)
/*-----------------------------------------------------------------------------------*/

function aa_destination_contextual_help( $contextual_help, $screen_id, $screen ) {
	if ( 'edit-videos' == $screen->id ) {
		
		$contextual_help = '<h2>Videos</h2>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce est libero, congue eget gravida mollis, eleifend sit amet felis.</p> 
    <p>Sed mollis pretium dolor at vestibulum. Phasellus condimentum dui in velit interdum, sed aliquam ex hendrerit.</p>';
		
	} elseif ( 'videos' == $screen->id ) {
		
		$contextual_help = '<h2>Editing Videos</h2>
    <p>Nunc eleifend arcu sit amet tortor <strong>luctus aliquam.</strong> Sed a massa vestibulum, iaculis magna ac, faucibus tellus.</p>';
		
	}
	return $contextual_help;
}
add_action( 'contextual_help', 'aa_destination_contextual_help', 10, 3 );

/*---------------------------------------------------------------
	LATEST POSTS FROM THIS CUSTOM POST TYPE SHORTCODE (optional)
------------------------------------------------------------------*/

function latest_videos_shortcode($atts, $content){
	$html = '<div class="videos"><ul>';
	
	global $post;
	
	$args = array( 'posts_per_page' => $atts['no'],
	               'offset'=> 0,
	               'post_type' => 'videos');
	$all_posts = new WP_Query($args);
	
	while($all_posts->have_posts()) : $all_posts->the_post();
		
		$html .= '<li><a href="' . get_permalink() . '">
			<div class="caption">
				<h3>' . get_the_title() . '</h3>
			</div>' . get_the_post_thumbnail($post->ID, 'thumb-video') . '
		</a></li>';
	
	endwhile;
	
	$html .= '</ul></div>';
	return $html;
}
add_shortcode('latest_videos', 'latest_videos_shortcode');