<?php
/**
 * Returns the itinerary form ID.
 * This field must be specified in Theme Settings.
 *
 * @return bool|int
 */
function aa_get_itinerary_form_id() {
	$form_id = get_field( 'itinerary_form_id', 'options' );
	return $form_id ? (int) $form_id : false;
}

/**
 * Returns the destination field ID that is used within the itinerary form.
 * This field must be specified in Theme Settings.
 *
 * @return bool|int
 */
function aa_get_itinerary_destination_field_id() {
	$field_id = get_field( 'itinerary_destination_field_id', 'options' );
	return $field_id ? (int) $field_id : false;
}

/**
 * Returns the Destination ID from a gravity form "lead" (the submitted data of a GF request).
 *
 * @param $lead
 *
 * @return bool|int
 */
function aa_get_destination_id_from_gravity_forms( $lead ) {
	// Only apply this filter to the itinerary form
	$itinerary_form_id = aa_get_itinerary_form_id();
	if ( !$itinerary_form_id ) return false;
	if ( $lead['form_id'] != $itinerary_form_id ) return false;
	
	// The form should include a hidden field for the destination ID.
	$destination_field_id = aa_get_itinerary_destination_field_id();
	if ( !$destination_field_id ) return false;
	
	// Get the value of the destination ID field.
	$destination_id = isset($lead[$destination_field_id]) ? $lead[$destination_field_id] : false;
	
	return $destination_id ? (int) $destination_id : false;
}

/*---------------------------------------------------------------
	Display an itinerary form using gravity forms.
		A hidden field with the name "destination_id" lets us refer to the destination ID throughout the submission process.
		The form ID is specified in theme options.
------------------------------------------------------------------*/
function aa_shortcode_itinerary_form( $atts, $content = '' ) {
	$itinerary_form_id = aa_get_itinerary_form_id();
	if ( !$itinerary_form_id ) return '';
	
	$destination_id = get_the_ID();
	if ( get_post_type($destination_id) !== 'destination' ) return '<!-- Itinerary form shortcode only works for a destination post type. -->';
	
	return '<div class="itinerary-form">'.
		'<p>Enter your information below to get a detailed itinerary and follow up information in your inbox:</p>'.
		do_shortcode('[gravityform id="'. $itinerary_form_id .'" field_values="destination_id='. $destination_id .'" title="false" description="false" ajax="true"]') .
		'</div>';
}
add_shortcode( 'itinerary_form', 'aa_shortcode_itinerary_form' );

/*---------------------------------------------------------------
	Display programs for a destination using a shortcode.
------------------------------------------------------------------*/
function aa_shortcode_destination_programs( $atts, $content = '' ) {
	$programs = get_field('available_programs');
	if ( empty($programs) ) return '';
	
	ob_start();
	
	// Combine dates with the same prices
	$groups = array();
	
	foreach( $programs as $p ) {
		$date_text = $p['date_text'];
		$single_price = $p['single_price'];
		$double_price = $p['double_price'];
		
		// For combining similar prices
		$price_key = ($single_price ?: "0") . '|' . ($double_price ?: "0");
		
		if ( !isset($groups[$price_key]) ) {
			// Create an new date group, this is a new price combo
			$groups[$price_key] = array(
				'dates' => array($date_text),
				'single_price' => $single_price,
				'double_price' => $double_price
			);
		}else{
			// Add to the existing date, since the price matches.
			$groups[$price_key]['dates'][] = $date_text;
		}
	}
	
	// Display groups of prices
	?>
	<div class="programs-list">
		<div class="ff-content">
			<?php
			$i = 0;
			
			foreach( $groups as $g ) {
				$i++;
				
				$date_term = _n( 'Date', 'Dates', count($g['dates']) );
				
				$price_term = ($g['single_price'] && $g['double_price']) ? 'Prices' : 'Price';
				
				if ( count($groups) >= 2 ) {
					$date_term .= ' #'. $i;
				}
				
				echo '<h3>' . $date_term . '</h3>';
				aa_display_program_dates( $g['dates'] );
				
				echo '<h3>' . $price_term . '</h3>';
				aa_display_program_prices( $g['single_price'], $g['double_price'] );
			}
			?>
		</div>
	</div>
	<?php
	
	return ob_get_clean();
}
add_shortcode( 'destination_programs', 'aa_shortcode_destination_programs' );

