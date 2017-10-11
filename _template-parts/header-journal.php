<?php
$blog_page_id = get_option( 'page_for_posts' );
if ( !$blog_page_id ) return;

$title = get_field( 'journal_title', $blog_page_id );
$background = get_field( 'header_background', $blog_page_id );

$archive_title = '';

if ( !is_singular() ) {
	if ( is_category() ) $archive_title = 'Showing posts filed under: ' . single_term_title( '', false );
	else if ( is_tag() ) $archive_title = 'Showing posts filed under: ' . single_term_title( '', false );
	else if ( is_date() ) $archive_title = 'Showing posts from: ' . get_the_time('F Y');
	else if ( is_month() ) $archive_title = 'Showing posts from: ' . get_the_time('F Y');
	else if ( is_year() ) $archive_title = 'Showing posts from: ' . get_the_time('Y');
}
?>
<div class="ff page-header content_align-center content_width-narrow">

	<?php aa_flexible_background_start( $background, array( 'journal-header' ) ); ?>
	
	<div class="container">
	
		<h1 class="header-title h2"><?php echo esc_html( $title ); ?></h1>
		
		<div class="archive-intro">
			<?php if ( $archive_title ) { ?>
			<h2 class="archive-title h4"><em><?php echo esc_html($archive_title); ?></em> <a href="<?php echo esc_attr(get_post_type_archive_link('post')); ?>" class="clear-filter">Clear</a></h2>
			<?php } ?>
			
			<?php
			if ( is_category() || is_tag() ) {
				$description = category_description( get_queried_object_id() );
				
				if ( $description ) {
					?>
					<div class="archive-content"><?php echo wpautop($description); ?></div>
					<?php
				}
			}
			?>
		</div>
	</div>
	
	<?php aa_flexible_background_end(); ?>
	
</div>