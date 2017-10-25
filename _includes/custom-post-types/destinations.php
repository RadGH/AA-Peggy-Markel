<?php

/*-----------------------------------------------------------------------------------*/
/*  CUSTOM POST TYPE REGISTRATION
/*-----------------------------------------------------------------------------------*/

function aa_register_destinations_post_type() {
	$labels = array(
		'name'                  => 'Destinations',
		'singular_name'         => 'Destination',
		'menu_name'             => 'Destinations',
		'name_admin_bar'        => 'Destination',
		'archives'              => 'Destination Archives',
		'parent_item_colon'     => 'Parent Destination:',
		'all_items'             => 'All Destinations',
		'add_new_item'          => 'Add New Destination',
		'add_new'               => 'Add Destination',
		'new_item'              => 'New Destination',
		'edit_item'             => 'Edit Destination',
		'update_item'           => 'Update Destination',
		'view_item'             => 'View Destination',
		'search_items'          => 'Search Destination',
		'not_found'             => 'No destinations found',
		'not_found_in_trash'    => 'Not found in Trash',
		'featured_image'        => 'Featured Image',
		'set_featured_image'    => 'Set featured image',
		'remove_featured_image' => 'Remove featured image',
		'use_featured_image'    => 'Use as featured image',
		'insert_into_item'      => 'Add into Destination',
		'uploaded_to_this_item' => 'Uploaded to this Destination',
		'items_list'            => 'Destination list',
		'items_list_navigation' => 'Destination list navigation',
		'filter_items_list'     => 'Filter Destination list',
	);
	
	$args = array(
		'label'                 => 'Destination',
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'revisions' ),
		'taxonomies'            => array(),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_icon'             => 'dashicons-location-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false, // Use the flexible field instead
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => true,
	);
	
	register_post_type( 'destination', $args );
}
add_action( 'init', 'aa_register_destinations_post_type' );

/**
 * Return the date range in a string format, eg: August 7 - 15, 2016
 */
function aa_destination_next_date() {
	$programs = get_field('available_programs');
	
	if ( !empty($programs) ) foreach( $programs as $p ) {
		return aa_format_program_date( $p['date_text'] );
	}
	
	return false;
}

/**
 * Adds the functionality for the registration form to fill in destination's program data.
 *
 * @param $shortcode_string
 * @param $attributes
 * @param $content
 *
 * @return string
 */
function aa_register_form_data( $shortcode_string, $attributes, $content ) {
	if ( is_admin() ) return $shortcode_string;
	
	$register_form_id = get_field( 'registration_form_id', 'options' );
	if ( (int) $register_form_id !== (int) $attributes['id'] ) return $shortcode_string;
	
	$program_data = aa_get_destination_program_data();
	
	$_registration_form = get_field( 'registration_form_id', 'options' );
	
	$_program = get_field( 'program_field_id', 'options' );
	$_date = get_field( 'program_date_field_id', 'options' );
	$_occupancy = get_field( 'program_occupancy_field_id', 'options' );
	
	$_price = get_field( 'program_price_field_id', 'options' );
	$_total = get_field( 'program_total_field_id', 'options' );
	
//	echo '<pre>';
//	var_dump($program_data);
//	echo '</pre>';
	
	$json = array(
		'destinations' => $program_data,
	    'ids' => array(
	    	'registration_form' => $_registration_form,
	    	'program' => $_program,
	    	'date' => $_date,
	    	'occupancy' => $_occupancy,
	    	'price' => $_price,
	    	'total' => $_total,
	    )
	);
	
	// Add our script to the end of the shortcode.
	$shortcode_string .= "\n\n";
	$shortcode_string .= '<script type="text/javascript">var aa_register_data = '. json_encode($json) .'</script>';
	
	return $shortcode_string;
}
add_filter( 'gform_shortcode_form', 'aa_register_form_data', 50, 3 );

