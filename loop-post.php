<div id="post-<?php the_ID(); ?>" <?php post_class( 'post clearfix' ); ?>>
	<div class="post-preview">
		<h2 class="post-title h5">
			<span class="pm-underline"><?php the_title(); ?></span>
		</h2>
		
		<div class="post-thumbnail"><?php the_post_thumbnail( 'blog-posts' ); ?></div>
		
		<div class="post-excerpt"><?php the_content(); ?></div>
		
		<div class="post-meta">
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