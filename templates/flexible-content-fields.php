<?php
/*
 * Template Name: Custom Layout
 * Template Post Type: page, destination
 */

// This template overrides the regular template for single pages (and other post types) which are using flexible fields.
//
// See: _includes/extended/flexible-content-fields.php

if ( !have_posts() ) {
	get_template_part( '404' );
	return;
}

// Flexible content fields are required for this template, otherwise use a single page template.
$fields = get_field( 'content-areas' );
if ( empty($fields) ) {
	get_template_part( 'single', get_post_type() );
	return;
}

get_header();
?>

<?php
while ( have_posts() ) : the_post();
	?>
	
	<div class="flexible-content-fields">
		
		<?php
		global $flex_key, $flex_field;
		
		foreach( $fields as $flex_key => $flex_field ) {
			get_template_part( '_template-parts/flexible-fields/_the_field');
		}
		?>
		
	</div> <!-- /.flexible-content-fields -->
	
	<?php
endwhile; // End of the loop.
?>

<?php

get_footer();