/*---------------------------------------------------------------
	Attach the itinerary PDF and replace short tags in the notification sent by gravity forms.
------------------------------------------------------------------*/
function aa_itinerary_notification_insert_short_tags_and_attachment( $notification, $form, $entry ) {
	$destination_id = aa_get_destination_id_from_gravity_forms( $entry );
	if ( !$destination_id ) return $notification;
	
	// Get the itinerary PDF and title to use for the short tags
	$destination_title = get_the_title( $destination_id );
	$pdf = get_field( 'itinerary_pdf', $destination_id );
	
	if ( !empty($pdf['ID']) ) {
		// Replace short tags within the subject and message. Short tags include: [itinerary_title] and [itinerary_download]
		$notification['subject'] = aa_itinerary_filter_short_tags( $notification['subject'], $pdf['url'], $destination_title );
		$notification['message'] = aa_itinerary_filter_short_tags( $notification['message'], $pdf['url'], $destination_title );
		
		// Don't bother attaching the PDF if it is going to the admin.
		if ( $notification['to'] !== '{admin_email}' && $notification['to'] !== get_option( 'admin_email' ) ) {
		
			// Attach the itinerary PDF to the notification (note: not to the $notification)
			$pdf_path = get_attached_file( $pdf['ID'] );
			if ( $pdf_path && file_exists($pdf_path) ) {
				if ( !isset($notification['attachments']) || !is_array($notification['attachments']) ) {
					// Initialize the attachments field
					$notification['attachments'] = array();
				}
				
				// Attach the file path
				$notification['attachments'][] = $pdf_path;
			}
		
		}
	}else{
		// The itinerary was not attached. Link to the destination page, and append an error to the download title
		$notification['subject'] = aa_itinerary_filter_short_tags( $notification['subject'], false );
		$notification['message'] = aa_itinerary_filter_short_tags( $notification['message'], false );
	}
	
	// Return the adjusted notification data
	return $notification;
}
add_filter( "gform_notification", "aa_itinerary_notification_insert_short_tags_and_attachment", 10, 30 );

/*---------------------------------------------------------------
	Replace short tags in the confirmation message displayed on the website after submitting the gravity form.
------------------------------------------------------------------*/
function aa_itinerary_confirmation_insert_short_tags( $confirmation, $form, $entry, $ajax ) {
	$destination_id = aa_get_destination_id_from_gravity_forms( $entry );
	if ( !$destination_id ) return $confirmation;
	
	// Get the itinerary PDF and title to use for the short tags
	$destination_title = get_the_title( $destination_id );
	$pdf = get_field( 'itinerary_pdf', $destination_id );
	
	if ( !empty($pdf['ID']) ) {
		$confirmation = aa_itinerary_filter_short_tags( $confirmation, $pdf['url'], $destination_title );
	}else{
		$confirmation = aa_itinerary_filter_short_tags( $confirmation, false );
	}
	
	return $confirmation;
}
add_filter( 'gform_confirmation', 'aa_itinerary_confirmation_insert_short_tags', 20, 4 );

/**
 * Replaces short tags [itinerary_title] and [itinerary_download] with the title and download link for the itinerary PDF.
 * Note: $pdf should be an array from ACF's result of get_field().
 *
 * @param $string
 * @param $pdf_url
 * @param $destination_title
 *
 * @return mixed
 */
function aa_itinerary_filter_short_tags( $string, $pdf_url, $destination_title = null ) {
	if ( !empty($pdf_url) ) {
		$pdf_link = sprintf(
			'<a href="%s" title="%s" target="_blank" rel="external" class="button">Download the itinerary for %s</a>',
			esc_attr($pdf_url),
			esc_attr('Download Itinerary'),
			esc_html($destination_title)
		);
	}else{
		$destination_title = '(Error: The itinerary is not available to download for this entry.)';
		$pdf_link = '<em>[Download link not available]</em>';
	}
	
	$tags = array(
		'[itinerary_title]' => esc_html($destination_title),
		'[itinerary_download]' => $pdf_link
	);
	
	return str_replace( array_keys($tags), array_values($tags), $string );
}

/**
 * Returns a destination URL with the itinerary slug at the end.
 *
 * @param $destination_id
 *
 * @return string
 */
function aa_get_itinerary_link( $destination_id ) {
	if ( is_object($destination_id) ) $destination_id = $destination_id->ID;
	
	$url = trailingslashit(get_permalink($destination_id));
	
	return $url . 'itinerary/';
}

/**
 * Displays a button to view the itinerary page.
 *
 * @param $field
 *
 * @return mixed
 */
