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
					<nav class="nav-menu footer-nav" role="navigation">
						<?php echo $menu; ?>
					</nav>
					<?php
				}
				?>
			</div>
			
			<div class="cell footer-col-middle">
				<div id="credits" class="container">
					<img src="<?php echo get_template_directory_uri(); ?>/_static/images/logo-small.png" alt="Peggy Markel Logo"><br>
					&copy; <?php echo date('Y'); ?> Peggy Markel. All rights reserved.<br>
					Site Developed by <a href="http://www.alchemyandaim.com/" target="_blank">Alchemy + Aim</a>.
				</div>
			</div>
			
			<div class="cell footer-col-right">
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

<?php // Photoswipe element ?>
<!-- Root element of PhotoSwipe. Must have class pswp. -->
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

    <!-- Background of PhotoSwipe.
		 It's a separate element as animating opacity is faster than rgba(). -->
    <div class="pswp__bg"></div>

    <!-- Slides wrapper with overflow:hidden. -->
    <div class="pswp__scroll-wrap">

        <!-- Container that holds slides.
			PhotoSwipe keeps only 3 of them in the DOM to save memory.
			Don't modify these 3 pswp__item elements, data is added later on. -->
        <div class="pswp__container">
	        <div class="pswp__item"></div>
	        <div class="pswp__item"></div>
	        <div class="pswp__item"></div>
        </div>

        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
        <div class="pswp__ui pswp__ui--hidden">
	
	        <div class="pswp__top-bar">
		
		        <!--  Controls are self-explanatory. Order can be changed. -->
		
		        <div class="pswp__counter"></div>
		
		        <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
		
		        <button class="pswp__button pswp__button--share" title="Share"></button>
		
		        <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
		
		        <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
		
		        <!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
		        <!-- element will get class pswp__preloader--active when preloader is running -->
		        <div class="pswp__preloader">
			        <div class="pswp__preloader__icn">
				        <div class="pswp__preloader__cut">
					        <div class="pswp__preloader__donut"></div>
				        </div>
			        </div>
		        </div>
	        </div>
	
	        <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
		        <div class="pswp__share-tooltip"></div>
	        </div>
	
	        <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
	        </button>
	
	        <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
	        </button>
	
	        <div class="pswp__caption">
		        <div class="pswp__caption__center"></div>
	        </div>

        </div>

    </div>

</div>
</body>
</html>