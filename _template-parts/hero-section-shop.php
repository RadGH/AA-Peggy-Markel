<?php
if ( !function_exists('wp') ) return;

// Use the WooCommerce shop page for the entire shop hero section.
$hero_object_id = get_option( 'woocommerce_shop_page_id' );

// Pass the ID back to the default hero section template
if ( $hero_object_id ) include( 'hero-section.php' );