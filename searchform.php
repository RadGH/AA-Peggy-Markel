<?php
global $sf_index;
if ( !isset($sf_index) ) $sf_index = 0;
$sf_index++;
?>
<form action="<?php echo esc_attr(site_url()); ?>" method="GET" class="search-form">
	<label for="header-search-input-<?php echo (int) $sf_index; ?>" class="screen-reader-text">Enter search terms:</label>
	<input type="search" name="s" id="header-search-input-<?php echo (int) $sf_index; ?>" placeholder="search" value="<?php if ( get_query_var('s') ) echo esc_attr(get_query_var('s')); ?>">
	<button type="submit">
		<i class="fa fa-search"></i>
		<span class="screen-reader-text">Search</span>
	</button>
</form>