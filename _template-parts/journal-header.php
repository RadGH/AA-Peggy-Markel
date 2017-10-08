<?php
$blog_page_id = get_option( 'page_for_posts' );
if ( !$blog_page_id ) return;

$title = get_field( 'journal_title', $blog_page_id );
$background = get_field( 'header_background', $blog_page_id );
?>

<?php aa_flexible_background_start( $background, array( 'journal-header' ) ); ?>

<h1 class="journal-title h2"><?php echo esc_html( $title ); ?></h1>

<?php aa_flexible_background_end(); ?>