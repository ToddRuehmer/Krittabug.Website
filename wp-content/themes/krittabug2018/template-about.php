<?php /* Template Name: About */ ?>

<?php get_header(); ?>

<?php
	if (have_posts()): while (have_posts()) : the_post(); 

	$portrait = wp_get_attachment_image_src(get_field('featured_image'), 'large');
	$intro = get_field('intro');
	$content1 = get_field('content_1');
?>


<section class="KB-PageTop KB-Top_js">
	<header class="KB-Header KB-Header_js">
		<?php include 'main-nav.php'; ?>
	</header>
	<main class="KB-Main" role="main">
		<header class="KB-AboutHeader">
			<section class="KB-Portrait KB-Portrait_js">		
				<img src="<?php echo get_template_directory_uri(); ?>/images/img-portrait.jpg" class="KB-PortraitImage KB-PortraitImage_js" />
			</section>
			<h1 class="KB-AboutTitle">
				<?php the_field('about_heading'); ?>
			</h1>
		</header>

		<?php if($intro): ?>
			<section class="KB-AboutIntro">
				<?php echo $intro; ?>
			</section>
		<?php endif; ?>

		<?php if($content1): ?>
			<section class="KB-AboutContent1">
				<?php echo $content1; ?>
			</section>
		<?php endif; ?>
		
		<?php the_content(); ?>
	</main>

</section><!-- /PageTop -->

<?php endwhile; endif; ?>

<?php
$script =  '<script>
	var portrait = new Pixelate({
		$image: $(\'.KB-PortraitImage_js\'),
		$container: $(\'.KB-Portrait_js\'),
	});

	var headerSticky = new Sticky({
		$wrapper: $(\'.KB-Top_js\'), 
		$sticky: $(\'.KB-Header_js\')
	});
	</script>';
?>

<?php get_footer(); ?>