<section class="KB-Articles KB-Articles_js">

<?php
	$loop = new WP_Query(array(
		'offset' => 1
	));

	if ($loop->have_posts()): while ($loop->have_posts()) : $loop->the_post(); 
?>

	<!-- article -->
	<article id="post-<?php the_ID(); ?>" <?php post_class('KB-Article KB-Article_js'); ?>>

		<header class="KB-ArticleHeader" style="background-image: url('<?php echo getContentImage(); ?>');">
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
				<!-- /post details -->
			</section>
		</header>

		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="KB-ArticleLink"></a>

	</article>
	<!-- /article -->

<?php endwhile; ?>

</section>

<section class="KB-PostsNav">
	<?php
		add_filter('previous_posts_link_attributes', function(){ return 'class="KB-PostsNavLink"'; });
		add_filter('next_posts_link_attributes', function(){ return 'class="KB-PostsNavLink"'; }); 
		$nextLabel = is_paged() ? "Next" : "See More Posts"; 
	?>
	<?php previous_posts_link( "Back" , $max_pages ); ?>
	<?php next_posts_link( $nextLabel , $max_pages ); ?>
</section>

<?php else: ?>

	<!-- article -->
	<article>
		<h2><?php _e( 'Sorry, nothing to display.' ); ?></h2>
	</article>
	<!-- /article -->

<?php endif; ?>

<?php
	global $script;
	if ( !is_paged() ):
	$script =  '<script>
	masonries.init(function() {
		sticky.init();
	});
	</script>';
	echo $script;
endif; ?>