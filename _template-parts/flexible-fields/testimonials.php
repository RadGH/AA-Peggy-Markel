<?php
/* Flexible field: Testimonials
 *
 * Displays title, subtitle, and a slider of testimonials.
 */

if ( !isset($flex_field) ) return; // This variable is passed through from "flexible-content-areas.php"

// Display some common data among the flexible fields
aa_flexible_field_title( $flex_field );
aa_flexible_field_subtitle( $flex_field );

$testimonials = !empty($flex_field['testimonial_list']) ? $flex_field['testimonial_list'] : false;
if ( $testimonials ) {
	?>
	<div class="testimonial-list" data-flickity='{ "wrapAround": true, "prevNextButtons": false, "pageDots": true, "autoPlay": 5000 }'>
		<?php
		foreach( $testimonials as $t ) {
			$message = '&ldquo;' . $t['message'] . '&rdquo;';
			$author = $t['author'];
			?>
			<div class="testimonial-item">
				<div class="message"><?php echo wpautop($message); ?></div>
				<div class="author">&ndash; <?php echo esc_html($author); ?></div>
			</div>
			<?php
		}
		?>
	</div>
	<?php
}