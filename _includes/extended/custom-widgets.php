<?php

// Register and load the widget
function load_widgets() {
	register_widget('social_widget');
	register_widget('rich_text_widget');
}

add_action( 'widgets_init', 'load_widgets' );



/*------------------
	SOCIAL WIDGET
---------------------*/
class social_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'social_widget', 

// Widget name will appear in UI
__('Social Widget', 'social_widget_domain'), 

// Widget description
array( 'classname' => 'social', 'description' => __( 'A widget that displays your social links.', 'social_widget_domain' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
// before and after widget arguments are defined by themes
echo $args['before_widget'];
//if ( ! empty( $title ) )
//echo $args['before_title'] . $title . $args['after_title'];

// This is where you run the code and display the output
echo '<div class="social-links"><span class="social-title">'.$title. '</span>';
             
        if( have_rows('social_links', 'option') ): 
		while( have_rows('social_links', 'option') ): the_row(); 

		// vars
		$icon = get_sub_field('social_media_icon', 'option');
		$link = get_sub_field('social_link', 'option');
		
		if( $link ): ?>
				<a href="<?php echo $link; ?>" target="_blank" class="social-link">
		<?php endif; ?>
        		<i class="fa <?php echo $icon; ?>"></i>
		<?php if( $link ): ?>
				</a>
		<?php endif; 
			  endwhile; 
			  endif; 
			  
		echo '</div>';
	
echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'Social Links', 'social_widget_domain' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<p>Edit social links within the <a href="<?php echo site_url(); ?>/wp-admin/admin.php?page=theme-general-settings">Theme Options Panel</a>.</p>
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}
} 


/*--------------------
	WYSIWYG WIDGET
---------------------*/
class rich_text_widget extends WP_Widget {

function __construct() {
parent::__construct(
// Base ID of your widget
'rich_text_widget', 

// Widget name will appear in UI
__('WYSIWYG Widget', 'rich_text_widget_domain'), 

// Widget description
array( 'classname' => 'rich_text', 'description' => __( 'A rich text WYSIWYG widget.', 'rich_text_widget_domain' ), ) 
);
}

// Creating widget front-end
// This is where the action happens
public function widget( $args, $instance ) {
$title = apply_filters( 'widget_title', $instance['title'] );
// before and after widget arguments are defined by themes
echo $args['before_widget'];
if ( ! empty( $title ) )
echo $args['before_title'] . $title . $args['after_title'];

// This is where you run the code and display the output
echo get_field('wysiwyg_widget', 'widget_' . $args['widget_id']);
	
echo $args['after_widget'];
}
		
// Widget Backend 
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'WYSIWYG Widget', 'rich_text_widget_domain' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php 
}
	
// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}
} 

?>