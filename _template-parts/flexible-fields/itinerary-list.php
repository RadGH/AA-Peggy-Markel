<?php
/* Flexible field: Itinerary List
 *
 * Displays title, subtitle, and list of itinerary day plans.
 */

if ( !isset($flex_field) ) return; // This variable is passed through from "flexible-content-areas.php"

// Add the [itinerary_form] shortcode to form content, if not already present:
if ( stripos($flex_field['content'], '[itinerary_form]') === false ) {
	$flex_field['content'] .= "\n\n[itinerary_form]";
}

?>
<div id="itinerary">
	<?php

	// Display some common data among the flexible fields
	aa_flexible_field_title( $flex_field );
	aa_flexible_field_subtitle( $flex_field );
	aa_flexible_field_content( $flex_field );
	
	// Display the itinerary list
	$days = !empty($flex_field['itinerary_log']) ? $flex_field['itinerary_log'] : false;
	if ( $days ) {
		?>
		<div class="itinerary-list">
			<h3 class="itinerary-list-title h3 ff-subtitle"><span class="pm-underline">Day By Day Overview</span></h3>
			
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
			
			<div class="itinerary-link ff-content">
				<h4 class="h4">Ready to get started?</h4>
				<p><a href="#itinerary" class="ff-button">Sign up to receive a detailed itinerary</a></p>
			</div>
		</div>
		<?php
	}
?>
</div>
