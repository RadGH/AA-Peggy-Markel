<?php
/**
 * Archives Page
 */

if ( !have_posts() ) {
	get_template_part( '404' );
	return;
}

get_header();

if ( !is_search() && (is_home() || is_post_type_archive('post') || is_tax('category') || is_category()) ) {
	get_template_part( '_template-parts/hero-section', 'journal' );
}
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

	<div class="content-area">
		
		<?php
		while ( have_posts() ) : the_post();
			
			get_template_part( 'loop', 'archive' );
		
		endwhile; // End of the loop.
		
		get_template_part( '_template-parts/part', 'navigation' );
		?>
	
	</div>

</div>
<?php

get_footer();