<?php
/**
 * Categories Page
 *
 */

get_header();
?>
<div class="container">
<div class="center"><?php _e( 'You are currently viewing all posts under the category <span style="text-transform:uppercase;"><strong>' .  get_category(get_query_var('cat'))->name. '</strong></span>.', 'theme' ); ?></div>
<div class="intro center"><?php echo category_description( $category_id ); ?></div>

<article>
	<div class="content-area">

		<?php get_template_part( 'loop', 'category' ); ?>

		<?php  get_template_part( '_template-parts/part', 'navigation' ); ?>

	</div>
</article>

<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
