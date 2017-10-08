<?php

// For some reason the blog doesn't route through archive.php and skips to index.php. Let's fix that.
if ( file_exists( get_template_directory() . '/archive.php' ) ) {
	// Load archive-post.php or fall back to archive.php
	get_template_part( 'archive', 'post' );
}else{
	// No archive template, go to index.php
	get_template_part( 'index' );
}