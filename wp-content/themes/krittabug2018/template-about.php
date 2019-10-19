<?php /* Template Name: About */ ?>

<?php get_header(); ?>

<?php if (have_posts()): while (have_posts()) : the_post(); ?>

<section class="KB-Portrait">
	<img src="<?php echo get_template_directory_uri(); ?>/images/img-portrait.jpg" class="KB-PortraitImage KB-Portrait_js" />
</section>

<section class="KB-PageTop KB-Top_js">
	<header class="KB-Header KB-Header_js">
		<?php include 'main-nav.php'; ?>
		<header class="KB-AboutHeader">
			<!-- post title -->
			<h1 class="KB-AboutTitle">
				<?php the_field('about_heading'); ?>
			</h1>
			<!-- /post title -->
		</header>
	</header>
	<main class="KB-Main" role="main">
		<?php the_content(); ?>
	</main>

</section><!-- /PageTop -->

<?php endwhile; endif; ?>

<?php
$script =  '<script>
	var portrait = new Pixelate({
		$image: $(\'.KB-Portrait_js\')
	});

	var headerSticky = new Sticky({
		$wrapper: $(\'.KB-Top_js\'), 
		$sticky: $(\'.KB-Header_js\')
	});
	</script>';
?>

<?php get_footer(); ?>