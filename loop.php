<?php
/**
 * The loop
 */

global $more
?>

<?php //If there are no posts to display, such as an empty archive page
	if ( ! have_posts() ) : ?>
		<h1>There are currently no entries for this archive.</h1>
		<?php get_search_form(); ?>
<?php endif; ?>

<?php while ( have_posts() ) : the_post(); ?>

	<!-- Display All Posts -->
		<div id="post-<?php the_ID(); ?>" <?php post_class('post clearfix'); ?>>
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
  <?php the_excerpt(); ?>
  <?php if(has_tag()) : ?><div class="tags"><?php the_tags('Tags: ', ', '); ?></div><?php endif; ?>
  <div class="read-more"><a href="<?php the_permalink(); ?>" class="button">read more</a></div>
</div>
		</div>
	

<?php endwhile;
wp_reset_query();
?>