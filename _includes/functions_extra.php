<?php
/*---------------------------------
	LOAD THEME ADMIN FUNCTIONS
------------------------------------*/
//require_once( get_template_directory() . '/_includes/admin/remove_warnings.php' ); // Remove ALL WP update and Plugin update warnings.
require_once( get_template_directory() . '/_includes/admin/custom-edits/admin-bar.php' ); // Add custom tweaks to the adman bar on the back end.
require_once( get_template_directory() . '/_includes/admin/custom-edits/admin-menu.php' ); // Add custom tweaks to the adman menu on the back end.
require_once( get_template_directory() . '/_includes/admin/custom-edits/dashboard-widgets.php' ); // Add custom tweaks to the adman dashboard on the back end.
require_once( get_template_directory() . '/_includes/admin/custom-edits/footer.php' ); // Add custom tweaks to the adman footer on the back end.
require_once( get_template_directory() . '/_includes/admin/custom-edits/login-screen.php' ); // Add custom tweaks to the adman login screen.
require_once( get_template_directory() . '/_includes/admin/custom-edits/welcome-panel.php' ); // Add a custom welcome panel on the back end.
require_once( get_template_directory() . '/_includes/admin/wp-admin-notification/bootstrap.php' ); // Add a custom admin alerts on the back end.


/*---------------------------------
	LOAD THEME EXTENDED FUNCTIONS
------------------------------------*/
require_once( get_template_directory() . '/_includes/extended/widget-subtitle/widget-subtitle.php' );  // Add subtitles to all widgets.
require_once( get_template_directory() . '/_includes/extended/tag-list-widget/taxonomy-list-widget.php' ); // Alternative to the tag cloud
require_once( get_template_directory() . '/_includes/extended/rich-text-tags/rich-text-tags.php' );  // Add a WYSIWYG editor to tags, categories and taxonomies.
require_once( get_template_directory() . '/_includes/extended/categories-images/categories-images.php' ); // Add images to categories and/or tags.
require_once( get_template_directory() . '/_includes/extended/custom-post-limits/custom-post-limits.php' ); //  Independently control the number of posts listed on the front page, author/category/tag archives, search results.
require_once( get_template_directory() . '/_includes/extended/orphan-word/orphan-word.php' ); // Handle the orphan words.
require_once( get_template_directory() . '/_includes/extended/admin-post-navigation/admin-post-navigation.php' ); // Add Prev & Next links to post editor.
require_once( get_template_directory() . '/_includes/extended/animsition/animsition.php' ); // Add animsition page transitions.
require_once( get_template_directory() . '/_includes/extended/custom-widgets.php' ); // Add custom widgets.
require_once( get_template_directory() . '/_includes/extended/re-add-underline-justify/re-add-underline-justify.php' ); // Add Underline and Justified text to TinyMCE Editor.
require_once( get_template_directory() . '/_includes/extended/woocommerce.php' ); // Add woocommerce support to the theme, including customizations.


/*---------------------------------------------
	REGISTER CUSTOM POST TYPES
------------------------------------------------*/

//require_once( get_template_directory() . '/_includes/custom-post-types/custom-post-type-template.php' ); // Add a Custom Post Type.

/*---------------------------------------------
	STOP UPDATE NAG ON THESE MODIFIED PLUGINS
------------------------------------------------*/

/*function filter_plugin_updates( $value ) {
    unset( $value->response['akismet/akismet.php'] ); // This is an example only. Add any additional plugins that may have been modified to stop them from getting the update nag.
    return $value;
}
add_filter( 'site_transient_update_plugins', 'filter_plugin_updates' );

/*-----------------------------------------------------------
	INCLUDE ADVANCED CUSTOM FIELDS PLUGIN WITHIN THE THEME
--------------------------------------------------------------*/

// 1. customize ACF path
add_filter('acf/settings/path', 'my_acf_settings_path');
function my_acf_settings_path( $path ) {
    // update path
    $path = get_stylesheet_directory() . '/_includes/acf/';
    // return
    return $path;
}
 
// 2. customize ACF dir
add_filter('acf/settings/dir', 'my_acf_settings_dir');
function my_acf_settings_dir( $dir ) {
    // update path
    $dir = get_stylesheet_directory_uri() . '/_includes/acf/';
    // return
    return $dir;
}
 
// 3. Hide ACF field group menu item
$user = wp_get_current_user();
$user = $user->user_login;
if($user != "alchemyandaim"): 

add_filter('acf/settings/show_admin', '__return_false');

endif;


// 4. Include ACF
include_once( get_stylesheet_directory() . '/_includes/acf/acf.php' );

/*---------------------------------------------
	ADVANCED CUSTOM FIELDS CONTROL PANEL
------------------------------------------------*/
if( function_exists('acf_add_options_page') ) {
	$user = wp_get_current_user();
	$user = $user->user_login;
	
	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
	if($user == "alchemyandaim"): 
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Theme Developer Page',
		'menu_title'	=> 'Developer',
		'parent_slug'	=> 'theme-general-settings',
	));
	endif;
}

