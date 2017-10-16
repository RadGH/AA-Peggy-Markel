<?php
/* Flexible field: Itinerary List
 *
 * Displays title, subtitle, and list of itinerary day plans.
 */

if ( !isset($flex_field) ) return; // This variable is passed through from "flexible-content-areas.php"

// Display some common data among the flexible fields
aa_flexible_field_title( $flex_field );
aa_flexible_field_subtitle( $flex_field );
aa_flexible_field_content( $flex_field );

$days = !empty($flex_field['itinerary_log']) ? $flex_field['itinerary_log'] : false;
if ( $days ) {
	?>
	<div class="itinerary-list">
		<?php
		$i = 1;
		foreach( $days as $d ) {
			$day_label = $d['day'];
			$description = $d['description'];
			
			if ( empty($day_label) ) {
				$day_label = "Day " . $i;
				$i++;
			}
			?>
			<div class="day">
				<div class="day-label"><?php echo esc_html($day_label); ?></div>
				
				<div class="day-description"><?php echo wpautop($description); ?></div>
			</div>
			<?php
		}
		?>
	</div>
	<?php
}