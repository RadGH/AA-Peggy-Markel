<?php
/**
 * Index Page
 * 
 */

if ( !have_posts() ) {
	get_template_part( '404' );
	return;
}

get_header();
?>
<div class="container">
<?php get_sidebar(); ?>

<article>
	<div class="content-area">
		<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post();
				
				get_template_part( 'loop', get_post_type() );
				
			endwhile; ?>
           
            <?php get_template_part( '_template-parts/part', 'navigation' ); ?>

		<?php endif; ?>
	</div>
</article>
</div>
<?php

get_footer();
