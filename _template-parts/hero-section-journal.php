<?php
// Allow filtering ID, used for WooCommerce store hero and blog posts/category pages.
$page_id = get_option( 'page_for_posts' );
if ( !$page_id ) return;

// Checkbox must be ticked
if ( empty(get_field( 'hero_toggle', $page_id )) ) return;

// Fields from the hero metabox
$title = get_field( 'hero_title', $page_id );
$description = get_field( 'hero_description', $page_id );
$background = get_field( 'hero_background', $page_id );

// Get blog category/tag description
if ( is_category() || is_tag() ) {
	if ( !$description ) {
		$description = category_description( get_queried_object_id() );
	}else{
		$description .= "\n\n" . category_description( get_queried_object_id() );
	}
}

// Create a subtitle based on filter settings.
$filter_title = '';

if ( !is_singular() ) {
	if ( is_category() ) $filter_title = 'Showing posts filed under: ' . single_term_title( '', false );
	else if ( is_tag() ) $filter_title = 'Showing posts filed under: ' . single_term_title( '', false );
	else if ( is_date() ) $filter_title = 'Showing posts from: ' . get_the_time('F Y');
	else if ( is_month() ) $filter_title = 'Showing posts from: ' . get_the_time('F Y');
	else if ( is_year() ) $filter_title = 'Showing posts from: ' . get_the_time('Y');
}
?>
<div class="ff hero-section hero-section-journal content_align-center content_width-narrow">
	
	<?php aa_flexible_background_start( $background, array( 'journal-header' ) ); ?>
	
	<div class="container">
		
		<?php
		// Display the hero title in an <h1>, unless we already used an h1 elsewhere.
		if ( $title ) {
			if ( !did_action( 'flexible-field-h1' ) ) {
				echo '<h1 class="hero-title h2">', esc_html( $title ), '</h1>';
				do_action( 'flexible-field-h1' );
			}else{
				echo '<h2 class="hero-title h2">', esc_html( $title ), '</h2>';
			}
		}
		?>
		
		<?php if ( $filter_title || $description ) { ?>
		<div class="hero-intro">
			
			<?php if ( $filter_title ) { ?>
				<h2 class="hero-filter-title h4"><em><?php echo esc_html($filter_title); ?></em> <a href="<?php echo esc_attr(get_post_type_archive_link('post')); ?>" class="clear-filter">Clear</a></h2>
			<?php } ?>
			
			<?php if ( $description ) { ?>
				<div class="hero-content"><?php echo wpautop($description); ?></div>
			<?php } ?>
			
		</div>
		<?php } ?>
		
	</div>
	
	<?php aa_flexible_background_end(); ?>

</div>