<section class="KB-Articles KB-Articles_js">

<?php
	$queryArgs = Array();
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

	if($paged == 1) {
		$queryArgs['offset'] = 1;
	}
	if($paged > 1) {
		$queryArgs['paged'] = $paged;
	}
	$loop = new WP_Query($queryArgs);

	if ($loop->have_posts()): while ($loop->have_posts()) : $loop->the_post(); 
?>

	<!-- article -->
	<article id="post-<?php the_ID(); ?>" <?php post_class('KB-Article KB-Article_js'); ?>>

		<header class="KB-ArticleHeader" style="background-image: url('<?php echo getContentImage(); ?>');">
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="KB-ArticleImage">
				<img src="<?php echo getContentImage(); ?>" />
			</a>
			
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

				<!-- post excerpt -->
				<section class="KB-ArticleExcerpt">
					<?php the_excerpt(); ?>
				</section>
				<!-- /post excerpt -->
			</section>
		</header>

		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="KB-ArticleLink"></a>

	</article>
	<!-- /article -->

<?php endwhile; ?>

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
        var headerSticky = new Sticky({
            $wrapper: $(\'.KB-PageTop_js\'), 
            $sticky: $(\'.KB-ArticlesHeader_js\')
        });
	});
	</script>';
	else:
		$script =  '<script>
		var $test = function(){ console.log(\'test\');};
		var headerSticky = new Sticky({
			$wrapper: $(\'.KB-PageTop_js\'), 
			$sticky: $(\'.KB-ArchiveHeader_js\')
		});
		</script>';
	endif; 
?>