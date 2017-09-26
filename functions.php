<?php
/*---------------------------------
	LOAD THEME FRAMEWORK
------------------------------------*/
// Load Extra Components
require_once( get_template_directory() . '/_includes/functions_extra.php' );

/*****************************************************************************************

	Below are the most important functions of the theme. Edit carefully! :)

*****************************************************************************************/

/*---------------------------------------
	Clean up the WordPress header output
-----------------------------------------*/

	function removeHeadLinks() {
	remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
	remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
	remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
	remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
	remove_action( 'wp_head', 'index_rel_link' ); // index link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
	remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.
	remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	}
	add_action('init', 'removeHeadLinks');
	remove_action('wp_head', 'wp_generator');

/*---------------------------------
	Remove Empty Span
------------------------------------*/

	function remove_empty_read_more_span($content) {
	  return preg_replace("(<p><span id=\"more-[0-9]{1,}\"></span></p>)", "", $content);
	}
	add_filter('the_content', 'remove_empty_read_more_span');

/*----------------------------------------
	Make some adjustments on theme setup
------------------------------------------*/

if ( ! function_exists( 'theme_setup' ) ):
	function theme_setup() {

		//Make theme available for translation
		//load_theme_textdomain( 'theme', get_template_directory() . '/lang' );

		//Define content width
		if(!isset($content_width)) $content_width = 940;

		//Style the visual editor with editor-style.css to match the theme style.
		add_editor_style(get_template_directory_uri() . '/_static/styles/admin/editor-style.css');

		//Add post thumbnails
		add_theme_support( 'post-thumbnails' );

		//Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );

		$locale = get_locale();
		$locale_file = get_template_directory() . "/lang/$locale.php";

		if ( is_readable( $locale_file ) )
			require_once( $locale_file );

		//This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
		'primary' => __( 'Main Navigation', 'alchemyaim' )
		) );

		//Define custom thumbnails
		set_post_thumbnail_size( 151, 110, true );
		add_image_size( 'thumb-gallery',  312, 250, true );
	}
endif;
add_action( 'after_setup_theme', 'theme_setup' );

//Add Admin Scripts
function admin_scripts_enqueue( $hook ) {
    if ('edit.php' != $hook) {
        return;
    }
    wp_enqueue_script( 'admin_custom_script', get_template_directory_uri() . '/_static/js/admin-scripts.js' );
}

add_action('admin_enqueue_scripts', 'admin_scripts_enqueue');

/*---------------------------------
	Make some changes to the wp_title() function
------------------------------------*/

function theme_filter_wp_title( $title, $separator ) {

	if ( is_feed() ) return $title;

	global $paged, $page;

	if ( is_search() ) {

		//If we're a search, let's start over:
		$title = sprintf( __( 'Search results for %s', 'theme' ), '"' . get_search_query() . '"' );
		//Add a page number if we're on page 2 or more:
		if ( $paged >= 2 )
			$title .= " $separator " . sprintf( __( 'Page %s', 'theme' ), $paged );
		//Add the site name to the end:
		$title .= " $separator " . get_bloginfo( 'name', 'display' );
		//We're done. Let's send the new title back to wp_title():
		return $title;
	}

	//Otherwise, let's start by adding the site name to the end:
	$title .= get_bloginfo( 'name', 'display' );

	//If we have a site description and we're on the home/front page, add the description:
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $separator " . $site_description;

	//Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $separator " . sprintf( __( 'Page %s', 'theme' ), max( $paged, $page ) );

	//Return the new title to wp_title():
	return $title;
}
add_filter( 'wp_title', 'theme_filter_wp_title', 10, 2 );

/*---------------------------------
	Create a wp_nav_menu() fallback, to show a home link
------------------------------------*/

function theme_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'theme_page_menu_args' );

/*---------------------------------
	Comments Callback Function
------------------------------------*/

