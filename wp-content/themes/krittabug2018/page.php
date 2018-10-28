<?php get_header(); ?>

<section class="KB-EntryTop KB-EntryTop_js">

	<?php include 'top.php'; ?>

	<main role="main" class="KB-Main">
	
		<!-- article -->
		<?php if (have_posts()): while (have_posts()) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class('KB-Entry'); ?>>

			<?php the_content(); // Dynamic Content ?>

		</article>

<?php endwhile; ?>

<?php else: ?>

	<!-- article -->
	<article>

		<h2><?php _e( 'Sorry, nothing to display.', 'html5blank' ); ?></h2>

	</article>

<?php endif; ?>
		<!-- /article -->

	</main>

</section>

<?php get_footer(); ?>
