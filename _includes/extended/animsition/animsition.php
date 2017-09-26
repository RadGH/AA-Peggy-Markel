<?php

/**
 * Enqueue scripts and styles for animsition v4.0.2
 */
function wpdocs_clad_scripts() {
    wp_enqueue_style( 'aimsition-styles', get_template_directory_uri() . '/_includes/extended/animsition/animsition.min.css');
    wp_enqueue_script( 'aimsition-script', get_template_directory_uri() . '/_includes/extended/animsition/animsition.min.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'wpdocs_clad_scripts' );


/* Add JS call to teh footer */
function aimsitionscript() {
?>
<script type="text/javascript">
  if ( undefined !== window.jQuery ) {
    
	// Page Transitions
jQuery(function($) {
        "use strict";
    $('.animsition').animsition();
  });
  
  }
</script>
<?php
}
add_action( 'wp_footer', 'aimsitionscript' );



?>