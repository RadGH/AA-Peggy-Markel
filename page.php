<?php
/**
 * Default Page Template
 */

if ( !have_posts() ) {
	get_template_part( '404' );
	return;
}

get_header();
?>

<div class="container">
    <?php
    while ( have_posts() ) : the_post();

	    get_template_part( 'loop', get_post_type() );

    endwhile; // End of the loop.
    ?>
</div> <!-- /.container -->

<?php get_footer(); ?>