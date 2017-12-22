<?php
/* Flexible field: Gallery
 *
 * Displays title, subtitle, a block of text, and a grid of photos.
 */

if ( !isset($flex_field) ) return; // This variable is passed through from "flexible-content-areas.php"

// Display some common data among the flexible fields
aa_flexible_field_title( $flex_field );
aa_flexible_field_subtitle( $flex_field );
aa_flexible_field_content( $flex_field );

// Button
aa_flexible_field_button( $flex_field, 'gallery_button', 'gallery_button_enabled' );

// Display the gallery
aa_flexible_field_gallery( $flex_field );

// Button, again
aa_flexible_field_button( $flex_field, 'gallery_button', 'gallery_button_enabled' );