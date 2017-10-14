<?php
// Allow the ID for the hero section to be overridden in a template (used by hero-section-shop.php)
if ( !isset($hero_object_id) ) {
	$hero_object_id = get_the_ID();
}

if ( !$hero_object_id ) return;

// Checkbox must be ticked
if ( empty(get_field( 'hero_toggle', $hero_object_id )) ) return;

// Fields from the hero metabox
$title = get_field( 'hero_title', $hero_object_id );
$description = get_field( 'hero_description', $hero_object_id );
$background = get_field( 'hero_background', $hero_object_id );
?>
<div class="ff hero-section hero-section-default content_align-center content_width-narrow">
	
	<?php aa_flexible_background_start( $background, array( 'journal-header' ) ); ?>
	
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