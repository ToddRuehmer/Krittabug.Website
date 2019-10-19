<?php
	$featuredImage = get_field('featured_image')['sizes']['banner'];
	$featuredImageCaption = get_field('featured_image_caption');
?>

<?php get_header(); ?>

<?php if (have_posts()): while (have_posts()) : the_post(); ?>

	<section class="KB-EntryTop KB-Top_js">
	
		<?php include 'top.php'; ?>
	
			<main role="main" class="KB-Main">

			
				<!-- banner -->
				<?php if($featuredImage) { ?>
					<section class="KB-FeaturedImage" style="background-image:url('<?php echo $featuredImage; ?>')">
						<?php if($featuredImageCaption) { ?>
							<div class="KB-FeaturedImageCaption"><?php echo $featuredImageCaption; ?></div>
						<?php } ?>
					</section>
				<?php } ?>
				<!-- /banner -->

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
		$wrapper: $(\'.KB-Top_js\'), 
		$sticky: $(\'.KB-Header_js\')
	});
	</script>
	';
?>

<?php get_footer(); ?>