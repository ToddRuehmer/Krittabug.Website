<?php get_header(); ?>

	<main class="KB-Main" role="main">
		<h1><?php _e( 'Latest Posts', 'html5blank' ); ?></h1>

		<?php get_template_part('loop'); ?>

		<?php get_template_part('pagination'); ?>
	</main>

<?php get_footer(); ?>
