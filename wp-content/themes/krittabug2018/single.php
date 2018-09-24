<?php get_header(); ?>


	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

		<header class="KB-EntryHeader">
			<!-- post title -->
			<h1 class="KB-EntryTitle">
				<?php the_title(); ?>
			</h1>
			<!-- /post title -->
		
			<!-- post details -->
			<span class="KB-Date"><?php the_time('F j, Y'); ?></span>
			<span class="KB-CommentsCount">
				<i class="far fa-comments KB-CommentsCountIcon"></i> <?php echo comments_number( __( 0 ), __( 1 ), __( '%' )); ?>
			</span>
			<!-- /post details -->
		</header>

		<main role="main" class="KB-Main">
	
			<!-- article -->
			<article id="post-<?php the_ID(); ?>" <?php post_class('KB-Entry'); ?>>

				<?php the_content(); // Dynamic Content ?>

				<?php the_tags( __( 'Tags: ', 'html5blank' ), ', ', '<br>'); // Separated by commas with a line break at the end ?>

				<p><?php _e( 'Categorised in: ', 'html5blank' ); the_category(', '); // Separated by commas ?></p>

				<?php edit_post_link(); // Always handy to have Edit Post Links available ?>

			</article>
			<!-- /article -->
	
		</main>

		<section class="KB-Comments">

			<?php comments_template(); ?>

		</section>

	<?php endwhile; ?>

	<?php else: ?>

		<main role="main" class="KB-Main">

			<!-- article -->
			<article>

				<h1><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h1>

			</article>
			<!-- /article -->

		</main>

	<?php endif; ?>

<?php get_footer(); ?>
