<?php
/* Flexible field: Text
 *
 * Displays title, subtitle, a block of text, and a button. All of these are optional.
 */

if ( !isset($flex_field) ) return; // This variable is passed through from "flexible-content-areas.php"

$args = array(
	'nopaging' => true,
	'post_type'=> 'destination',
);

$dest_query = new WP_Query($args);

aa_flexible_field_title( $flex_field );
aa_flexible_field_subtitle( $flex_field );
aa_flexible_field_content( $flex_field );

if ( $dest_query->have_posts() ) {
	?>
	<div class="destinations-list grid grid-3-cols">
		<?php
		while( $dest_query->have_posts() ): $dest_query->the_post();
			$date_range = aa_destination_date_range();
			?>
			<div <?php post_class('destination-item columns one-third'); ?>>
				
				<?php
				if ( has_post_thumbnail() ) {
					$image_id = get_post_thumbnail_id();
					$image_full = wp_get_attachment_image_src( $image_id, 'full' );
					$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
					if ( !$image_alt ) $image_alt = get_the_title( $image_id );
					
					$pinit_url = add_query_arg( array(
						'url' => urlencode( get_permalink() ),
					    'media' => urlencode( $image_full[0] ),
					    'description' => urlencode( $image_alt )
					), 'https://pinterest.com/pin/create/button/' );
					?>
					<div class="image">
						<a href="<?php echo esc_attr($pinit_url); ?>" class="pin-it" target="_blank" rel="external">
							<?php the_post_thumbnail( get_the_ID(), 'thumbnail' ); ?>
							<span class="pin-it-label">Pin It</span>
						</a>
					</div>
					<?php
				}
				?>
				
				<h4 class="title"><a href="<?php echo esc_attr(get_permalink()); ?>" title="Read more about <?php echo esc_attr(get_the_title()); ?>"><?php echo esc_html(get_the_title()); ?></a></h4>
				
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