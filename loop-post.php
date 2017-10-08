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
	<div id="post-<?php the_ID(); ?>" <?php post_class( 'post clearfix' ); ?>>
		<div class="post-preview">
			<h4 class="post-title">
				<span class="pm-underline"><?php the_title(); ?></span>
			</h4>
			
			<?php the_post_thumbnail( 'blog-posts' ); ?>
			
			<?php the_excerpt(); ?>
			
			<div class="read-more"><a href="<?php the_permalink(); ?>" class="button">read more</a></div>
			
			<div class="post-meta">
				<p>Posted by
					<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a> on <?php the_time( 'n/j/Y' ); ?> | Filed under: <?php the_category( ', ' ); ?>
					
					<?php if ( has_tag() ) : ?>
						| <span class="tags"><?php the_tags( 'Tags: ', ', ' ); ?></span>
					<?php endif; ?>
				</p>
			</div>
		</div>
	</div>
	

<?php endwhile;
wp_reset_query();
?>