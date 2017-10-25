        <div style="clear:both;"></div>

    </div><!--CONTAINER-->

</div><!--OUTER WRAPPER-->

<footer>
	
	<div class="container">
		<div class="grid grid-3-cols">
			<div class="cell footer-col-left">
				<?php
				if ( $menu = aa_get_nav_menu( 'footer' ) ) {
					?>
					<nav class="nav-menu footer-nav">
						<?php echo $menu; ?>
					</nav>
					<?php
				}
				?>
			</div>
			
			<div class="cell footer-col-middle">
				<div id="credits" class="container">
					<?php
					// Footer Logo
					if ( $footer_logo = get_field( 'footer_logo', 'options', false ) ) {
						echo wp_get_attachment_image( $footer_logo, 'full' );
						echo '<br>';
					}
					
					// Copyright Text -- (c) Peggy Markel 2017
					if ( $footer_copyright_text = get_field( 'footer_copyright_text', 'options', false ) ) {
						$footer_copyright_text = str_ireplace( '[year]', date('Y'), $footer_copyright_text );
						echo nl2br(esc_html($footer_copyright_text));
						echo '<br>';
					}
					
					// Un-editable By-Lines
					echo 'Site Designed by <a href="http://thedenizenco.com/" target="_blank">The Denizen Co</a>.<br>';
					echo 'Site Developed by <a href="http://www.alchemyandaim.com/" target="_blank">Alchemy + Aim</a>.';
					?>
				</div>
			</div>
			
			<div class="cell footer-col-right">
				<div class="footer-contact">
					<?php
					if ( $footer_contact_text = get_field( 'footer_contact_text', 'options', false ) ) {
						echo wpautop($footer_contact_text);
					}
					?>
				</div>
				
				<?php
				// Display social menu navigation
				if ( $social_menu_html = aa_get_social_navigation() ) {
					?>
					<div class="footer-social">
						<nav class="social-icons">
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

<!-- Load Flickity JS -->
<script src="//unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>

<!-- Load Swipebox JS -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.swipebox/1.4.4/js/jquery.swipebox.min.js"></script>

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