function commentlist($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment ?>
	<li <?php comment_class('comment'); ?> id="comment-<?php comment_ID() ?>"><div id="div-comment-<?php comment_ID(); ?>" class="comments">
		<p class="comments-block">
        <div class="user"><?php echo get_avatar( $comment, 96 ); ?></div>
        <div class="message">
        <div class="reply-link"><?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?></div>
        <div class="info">
			<div class="comment-author"><?php comment_author_link() ?> </div>
			<div class="comment-time comment-meta commentmetadata"><a class="date" href="#comment-<?php comment_ID(); ?>" title="Permanent Link to this comment"><?php comment_date('F j, Y'); echo " AT "; ?><?php comment_time('g:iA'); ?></a> <?php edit_comment_link('Edit','  (',')'); ?></div>
		</p>
		<div class="comment-body">
        
			<?php comment_text() ?>
			<?php if ($comment->comment_approved == '0') : ?>
				<p>Thank you. Comments are moderated. Your comment will appear shortly.</p>
			<?php endif; ?>
		</div>
        </div>
        </div>
		
	</div>
<?php }
// end comment callback function (note: no need to close with </li>)

/*---------------------------------
	Custom Local Avatars
------------------------------------*/

add_filter('get_avatar', 'tsm_acf_profile_avatar', 10, 5);
function tsm_acf_profile_avatar( $avatar, $id_or_email, $size, $default, $alt ) {

    // Get user by id or email
    if ( is_numeric( $id_or_email ) ) {

        $id   = (int) $id_or_email;
        $user = get_user_by( 'id' , $id );

    } elseif ( is_object( $id_or_email ) ) {

        if ( ! empty( $id_or_email->user_id ) ) {
            $id   = (int) $id_or_email->user_id;
            $user = get_user_by( 'id' , $id );
        }

    } else {
        $user = get_user_by( 'email', $id_or_email );
    }

    // Get the user id
    $user_id = $user->ID;

    // Get the file id
    $image_id = get_user_meta($user_id, 'tsm_local_avatar', true); // CHANGE TO YOUR FIELD NAME

    // Bail if we don't have a local avatar
    if ( ! $image_id ) {
        return $avatar;
    }

    // Get the file size
    $image_url  = wp_get_attachment_image_src( $image_id, 'thumbnail' ); // Set image size by name
    // Get the file url
    $avatar_url = $image_url[0];
    // Get the img markup
    $avatar = '<img alt="' . $alt . '" src="' . $avatar_url . '" class="avatar avatar-' . $size . '" height="' . $size . '" width="' . $size . '"/>';

    // Return our new avatar
    return $avatar;
}


/*---------------------------------
	Feature to RSS
------------------------------------*/

function featuredtoRSS($content) {global $post;
if ( has_post_thumbnail( $post->ID ) ){
$content = '' . get_the_post_thumbnail( $post->ID, 'full', array( 'style' => 'margin:10px auto;display:block;' ) ) . '' . $content;
}
return $content;
}

add_filter('the_excerpt_rss', 'featuredtoRSS');
add_filter('the_content_feed', 'featuredtoRSS');

/*---------------------------------
	Register widget areas
------------------------------------*/
add_filter( 'widget_text', 'do_shortcode'); /* Enable Shortcodes on Widgets */

