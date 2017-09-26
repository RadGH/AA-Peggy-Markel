<?php 

// Remove Password Reset on Login Screen.
/*function remove_lostpassword_text ( $text ) {
         if ($text == 'Lost your password?'){$text = '';}
                return $text;
         }
add_filter( 'gettext', 'remove_lostpassword_text' );

function disable_password_reset() {
              return false;
              }
add_filter ( 'allow_password_reset', 'disable_password_reset' );


/*---------------------------------
		Customize Login Area
------------------------------------*/
function custom_login_logo() { 
		$image = get_field('site_login_logo', 'option');
		$default_image = get_stylesheet_directory_uri() . '/_static/images/alchemy-and-aim-logo.png';
		if( !empty($image) ):    
		echo '<style type="text/css">
	 h1 a { background-image:url(' .$image['url']. ') !important; width:100% !important; height:100px !important; background-size:contain !important;} 
	 body, html { background: #fff none repeat scroll 0 0;}
    </style>';
		else:
		echo '<style type="text/css">
	 h1 a { background-image:url('.$default_image.') !important; width:100% !important; height:100px !important; background-size:contain !important;} 
	 body, html { background: #fff none repeat scroll 0 0;}
    </style>';
		endif; 
}
add_action('login_head', 'custom_login_logo');

// Change  Login Logo Link
function loginpage_custom_link() {
	return get_home_url();
}
add_filter('login_headerurl','loginpage_custom_link');

// Rename the hover logo text on the login logo
function change_title_on_logo() {
	return get_bloginfo();
}
add_filter('login_headertitle', 'change_title_on_logo');

?>