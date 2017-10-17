<?php

if ( is_single() || is_singular() ) {
	
	?>
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
	<?php
	
}else{
	
	?>
	<nav class="pagination">
		<?php
		echo paginate_links( apply_filters( 'aa_pagination_args', array(
			'base'         => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
			'format'       => '',
			'add_args'     => false,
			'current'      => max( 1, get_query_var( 'paged' ) ),
			'prev_text'    => '&lsaquo;',
			'next_text'    => '&rsaqo;',
			'type'         => 'list',
			'end_size'     => 3,
			'mid_size'     => 3
		) ) );
		?>
	</nav>
	<?php
	
}