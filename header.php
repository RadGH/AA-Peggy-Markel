<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="initial-scale=1.0001, minimum-scale=1.0001, maximum-scale=1.0001, user-scalable=no"/>

	<title><?php wp_title('|',1,'right'); ?></title>
    
    <!-- Enqueue custom browser-detect for browser-targeted CSS styling -->
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/_static/js/browser-detect.js"></script>

	<!-- Theme Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Crimson+Text:400,400i|EB+Garamond|Karla" rel="stylesheet">
	
    <!-- Style Sheets -->
	<link rel="stylesheet" href="https://necolas.github.io/normalize.css/3.0.2/normalize.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />

    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    
    <!-- For use with browser-detect.js -->
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/_static/styles/browser-specific-styles.css" />

	<!--
	This second stylesheet is for hotfixes/vanilla CSS,
	and should only be used if you are not compiling the Sass files -->
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/vanilla-style.css">

    <!-- Load FontAwesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Load Flickity -->
	<?php /*
    <link rel="stylesheet" href="<?php echo esc_attr(get_template_directory_uri()); ?>/_static/js/flickity/flickity.css">
	<script src="<?php echo esc_attr(get_template_directory_uri()); ?>/_static/js/flickity/flickity.pkgd.min.js"></script>
    */ ?>
	<link rel="stylesheet" href="//unpkg.com/flickity@2/dist/flickity.min.css">
	<script src="//unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>

    <!-- Load Photoswipe (Lightbox) -->
	<link rel="stylesheet" href="<?php echo esc_attr(get_template_directory_uri()); ?>/_static/js/photoswipe/photoswipe.css">
	<link rel="stylesheet" href="<?php echo esc_attr(get_template_directory_uri()); ?>/_static/js/photoswipe/default-skin/default-skin.css">
	<script src="<?php echo esc_attr(get_template_directory_uri()); ?>/_static/js/photoswipe/photoswipe.min.js"></script>
	<script src="<?php echo esc_attr(get_template_directory_uri()); ?>/_static/js/photoswipe/photoswipe-ui-default.min.js"></script>
	
	<?php //Custom CSS
		$css = get_field('custom_css' ,'option');
		if( !empty($css) ): ?>
		<style>
	    <?php echo $css; ?>
		</style>
		<?php endif;
	?>

    <!-- Legacy IE Support For HTML5 Tags -->
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

     <!-- Modernizr -->
	 <script type="text/javascript" src="https://daks2k3a4ib2z.cloudfront.net/0globals/modernizr-2.7.1.js"></script>
    

    <!-- Favicon -->
    <?php $image = get_field('site_favicon', 'option');
		if( !empty($image) ): ?>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $image['url']; ?>" />
    	<?php else: ?>
    <link rel="shortcut icon" type="image/x-icon" href="http://alchemyandaim.com/wp-content/uploads/2016/06/favicon.png" />
	<?php endif; ?>

	<?php //Apple Touch Icons
		$iphone = get_field('iphone', 'option');
		if( !empty($iphone) ): ?>
	        <!-- For non-Retina iPhone, iPod Touch, and Android 2.1+ devices: -->
	        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo $iphone['url']; ?>">
	<?php endif;
    	$iphone_retina = get_field('iphone_retina', 'option');
		if( !empty($iphone_retina) ): ?>
	        <!-- For iPhone with high-resolution Retina display: -->
	        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $iphone_retina['url']; ?>">
	<?php endif;
    $ipad = get_field('ipad', 'option');
		if( !empty($ipad) ): ?>
	        <!-- For first- and second-generation iPad: -->
	        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $ipad['url']; ?>">
	<?php endif;
    $ipad_retina = get_field('ipad_retina', 'option');
		if( !empty($ipad_retina) ): ?>
	        <!-- For third-generation iPad with high-resolution Retina display: -->
	        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $ipad_retina['url']; ?>">
	<?php endif; ?>

    <?php //Google Analytics
		if(get_field('google_analytics_location', 'option') == "header"):
			echo get_field('google_analytics_code', 'option');
		endif;
	?>

	<?php if ( is_singular() ) { wp_enqueue_script( 'comment-reply' ); } ?>

	<?php wp_enqueue_script("jquery"); ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div class="animsition">
	
	<div id="outer-wrapper">
		
		
		<!-- Begin Header -->
		<header>
			<div id="header-bar">
				<div class="container">
					<div class="left">
						<form action="<?php echo esc_attr(site_url()); ?>" method="GET" class="header-search">
							<label for="header-search-input" class="screen-reader-text">Enter search terms:</label>
							<input type="search" name="s" id="header-search-input" placeholder="search" value="<?php if ( get_query_var('s') ) echo esc_attr(get_query_var('s')); ?>">
							<button type="submit">
								<i class="fa fa-search"></i>
								<span class="screen-reader-text">Search</span>
							</button>
						</form>
					</div>
					
					<?php
					// Display social menu navigation
					if ( $social_menu_html = aa_get_social_navigation() ) {
					?>
					<div class="right">
						<nav class="social-icons" role="navigation">
							<?php echo $social_menu_html; ?>
						</nav>
					</div>
					<?php
					}
					?>
				</div>
			</div>
			<div id="header-wrapper">
				<div class="header-inner container">
					
					<!-- Begin Header -->
					<div id="linkbar" class="nav-bar">
						<nav id="menu" class="nav-menu" role="navigation">
							<?php
							if ( $menu = aa_get_nav_menu( 'primary_left' ) ) {
								?>
								<div class="left header-nav">
									<?php echo $menu; ?>
								</div>
								<?php
							}
							?>
							
							<?php
							$image = get_field( 'site_header_logo', 'option' );
							if ( !empty( $image ) ) {
								?>
								<div class="center nav-logo">
									<a href="<?php echo home_url(); ?>" target="_self"><img src="<?php echo $image['url']; ?>" alt="<?php bloginfo( 'name' ); ?>" /></a>
								</div>
								<?php
							}
							?>
							
							<?php
							if ( $menu = aa_get_nav_menu( 'primary_right' ) ) {
								?>
								<div class="right header-nav">
									<?php echo $menu; ?>
								</div>
								<?php
							}
							?>
						</nav>
						<a href="#" id="slideout-trigger">
							<div id="slideout-bar"></div>
						</a>
					</div>
				</div>
			</div><!--HEADER WRAPPER-->
		</header>
		
		<div id="slideout-menu">
			<nav id="slideout-nav">
				<h2 class="menu-title">Menu</h2>
				
				<?php wp_nav_menu( array( 'theme_location' => 'mobile' ) ); ?>
				
				<?php
				// Display social menu navigation
				if ( $social_menu_html = aa_get_social_navigation() ) {
					?>
					<div class="right">
						<nav class="social-icons" role="navigation">
							<?php echo $social_menu_html; ?>
						</nav>
					</div>
					<?php
				}
				?>
				
				<a href="#" id="nav-close">
					<div class="close-lines1"></div>
					<div class="close-lines2"></div>
				</a>
			</nav>
		</div>
		
		<div id="content-wrapper">