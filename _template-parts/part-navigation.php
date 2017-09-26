<div id="navigation">
	<?php if (is_single()) : ?>

		<div id="pagination">
			<div class="nav-older"><?php previous_post_link('%link', 'Previous Post') ?></div>
			<div class="nav-newer"><?php next_post_link('%link', 'Next Post') ?></div>
			<div style="clear:both;"></div>
		</div>

	<?php else : ?>

		<div id="pagination">
			<div class="nav-older"><?php next_posts_link('Older Posts') ?></div>
			<div class="nav-newer"><?php previous_posts_link('Newer Posts') ?></div>
			<div style="clear:both;"></div>
		</div>

	<?php endif; ?>
</div>