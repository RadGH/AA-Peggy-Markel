<?php
/**
 * Comments Template
 *
 */

// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
die ('Please do not load this page directly. Thanks!');

if ( post_password_required() ) { ?>
	<p class="center"><?php _e("This post is password protected. Enter the password to view comments."); ?></p>
	<?php return;
} /* You can start editing below. */ ?>

<div id="comments">

	<h4>
    <?php comments_number('0 comments to', '1 comment to', '% comments to' );?>
    "
    <?php the_title(); ?>
    "</h4>
	<?php if ( have_comments() ) { ?>
		<ul class="comment-block" id="comment-block">
			<?php wp_list_comments('callback=commentlist'); ?>
		</ul>
	<?php } ?>

	<!-- Comment Form -->
	<?php if ('open' == $post-> comment_status) : ?>

		<div id="respond">

			<h4 class="comments-headers"><?php comment_form_title('Leave a Comment', 'Leave a Reply to %s'); ?> <span id="cancel-comment-reply"><?php cancel_comment_reply_link('(cancel)') ?></span></h4>

			<?php if ( get_option('comment_registration') && !$user_ID ) : ?>

				<p class="unstyled">You must <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>">log in</a> to post a comment.</p>

			<?php else : ?>

				<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="comment_form">
					<?php if ( $user_ID ) { ?>
						<p class="unstyled">Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account') ?>">Logout &raquo;</a></p>
					<?php } ?>
					<?php if ( !$user_ID ) { ?>
						<input class="u-full-width" type="text" name="author" id="author" value="<?php echo $comment_author; ?>" tabindex="1" placeholder="NAME" />
						<input class="u-full-width" type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" tabindex="2" placeholder="EMAIL" />
						<input class="u-full-width" type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" tabindex="3" placeholder="WEBSITE" />
					<?php } ?>
					<textarea class="u-full-width" name="comment" id="comment" rows="8" tabindex="4" placeholder="COMMENT"></textarea>
					<?php if (function_exists('show_subscription_checkbox')) { show_subscription_checkbox(); } ?>
					<?php comment_id_fields(); ?><input name="submit" class="button-primary" type="submit" id="submit" tabindex="5" value="SUBMIT" />
					<?php do_action('comment_form', $post->ID); ?>
				</form>

			<?php endif; // If registration required and not logged in ?>

		</div>

		<div class="navigation"><?php /* &nbsp; for making the empty floated divs have width */ ?>
			<div class="nav-older"><?php previous_comments_link('older comments') ?></div>
			<div class="nav-newer"><?php next_comments_link('newer comments') ?></div>
		</div>

	<?php endif; // if you delete this the sky will fall on your head ?>

</div><?php /* #comments */ ?>
<div style="clear:both;"></div>
