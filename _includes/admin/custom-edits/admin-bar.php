<?php

// Remove WP Logo from Admin Bar.
function remove_wp_logo() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo');
}
add_action( 'wp_before_admin_bar_render', 'remove_wp_logo' );

// Remove the Comment Bubble from the WordPress Admin Bar.
/*function remove_comment_bubble() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('comments');
}
add_action( 'wp_before_admin_bar_render', 'remove_comment_bubble' );

// Disable the Add New Content Menu.
function disable_new_content() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('new-content');
}
add_action( 'wp_before_admin_bar_render', 'disable_new_content' );

add_action( 'admin_bar_menu', 'wp_admin_bar_my_custom_account_menu', 11 );

// Hide 'Screen Options & Help' Tab Tab For ALL Users
/*function remove_screen_options_tab() {

	 echo '<style type="text/css">
            #screen-meta-links { display: none !important; }
          </style>';
    return false;
}
add_filter('screen_options_show_screen', 'remove_screen_options_tab');

// Hide 'Screen Options' Tab For ALL Users Except Admin
/*function remove_screen_options(){ return false;}
if(is_user_logged_in() && current_user_can('editor'))
add_filter('screen_options_show_screen', 'remove_screen_options');


// Hide admin 'Help' Tab
function hide_help() {
	if(is_user_logged_in() && current_user_can('editor'))

    echo '<style type="text/css">
            #contextual-help-link-wrap { display: none !important; }
          </style>';
}
add_action('admin_head', 'hide_help');*/

// Relabel admin 'Help' tab
/*add_filter( 'gettext', 'wpse51861_change_help_text', 10, 2 );
function wpse51861_change_help_text( $translation, $text ) {
if ( $text == 'Help' )
    return __('Documentation','my-plug-text-domain');
return $translation;
}*/

// Remove the Howdy menu from the WordPress Admin Bar.
/*function remove_my_account() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('my-account');
}
add_action( 'wp_before_admin_bar_render', 'remove_my_account' );
*/

// Rename 'Howdy' Menu.
add_action( 'admin_bar_menu', 'wp_admin_bar_my_custom_account_menu', 11 );

function wp_admin_bar_my_custom_account_menu( $wp_admin_bar ) {
$user_id = get_current_user_id();
$current_user = wp_get_current_user();
$profile_url = get_edit_profile_url( $user_id );

if ( 0 != $user_id ) {
/* Add the "My Account" menu */
$avatar = get_avatar( $user_id, 28 );
$howdy = sprintf( __('Logged in as %1$s'), $current_user->display_name );
$class = empty( $avatar ) ? '' : 'with-avatar';

$wp_admin_bar->add_menu( array(
'id' => 'my-account',
'parent' => 'top-secondary',
'title' => $howdy . $avatar,
'href' => $profile_url,
'meta' => array(
'class' => $class,
),
) );

}
}


// One Click Logout on Admn Bar.
/*function remove_old_logout() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_node('my-account');
}
add_action( 'wp_before_admin_bar_render', 'remove_old_logout' );

function newlogout() {
?>

<table id="one-click01" style="" border="0" cellspacing="0" cellpadding="0"><tr><td align=center valign=center>
<?php
    wp_get_current_user();
    $current_user = wp_get_current_user();
    if ( !($current_user instanceof WP_User) )
    return;
    $name = $current_user->display_name;
?>

<?php echo '
<a href="' . wp_logout_url() . '" title="' . esc_attr__('Log Out') . '">Logged in as ' . __($name) .' | Log Out</a>'
; ?>

</td></tr></table>

<?php
}
add_action( 'admin_bar_menu', 'newlogout' );*/


// Disable the Current Site Name Menu in the Admin Bar.
function remove_this_site() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('site-name');
}
add_action( 'wp_before_admin_bar_render', 'remove_this_site' );


// Add a simple menu & link that opens in a new window.
function custom_adminbar_menu( $meta = TRUE ) {
	global $wp_admin_bar;
		if ( !is_user_logged_in() ) { return; }
		if ( !is_super_admin() || !is_admin_bar_showing() ) { return; }
	$wp_admin_bar->add_menu( array(
		'id' => 'custom_menu',
		'class' => 'visit_menu',
		'title' => __( 'Visit Site' ),
		'href' => get_home_url( $blog->userblog_id, '/' ),
		'meta' 	=> array( target => '_blank' ) )
	);
}
add_action( 'admin_bar_menu', 'custom_adminbar_menu', 10 );
/* The add_action # is the menu position:
10 = Before the WP Logo
15 = Between the logo and My Sites
25 = After the My Sites menu
100 = End of menu
*/


?>
