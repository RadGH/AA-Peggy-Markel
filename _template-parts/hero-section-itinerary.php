<?php
$header = get_field('itinerary_header');
$title = isset($header['title']) ? $header['title'] : false;
$description = isset($header['description']) ? $header['description'] : false;
$background = isset($header['background']) ? $header['background'] : false;
?>
<div class="ff hero-section hero-section-default content_align-center content_width-narrow">
	
	<?php aa_flexible_background_start( $background, array( 'itinerary-header' ) ); ?>
	
	<div class="container">
		
		<?php
		// Display the hero title in an <h1>, unless we already used an h1 elsewhere.
		if ( $title ) {
			if ( !did_action( 'flexible-field-h1' ) ) {
				echo '<h1 class="hero-title h2">', esc_html( $title ), '</h1>';
				do_action( 'flexible-field-h1' );
			}else{
				echo '<h2 class="hero-title h2">', esc_html( $title ), '</h2>';
			}
		}
		?>
		
		<?php if ( $description ) { ?>
			<div class="hero-intro">
				
				<div class="hero-content"><?php echo wpautop($description); ?></div>
			
			</div>
		<?php } ?>
	
	</div>
	
	<?php aa_flexible_background_end(); ?>

</div>