<?php

// Admin Footer Modification.
function remove_footer_admin ()
{
    echo '<style type="text/css">
		/*#wpfooter{ background-color:#000000; padding-left:25px; padding-right:25px; margin-left:146px;}*/#footer-upgrade:before{content:"CMS ";}
		</style> 
		<span id="footer-thankyou">Developed by<a href="http://alchemyandaim.com/" target="_blank"><span style="font-style:normal;margin-left:5px;"><span class="icon"><img src="http://alchemyandaim.com/wp-content/themes/brandibernoskie2014/images/favicon.png" alt="" /></span> Alchemy + Aim</span></span></a>';
	
}
add_filter('admin_footer_text', 'remove_footer_admin');

?>