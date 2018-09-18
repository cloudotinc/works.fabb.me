<?php
/*
Template Name: SEARCH PAGE
*/
?>

<?php get_header(); ?>

			<div class="content" id="searchpage">

				<div id="inner-content" class="wrap cf">

						<main id="main" class="m-all t-all d-all cf" role="main" itemscope itemprop="mainEntity" itemtype="http://schema.org/Blog">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<header class="article-header std-title-block">

									<h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>
									<p class="subtitle">検索</p>
									<p class="description">otoCotoの記事をキーワードで検索することができます。</p>

								</header> <?php // end article header ?>

								<section class="entry-content cf" itemprop="articleBody">
									<?php

										get_search_form();

									?>
								</section> <?php // end article section ?>

								<footer class="article-footer cf">

								</footer>

								<?php //comments_template(); ?>

							</article>

							<?php endwhile; else : ?>


							<?php endif; ?>

						</main>

				</div>

			</div>

<?php get_footer(); ?>