require_once( get_template_directory() . '/_includes/acf-base.php' ); // Add ACF base fields.


/*---------------------------------------------
	ADVANCED CUSTOM FIELDS ADDONS
------------------------------------------------*/

include_once( get_stylesheet_directory() . '/_includes/acf-addons/acf-image-crop-add-on/acf-image-crop.php');
include_once( get_stylesheet_directory() . '/_includes/acf-addons/acf-sidebar-selector-field/acf-sidebar_selector.php');
include_once( get_stylesheet_directory() . '/_includes/acf-addons/acf-menu-selector-field/acf-menus.php');
include_once( get_stylesheet_directory() . '/_includes/acf-addons/acf-background/acf-background.php');
include_once( get_stylesheet_directory() . '/_includes/acf-addons/acf-rgba-color-picker/acf-rgba-color-picker.php');
include_once( get_stylesheet_directory() . '/_includes/acf-addons/acf-code-field/acf-code-field.php');
include_once( get_stylesheet_directory() . '/_includes/acf-addons/acf-font-awesome/acf-font-awesome.php');
include_once( get_stylesheet_directory() . '/_includes/acf-addons/acf-justified-image-grid/acf-justified-image-grid.php');
include_once( get_stylesheet_directory() . '/_includes/acf-addons/acf-medium-editor-field/acf-medium-editor.php');

/*---------------------------------
	REGISTER CUSTOM SIDEBAR AREAS
------------------------------------*/

