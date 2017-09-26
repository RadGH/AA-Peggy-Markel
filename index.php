<?php
/**
 * Index Page
 * 
 */

get_header();
?>
<div class="container">
<article>
	<div class="content-area">
		<?php if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>

				<?php 
				the_post_thumbnail('blog-posts'); ?>
    <div class="post-preview">
  <h4 class="post-title"><a href="<?php the_permalink(); ?>">
    <?php the_title(); ?>
    </a></h4>
    <div class="post-meta">by <a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>">
      <?php the_author(); ?>
      </a> under <?php the_category(' , '); ?>&ensp;|&ensp; <span class="post-date">
      <?php the_time('F j, Y'); ?>
      </span> &ensp;|&ensp;
      <?php comments_number(__('No Comments')); ?>
    </div>
  <?php the_excerpt(__('new_excerpt_length')); ?>
  <?php if(has_tag()) : ?><div class="tags"><?php the_tags('Tags: ', ', '); ?></div><?php endif; ?>
  <div class="read-more"><a href="<?php the_permalink(); ?>" class="button">read more</a></div>
</div>

			<?php endwhile; ?>
           
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
