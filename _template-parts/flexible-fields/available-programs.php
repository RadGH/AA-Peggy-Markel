<?php
/* Flexible field: Itinerary List
 *
 * Displays title, subtitle, and list of itinerary day plans.
 */

if ( !isset($flex_field) ) return; // This variable is passed through from "flexible-content-areas.php"

// Display some common data among the flexible fields
aa_flexible_field_title( $flex_field );
aa_flexible_field_subtitle( $flex_field );
aa_flexible_field_content( $flex_field );

// Display the itinerary list
echo do_shortcode('[destination_programs]');