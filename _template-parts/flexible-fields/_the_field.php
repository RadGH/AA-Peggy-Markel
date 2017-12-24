<?php
global $flex_key, $flex_field;

if ( !isset($flex_key) || !isset($flex_field) ) {
	echo '(Error: $flex_key or $flex_field must be globally defined in "'. basename(__FILE__) .'", on line ' . __LINE__ .')';
}

$layout_key = strtolower($flex_field['acf_fc_layout']);

$classes = array( 'ff' );
$classes[] = 'field-' . esc_attr($flex_key);
$classes[] = 'layout-' . $layout_key;
$classes[] = 'spacing-' . (!empty($flex_field['spacing']) ? $flex_field['spacing'] : 'regular');
$classes[] = 'content_align-' . (!empty($flex_field['content_alignment']) ? $flex_field['content_alignment'] : 'left');
$classes[] = 'content_width-' . (!empty($flex_field['content_width']) ? $flex_field['content_width'] : 'regular');

$id = false;

// Custom classes
if ( !empty($flex_field['advanced_css']['html_class']) ) {
$classes[] = $flex_field['advanced_css']['html_class'];
}

// Custom ID
if ( !empty($flex_field['advanced_css']['html_class']) ) {
$id = $flex_field['advanced_css']['html_id'];
}
?>
<div <?php if ( $id ) echo 'id="'. esc_attr($id) .'"'; ?> class="<?php echo esc_attr( implode(' ', $classes) ); ?>">
	
	<?php aa_flexible_background_start( $flex_field ); ?>
	
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