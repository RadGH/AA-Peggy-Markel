<?php

/**
 * Changes the page template when a singular object is using a flexible content area.
 *
 * @param $template
 *
 * @return string
 */
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

/**
 * Outputs the start tag for a flexible field's background div.
 *
 * @param $field
 * @param $classes
 * @param string $background_key
 */
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

/**
 * Closes the background div
 */
function aa_flexible_background_end() {
	?>
	</div> <!-- /.ff-background -->
	<?php
}

/**
 * Converts a hex color with opacity value to an rgba color for CSS.
 *
 * @param $color
 * @param bool $opacity
 *
 * @return string
 */
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

/**
 * Output the title for a flexible content field. The first occurrence is an <h1>, the rest are <h2>.
 *
 * @param $fields
 * @param $key
 */
function aa_flexible_field_title( $fields, $key = 'title' ) {
	$value = !empty($fields[$key]) ? $fields[$key] : false;
	if ( empty($value) ) return;
	
	$tag = 'h1';
	
	if ( did_action( 'flexible-field-h1' ) ) $tag = 'h2';
	else do_action( 'flexible-field-h1' );
	
	echo '<'. $tag .' class="h1 ff-title">';
	echo nl2br(esc_html($value));
	echo '</'. $tag .'>';
}

/**
 * Output the subtitle field for a flexible content field.
 * @param $fields
 * @param $key
 */
function aa_flexible_field_subtitle( $fields, $key = 'subtitle' ) {
	$value = !empty($fields[$key]) ? $fields[$key] : false;
	if ( empty($value) ) return;
	
	echo '<h3 class="h3 ff-subtitle">';
	echo nl2br(esc_html($value));
	echo '</h3>';
}

/**
 * Output the text content for a flexible content field.
 * @param $fields
 * @param $key
 */
function aa_flexible_field_content( $fields, $key = 'content' ) {
	$value = !empty($fields[$key]) ? $fields[$key] : false;
	if ( empty($value) ) return;
	
	$value = do_shortcode(wpautop($value));
	
	echo '<div class="ff-content">';
	echo $value;
	echo '</div>';
}

/**
 * Render a button for a flexible content field.
 *
 * @param $fields
 * @param string $key
 * @param string $enabled
 */
function aa_flexible_field_button( $fields, $key = 'button', $enabled = 'button_enabled' ) {
	$value = !empty($fields[$key]) ? $fields[$key] : false;
	if ( empty($value) ) return;
	
	// A checkbox may be used to enable the button. If the parameter is false, this check is skipped. Otherwise, we check that a field is set with a truthful value.
	if ( !empty($enabled) ) {
		if ( empty($fields[$enabled]) ) return;
	}
	
	$url = $value['url'] ? $value['url'] : '#';
	$text = $value['text'] ? $value['text'] : 'Learn More';
	$target = $value['target'] ? 'target="_blank"' : '';
	
	echo '<div class="ff-button-row">';
	printf( '<a href="%s" class="ff-button" %s>%s</a>', esc_attr($url), $target, esc_html($text) );
	echo '</div>';
}

/**
 * Displays a gallery of a flexible content field.
 * @param $fields
 * @param $key
 */
function aa_flexible_field_gallery( $fields, $key = 'images' ) {
	$value = !empty($fields[$key]) ? $fields[$key] : false;
	if ( empty($value) || !is_array($value) ) return;
	
	?>
	<div class="ff-gallery">
		<div class="gallery-items">
			<?php
			foreach( $value as $image ) {
				?>
				<div class="gallery-item columns four">
					<a href="<?php echo esc_attr($image['url']) ; ?>" title="View full image" target="_blank" rel="lightbox"><?php
						echo wp_get_attachment_image( $image['ID'], 'thumbnail' );
					?></a>
				</div>
				<?php
			}
			?>
		</div>
	</div>
	<?php
}