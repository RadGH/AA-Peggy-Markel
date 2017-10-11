<?php
/**
 * Archives Page
 */

if ( !have_posts() ) {
	get_template_part( '404' );
	return;
}

get_header();

if ( !is_search() && (is_home() || is_post_type_archive('post') || is_tax('category') || is_category()) ) {
	get_template_part( '_template-parts/header', 'journal' );
}
?>
<div class="container">
	
	<?php get_sidebar(); ?>
	
	<article>
		<div class="content-area">
			
			
			<?php
			while ( have_posts() ) : the_post();
				
				get_template_part( 'loop', 'archive' );
			
			endwhile; // End of the loop.
			
			get_template_part( '_template-parts/part', 'navigation' );
			?>
		
		</div>
	</article>
	
</div>
<?php

get_footer();