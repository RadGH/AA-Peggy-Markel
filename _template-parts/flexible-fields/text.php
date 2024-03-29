<?php
/* Flexible field: Text
 *
 * Displays title, subtitle, a block of text, and a button.
 */

if ( !isset($flex_field) ) return; // This variable is passed through from "flexible-content-areas.php"

// Display some common data among the flexible fields
aa_flexible_field_title( $flex_field );
aa_flexible_field_subtitle( $flex_field );
aa_flexible_field_content( $flex_field );
aa_flexible_field_button( $flex_field );