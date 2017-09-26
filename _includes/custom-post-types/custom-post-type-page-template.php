<?php
/*---------------------------------------------------------
	Template Name: CUSTOM POST TYPE PAGE TEMPLATE 
------------------------------------------------------------*/

get_header(); ?>

<div class="section">
	<div class="container">

<?php
 $query = new WP_Query( array('post_type' => 'videos', 'posts_per_page' => 5 ) );
 if ( have_posts() ) while ( $query->have_posts() ) : $query->the_post(); ?>
 
	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
 
 <?php 
    if ( has_post_thumbnail() ) {
      the_post_thumbnail();
    } ?>
      <p><?php excerpt('excerptlength_post', 'excerptmore'); ?></p>  

<?php wp_reset_postdata(); ?>
<?php endwhile; ?>

	</div>
</div>

<?php get_footer(); ?>