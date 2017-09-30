<?php
/* Flexible field: Background Image
 *
 * Doesn't display any content, used for background images.
 * Structurally identical to a text field, except since there is no content the background information shows by default when editing the field.
 */

if ( !isset($flex_field) ) return; // This variable is passed through from "flexible-content-areas.php"

// This section does not have any content to display.
echo '&nbsp;';