<?php

// Disable Default Dashboard Widgets.
function disable_default_dashboard_widgets() {

	// disable default dashboard widgets
	//remove_meta_box('dashboard_activity', 'dashboard', 'core');
	//remove_meta_box('dashboard_right_now', 'dashboard', 'core');
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');

	remove_meta_box('dashboard_quick_press', 'dashboard', 'core');
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');
	remove_meta_box('dashboard_primary', 'dashboard', 'core');
	remove_meta_box('dashboard_secondary', 'dashboard', 'core');

	// disable Simple:Press dashboard widget
	remove_meta_box('sf_announce', 'dashboard', 'normal');
}
add_action('admin_menu', 'disable_default_dashboard_widgets');

// Custom Dashboard Widget.
/*function custom_dashboard_widget() {
	echo "<p>Dearest Client, Here&rsquo;s how to do that thing I told you about yesterday...</p>";
}
function add_custom_dashboard_widget() {
	wp_add_dashboard_widget('custom_dashboard_widget', 'How to Do Something in WordPress', 'custom_dashboard_widget');
}
add_action('wp_dashboard_setup', 'add_custom_dashboard_widget');*/

//Remove Admin Color Scheme Picker.
remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );

?>