<?php
/**
 * Archives Page
 */

get_header();
?>
<div class="container">
<article>
	<div class="content-area">
		<?php if (have_posts()) : ?>
			<?php //$post = $posts[0]; // Hack. Set $post so that the_date() works. ?>

			<?php /* If this is a category archive */ if (is_category()) { ?>
				<h3 class="archive_head"><?php echo single_cat_title(); ?></h3>
			<?php /* If this is a tag archive */ } elseif (is_tag()) { ?>
				<h3 class="archive_head"><?php echo single_tag_title() ?></h3>
			<?php /* If this is a date archive */ } elseif (is_date()) { ?>
				<h3 class="archive_head">Entries from <?php the_time('F Y'); ?></h3>
			<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
				<h3 class="archive_head">Entries from <?php the_time('F Y'); ?></h3>
			<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
				<h3 class="archive_head">Entries from <?php the_time('Y'); ?></h3>
			<?php } ?>

	    	<div class="post-body entry-content">
			<?php get_template_part( 'loop' , 'archive' ); ?>
	        </div>

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
