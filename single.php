<?php
/**
 * The template for displaying all single posts.
 */

get_header();
?>
<div class="container">
<article class="blog-container">
<div class="content-area">

	<?php
    while ( have_posts() ) : the_post();

        get_template_part( '_template-parts/content', get_post_format() );
		
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
		

        get_template_part( '_template-parts/part', 'navigation' );

        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;

    endwhile; // End of the loop.
    ?>

</div>
</article>
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
