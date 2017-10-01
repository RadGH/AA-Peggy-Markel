<?php
/* Flexible field: Testimonials
 *
 * Displays title, subtitle, and a slider of testimonials.
 */

if ( !isset($flex_field) ) return; // This variable is passed through from "flexible-content-areas.php"

// Display some common data among the flexible fields
aa_flexible_field_title( $flex_field );
aa_flexible_field_subtitle( $flex_field );

$staff = !empty($flex_field['staff_list']) ? $flex_field['staff_list'] : false;
if ( $staff ) {
	?>
	<div class="staff-list">
		<?php
		foreach( $staff as $s ) {
			$picture = $s['picture'];
			$name = $s['name'];
			$title = $s['title'];
			$biography = $s['biography'];
			?>
			<div class="staff-member">
				<?php if ( $picture ) { ?>
				<div class="photo">
					<?php echo wp_get_attachment_image( $picture, 'flex-field-staff-photo' ); ?>
				</div>
				<?php } ?>
				
				<div class="ff-content">
					<h4 class="name"><?php echo esc_html($name); ?></h4>
					<h5 class="author"><?php echo esc_html($title); ?></h5>
					<div class="biography"><?php echo wpautop($biography); ?></div>
				</div>
			</div>
			<?php
		}
		?>
	</div>
	<?php
}