function aa_destination_fill_register_form_dropdowns( $form, $ajax, $field_values ) {
	if ( is_admin() ) return $form;
	
	$register_form_id = get_field( 'registration_form_id', 'options' );
	if ( (int) $register_form_id !== (int) $form['id'] ) return $form;
	
	// Field IDs to be populated
	$_program = get_field( 'program_field_id', 'options' );
	$_date = get_field( 'program_date_field_id', 'options' );
	$_occupancy = get_field( 'program_occupancy_field_id', 'options' );
	
	// Get the possible fields for each item
	$program_options = array( array( 'value'=>'', 'text' => '', 'isSelected' => false) );
	$date_options = array( array( 'value'=>'', 'text' => '', 'isSelected' => false) );
	$occupancy_options = array( array( 'value'=>'', 'text' => '', 'isSelected' => false) );
	
	$program_selected = isset($_POST['input_'.$_program]) ? stripslashes($_POST['input_'.$_program]) : false;
	$date_selected = isset($_POST['input_'.$_date]) ? stripslashes($_POST['input_'.$_date]) : false;
	$occupancy_selected = isset($_POST['input_'.$_occupancy]) ? stripslashes($_POST['input_'.$_occupancy]) : false;
	
	$program_data = aa_get_destination_program_data();
	
	foreach( $program_data as $pd_key => $pd ) {
		$program_options[] = array(
			'value' => $pd_key,
			'text' => $pd['label'],
			'isSelected' => $program_selected === $pd_key
		);
		
		foreach( $pd['programs'] as $pr_key  => $pr ) {
			$date_options[] = array(
				'value' => $pr_key,
				'text' => $pr['label'],
				'isSelected' => $date_selected === $pr_key
			);
			
			foreach( $pr['options'] as $po_key => $po ) {
				$occupancy_options[] = array(
					'value' => $po_key,
					'text' => $po['label'],
					'isSelected' => $occupancy_selected === $po_key
				);
			}
			
		}
		
	}
	
	/*
	echo '<pre>';
	echo "\n<br>\n" . 'VARDUMP: $program_options' . "\n<br>\n";
	var_dump($program_options);
	echo "\n<br>\n" . 'VARDUMP: $date_options' . "\n<br>\n";
	var_dump($date_options);
	echo "\n<br>\n" . 'VARDUMP: $occupancy_options' . "\n<br>\n";
	var_dump($occupancy_options);
	echo "\n<br>\n" .'VARDUMP: $form' . "\n<br>\n";
	var_dump($form);
	echo "\n<br>\n" . 'VARDUMP: $field_values' . "\n<br>\n";
	var_dump($field_values);
	echo "\n<br>\n" . 'VARDUMP: $_POST' . "\n<br>\n";
	var_dump($_POST);
	echo '</pre>';
	*/
	
	// We'll add all combinations to each option. Those will be filtered in JS later.
	foreach( $form['fields'] as $i => $field ) {
		switch( $field->id ) {
			case $_program:
				$field->choices = $program_options;
				break;
				
			case $_date:
				$field->choices = $date_options;
				break;
				
			case $_occupancy:
				$field->choices = $occupancy_options;
				break;
				
			default:
				continue;
				break;
		}
	}
	
	return $form;
}

add_filter( 'gform_pre_render', 'aa_destination_fill_register_form_dropdowns', 15, 3 );
add_filter( 'gform_pre_validation', 'aa_destination_fill_register_form_dropdowns', 15, 3 );
add_filter( 'gform_pre_submission_filter', 'aa_destination_fill_register_form_dropdowns', 15, 3 );
add_filter( 'gform_admin_pre_render', 'aa_destination_fill_register_form_dropdowns', 15, 3 );


/**
 * Get an array of destination program's data, to use in the registration form
 *
 * @return array|null
 */
function aa_get_destination_program_data() {
	// Store this data, we only need to calculate it once per session.
	static $program_data = null;
	if ( $program_data !== null ) return $program_data;
	
	// Get a list of all destinations and associated data to use for the fields.
	$program_data = array();
	
	$args = array(
		'post_type' => 'destination',
		'nopaging' => true,
		'orderby' => 'name',
		'order' => 'ASC',
	);
	
	$dest_posts = get_posts($args);
	
	$p_index = 1;
	foreach( $dest_posts as $d ) {
		$prog_items = get_field( 'available_programs', $d->ID );
		$programs = array();
		
		$program_key = aa_sanitize_key($d->post_title);
		if ( isset($programs[$program_key]) ) {
			$p_index++;
			$program_key .= '-' . $p_index;
		}
		
		$d_index = 1;
		foreach( $prog_items as $p ) {
			$date_key = $program_key . '_' . aa_sanitize_key($p['date_text']);
			
			// Ensure key is unique
			if ( isset($programs[$date_key]) ) {
				$d_index++;
				$date_key .= '-' . $d_index;
			}
			
			$options = array();
			
			if ( $p['single_price'] ) {
				$options[$date_key . '_single'] = array(
					'label' => 'Single Occupancy – $' . aa_format_program_price($p['single_price']) . ' / per person',
					'price' => (float) $p['single_price']
				);
			}
			
			if ( $p['double_price'] ) {
				$per_person = round( ($p['double_price'] / 2) * 100 ) / 100;
				
				$options[$date_key . '_double'] = array(
					'label' => 'Double Occupancy – $' . aa_format_program_price($per_person) . ' / per person',
					'price' => (float) $p['double_price']
				);
			}
			
			$programs[$date_key] = array(
				'label' => $p['date_text'],
				'options' => $options
			);
		}
		
		$label = strtoupper($d->post_title);
		$description = get_field( 'program_description', $d->ID );
		if ( $description ) $label .= ' – ' . $description;
		
		$program_data[$program_key] = array(
			'label' => $label,
			'programs' => $programs
		);
	}
	
	return $program_data;
}

/**
 * Sanitize a string for use with an array key. Removes weird characters, hyphenates spaces.
 *
 * @param $string
 *
 * @return string
 */
function aa_sanitize_key( $string ) {
	$string = iconv("UTF-8", "ISO-8859-1//IGNORE", $string); // Fix weird spaces and characters, converting them to normal. Eg, nbsp to regular space. N-dash to regular hyphen.
	return sanitize_title_with_dashes( preg_replace('/[^\w-_]/', '', preg_replace('/[\s-_  ]+/', '-', strtolower($string))) );
}