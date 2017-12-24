<?php
if ( function_exists('dynamic_sidebar') ):
	if ( get_post_type() == 'destination' && get_query_var('itinerary') ) {
		dynamic_sidebar('Itinerary');
	}else{
		dynamic_sidebar('Sidebar');
	}
endif;