<?php
/**
 * Archives Page
 */

if ( !have_posts() ) {
	get_template_part( '404' );
	return;
}

$archive_title = 'Archives';
if ( is_category() ) $archive_title = single_term_title( '', false );
else if ( is_tag() ) $archive_title = single_term_title( '', false );
else if ( is_date() ) $archive_title = get_the_time('F Y');
else if ( is_month() ) $archive_title = get_the_time('F Y');
else if ( is_year() ) $archive_title = get_the_time('Y');

get_header();
?>
<div class="container">
	
	<?php get_sidebar(); ?>
	
	<article>
		<div class="content-area">
			<div class="archive-intro">
				<h1 class="archive-title h3"><?php echo esc_html($archive_title); ?> <a href="<?php echo esc_attr(get_post_type_archive_link('post')); ?>" class="clear-filter">Clear filter</a></h1>
				
				<?php if ( is_category() || is_tag() ) { ?>
					<div class="archive-content"><?php echo category_description( get_queried_object_id() ); ?></div>
				<?php } ?>
			</div>
			
			<?php get_template_part( 'loop', 'archive' ); ?>
			
			<?php get_template_part( '_template-parts/part', 'navigation' ); ?>
		
		</div>
	</article>
	
</div>
<?php get_footer(); ?>