function widgets_init() {

	register_sidebar( array(
		'name' => __('Sidebar', 'theme'),
		'id' => 'sidbar_widget',
		'description' => __('The sidebar of the theme.', 'theme'),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
	}
add_action( 'widgets_init', 'widgets_init' );

/*---------------------------------
	Add Featured Image Column for Posts
------------------------------------*/

add_filter('manage_posts_columns', 'add_thumbnail_column', 5);

function add_thumbnail_column($columns){
  $columns['new_post_thumb'] = __('Featured Image');
  return $columns;
}

add_action('manage_posts_custom_column', 'display_thumbnail_column', 5, 2);

function display_thumbnail_column($column_name, $post_id){
  switch($column_name){
    case 'new_post_thumb':
      $post_thumbnail_id = get_post_thumbnail_id($post_id);
      if ($post_thumbnail_id) {
        $post_thumbnail_img = wp_get_attachment_image_src( $post_thumbnail_id, 'thumbnail' );
        echo '<img width="100" src="' . $post_thumbnail_img[0] . '" />';
      }
      break;
  }
}

/*---------------------------------
	Add Featured Image Column for Pages
------------------------------------*/

add_filter( 'manage_pages_columns', 'custom_pages_columns' );
function custom_pages_columns( $columns ) {

  $columns['new_page_thumb'] = __('Featured Image');
  return $columns;
}

add_action( 'manage_pages_custom_column', 'custom_page_column_content', 10, 2 );

function custom_page_column_content( $column_name, $post_id ) {
  switch($column_name){
    case 'new_page_thumb':
    $post_thumbnail_id = get_post_thumbnail_id($post_id);
    if ($post_thumbnail_id) {
      $post_thumbnail_img = wp_get_attachment_image_src( $post_thumbnail_id, 'thumbnail' );
      echo '<img width="100" src="' . $post_thumbnail_img[0] . '" />';
    }
     break;
  }
}

/* ------------------------
-----   Show Page/Post IDs    -----
------------------------------*/

/*Forked from "Simply Show IDs" Plugin*/
// Prepend the new column to the columns array
function ssid_column($cols) {
	$cols['ssid'] = 'ID';
	return $cols;
}

// Echo the ID for the new column
function ssid_value($column_name, $id) {
	if ($column_name == 'ssid')
		echo $id;
}

function ssid_return_value($value, $column_name, $id) {
	if ($column_name == 'ssid')
		$value = $id;
	return $value;
}

// Output CSS for width of new column
function ssid_css() {
?>
<style type="text/css">
	#ssid { width: 50px; } /* Simply Show IDs */
</style>
<?php
}

// Actions/Filters for various tables and the css output
function ssid_add() {
	add_action('admin_head', 'ssid_css');

	add_filter('manage_posts_columns', 'ssid_column');
	add_action('manage_posts_custom_column', 'ssid_value', 10, 2);

	add_filter('manage_pages_columns', 'ssid_column');
	add_action('manage_pages_custom_column', 'ssid_value', 10, 2);

	add_filter('manage_media_columns', 'ssid_column');
	add_action('manage_media_custom_column', 'ssid_value', 10, 2);

	add_filter('manage_link-manager_columns', 'ssid_column');
	add_action('manage_link_custom_column', 'ssid_value', 10, 2);

	add_action('manage_edit-link-categories_columns', 'ssid_column');
	add_filter('manage_link_categories_custom_column', 'ssid_return_value', 10, 3);

	foreach ( get_taxonomies() as $taxonomy ) {
		add_action("manage_edit-${taxonomy}_columns", 'ssid_column');
		add_filter("manage_${taxonomy}_custom_column", 'ssid_return_value', 10, 3);
	}

	add_action('manage_users_columns', 'ssid_column');
	add_filter('manage_users_custom_column', 'ssid_return_value', 10, 3);

	add_action('manage_edit-comments_columns', 'ssid_column');
	add_action('manage_comments_custom_column', 'ssid_value', 10, 2);
}

add_action('admin_init', 'ssid_add');

/*---------------------------------
	Remove "Recent Comments Widget" Styling
------------------------------------*/

function theme_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'theme_remove_recent_comments_style' );

/*---------------------------------
	Function that replaces the default the_excerpt() function
------------------------------------*/

function new_excerpt_length($length) {
    return 50;
}
add_filter('excerpt_length', 'new_excerpt_length');

function new_excerpt_more( $more ) {
	return ' ...';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );


function excerpt($length_callback='', $more_callback='') {

    global $post;

    if(function_exists($length_callback)){
		add_filter('excerpt_length', $length_callback);
    }

    if(function_exists($more_callback)){
		add_filter('excerpt_more', $more_callback);
    }

    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = $output;

    echo $output;

}

/*---------------------------------
	ACF custom excerpt function
------------------------------------*/
function custom_field_excerpt($title) {
			global $post;
			$text = get_field($title);
			if ( '' != $text ) {
				$text = strip_shortcodes( $text );
				$text = apply_filters('the_content', $text);
				$text = str_replace(']]>', ']]>', $text);
				$excerpt_length = 55; // 55 words
				$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
				$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
			}
			return apply_filters('the_excerpt', $text);
		}
		
		
/*---------------------------------------------------------------
	A custom excerpt function (Usage: <?php echo new_excerpt(25); ?>
----------------------------------------------------------------*/		
function new_excerpt($limit) {
      $excerpt = explode(' ', get_the_excerpt(), $limit);
      if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'...';
      } else {
        $excerpt = implode(" ",$excerpt);
      } 
      $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
      return $excerpt;
    }

    function content($limit) {
      $content = explode(' ', get_the_content(), $limit);
      if (count($content)>=$limit) {
        array_pop($content);
        $content = implode(" ",$content).'...';
      } else {
        $content = implode(" ",$content);
      } 
      $content = preg_replace('/\[.+\]/','', $content);
      $content = apply_filters('the_content', $content); 
      $content = str_replace(']]>', ']]&gt;', $content);
      return $content;
    }
	
	
	function modify_read_more_link() {
    return '<a class="more-link" href="' . get_permalink() . '"> Continue reading...</a>';
}
add_filter( 'the_content_more_link', 'modify_read_more_link' );

