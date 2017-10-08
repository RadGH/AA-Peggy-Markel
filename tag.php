<?php
/**
 * Tags Page
 * 
 */

get_header();
?>

<div class="container">
<div class="intro center"><?php _e( 'You are currently viewing all posts tagged with <span style="text-transform:uppercase;"><strong>' . single_tag_title('', false) . '</strong></span>.', 'theme' ); ?></div>

<article>
	<div class="content-area">
    
		<?php get_template_part( 'loop', 'tag' ); ?>

		<?php  get_template_part( '_template-parts/part', 'navigation' ); ?>

	</div>
</article>

<?php get_sidebar(); ?>
</div>
<?php

get_footer();
