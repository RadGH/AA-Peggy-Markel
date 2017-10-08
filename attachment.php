<?php
/**
 * Attachments Page
 *
 */
?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

	<?php echo wp_get_attachment_image( get_the_ID(), 'large' ); ?>

<?php endwhile; ?>