/*---------------------------------
	A custom pagination class
------------------------------------*/

add_filter('next_posts_link_attributes', 'posts_link_attributes');
add_filter('previous_posts_link_attributes', 'posts_link_attributes');

function posts_link_attributes() {
    return 'class="button button-primary"';
}


add_filter('next_post_link', 'post_link_attributes');
add_filter('previous_post_link', 'post_link_attributes');

function post_link_attributes($output) {
    $injection = 'class="button button-primary"';
    return str_replace('<a href=', '<a '.$injection.' href=', $output);
}

/*---------------------------------
	Count post views
------------------------------------*/

function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return 0;
    }
    return $count;
}

function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

/*---------------------------------
	Deal with WP empty paragraphs
------------------------------------*/

function formatter($content) {

	$bad_content = array('<p></div></p>', '<p><div class="full', '_width"></p>', '</div></p>', '<p><ul', '</ul></p>', '<p><div', '<p><block', 'quote></p>', '<p><hr /></p>', '<p><table>', '<td></p>', '<p></td>', '</table></p>', '<p></div>', 'nosidebar"></p>', '<p><p>', '<p><a', '</a></p>', '-half"></p>', '-third"></p>', '-fourth"></p>', '<p><p', '</p></p>', 'child"></p>', '<p></p>', '-fifth"></p>', '-sixth"></p>', 'last"></p>', 'fix" /></p>', '<p><hr', '<p><li', '"centered"></p>', '</li></p>', '<div></p>', '<p></ul>', '<p><img', ' /></p>', '"nop"></p>', 'tures"></p>', '"left"></p>', '<p><h1 class="center">', 'centered"></p>');
	$good_content = array('</div>', '<div class="full', '_width">', '</div>', '<ul', '</ul>', '<div', '<block', 'quote>', '<hr />', '<table>', '<td>', '</td>', '</table>', '</div>', 'nosidebar">', '<p>', '<a', '</a>', '-half">', '-third">', '-fourth">', '<p', '</p>', 'child">', '', '-fifth">', '-sixth">', 'last">', 'fix" />', '<hr', '<li', '"centered">', '</li>', '<div>', '</ul>', '<img', ' />', '"nop">', 'tures">', '"left">', '<h1 class="center">', 'centered">');

	$new_content = str_replace($bad_content, $good_content, $content);
	return $new_content;

}

remove_filter('the_content', 'wpautop');
add_filter('the_content', 'wpautop', 10);
add_filter('the_content', 'formatter', 11);

