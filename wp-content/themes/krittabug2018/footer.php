			<!-- footer -->
			<footer class="KB-Footer" role="contentinfo">

				<section class="KB-FooterRecents">
					
					<?php
						$loop = new WP_Query(array(
							'offset' => 1,
							'posts_per_page' => 4
						));
					
						if ($loop->have_posts()): while ($loop->have_posts()) : $loop->the_post(); 
					?>

					<article class="KB-FooterArticle">

						<h4 class="KB-ArticleTitle">
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="KB-ArticleTitleLink"><?php the_title(); ?></a>
						</h4>
						<span class="KB-Date"><?php the_time('F j, Y'); ?></span>

					</article>

					<?php endwhile; ?>
					
					<?php endif; ?>

				</section>

				<section class="KB-FooterAbout">
					
					<div class="KB-FooterAboutImage">
						<img src="http://placehold.it/700x500" />
					</div>
					<section class="KB-FooterAboutContent">
						<h4>Uuummmm, this is a tasty burger!</h4>
						<p>I wrote my first book, The Antique Cat, when I was a kid. In my debut "novel," which was written by hand, illustrated with crayons, and bound with Elmer's glue, an antique heirloom killed my protagonist's family. One day I'll write a better novel. Today is not that day.</p>
					</section>
					<section class="KB-FooterAboutSocial">
						<a href="#">Instagram</a>
						<a href="#">Twitter</a>
					</section>

				</section>

				<section class="KB-FooterBottom">
					
					<section class="KB-FooterCopyright">
						<p>&copy;<?php echo date("Y"); ?> Krittabug. <br />You don't know my life.</p>
					</section>
					<section class="KB-FooterNav">
						<?php foreach (wp_get_nav_menu_items('main-navigation') as $key => $menuItem): ?>
							<a href="<?php echo $menuItem->url ?>" class="KB-FooterNavLink"><?php echo $menuItem->title ?></a>
						<?php endforeach ?>
					</section>

				</section>

			</footer>
			<!-- /footer -->

		<?php wp_footer(); ?>

		<?php
			global $script;
			if(!empty($script)) {
				echo $script;
			}
		?>

	</body>
</html>
