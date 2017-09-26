<?php

/*-----------------------------------------------------------------------------------*/
/*  CUSTOM POST TYPE REGISTRATION
/*-----------------------------------------------------------------------------------*/

// Creates Movie Reviews Custom Post Type
function videos_init() {
    $args = array(
      'label' => 'Videos',
        'public' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => array('slug' => 'videos'),
        'query_var' => true,
        'menu_icon' => 'dashicons-video-alt',
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'trackbacks',
            'custom-fields',
            'comments',
            'revisions',
            'thumbnail',
            'author',
            'page-attributes',)
        );
    register_post_type( 'videos', $args );
}
add_action( 'init', 'videos_init' );

/*-----------------------------------------------------------------------------------*/
/*  CUSTOM INTERACTION MESSAGES (optional)
/*-----------------------------------------------------------------------------------*/

function video_updated_messages( $messages ) {
  global $post, $post_ID;
  $messages['videos'] = array(
    0 => '', 
    1 => sprintf( __('Video updated. <a href="%s"> View video page.</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Video updated.'),
    5 => isset($_GET['revision']) ? sprintf( __('Video restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Video published. <a href="%s">View video page.</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Video saved.'),
    8 => sprintf( __('Video submitted. <a target="_blank" href="%s">Preview video page</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Video scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview video page</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Video draft updated. <a target="_blank" href="%s">Preview video page</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );
  return $messages;
}
add_filter( 'post_updated_messages', 'video_updated_messages' );


/*-----------------------------------------------------------------------------------*/
/*  CONTEXTUAL HELP (optional)
/*-----------------------------------------------------------------------------------*/

function video_contextual_help( $contextual_help, $screen_id, $screen ) { 
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
add_action( 'contextual_help', 'video_contextual_help', 10, 3 );

/*-----------------------------------------------------------------------------------*/
/*  CUSTOM TAXONOMIES
/*-----------------------------------------------------------------------------------*/

function videos_taxonomies() {
  $labels = array(
    'name'              => _x( 'Video Categories', 'taxonomy general name' ),
    'singular_name'     => _x( 'Video Category', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Video Categories' ),
    'all_items'         => __( 'All Video Categories' ),
    'parent_item'       => __( 'Parent Video Category' ),
    'parent_item_colon' => __( 'Parent Video Category:' ),
    'edit_item'         => __( 'Edit Video Category' ), 
    'update_item'       => __( 'Update Video Category' ),
    'add_new_item'      => __( 'Add New Video Category' ),
    'new_item_name'     => __( 'New Video Category' ),
    'menu_name'         => __( 'Video Categories' ),
  );
  $args = array(
    'labels' => $labels,
    'hierarchical' => true,
  );
  register_taxonomy( 'video_category', 'videos', $args );
}
add_action( 'init', 'videos_taxonomies', 0 );

/*-----------------------------------------------------------------------------------*/
/*  DEFINE META BOX (optional YOU CAN USE ACF FIELDS INSTEAD)
/*-----------------------------------------------------------------------------------*/

add_action( 'add_meta_boxes', 'youtube_id_box' );
function youtube_id_box() {
    add_meta_box( 
        'youtube_id_box',
        __( 'YouTube ID', 'myplugin_textdomain' ),
        'youtube_id_box_content',
        'videos',
        'side',
        'high'
    );
}

/*-----------------------------------------------------------------------------------*/
/*  DEFINE THE CONTENT OF THE META BOX (optional YOU CAN USE ACF FIELDS INSTEAD)
/*-----------------------------------------------------------------------------------*/

function youtube_id_box_content( $post ) {
    wp_nonce_field( plugin_basename( __FILE__ ), 'youtube_id_box_content_nonce' );
    $meta_values = get_post_meta($post->ID, 'youtube_id', true);
 
    echo '<label for="youtube_id"></label>';
    if($meta_values != '') {
        echo '<input type="text" id="youtube_id" name="youtube_id" placeholder="enter a YouTube ID" value="' . $meta_values . '"/>';
    } else {
        echo '<input type="text" id="youtube_id" name="youtube_id" placeholder="enter a YouTube ID"/>';
    }
}

/*-----------------------------------------------------------------------------------*/
/*  HANDLING SUBMITTED DATA (optional YOU CAN USE ACF FIELDS INSTEAD)
/*-----------------------------------------------------------------------------------*/

add_action( 'save_post', 'youtube_id_box_save' );
function youtube_id_box_save( $post_id ) {

  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
  return;

  if ( !wp_verify_nonce( $_POST['youtube_id_box_content_nonce'], plugin_basename( __FILE__ ) ) )
  return;

  if ( 'page' == $_POST['post_type'] ) {
    if ( !current_user_can( 'edit_page', $post_id ) )
    return;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ) )
    return;
  }
  $youtube_id = $_POST['youtube_id'];
  update_post_meta( $post_id, 'youtube_id', $youtube_id );
}

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

/* THIS HELPS FOR SINGLE PAGES FOR CUSTOM POST TYPES */
flush_rewrite_rules();
?>