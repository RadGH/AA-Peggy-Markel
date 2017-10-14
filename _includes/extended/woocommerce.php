<?php

// Only add woocommerce support if the plugin is running
if ( !class_exists('WooCommerce') ) return;

add_theme_support( 'woocommerce' );

// Remove the description tab
function aa_remove_description_tab( $tabs ) {
	if ( isset($tabs['description']) ) unset($tabs['description']);
	return $tabs;
}

// Add the description
function aa_insert_product_description_below_title() {
	$heading = esc_html( apply_filters( 'woocommerce_product_description_heading', __( '', 'woocommerce' ) ) );
	?>
	
	<div class="product-description">
		<?php if ( $heading ): ?>
			<h2><?php echo $heading; ?></h2>
		<?php endif; ?>
		
		<?php the_content(); ?>
	</div>
	
	<?php
}

function aa_wc_reorganize_woocommerce_hooks() {
	// Remove product description tab, move description below title instead
	add_filter( 'woocommerce_product_tabs', 'aa_remove_description_tab' );
	add_action( 'woocommerce_single_product_summary', 'aa_insert_product_description_below_title', 7 );
	
	// Remove add to cart button on archive
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	
	// Disable the breadcrumbs
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
	
	// Disable WooCommerce "On Sale" div
	add_filter( 'woocommerce_sale_flash', '__return_false' );
	
	// Disable "Sort by" dropdown
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
	
	// Disable the line of text that read "Showing all xxx results"
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	
	// Move SKU below title on single products
	// @add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
	
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 7 );
	
	// @add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
	
	// @add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
	
	// Move price after excerpt
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25 );
	
	// @add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
}
add_action( 'init', 'aa_wc_reorganize_woocommerce_hooks' );

function aa_wc_rename_sort_dropdown_verbiage( $options ) {
	if ( isset($options['menu_order']) ) $options['menu_order'] = 'Default';
	if ( isset($options['popularity']) ) $options['popularity'] = 'Most Popular';
	if ( isset($options['rating']) )     $options['rating'] =     'Highest Rating';
	if ( isset($options['date']) )       $options['date'] =       'Date Added';
	if ( isset($options['price']) )      $options['price'] =      'Price (lowest first)';
	if ( isset($options['price-desc']) ) $options['price-desc'] = 'Price (highest first)';
	return $options;
}
add_filter( 'woocommerce_catalog_orderby', 'aa_wc_rename_sort_dropdown_verbiage', 15 );

function aa_wc_remove_default_woocommerce_stylesheets( $enqueue_styles ) {
	unset( $enqueue_styles['woocommerce-general'] ); // Remove the gloss
	// unset( $enqueue_styles['woocommerce-layout'] ); // Remove the layout
	// unset( $enqueue_styles['woocommerce-smallscreen'] );	// Remove the smallscreen optimisation
	return $enqueue_styles;
}
add_filter( 'woocommerce_enqueue_styles', 'aa_wc_remove_default_woocommerce_stylesheets' );

function aa_wc_woocommerce_body_class_for_pages( $classes ) {
	if ( is_page() ) {
		if ( get_the_ID() == get_option( 'woocommerce_cart_page_id' ) ) $classes[] = 'woocommerce';
		else if ( get_the_ID() == get_option( 'woocommerce_checkout_page_id' ) ) $classes[] = 'woocommerce';
	}
	
	return $classes;
}
add_filter( 'body_class', 'aa_wc_woocommerce_body_class_for_pages' );

// Customize the WooCommerce template using hooks
function aa_wc_woocommerce_template_hooks() {
	// Add underline to single product titles
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
	add_action('woocommerce_single_product_summary', 'aa_single_product_title', 5 );
	
	// Display markup before woocommerce
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	add_action('woocommerce_before_main_content', 'aa_wc_woocommerce_before', 10 );
	
	// Display markup after woocommerce
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
	add_action( 'woocommerce_after_main_content', 'aa_wc_woocommerce_after', 10 );
	
	if ( is_singular('product') ) {
		// Disable sidebar on single product pages
		add_filter( 'sidebar_enabled', '__return_false' );
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
	}else{
		// Move sidebar into custom hook on other pages
		add_action( 'aa_wc_woocommerce_sidebar_area', 'woocommerce_get_sidebar', 10 );
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
	}
}
add_action( 'wp', 'aa_wc_woocommerce_template_hooks' );

// Hooks used before and after WooCommerce template content
function aa_wc_woocommerce_before() {
	
	if ( !is_cart() && !is_checkout() && !is_singular('product') ) {
		get_template_part( '_template-parts/hero-section', 'shop' );
	}
	
	?>
	<div class="container">
		<article>
	<?php
}
function aa_wc_woocommerce_after() {
	?>
		</article>
	</div>
	<!-- /.container -->
	<?php
}

// Enable shortcodes on specific WooCommerce filters
function aa_wc_woocommerce_filter_shortcodes() {
	add_filter( 'woocommerce_email_footer_text', 'do_shortcode', 80 );
}
add_action( 'init', 'aa_wc_woocommerce_filter_shortcodes' );

// Disable Order Notes on checkout screen
function aa_wc_disable_order_notes( $fields ) {
	if ( isset($fields['order']['order_comments']) ) {
		unset($fields['order']['order_comments']);
	}
	
	return $fields;
}
add_filter( 'woocommerce_checkout_fields' , 'aa_wc_disable_order_notes' );

// Disable page title on shop archive
function aa_disable_shop_archive_title( $show ) {
	if ( is_shop() && is_archive() ) return false;
	return $show;
}
add_filter( 'woocommerce_show_page_title', 'aa_disable_shop_archive_title' );

// Add an underline to singular product titles
function aa_single_product_title() {
	the_title( '<h1 itemprop="name" class="product_title entry-title"><span class="pm-underline">', '</span></h1>' );
}