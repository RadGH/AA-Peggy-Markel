<?php
// This template overrides the regular template for single pages (and other post types) which are using flexible fields.
//
// See: _includes/extended/flexible-content-fields.php

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
		foreach( $fields as $key => $flex_field ) {
			$layout_key = strtolower($flex_field['acf_fc_layout']);
			
			$spacing = !empty($flex_field['spacing']) ? $flex_field['spacing'] : 'regular';
			?>
			
			<div class="ff field-<?php echo esc_attr($key); ?> layout-<?php echo esc_attr($layout_key); ?> spacing-<?php echo esc_attr($spacing); ?>">
				
				<?php aa_flexible_background_start( $flex_field, 'ff-background' ); ?>
				
					<div class="container">
						
						<?php
						// Example:
						// _template-parts/flex/destinations.php
						$template = locate_template( '_template-parts/flexible-fields/' . $layout_key . '.php' );
						
						// Load the field template if it exists, or show html comments if it doesn't.
						if ( $template ) {
							
							include( $template );
							
						}else{
							
							echo "\n" . '<!-- Unknown flexible content layout: "'. esc_html($layout_key) .'" -->' . "\n";
							echo "\n" . '<!-- The missing layout path is: "'. esc_html( '_template-parts/flexible-fields/' . $layout_key . '.php' ) .'" -->' . "\n";
							
						}
						?>
					
					</div> <!-- /.container -->
				
				<?php aa_flexible_background_end(); ?>
				
			</div> <!-- /.ff -->
			
			<?php
		}
		?>
		
	</div> <!-- /.flexible-content-fields -->
	
	<?php
endwhile; // End of the loop.
?>

<?php get_footer(); ?>