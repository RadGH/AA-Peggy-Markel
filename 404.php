<?php
/**
 * 404 Page
 *
 */

get_header();
?>

<article>
	<div class="container">
		<?php the_field('error_page_text', 'option'); ?>
        <?php get_search_form(); ?>
	</div>
</article>

<?php get_footer(); ?>
