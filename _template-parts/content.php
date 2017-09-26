<?php
/**
 * Template part for displaying posts.
 *
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="post-body entry-content">
    	<div class="featured blog"><?php the_post_thumbnail('featured-blog-post'); ?></div>	
        
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
    <?php the_content(); ?>
    <div class="tags"><?php if(has_tag()) : ?><?php the_tags('Tags: ', ', '); ?><?php endif; ?></div>
  </div>    

<div class="post-footer">
	<div class="share-buttons">
     <?php 
		$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
		$subject =  get_the_title();
		$body = get_permalink();
		$desc = get_the_excerpt();
		
	?>
       <div class="tshare"><a href="http://twitter.com/home?status=Currently reading: <?php the_title ();?><?php echo get_settings('home'); ?>/?p=<?php the_ID(); ?>" target="_blank"><i class="fa fa-twitter"></i> Twitter</a></div>
       
       <div class="fshare"><a href="https://www.facebook.com/dialog/feed?app_id=184683071273&link=<?php the_permalink() ?>&picture=<?php echo $feat_image; ?>&name=<?php echo the_title (); ?>&caption=%20&description=<?php echo $desc; ?>&redirect_uri=http%3A%2F%2Fwww.facebook.com%2F" target="_blank"><i class="fa fa-facebook"></i> Facebook</a></div>
       
       <div class="pshare"><a href="//www.pinterest.com/pin/create/button/?url=<?php the_permalink() ?>&media=<?php echo $feat_image; ?>&description=<?php the_title(); ?> - <?php echo $desc; ?>" data-pin-do="buttonBookmark" target="_blank" ><i class="fa fa-pinterest-p"></i> Pinterest</a></div>
       
       <div class="comment-link"><a href="<?php the_permalink(); ?>/#respond"><i class="fa fa-comment" aria-hidden="true"></i> Comment</a></div>
      
    </div>
</div>

<!--BEGIN AUTHOR BIO-->
		<div class='clearfix' id='about_author'>
			<?php echo get_avatar( get_the_author_meta('email'), '150' ); ?>
			<div class='author_text'>
				<h4>About <a href='<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>'><?php echo get_the_author_meta("first_name"); ?> <?php echo get_the_author_meta("last_name"); ?></a></h4>
				<p class="author-description"><?php the_author_meta('description'); ?></p>
				<div class='clear'></div>	
			</div>
		</div>
        	<!--END AUTHOR BIO-->

</div>

</article> <!--POST-->
