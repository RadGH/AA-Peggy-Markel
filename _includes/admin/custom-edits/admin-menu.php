<?php
// Add a logo to the top of the Admin Menu 
add_action('admin_menu', 'aa_admin_menu');

function aa_admin_menu() {
    global $menu;
    $url = get_home_url();
	$blog_title = get_bloginfo();
    $menu[0] = array( __($blog_title), 'read', $url, 'aa-logo', 'aa-logo');
		
}

add_action('admin_head','aa_admin_menu_logo');
function aa_admin_menu_logo() {
	$admin_logo = get_field('admin_logo','options');
	if( !empty($admin_logo) && is_array($admin_logo) ):
		echo '<style>#adminmenu a.aa-logo {background: url('.$admin_logo['url'].') no-repeat center center !important;background-size: contain !important;}#adminmenu a.aa-logo div.wp-menu-name{display: none !important;}.folded #adminmenu a.aa-logo {background:none !important;padding:0 !important;}</style>';
	endif;
}

// Remove Admin Menu Items For all Users.
/*function remove_menus () {
global $menu;
	$restricted = array(__('Posts'), __('Tools'), __('Users'), __('Comments')); //Add or Remove Menus Items All Users
	end ($menu);
	while (prev($menu)){
		$value = explode(' ',$menu[key($menu)][0]);
		if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
	}
}
add_action('admin_menu', 'remove_menus');*/


//REMOVE POST POST TYPE FOR ALL USERS
/*add_action('admin_menu','remove_default_post_type');

function remove_default_post_type() {
	remove_menu_page('edit.php');
}*/


// Remove Admin Menu Items Per User Role.
/*function remove_menus () {
    if(is_user_logged_in() && current_user_can('editor'))
    {
        global $menu;
        $restricted = array(__('Settings'),__('Tools'),__('Plugins'),__('Users'),__('Appearance')); // If Not Admin Hide These Menu Items
        end ($menu);
        while (prev($menu)){
            $value = explode(' ',$menu[key($menu)][0]);
            if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
        }
    }
}
add_action('admin_menu', 'remove_menus');

// Rename Admin Menu Items.
/*function menu_item_text( $menu ) {
     $menu = str_ireplace( 'Dashboard', 'Your Text', $menu );
	 $menu = str_ireplace( 'Posts', 'Your Text', $menu );
	 $menu = str_ireplace( 'Media', 'Your Text',  $menu );
     $menu = str_ireplace( 'Library', 'Your Text', $menu );
     $menu = str_ireplace( 'Links', 'Your Text', $menu );
     $menu = str_ireplace( 'Pages', 'Your Text', $menu );
     $menu = str_ireplace( 'Comments', 'Your Text', $menu );
     $menu = str_ireplace( 'Appearance', 'Your Text', $menu );
     $menu = str_ireplace( 'Plugins', 'Your Text', $menu );
     $menu = str_ireplace( 'Users', 'Your Text', $menu );
     $menu = str_ireplace( 'Tools', 'Your Text', $menu );
     $menu = str_ireplace( 'Settings', 'Your Text', $menu );
	 
     return $menu;
}
add_filter('gettext', 'menu_item_text');
add_filter('ngettext', 'menu_item_text');*/

// Remove Admin Sub-Menu Items.
/*function remove_submenus() {
  global $submenu;
  
  //Dashboard menu
  unset($submenu['index.php'][10]); // Removes Updates
  
  //Posts menu
  unset($submenu['edit.php'][5]); // Leads to listing of available posts to edit
  unset($submenu['edit.php'][10]); // Add new post
  unset($submenu['edit.php'][15]); // Remove categories
  unset($submenu['edit.php'][16]); // Removes Post Tags
  
  //Media Menu
  unset($submenu['upload.php'][5]); // View the Media library
  unset($submenu['upload.php'][10]); // Add to Media library
   
  //Pages Menu
  unset($submenu['edit.php?post_type=page'][5]); // The Pages listing
  unset($submenu['edit.php?post_type=page'][10]); // Add New page
  
  //Appearance Menu
  unset($submenu['themes.php'][5]); // Removes 'Themes'
  unset($submenu['themes.php'][7]); // Widgets
  unset($submenu['themes.php'][15]); // Removes Theme Installer tab
  
  //Plugins Menu
  unset($submenu['plugins.php'][5]); // Plugin Manager
  unset($submenu['plugins.php'][10]); // Add New Plugins
  unset($submenu['plugins.php'][15]); // Plugin Editor
  
  //Users Menu
  unset($submenu['users.php'][5]); // Users list
  unset($submenu['users.php'][10]); // Add new user
  unset($submenu['users.php'][15]); // Edit your profile
  
  //Tools Menu
  unset($submenu['tools.php'][5]); // Tools area
  unset($submenu['tools.php'][10]); // Import
  unset($submenu['tools.php'][15]); // Export
  unset($submenu['tools.php'][20]); // Upgrade plugins and core files
  
  //Settings Menu
  unset($submenu['options-general.php'][10]); // General Options
  unset($submenu['options-general.php'][15]); // Writing
  unset($submenu['options-general.php'][20]); // Reading
  unset($submenu['options-general.php'][25]); // Discussion
  unset($submenu['options-general.php'][30]); // Media
  unset($submenu['options-general.php'][35]); // Privacy
  unset($submenu['options-general.php'][40]); // Permalinks
  unset($submenu['options-general.php'][45]); // Misc
}
add_action('admin_menu', 'remove_submenus');*/

?>