function create_sidebars() {
    	 if( have_rows('register_sidebar', 'options') ): 
		 while( have_rows('register_sidebar', 'options') ): the_row(); 

		// vars
		$sidebar_title = get_sub_field('title');
		$sidebar_id = get_sub_field('id');
		
		register_sidebar( array(
			'name' => $sidebar_title,
			'id' => $sidebar_id,
			'description' => '',
			'before_widget' => '<div id="%1$s" class="widget sidebox %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		));
	
  		endwhile; 
		endif; 
}

add_action( 'after_setup_theme', 'create_sidebars' );

/*---------------------------------
	ADD CUSTOM DASHBOARD WIDGETS
------------------------------------*/
function aa_dashboard_widget() {
	if( have_rows('dashboard_widgets', 'options') ): 
		 while( have_rows('dashboard_widgets', 'options') ): the_row();
		 
		// vars
		$title = get_sub_field('widget_title');
		$name_clean = sanitize_title($title);
		$the_msg = get_sub_field( 'widget_content');	  

	wp_add_dashboard_widget(
        $name_clean.'_dashboard_widget',     // Widget slug
        $title,                              // Title
        'dashboard_widget_display_function', // Display function
        'dashboard_widget_control_function', // Control function
        array('title' => $title, 'slug' => $name_clean, 'content' => $the_msg) // Callback arguments
      );
		
		endwhile; 
		endif; 
}
add_action( 'wp_dashboard_setup', 'aa_dashboard_widget' );

function dashboard_widget_display_function($post_obj, $args) {
	 printf($args['args']['content']);
}

/*---------------------------------------------------
	ADD CUSTOM NOTIFICATION ALERTS IN WP DASHBOARD
----------------------------------------------------*/

add_action( 'admin_notices', 'aa_dashalerts' );

function aa_dashalerts() {
	if(have_rows('dashboard_alerts','options')):
		while(have_rows('dashboard_alerts','options')): the_row();
		
		//vars
		$alert_id = get_sub_field('alert_id');
		$alert_type = get_sub_field('type');
		$alert_close = get_sub_field('dismissible');
		$alert_message = get_sub_field('message');

    wp_admin_notification( 
    ''.$alert_id.'', 
    __(''.$alert_message.'','slug'), 
    ''.$alert_type.'', 
    $alert_close
	);
	
	endwhile;
	endif;
}
	
	/*wp_admin_notification( 
    ''.$alert_id.'', 
    __(''.$alert_message.'','slug'), 
    ''.$alert_type.'', 
    $alert_close
	);*/


//wp_reset_admin_notification('alert_id');


/*---------------------------------
	ADD DEFAULT PAGE
------------------------------------*/
if (isset($_GET['activated']) && is_admin()){
        $new_page_title = 'Default Page';
        $new_page_content = '<!-- Sample Content to Plugin to Template -->

The purpose of this HTML is to help determine what default settings are with CSS and to make sure that all possible HTML Elements are included in this HTML so as to not miss any possible Elements when designing a site.

<hr />

<div class="row">
<div class="four columns">
<h2 id="headings">Headings</h2>
<h1>Heading 1</h1>
<h2>Heading 2</h2>
<h3>Heading 3</h3>
<h4>Heading 4</h4>
<h5>Heading 5</h5>
<h6>Heading 6</h6>
</div>
<div class="four columns">
<h2 id="list_types">List Types</h2>
<h3>Ordered List</h3>
<ol>
 	<li>List Item 1</li>
 	<li>List Item 2</li>
 	<li>List Item 3</li>
</ol>
<h3>Unordered List</h3>
<ul>
 	<li>List Item 1</li>
 	<li>List Item 2</li>
 	<li>List Item 3</li>
</ul>
</div>
<div class="four columns">
<h2 id="block-quote">Block Quotes</h2>
<blockquote>“This stylesheet is going to help so freaking much.”
-Blockquote</blockquote>
</div>
</div>

<hr />

<h2 id="paragraph">Paragraph</h2>
<img class="alignleft" src="http://placehold.it/400x300" />

<strong>Lorem ipsum</strong> dolor sit amet, <a title="test link" href="#">test link</a> adipiscing elit. Nullam dignissim convallis est. Quisque aliquam. Donec faucibus. Nunc iaculis suscipit dui. Nam sit amet sem. Aliquam libero nisi, imperdiet at, tincidunt nec, gravida vehicula, nisl. Praesent mattis, massa quis luctus fermentum, turpis mi volutpat justo, eu volutpat enim diam eget metus. Maecenas ornare tortor. Donec sed tellus eget sapien fringilla nonummy. Mauris a ante. Suspendisse quam sem, consequat at, commodo vitae, feugiat in, nunc. Morbi imperdiet augue quis tellus.

Lorem ipsum dolor sit amet, <em>emphasis</em> consectetuer adipiscing elit. Nullam dignissim convallis est. Quisque aliquam. Donec faucibus. Nunc iaculis suscipit dui. Nam sit amet sem. Aliquam libero nisi, imperdiet at, tincidunt nec, gravida vehicula, nisl. Praesent mattis, massa quis luctus fermentum, turpis mi volutpat justo, eu volutpat enim diam eget metus. Maecenas ornare tortor. Donec sed tellus eget sapien fringilla nonummy. Mauris a ante. Suspendisse quam sem, consequat at, commodo vitae, feugiat in, nunc. Morbi imperdiet augue quis tellus.

<hr />

<h2 id="form_elements">Forms</h2>
<style>input[type="email"],input[type="text"],textarea,select{border:1px solid #E1E1E1;}</style>

<form class="contact-form">
<div class="row">
<div class="six columns"><label for="exampleEmailInput">Your email</label>
<input id="exampleEmailInput" class="u-full-width" type="email" placeholder="test@mailbox.com" /></div>
<div class="six columns"><label for="exampleRecipientInput">Reason for contacting</label>
<select id="exampleRecipientInput" class="u-full-width">
<option value="Option 1">Questions</option>
<option value="Option 2">Admiration</option>
<option value="Option 3">Can I get your number?</option>
</select></div>
</div>
<label for="exampleMessage">Message</label>
<textarea id="exampleMessage" class="u-full-width" placeholder="Hi Dave …"></textarea>
<label class="example-send-yourself-copy">
<input type="checkbox" /><span class="label-body">Send a copy to yourself</span>
</label>
<input class="button button-primary" type="submit" value="Submit" />

</form>

<hr />

<h2 id="misc">Misc Stuff – abbr, acronym, pre, code, sub, sup, etc.</h2>
Lorem <sup>superscript</sup> dolor <sub>subscript</sub> amet, consectetuer adipiscing elit. Nullam dignissim convallis est. Quisque aliquam. <cite>cite</cite>. Nunc iaculis suscipit dui. Nam sit amet sem. Aliquam libero nisi, imperdiet at, tincidunt nec, gravida vehicula, nisl. Praesent mattis, massa quis luctus fermentum, turpis mi volutpat justo, eu volutpat enim diam eget metus. Maecenas ornare tortor. Donec sed tellus eget sapien fringilla nonummy. <acronym title="National Basketball Association">NBA</acronym> Mauris a ante. Suspendisse quam sem, consequat at, commodo vitae, feugiat in, nunc. Morbi imperdiet augue quis tellus. <abbr title="Avenue">AVE</abbr>
<pre>This is an example of using the &lt;pre&gt; tag</pre>
<code>&lt;?php echo "This is an example of using the &lt;code&gt; tag"; ?&gt;</code>';
        $new_page_template = ''; //ex. template-custom.php. Leave blank if you don't want a custom page template.
        //don't change the code bellow, unless you know what you're doing
        $page_check = get_page_by_title($new_page_title);
        $new_page = array(
                'post_type' => 'page',
                'post_title' => $new_page_title,
                'post_content' => $new_page_content,
                'post_status' => 'publish',
                'post_author' => 1,
        );
        if(!isset($page_check->ID)){
                $new_page_id = wp_insert_post($new_page);
                if(!empty($new_page_template)){
                        update_post_meta($new_page_id, '_wp_page_template', $new_page_template);
                }
        }
}
?>