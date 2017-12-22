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