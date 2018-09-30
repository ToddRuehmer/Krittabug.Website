<?php get_header(); ?>

<?php if (have_posts()): while (have_posts()) : the_post(); ?>

	<section class="KB-EntryTop KB-EntryTop_js">
	
		<?php include 'top.php'; ?>
	
			<main role="main" class="KB-Main">
			
				<!-- article -->
				<article id="post-<?php the_ID(); ?>" <?php post_class('KB-Entry'); ?>>
	
					<?php the_content(); // Dynamic Content ?>
	
				</article>
				<!-- /article -->
	
			</main>
	
	</section>

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

<?php
	global $script;
	$script = '
	<script>
	var headerSticky = new Sticky({
		$wrapper: $(\'.KB-EntryTop_js\'), 
		$sticky: $(\'.KB-Header_js\')
	});
	</script>
	';
?>

<?php get_footer(); ?>