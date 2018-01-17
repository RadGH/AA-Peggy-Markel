<?php
/**
 * The template for displaying all single posts.
 */

if ( !have_posts() ) {
	get_template_part( '404' );
	return;
}

get_header();

// Blog post header
get_template_part( '_template-parts/hero-section', 'journal' );

?>
<div class="container">
	
	<div class="content-sidebar sidebar-archive sticky" data-sticky-for="1175" data-margin-top="<?php echo is_admin_bar_showing() ? (16+32) : 16; ?>">
		<div class="mobile-sidebar-button">
			<a href="#">Navigation <span></span></a>
		</div>
		
		<div id="sidebar">
			<?php get_sidebar(); ?>
		</div>
	</div>
	
	<article class="blog-container">
		<div class="content-area">
		
			<?php
		    while ( have_posts() ) : the_post();
		
		        get_template_part( 'loop', get_post_type() );
			
			    // aa_the_related_posts();
		
			    /*
		        // If comments are open or we have at least one comment, load up the comment template.
		        if ( comments_open() || get_comments_number() ) :
		            comments_template();
		        endif;
			    */
		
		    endwhile; // End of the loop.
			
			get_template_part( '_template-parts/part', 'navigation' );
		    ?>
		
		</div>
	</article>
	
</div>
<?php

get_footer();
