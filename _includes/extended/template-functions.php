<?php

function aa_get_nav_menu( $menu_id ) {
	if ( !has_nav_menu($menu_id) ) return false;
	
	ob_start();
	
	wp_nav_menu( array(
		'theme_location'  => $menu_id,
		'menu' 			  => get_post_meta( get_the_ID(), 'meta_box_menu_name_set', true),
		'container'       => 'none',
		'container_class' => 'menu-' . $menu_id,
		'container_id'    => '',
		'menu_class'      => 'nav',
		'menu_id'         => $menu_id . '-nav',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '<span>',
		'link_after'      => '</span>',
		'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
		'depth'           => 3,
		'walker'		  => new theme_walker_nav_menu()
	) );
	
	return ob_get_clean();
}

/**
 * Returns the HTML for a social navigation menu, using font awesome icons. The icons can be configured in Theme Settings > Social.
 * If no social icons are enabled, returns false.
 *
 * @return bool|string
 */
function aa_get_social_navigation() {
	$social_links = get_field( 'social_links', 'options' );
	if ( !$social_links ) return false;
	
	ob_start();
	?>
	<ul class="social-menu">
		<?php
		foreach( $social_links as $l ) {
			$icon = $l['social_media_icon'];
			$url = $l['social_link'];
			if ( empty($url) ) continue;
			
			// Remove the "fa-" prefix, and suffixes like "-alt"  or "-square", and one-letter suffixes like "-p" like in "fa-pinterest-p". Then capitalize the word.
			$network_name = str_replace( 'fa-', '', $icon );
			$network_name = preg_replace('/-(alt|square|circle|[a-zA-Z])$/', '', $network_name);
			$network_name = ucwords($network_name);
			
			?>
			<li class="social-menu-item">
				<a href="<?php echo esc_attr($url); ?>" title="Visit us on <?php echo esc_attr($network_name); ?>" target="_blank">
					<i class="fa <?php echo esc_attr($icon); ?>"></i>
					<span class="screen-reader-text">Visit us on <?php echo esc_html($network_name); ?></span>
				</a>
			</li>
			<?php
		}
		?>
	</ul>
	<?php
	return ob_get_clean();
}

/**
 * Returns a link to pin an image, including the full size source image, alt text, and a link to the page it was referenced on.
 *
 * @param $image_id
 * @param $page_url
 *
 * @return bool|string
 */
function aa_get_pinit_url( $image_id = null, $page_url = null ) {
	if ( $image_id === null ) $image_id = get_post_thumbnail_id();
	if ( !$image_id ) return false;
	
	if ( $page_url === null ) $page_url = get_permalink();
	
	$image_id = get_post_thumbnail_id();
	$image_full = wp_get_attachment_image_src( $image_id, 'full' );
	$image_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
	if ( !$image_alt ) $image_alt = get_the_title( $image_id );
	
	$args = array(
		'url' => urlencode( get_permalink() ),
		'media' => urlencode( $image_full[0] ),
		'description' => urlencode( $image_alt )
	);
	
	return add_query_arg( $args, 'https://pinterest.com/pin/create/button/' );
}

/**
 * Displays related posts for the current post of the loop.
 */
function aa_the_related_posts() {
	global $post;
	$orig_post = $post;
	global $post;
	$categories = get_the_category($post->ID);
	if ($categories) {
		$category_ids = array();
		foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
		$args=array(
			'category__in' => $category_ids,
			'post__not_in' => array($post->ID),
			'posts_per_page'=> 3, // Number of related posts that will be shown.
			'caller_get_posts'=>1
		);
		$my_query = new wp_query( $args );
		if( $my_query->have_posts() ) {
			echo '<div id="related_posts"><h3>Related Posts</h3><ul>';
			while( $my_query->have_posts() ) {
				$my_query->the_post();?>
				<li>
					<div class="relatedthumb"><a href="<? the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>">
							<?php the_post_thumbnail('related-blog-posts'); ?>
						</a></div>
					<div class="relatedcontent">
						<h3><a href="<? the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>">
								<?php the_title(); ?>
							</a></h3>
						<div class="post-meta post-date">
							<?php the_time('F j') ?>
						</div>
					</div>
				</li>
				<?
			}
			echo '</ul></div>';
		}
	}
	$post = $orig_post;
	wp_reset_query();
}