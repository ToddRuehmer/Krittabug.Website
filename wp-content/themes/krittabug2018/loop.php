<?php 
	if (have_posts()): while (have_posts()) : the_post(); 
?>

	<!-- article -->
	<article id="post-<?php the_ID(); ?>" <?php post_class('KB-Article'); ?>>

		<!-- post title -->
		<h2 class="KB-ArticleTitle">
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="KB-ArticleTitleLink"><?php the_title(); ?></a>
		</h2>
		<!-- /post title -->

		<!-- post details -->
		<span class="KB-ArticleDate"><?php the_time('F j, Y'); ?></span>
		<span class="KB-ArticleCommentsCount"><?php if (comments_open( get_the_ID() ) ) comments_popup_link( __( 0 ), __( 1 ), __( '%' )); ?></span>
		<!-- /post details -->

		<?php edit_post_link(); ?>

	</article>
	<!-- /article -->

<?php endwhile; ?>

<?php else: ?>

	<!-- article -->
	<article>
		<h2><?php _e( 'Sorry, nothing to display.' ); ?></h2>
	</article>
	<!-- /article -->

<?php endif; ?>
