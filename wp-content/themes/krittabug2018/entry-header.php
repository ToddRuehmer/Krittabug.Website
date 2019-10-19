	<?php if(is_single() || is_page()): ?>
		<header class="KB-EntryHeader">
			<!-- post title -->
			<h1 class="KB-EntryTitle">
				<?php the_title(); ?>
			</h1>
			<!-- /post title -->

			<!-- post details -->
			<?php if(!is_page()): ?>
				<span class="KB-Date"><?php the_time('F j, Y'); ?></span>
				<?php if (get_comments_number() > 0): ?>
					<span class="KB-CommentsCount">
						<i class="far fa-comments KB-CommentsCountIcon"></i> <?php echo comments_number( __( 0 ), __( 1 ), __( '%' )); ?>
					</span>
				<?php endif; ?>
			<?php endif; ?>
			<!-- /post details -->
		</header>
	<?php endif; ?>