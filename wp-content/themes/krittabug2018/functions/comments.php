<?php 

	// Custom Gravatar in Settings > Discussion
	function html5blankgravatar ($avatar_defaults)
	{
			$myavatar = get_template_directory_uri() . '/img/gravatar.jpg';
			$avatar_defaults[$myavatar] = "Custom Gravatar";
			return $avatar_defaults;
	}
	
	// Threaded Comments
	function enable_threaded_comments()
	{
			if (!is_admin()) {
					if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
							wp_enqueue_script('comment-reply');
					}
			}
	}
	
	// Custom Comments Callback
	function html5blankcomments($comment, $args, $depth)
	{
        $GLOBALS['comment'] = $comment;
        extract($args, EXTR_SKIP);

        if ( 'div' == $args['style'] ) {
                $tag = 'div';
                $add_below = 'comment';
        } else {
                $tag = 'li';
                $add_below = 'div-comment';
        }
    ?>
    
        <!-- heads up: starting < for the html tag (li or div) in the next line: -->
        <<?php echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
        <div class="KB-CommentImage">
            <?php if ($args['avatar_size'] != 0) echo get_avatar( $comment, $args['180'] ); ?>
		</div>
		
		<section class="KB-CommentMain">
            <header class="KB-CommentHeader">
                <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
                    <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>'), get_comment_author_link()) ?>
			    </div>
		    </header>
			
            <?php if ($comment->comment_approved == '0') : ?>
            <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.') ?></em>
            <?php endif; ?>
            
			<?php comment_text() ?>
        
            <div class="reply">
                <?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
            </div>
		</section>

	<?php }

?>