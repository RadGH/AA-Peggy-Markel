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
	
	<div id="post-<?php the_ID(); ?>" <?php post_class( 'post search-result clearfix' ); ?>>
		<div class="post-preview">
			<h4 class="post-title">
				<span class="pm-underline"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
			</h4>
			
			<?php if ( has_post_thumbnail() ) { ?>
				<div class="post-thumbnail"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'thumbnail' ); ?></a></div>
			<?php } ?>
			
			<div class="post-excerpt"><?php
				if( get_the_excerpt() ) {
					the_excerpt();
				}else{
					$content = get_the_content();
					echo wpautop( strip_shortcodes( wp_trim_words( $content ) ) );
				}
				?></div>
			
			<div class="post-meta">
				<div class="read-more"><a href="<?php the_permalink(); ?>">read more</a></div>
				
				<p>Posted
					
					<?php if ( get_the_author() ) { ?>
						by <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a>
					<?php } ?>
					
					<?php if ( get_the_time() ) { ?>
						on <?php the_time( 'n/j/Y' ); ?>
					<?php } ?>
					
					<?php if ( has_category() ) : ?>
						| <span class="categories">Filed under: <?php the_category( ', ' ); ?></span>
						<?php endif; ?>
					
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