/*---------------------------------
	Register Menu Areas
------------------------------------*/
register_nav_menus( array(  
'primary' => __( 'Main Navigation', 'alchemyaim' ),
'mobile' => __( 'Mobile Navigation', 'alchemyaim' ),
) );


/*---------------------------------
	Redefine menu structure with a walker class
------------------------------------*/
class theme_walker_nav_menu extends walker_nav_menu {
	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param int $current_page Menu item ID.
	 * @param object $args
	 */

	 // Add CSS class to menus for submenu indicator

    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
        $id_field = $this->db_fields['id'];
        if ( !empty( $children_elements[ $element->$id_field ] ) ) {
            $element->classes[] = 'menu-item-parent';
        }
        Walker_Nav_Menu::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }

	function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
		global $wp_query;

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

		$output .= $indent . '<li' . $id . $value . $class_names .'>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

                // new addition for active class on the a tag
                if(in_array('current-menu-item', $classes)) {
                    $attributes .= ' class="active"';
                }

		$item_output = $args->before;
		$item_output .= '<a class="w-nav-link nav-link" style="max-width: 1170px;" '. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}



/*---------------------------------
	Fix empty search issue
------------------------------------*/

function request_filter( $query_vars ) {
    if( isset( $_GET['s'] ) && empty( $_GET['s'] ) ) {
        $query_vars['s'] = " ";
    }
    return $query_vars;
}
add_filter('request', 'request_filter');

/*---------------------------------
	Enqueue custom admin scripts & styles
------------------------------------*/

function add_admin_stuff(){
	wp_register_style('custom_admin_styles', get_template_directory_uri(). '/_static/styles/admin/admin_styles.css');
	wp_enqueue_style('custom_admin_styles');
	wp_register_style('admin_fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
	wp_enqueue_style('admin_fontawesome'); //add fontawesome to the backend
}
add_action( 'admin_init', 'add_admin_stuff' );


/*---------------------------------
	Enqueue custom admin scripts & styles
------------------------------------*/

function theme_scripts() {
	wp_enqueue_script( 'plugins', get_template_directory_uri() . '/_static/js/plugins.js', array(), '1.0.0', true );
	wp_enqueue_script( 'scripts', get_template_directory_uri() . '/_static/js/scripts.js', array(), '1.0.0', true );
	wp_enqueue_script( 'acf_seo', get_template_directory_uri() . '/_static/js/acf_yoastseo.js', array(), '1.0.0', true );
	}

add_action( 'wp_enqueue_scripts', 'theme_scripts' );

/*---------------------------------
	Thumbnail Size Upscale
------------------------------------*/
function alx_thumbnail_upscale( $default, $orig_w, $orig_h, $new_w, $new_h, $crop ){
    if ( !$crop ) return null; // let the wordpress default function handle this

    $aspect_ratio = $orig_w / $orig_h;
    $size_ratio = max($new_w / $orig_w, $new_h / $orig_h);

    $crop_w = round($new_w / $size_ratio);
    $crop_h = round($new_h / $size_ratio);

    $s_x = floor( ($orig_w - $crop_w) / 2 );
    $s_y = floor( ($orig_h - $crop_h) / 2 );

    return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
}
add_filter( 'image_resize_dimensions', 'alx_thumbnail_upscale', 10, 6 );

/*---------------------------------
	Thumbnail Size Support
------------------------------------*/
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 150, 150, true ); // Normal post thumbnails
add_image_size( 'featured-thumbnail', 60, 60 ); // Featured thumbnail size

/*------------------------------------------------
	Add Support for Facebook Feature Image Share
---------------------------------------------------*/
function insert_image_src_rel_in_head() {
	global $post;
	if ( !is_singular()) //if it is not a post or a page
		return;
	if(!has_post_thumbnail( $post->ID )) { //the post does not have featured image, use a default image
		$default_image = get_template_directory() . '/_static/images/default-image.jpg'; //replace this with a default image on your server or an image in your media library
		echo '<meta property="og:image" content="' . $default_image . '"/>';
	}
	else{
		$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
		echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
	}
	echo "
";
}
add_action( 'wp_head', 'insert_image_src_rel_in_head', 5 );


