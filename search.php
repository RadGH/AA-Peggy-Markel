<?php
/**
 * Search Page
 * 
 */

get_header();

$s = trim(get_query_var('s'));

the_post();

new WP_Widget_Search()

?>
<div class="container">
	
	<?php get_sidebar(); ?>
	
	<article>
		<div class="content-area">
			<?php if ( have_posts() && $s ) : ?>
				
				<div class="archive-intro">
					<h1 class="archive-title h3">Viewing results for &ldquo;<?php echo esc_html( $s ); ?>&rdquo;
						<a href="<?php echo esc_attr( get_post_type_archive_link( 'post' ) ); ?>" class="clear-filter">Clear filter</a></h1>
				</div>
				
				<?php get_template_part( 'loop', 'search' ); ?>
				
				<?php get_template_part( '_template-parts/part', 'navigation' ); ?>
			
			<?php else : ?>
				
				<h1 class="heading">Search</h1>
				<p>Enter search keywords below to begin.</p>
				<?php get_search_form(); ?>
			
			<?php endif; ?>
		</div>
	</article>
	
</div>
<?php

get_footer();
