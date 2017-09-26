<?php get_header(); ?>

<div class="section">
	<div class="container">

<?php while ( have_posts() ) : the_post(); ?>
 
	<h3><?php the_title(); ?> </h3>
 
 <?php 
    if ( has_post_thumbnail() ) {
      the_post_thumbnail();
    }
      the_content();
 ?>
 
 <?php 
	 $youtube_id = get_post_meta($post->ID, 'youtube_id', true );
	 if( get_post_meta($post->ID, 'youtube_id', true ) != '' ) {
		echo '<div class="video-container"><iframe width="640" height="360" src="http://www.youtube.com/embed/'. $youtube_id .'?rel=0&vq=hd360;3&amp;autohide=1&amp;&amp;showinfo=0" frameborder="0" allowfullscreen></iframe></div><br/>'; 
	} else {
		echo 'No YouTube ID';
	 }
?>

<?php endwhile; ?>

	</div>
</div>

<?php get_footer(); ?>