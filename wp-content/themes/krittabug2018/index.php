<?php get_header(); ?>

<section class="KB-PageTop KB-PageTop_js">

<?php
	$loop = new WP_Query(array(
		'posts_per_page' => 1
	));

	if ($loop->have_posts()): while ($loop->have_posts()) : $loop->the_post();
?>

<?php if(!is_paged()): ?>
<section class="KB-ArticlesHeader KB-ArticlesHeader_js" role="banner" style="background-image: url('<?php echo getContentImage() ?>');">
		
	<?php include 'top.php'; ?>
		
	<article id="post-<?php the_ID(); ?>" <?php post_class('KB-Article'); ?>>

		<header class="KB-ArticleHeader">

			<section class="KB-ArticleHeaderContent">
				<!-- post title -->
				<div class="KB-ArticleSubtitle">The Latest</div>
				<h2 class="KB-ArticleTitle">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="KB-ArticleTitleLink"><?php the_title(); ?></a>
				</h2>
				<!-- /post title -->

				<!-- post details -->
				<span class="KB-Date"><?php the_time('F j, Y'); ?></span>
				<span class="KB-CommentsCount">
					<i class="far fa-comments KB-CommentsCountIcon"></i> <?php echo comments_number( __( 0 ), __( 1 ), __( '%' )); ?>
				</span>
				<!-- /post details -->

				<!-- post excerpt -->
				<section class="KB-ArticleExcerpt">
					<?php the_excerpt(); ?>
				</section>
				<!-- /post excerpt -->
			</section>
		</header>

		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="KB-ArticleLink"></a>

	</article>
	
</section>
<?php else: ?>
	<section class="KB-ArchiveHeader KB-ArchiveHeader_js" role="banner">
		<?php include 'top.php'; ?>
	</section>
<?php endif; ?>

<?php endwhile; endif; ?>

	<main class="KB-Main" role="main">
		<?php get_template_part('loop'); ?>
	</main>

	<section class="KB-PostsNav">
		<?php
			add_filter('previous_posts_link_attributes', function(){ return 'class="KB-PostsNavLink"'; });
			add_filter('next_posts_link_attributes', function(){ return 'class="KB-PostsNavLink"'; }); 
			$nextLabel = is_paged() ? "Next" : "See More Posts"; 
		?>
		<?php previous_posts_link( "Back" , $max_pages ); ?>
		<?php next_posts_link( $nextLabel , $max_pages ); ?>
	</section>

</section><!-- /PageTop -->

<?php get_footer(); ?>
