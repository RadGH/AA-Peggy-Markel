<?php
/**
 * The template for displaying all single posts.
 */

if ( !have_posts() ) {
	get_template_part( '404' );
	return;
}

get_header();
?>
<div class="container">
<article class="blog-container">
<div class="content-area">

	<?php
    while ( have_posts() ) : the_post();

        get_template_part( 'loop', get_post_type() );
	
	    aa_the_related_posts();

        get_template_part( '_template-parts/part', 'navigation' );

        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;

    endwhile; // End of the loop.
    ?>

</div>
</article>
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
