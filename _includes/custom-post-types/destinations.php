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
		'supports'              => array( 'title', 'author', 'thumbnail', 'revisions' ),
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


/**
 * Return the date range in a string format, eg: August 7 - 15, 2016
 */
function aa_destination_date_range() {
	$start = get_field( 'start_date' );
	$end = get_field( 'end_date' );
	if ( !$start ) return false;
	
	// Get a timestamp to benefit from PHP's date() format.
	$start_timestamp = strtotime($start);
	if ( $start_timestamp < 1 ) return false;
	
	// Verify that end timestamp is after the start time.
	if ( $end ) {
		$end_timestamp = strtotime($end);
		
		if ( $end_timestamp < $start_timestamp ) {
			// End date shouldn't come first.
			$end = false;
		}
	}
	
	// Pick from four possible formats to display the time range in.
	if ( $end ) {
		if ( date('n', $start_timestamp) === date('n', $end_timestamp) ) {
			// Same month
			// Return format: August 3 - 5, 2017
			return date('F j', $start_timestamp) . ' - ' . date('j, Y', $end_timestamp);
		}else{
			if ( date('Y', $start_timestamp) === date('Y', $end_timestamp) ) {
				// Same year, different months
				// Return format: August 28 - June 1, 2017
				return date('F j', $start_timestamp) . ' - ' . date('F j, Y', $end_timestamp);
			}else{
				// Different months, different years.
				// Return format: December 28, 2017 - January 2, 2018
				return date('F j, Y', $start_timestamp) . ' - ' . date('F j, Y', $end_timestamp);
			}
		}
	}else{
		// Only start time
		// Return format: August 3, 2017
		return date('F j, Y', $start_timestamp);
	}
}