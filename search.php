<?php
/**
 * Search Page
 * 
 */

get_header();

$s = trim(get_query_var('s'));

new WP_Widget_Search();

?>
<div class="container">
	
	<article>
		<?php if ( have_posts() && $s ) : ?>
			
			<div class="archive-intro search-intro">
				<h1 class="heading">Search</h1>
				<p>Viewing results for &ldquo;<?php echo esc_html( $s ); ?>&rdquo;</p>
				
				<?php get_search_form(); ?>
			</div>
			
			<?php get_template_part( 'loop', 'search' ); ?>
			
			<?php get_template_part( '_template-parts/part', 'navigation' ); ?>
		
		<?php else : ?>
		
			<div class="archive-intro search-intro">
				<h1 class="heading">Search</h1>
				<p>Enter search keywords below to begin.</p>
				<?php get_search_form(); ?>
			</div>
		
		<?php endif; ?>
	</article>
	
</div>
<?php

get_footer();
