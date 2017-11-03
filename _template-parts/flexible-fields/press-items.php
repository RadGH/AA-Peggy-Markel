<?php
/* Flexible field: Press
 *
 * Displays title, subtitle, a block of text, and a list of press items.
 * When used on a destination page, only press items for that destination will be displayed.
 */

if ( !isset($flex_field) ) return; // This variable is passed through from "flexible-content-areas.php"

$args = array(
	'nopaging' => true,
	'post_type'=> 'press',
);

if ( get_post_type() == 'destination' ) {
	// When viewing a destination, only show press items for that destination.
	$args['meta_query'] = array(
		array(
			'key' => 'destination_id',
		    'value' => get_the_ID(),
		    'type' => 'NUMERIC'
		),
	);
}

$press_query = new WP_Query($args);

// Display some common data among the flexible fields
aa_flexible_field_title( $flex_field );
aa_flexible_field_subtitle( $flex_field );
aa_flexible_field_content( $flex_field );

// Display a grid of press items.
if ( $press_query->have_posts() ) {
	?>
	<div class="press-list grid grid-3-cols">
		<?php
		while( $press_query->have_posts() ): $press_query->the_post();
			$download_type = get_field( 'download_type' );
			
			if ( $download_type == 'Download a file' ) {
				$download_link = get_field( 'file' );
			}else{
				$download_link = get_field( 'link' );
			}
			?>
			<div <?php post_class('press-item cell'); ?>>
				
				<div class="item-inner">
				
					<?php if ( has_post_thumbnail() ) { ?>
					<div class="image">
						<a href="<?php echo esc_attr($download_link); ?>" title="Read more about <?php echo esc_attr(get_the_title()); ?>" target="_blank" rel="external" class="image-overlay-label">
							<?php aa_display_attachment_image_tag( get_post_thumbnail_id(), 'thumbnail' ); ?>
							<span class="overlay">View Entry</span>
						</a>
					</div>
					<?php } ?>
					
					<h4 class="title"><?php echo esc_html(get_the_title()); ?></h4>
					
					<div class="press-download">
						<?php if ( esc_url($download_link) ) { ?>
							<a href="<?php echo esc_attr($download_link); ?>" title="Read more about <?php echo esc_attr(get_the_title()); ?>" target="_blank" rel="external">Read More</a>
						<?php }else{ ?>
							<em>No download available</em>
						<?php } ?>
					</div>
					
				</div>
				
			</div>
			<?php
		
		endwhile;
		?>
	</div>
	<?php
}else{
	if ( isset($args['meta_query']) ) {
		echo '<p><em>No press items have been posted for this destination yet.</em></p>';
	}else{
		echo '<p><em>No press items have been posted yet.</em></p>';
	}
}