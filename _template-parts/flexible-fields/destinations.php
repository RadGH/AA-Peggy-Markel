<?php
/* Flexible field: Destinations
 *
 * Displays title, subtitle, a block of text, and a list of destinations.
 */

if ( !isset($flex_field) ) return; // This variable is passed through from "flexible-content-areas.php"

$args = array(
	'nopaging' => true,
	'post_type'=> 'destination',
);

$dest_query = new WP_Query($args);

// Display some common data among the flexible fields
aa_flexible_field_title( $flex_field );
aa_flexible_field_subtitle( $flex_field );
aa_flexible_field_content( $flex_field );

// Display a grid of destination items.
if ( $dest_query->have_posts() ) {
	?>
	<div class="destinations-list grid grid-3-cols">
		<?php
		while( $dest_query->have_posts() ): $dest_query->the_post();
			$date_range = aa_destination_next_date();
			?>
			<div <?php post_class('destination-item cell'); ?>>
				
				<?php
				if ( has_post_thumbnail() ) {
					?>
					<div class="image">
						<a href="<?php echo esc_attr(get_permalink()); ?>" class="image-overlay-label">
							<?php aa_display_attachment_image_tag( get_post_thumbnail_id(), 'thumbnail' ); ?>
							<span class="overlay">Experience <?php the_title(); ?></span>
						</a>
					</div>
					<?php
				}
				?>
				
				<h4 class="title">
					<a href="<?php echo esc_attr(get_permalink()); ?>" title="Read more about <?php echo esc_attr(get_the_title()); ?>"><span class="pm-underline"><?php echo esc_html(get_the_title()); ?></span></a>
				</h4>
				
				<?php if ( $date_range ) { ?>
				<div class="date"><?php echo esc_html($date_range); ?></div>
				<?php } ?>
				
			</div>
			<?php
		
		endwhile;
		?>
	</div>
	<?php
}else{
	echo '<p><em>No destinations have been posted yet.</em></p>';
}