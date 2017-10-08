<div id="post-<?php the_ID(); ?>" <?php post_class( 'post clearfix' ); ?>>
	<div class="post-preview">
		<h2 class="post-title h5">
			<span class="pm-underline"><?php the_title(); ?></span>
		</h2>
		
		<?php the_post_thumbnail( 'blog-posts' ); ?>
		
		<?php the_excerpt(); ?>
		
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