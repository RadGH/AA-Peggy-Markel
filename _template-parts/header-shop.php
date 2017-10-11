<?php
if ( !function_exists('wp') ) return;

$shop_page_id = get_option( 'woocommerce_shop_page_id' );
if ( !$shop_page_id ) return;

$title = get_field( 'shop_title', $shop_page_id );
$description = get_field( 'shop_description', $shop_page_id );
$background = get_field( 'background', $shop_page_id );

$archive_title = '';

if ( is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) $archive_title = 'Showing products filed under: ' . single_term_title( '', false );
?>
<div class="ff page-header content_align-center content_width-narrow">

	<?php aa_flexible_background_start( $background, array( 'journal-header' ) ); ?>
	
	<div class="container">
		
		<?php if ( $title ) { ?>
		<h1 class="header-title h2"><?php echo esc_html( $title ); ?></h1>
		<?php } ?>
		
		<?php if ( $archive_title || $description ) { ?>
		<div class="archive-intro">
			
			<?php if ( $archive_title ) { ?>
				<h2 class="archive-title h4"><?php echo esc_html($archive_title); ?> <a href="<?php echo esc_attr(get_post_type_archive_link('post')); ?>" class="clear-filter">Clear</a></h2>
			<?php } ?>
			
			<?php if ( $description ) { ?>
				<div class="archive-content"><?php echo wpautop($description); ?></div>
			<?php } ?>
			
		</div>
		<?php } ?>
		
	</div>
	
	<?php aa_flexible_background_end(); ?>

</div>