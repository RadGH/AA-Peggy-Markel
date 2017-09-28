<?php
/* Flexible field: Text
 *
 * Displays title, subtitle, a block of text, and a button. All of these are optional.
 */

if ( !isset($flex_field) ) return; // This variable is passed through from "flexible-content-areas.php"

$args = array(
	'nopaging' => true,
	'post_type'=> 'press',
);

$dest_query = new WP_Query($args);

aa_flexible_field_title( $flex_field );
aa_flexible_field_subtitle( $flex_field );
aa_flexible_field_content( $flex_field );

if ( $dest_query->have_posts() ) {
	?>
	<div class="press-list grid grid-3-cols">
		<?php
		while( $dest_query->have_posts() ): $dest_query->the_post();
			$date_range = get_field( 'date_range' );
			?>
			<div class="press-item columns four columns <?php post_class(); ?>">
				
				<?php if ( has_post_thumbnail() ) { ?>
				<div class="image">
					<?php the_post_thumbnail( get_the_ID(), 'thumbnail' ); ?>
				</div>
				<?php } ?>
				
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