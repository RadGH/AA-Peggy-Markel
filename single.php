<?php
/**
 * Layout for pages and destinations
 */

if ( !have_posts() ) {
	get_template_part( '404' );
	return;
}

get_header();

// Hero section
get_template_part( '_template-parts/hero-section', 'single' );
?>

<div class="container">
    <?php

    while ( have_posts() ) : the_post();
	
	    ?>
	    <article>
		    
		    <?php
		    // Title can be replaced by a hero section
		    if ( empty(get_field( 'hero_toggle', $hero_object_id )) ) {
		    	?>
			    <header class="entry-header">
				    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			    </header>
			    <!-- .entry-header -->
			    <?php
		    }
		    ?>
		
		    <div class="entry-content">
			    <?php the_content(); ?>
		    </div>
		    <!-- /.entry-content -->
	
	    </article>
	    <!-- /#post-## -->
	    <?php
	
	    endwhile; // End of the loop.
    ?>
</div> <!-- /.container -->

<?php

get_footer();