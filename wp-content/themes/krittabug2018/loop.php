<section class="KB-Articles KB-Articles_js">

<?php if (have_posts()): while (have_posts()) : the_post(); ?>

	<!-- article -->
	<article id="post-<?php the_ID(); ?>" <?php post_class('KB-Article KB-Article_js'); ?>>

		<header class="KB-ArticleHeader">
			<img src="<?php echo getContentImage(); ?>" class="KB-ArticleImage" />
			
			<section class="KB-ArticleHeaderContent">
				<!-- post title -->
				<h2 class="KB-ArticleTitle">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="KB-ArticleTitleLink"><?php the_title(); ?></a>
				</h2>
				<!-- /post title -->

				<!-- post details -->
				<span class="KB-Date"><?php the_time('F j, Y'); ?></span>
				<span class="KB-CommentsCount">
					<i class="far fa-comments KB-CommentsCountIcon"></i> <?php echo comments_number( __( 0 ), __( 1 ), __( '%' )); ?>
				</span>
				<?php edit_post_link(); ?>
				<!-- /post details -->
			</section>
		</header>

		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="KB-ArticleLink"></a>

	</article>
	<!-- /article -->

<?php endwhile; ?>

</section>

<?php else: ?>

	<!-- article -->
	<article>
		<h2><?php _e( 'Sorry, nothing to display.' ); ?></h2>
	</article>
	<!-- /article -->

<?php endif; ?>