function aa_preview_itinerary_button($field) {
	if ( get_post_type() != 'destination' ) return $field;
	
	$id = isset($_REQUEST['post']) ? (int) $_REQUEST['post'] : get_the_ID();
	$link = aa_get_itinerary_link($id);
	
	$button = '<a href="'. esc_attr($link) .'" class="button button-primary" target="itinerary">Go to Detailed Itinerary</a>';
	
	if ( empty($field['message']) ) {
		$field['message'] = $button;
	}else{
		$field['message'].= "<br><br>" . $button;
	}
	
	return $field;
}
// "View Detailed Itinerary" field:
add_filter('acf/load_field/key=field_5a3ee22341c21', 'aa_preview_itinerary_button');

/**
 * Add /itinerary/ as an endpoint. This means every permalink can end in /itinerary/.
 */
function aa_itinerary_endpoint() {
	add_rewrite_endpoint( 'itinerary', EP_PERMALINK );
}
add_action( 'init', 'aa_itinerary_endpoint' );

/**
 * If the itinerary query var is set, set it to true instead of an empty string so that we can compare it.
 * Note: Empty query vars and unset query vars are both empty string by default - this is to workaround that issue.
 *
 * @param $vars
 *
 * @return mixed
 */
function aa_itinerary_query_var( $vars ) {
	if( isset( $vars['itinerary'] ) ) $vars['itinerary'] = true;
	return $vars;
}
add_filter( 'request', 'aa_itinerary_query_var' );

/**
 * Make sure this code can only run on single destination pages.
 */
function aa_itinerary_non_destination_redirect() {
	$itinerary = get_query_var('itinerary');
	
	if ( $itinerary === true && !is_singular('destination') ) {
		// Redirect without the itinerary
		wp_redirect( str_replace('itinerary/', '', get_permalink() ) );
		exit;
	}
}
add_action( 'template_redirect', 'aa_itinerary_non_destination_redirect' );

function aa_itinerary_page_template( $template ) {
	if ( is_singular( 'destination' ) && get_query_var('itinerary') === true ) {
		$new_template = locate_template( array( '/templates/destination-itinerary.php' ) );
		if ( '' != $new_template ) {
			return $new_template;
		}
	}
	
	return $template;
}
add_filter( 'template_include', 'aa_itinerary_page_template', 30 );

/**
 * Ask robots not to index itinerary detail pages using: meta tag
 */
function aa_itinerary_noindex_meta_tag() {
	if ( get_post_type() == 'destination' && get_query_var('itinerary') ) {
		echo "\t" . '<meta name="robots" content="noindex">';
		echo "\n";
	}
}
add_filter( 'wp_head', 'aa_itinerary_noindex_meta_tag' );

/**
 * Ask robots not to index itinerary detail pages using: response header
 */
function aa_itinerary_noindex_response_header() {
	if ( get_post_type() == 'destination' && get_query_var('itinerary') ) {
		header('X-Robots-Tag: noindex');
	}
}
add_filter( 'template_redirect', 'aa_itinerary_noindex_response_header', 30 );

function aa_shortcode_itinerary_registration_button( $atts, $content = '' ) {
	if ( !is_array($atts) ) $atts = (array) $atts;
	$atts['button'] = 1;
	return aa_shortcode_itinerary_registration_link($atts, $content);
}
add_shortcode('itinerary_registration_button', 'aa_shortcode_itinerary_registration_button' );

function aa_shortcode_itinerary_registration_link( $atts, $content = '' ) {
	if ( !is_array($atts) ) $atts = (array) $atts;
	$is_button = !empty($atts['button']);
	$text = empty($atts['text']) ? 'Click here to register' : $atts['text'];
	$destination_id = empty($atts['destination']) ? get_the_ID() : (int) $atts['destination'];
	
	$destination_post = get_post($destination_id);
	$destination_slug = aa_sanitize_key($destination_post->post_title); // the value to pass to the registration form
	
	$register_page_id = get_field('registration_page_id', 'options', false);
	$register_page_url = get_permalink( $register_page_id );
	
	$link = add_query_arg( array('register-program' => $destination_slug), $register_page_url );
	
	// note "button button" is correct, it joins the first class but also adds button as a separate class.
	return '<a href="'. esc_attr($link) .'" class="itinerary-registration-'. ($is_button ? 'button button' : 'link').'">'. esc_html($text) .'</a>';
}
add_shortcode('itinerary_registration_link', 'aa_shortcode_itinerary_registration_link' );