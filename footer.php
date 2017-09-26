        <div style="clear:both;"></div>

    </div><!--CONTAINER-->

</div><!--OUTER WRAPPER-->

<footer>
	<div id="credits" class="container">
		<div class="footer-left u-pull-left"><?php if(is_active_sidebar('footer_left')) dynamic_sidebar('footer_left'); ?></div>
		<div class="footer-right u-pull-right">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?> | Site Developed by <a href="http://www.alchemyandaim.com/" target="_blank">Alchemy + Aim</a></div>
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