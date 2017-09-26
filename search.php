<?php
/**
 * Search Page
 * 
 */

get_header();
?>
<div class="container">
<article>
	<div class="content-area">
		<?php if (have_posts()) : ?>

	        <h3 class="center">results for <?php echo $s; ?></h3>

				<?php get_template_part( 'loop', 'archive'); ?>

				<?php get_template_part( '_template-parts/part', 'navigation' ); ?>

		<?php else : ?>

				<h1 class="heading">Not Found</h1>
				<p class="center">Sorry, but you are looking for something that isn't here.</p>
				<?php get_search_form(); ?>

		<?php endif; ?>
	</div>
</article>
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
