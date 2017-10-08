<?php
/**
 * Author Page
 *
 */

get_header();
?>
<div class="container">
	<div class="center intro"><?php _e( 'You are currently viewing all posts published by <span style="text-transform:uppercase;"><strong>' . get_userdata( get_query_var( 'author' ) )->nickname . '</strong></span>.', 'theme' ); ?></div>
	
	<?php get_sidebar(); ?>
	
	<article>
		<div class="content-area">
			
			<?php get_template_part( 'loop', 'author' ); ?>
			
			<?php get_template_part( '_template-parts/part', 'navigation' ); ?>
		
		</div>
	</article>

</div>
<?php

get_footer();