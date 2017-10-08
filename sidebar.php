<div class="sidebar aside">
	<div class="mobile-sidebar-button">
		<a href="#">Navigation <span></span></a>
	</div>
	<div id="sidebar">
		<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar')) : ?><?php endif; ?>
	</div>
</div>