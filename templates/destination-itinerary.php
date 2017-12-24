<?php
/*
This template is loaded when viewing a "detailed itinerary" for a destination. Just add /itinerary/ to any destination URL.
The code that loads this template is in destinations-itinerary.php, see function "aa_itinerary_non_destination_redirect"
*/

$header_type = get_field( 'itinerary_use_custom_header' );
$content = get_field( 'itinerary_content' );
$sidebar_info = get_field( 'itinerary_additional_info' );

get_header();
?>
		<?php
		
		while ( have_posts() ) : the_post();
			
			?>
			<article>
				
				<?php
				
				if ( $header_type == 'destination' ) {
					
					if ( get_page_template_slug() == 'templates/flexible-content-fields.php' ) {
						
						// Use the first field from the flexible fields for the destination.
						$fields = get_field( 'content-areas' );
						foreach( $fields as $flex_key => $flex_field ) {
							
							echo '<div class="hero-section itinerary-hero-section-inherited">';
							get_template_part( '_template-parts/flexible-fields/_the_field');
							echo '</div>';
							
							break; // only the first field!
						}
						
					}else{
						
						// Use the hero field from the main destination
						get_template_part( '_template-parts/hero-section', 'single' );
						
					}
				
				}else if ( $header_type == 'custom' ) {
					
					// Use a custom hero section defined in the itinerary details
					get_template_part( '_template-parts/hero-section-itinerary' );
					
				}
				?>
				
				
				<div class="container">
					
					<div class="content-sidebar sidebar-itinerary sticky" data-sticky-for="1175" data-margin-top="<?php echo is_admin_bar_showing() ? (16+32) : 16; ?>">
						<div class="mobile-sidebar-button">
							<a href="#">View Details <span></span></a>
						</div>
						
						<div id="sidebar">
							<div id="itinerary-programs-widget" class="widget widget_text">
								<div class="textwidget"><?php
									// Display the itinerary list
									echo do_shortcode('[destination_programs]');
								?></div>
							</div>
						
							<?php
							if ( $sidebar_info ) {
								?>
								<div id="itinerary-additional-info-widget" class="widget widget_text">
									<h3>More Information</h3>
									<div class="textwidget"><?php echo $sidebar_info; ?></div>
								</div>
								<?php
							}
							?>
							
							<?php get_sidebar(); ?>
							
							<div id="itinerary-register-button-widget" class="widget widget_text">
								<h3>Are you ready?</h3>
								<div class="textwidget"><?php echo do_shortcode('[itinerary_registration_link]'); ?></div>
							</div>
						</div>
					</div>
					
					<div class="content-area">
						<?php echo $content; ?>
					</div>
					<!-- /.content-area -->
					
				</div> <!-- /.container -->
			
			</article>
			<!-- /#post-## -->
		<?php
		
		endwhile; // End of the loop.
		?>

<?php

get_footer();