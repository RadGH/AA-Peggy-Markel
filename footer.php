        <div style="clear:both;"></div>

    </div><!--CONTAINER-->

</div><!--OUTER WRAPPER-->

<footer>
	
	<div class="container">
		<div class="grid grid-3-cols">
			<div class="columns four footer-col-left">
				<nav class="nav-menu footer-nav" role="navigation">
					<?php wp_nav_menu( array(
						'theme_location'  => 'footer',
						'menu' 			  => get_post_meta( get_the_ID(), 'meta_box_menu_name_set', true),
						'container'       => 'none',
						'container_class' => 'menu-header',
						'container_id'    => '',
						'menu_class'      => 'nav',
						'menu_id'         => 'main-nav',
						'echo'            => true,
						'fallback_cb'     => 'wp_page_menu',
						'before'          => '',
						'after'           => '',
						'link_before'     => '',
						'link_after'      => '',
						'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
						'depth'           => 3,
						'walker'		  => new theme_walker_nav_menu()
					) ); ?>
				</nav>
			</div>
			
			<div class="columns four footer-col-middle">
				<div id="credits" class="container">
					<img src="<?php echo get_template_directory_uri(); ?>/_static/images/logo-small.png" alt="Peggy Markel Logo"><br>
					&copy; <?php echo date('Y'); ?> Peggy Markel. All rights reserved.<br>
					Site Developed by <a href="http://www.alchemyandaim.com/" target="_blank">Alchemy + Aim</a>
				</div>
			</div>
			
			<div class="columns four footer-col-right">
				<div class="contact-footer">
					<p>Call us: <a href="tel:+18009882851" target="_blank">(800) 988-2851</a><br>
					   Email: <a href="mailto:info@peggymarkel.com" target="_blank">info@peggymarkel.com</a><br>
					   Join Our Mailing List
					</p>
				</div>
			</div>
		</div>
	</div>
	
</footer>

</div>

<?php wp_footer(); ?>

<?php //Google Analytics
	if(get_field('google_analytics_location', 'option') == "footer") {
    	echo get_field('google_analytics_code', 'option');
	}
?>

<?php //Custom Javascript
	$js = get_field('custom_javascript' ,'option');
	if( !empty($js) ): ?>
    	<script>
		(function($) {
        <?php echo $js; ?>
		})(jQuery);
    	</script>
<?php endif; ?>
</body>
</html>