<div class="comments">
	<?php if (post_password_required()) : ?>
	<p><?php _e( 'Post is password protected. Enter the password to view any comments.', 'html5blank' ); ?></p>
</div>

	<?php return; endif; ?>
	
	<?php if (have_comments()) : ?>
	
	<span class="KB-CommentsCount">
		<i class="far fa-comments KB-CommentsCountIcon"></i> <?php echo comments_number( __( 0 ), __( 1 ), __( '%' )); ?>
	</span>

	<ul>
		<?php wp_list_comments('type=comment&callback=html5blankcomments'); // Custom callback in functions.php ?>
	</ul>

<?php elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

	<p><?php _e( 'Comments are closed here.', 'html5blank' ); ?></p>

<?php endif; ?>

<?php comment_form(); ?>

</div>
