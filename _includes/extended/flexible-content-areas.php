<?php

function aa_replace_flexible_content_field_template( $template ) {
	if ( !is_singular() ) return $template;
	if ( is_admin() ) return $template;
	
	// If the page is using flexible content fields, change the template
	$fields = get_field( 'content-areas' );
	
	if ( $fields ) {
		return get_template_directory() . '/flexible-content-fields.php';
	}else{
		return $template;
	}
}
add_filter( "template_include", "aa_replace_flexible_content_field_template" );

function aa_flexible_background_start( $field, $classes, $background_key = 'background' ) {
	if ( !is_array($classes) ) $classes = (array) $classes;
	
	// Shorthand of the background field
	$b = !empty($field[$background_key]) ? $field[$background_key] : false;
	
	// Get the style. This, and other fields like it, come from the "[Clone] Background" field group.
	$_style = !empty($b['style']) ? $b['style'] : 'No Background';
	
	$_color = !empty($b['background_color']) ? $b['background_color'] : (!empty($b['overlay_color']) ? $b['overlay_color'] : false); // Overlay color is the same as Background color, but named differently.
	$_opacity = !empty($b['overlay_opacity']) ? $b['overlay_opacity'] : false;
	$_image = !empty($b['image']) ? wp_get_attachment_image_src( $b['image'], 'full' ) : false;
	$_scaling = !empty($b['image_scaling']) ? $b['image_scaling'] : 'cover';
	$_position = !empty($b['image_position']) ? $b['image_position'] : 'center';
	
	if ( !empty($b['light_theme']) ) $classes[] = 'light-theme';
	
	switch( $_style ) {
		
		case "No Background":
			$classes[] = 'no-background';
			echo '<div class="'. esc_attr(implode(' ', $classes)) .'">';
			break;
			
		case "Color":
			$classes[] = 'color-background';
			echo '<div class="'. esc_attr(implode(' ', $classes)) .'" style="background: '. esc_attr($_color) .';">';
			break;
			
		case "Image":
			$classes[] = 'image-background';
			
			echo '<div class="'. esc_attr(implode(' ', $classes)) .'" style="'.
					'background-image: url('. esc_attr($_image[0]) .'); '.
					'background-size: '. esc_attr($_scaling) .'; '.
					'background-position: '. esc_attr($_position) .';'.
				'">';
			
			break;
			
		case "Image with Color Overlay":
			$classes[] = 'image-background image-color-overlay';
			$rgba_color = aa_hex2rgba($_color, $_opacity/100); // Opacity field is between 0-100. 50 needs to be converted to 0.50.
			
			echo '<div class="'. esc_attr(implode(' ', $classes)) .'" style="'.
				'background-image: url('. esc_attr($_image[0]) .'); '.
				'background-size: '. esc_attr($_scaling) .'; '.
				'background-position: '. esc_attr($_position) .';'.
				'">';
			
			echo '<div class="ff-background-overlay" style="background: '. esc_attr($rgba_color) .';"></div>';
			break;
		
	}
}

function aa_flexible_background_end() {
	?>
	</div> <!-- /.ff-background -->
	<?php
}

// Source: http://mekshq.com/how-to-convert-hexadecimal-color-code-to-rgb-or-rgba-using-php/
function aa_hex2rgba( $color, $opacity = false ) {
	$default = 'none';
	
	// Return default if no color provided
	if(empty($color)) return $default;
	
	// Sanitize $color if "#" is provided
	if ( $color[0] == '#' ) {
		$color = substr( $color, 1 );
	}
	
	// Check if color has 6 or 3 characters and get values
	if (strlen($color) == 6) {
		$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	} elseif ( strlen( $color ) == 3 ) {
		$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	} else {
		return $default;
	}
	
	// Convert hexadec to rgb
	$rgb =  array_map('hexdec', $hex);
	
	//Check if opacity is set(rgba or rgb)
	if( $opacity ) {
		if(abs($opacity) > 1)
			$opacity = 1.0;
		$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
	} else {
		$output = 'rgb('.implode(",",$rgb).')';
	}
	
	// Return rgb(a) color string
	return $output;
}