/*------------------------------------------------
	Add Breadcrumbs
---------------------------------------------------*/
function custom_breadcrumbs() {
       
    // Settings
	$prefix             = '';
    $separator          = '&gt;';
    $breadcrums_id      = 'breadcrumbs';
    $breadcrums_class   = 'breadcrumbs';
    $home_title         = 'Homepage';
      
    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = 'product_cat';
       
    // Get the query & post information
    global $post,$wp_query;
       
    // Do not display on the homepage
    if ( !is_front_page() ) {
       
        // Build the breadcrums
        echo '<ul id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';
           
        // Home page
        echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';
        echo '<li class="separator separator-home"> ' . $separator . ' </li>';
           
        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {
              
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title($prefix, false) . '</strong></li>';
              
        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            $custom_tax_name = get_queried_object()->name;
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . $custom_tax_name . '</strong></li>';
              
        } else if ( is_single() ) {
              
            // If post is a custom post type
            $post_type = get_post_type();
              
            // If it is a custom post type display name and link
            if($post_type != 'post') {
                  
                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);
              
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
              
            }
              
            // Get post category info
            $category = get_the_category();
             
            if(!empty($category)) {
              
                // Get last category post is in
                $last_category = end(array_values($category));
                  
                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);
                  
                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat">'.$parents.'</li>';
                    $cat_display .= '<li class="separator"> ' . $separator . ' </li>';
                }
             
            }
              
            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
                   
                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;
               
            }
              
            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                  
            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {
                  
                echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
              
            } else {
                  
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                  
            }
              
        } else if ( is_category() ) {
               
            // Category page
            echo '<li class="item-current item-cat"><strong class="bread-current bread-cat">' . single_cat_title('', false) . '</strong></li>';
               
        } else if ( is_page() ) {
               
            // Standard page
            if( $post->post_parent ){
                   
                // If child page, get parents 
                $anc = get_post_ancestors( $post->ID );
                   
                // Get parents in the right order
                $anc = array_reverse($anc);
	
                // Initialize parent variable
	            $parents = '';
                   
                // Parent page loop
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
                }
                   
                // Display parent pages
                echo $parents;
                   
                // Current page
                echo '<li class="item-current item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></li>';
                   
            } else {
                   
                // Just display current page if not parents
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</strong></li>';
                   
            }
               
        } else if ( is_tag() ) {
               
            // Tag page
               
            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;
               
            // Display the tag name
            echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong></li>';
           
        } elseif ( is_day() ) {
               
            // Day archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month link
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';
               
            // Day display
            echo '<li class="item-current item-' . get_the_time('j') . '"><strong class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_month() ) {
               
            // Month Archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month display
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><strong class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_year() ) {
               
            // Display year archive
            echo '<li class="item-current item-current-' . get_the_time('Y') . '"><strong class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong></li>';
               
        } else if ( is_author() ) {
               
            // Auhor archive
               
            // Get the author information
            global $author;
            $userdata = get_userdata( $author );
               
            // Display author name
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><strong class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong></li>';
           
        } else if ( get_query_var('paged') ) {
               
            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '"><strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</strong></li>';
               
        } else if ( is_search() ) {
           
            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></li>';
           
        } elseif ( is_404() ) {
               
            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        }
       
        echo '</ul>';
           
    }
       
}

/*------------------------------------------------
	Page Slug Body Class
---------------------------------------------------*/
function add_slug_body_class( $classes ) {
global $post;
if ( isset( $post ) ) {
$classes[] = $post->post_type . '-' . $post->post_name;
}
return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );

/*------------------------------------------------
	Woocommerce 3 Gallery Support
---------------------------------------------------*/
add_action( 'after_setup_theme', 'clad_setup' );

function clad_setup() {
add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );
}

?>