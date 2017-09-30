<?php
/* Flexible field: Text Column(s)
 *
 * Displays title, subtitle, a multiple columns of text.
 */

if ( !isset($flex_field) ) return; // This variable is passed through from "flexible-content-areas.php"

// Display some common data among the flexible fields
aa_flexible_field_title( $flex_field );
aa_flexible_field_subtitle( $flex_field );

$columns = !empty($flex_field['columns']) ? (array) $flex_field['columns'] : false;

if ( $columns ) {
	$column_count = count($columns);
	if ( $column_count > 4 ) $column_count = 4;
	?>
	<div class="ff-columns grid grid-<?php echo esc_attr($column_count); ?>-cols">
		<?php
		foreach( $columns as $i => $column_field ) {
			?>
			<div class="cell cell-<?php echo esc_attr($i); ?>">
				<?php
				aa_flexible_field_title( $column_field, 'title', 'h4' );
				aa_flexible_field_content( $column_field );
				aa_flexible_field_button( $column_field );
				?>
			</div>
			<?php
		}
		?>
	</div>
	<?php
}