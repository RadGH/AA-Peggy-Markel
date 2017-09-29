        <div style="clear:both;"></div>

    </div><!--CONTAINER-->

</div><!--OUTER WRAPPER-->

<footer>
	
	<div class="container">
		<div class="grid grid-3-cols">
			<div class="columns four footer-col-left">
				<?php
				if ( $menu = aa_get_nav_menu( 'footer' ) ) {
					?>
					<nav class="nav-menu footer-nav" role="navigation">
						<?php echo $menu; ?>
					</nav>
					<?php
				}
				?>
			</div>
			
			<div class="columns four footer-col-middle">
				<div id="credits" class="container">
					<img src="<?php echo get_template_directory_uri(); ?>/_static/images/logo-small.png" alt="Peggy Markel Logo"><br>
					&copy; <?php echo date('Y'); ?> Peggy Markel. All rights reserved.<br>
					Site Developed by <a href="http://www.alchemyandaim.com/" target="_blank">Alchemy + Aim</a>
				</div>
			</div>
			
			<div class="columns four footer-col-right">
				<div class="footer-contact">
					<p>Call us: <a href="tel:+18009882851" target="_blank">(800) 988-2851</a><br>
					   Email: <a href="mailto:info@peggymarkel.com" target="_blank">info@peggymarkel.com</a><br>
					   Join Our Mailing List
					</p>
				</div>
				
				<?php
				// Display social menu navigation
				if ( $social_menu_html = aa_get_social_navigation() ) {
					?>
					<div class="footer-social">
						<nav class="social-icons" role="navigation">
							<?php echo $social_menu_html; ?>
						</nav>
					</div>
					<?php
				}
				?>
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