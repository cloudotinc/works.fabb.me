<?php

wp_enqueue_script("infinitescrolljs",get_bloginfo("template_directory")."/library/js/libs/jquery.infinitescroll.min.js");

get_header(); ?>

<script>
	$(function() {
		$('#postlist-search').infinitescroll({
			loading: {
				img: "<?php echo get_bloginfo('template_directory') ?>/library/images/loading.gif",
				finished: function() {
					$('#infscr-loading').fadeOut();
				},
				msgText: '<em>読み込み中...</em>',
				finishedMsg: "<em>全ての記事を読み込みました</em>"
			},
			navSelector  : ".pagination",
			// selector for the paged navigation (it will be hidden)
			nextSelector : ".pagination a.next",
			// selector for the NEXT link (to page 2)
			itemSelector : "#postlist-search .postlist-item"
			// selector for all items you'll retrieve
		}, function (newElements, data, url) {

			$('#infscr-loading').fadeOut();
			$(newElements).hide().fadeIn(400,function() {
				/*
				 try{
				 FB.XFBML.parse();
				 twttr.widgets.load();
				 }catch(ex){}
				 */
			});

		});
	});
</script>
			<div class="content" id="search">

				<div id="inner-content" class="wrap cf">

					<main id="main" class="m-all t-all d-all cf" role="main">
						<p class="search-title">search</p>

						<div class="archive_wrap">
						<h1 class="archive-title"><span><?php _e( 'Search Results for:', 'bonestheme' ); ?></span> <?php echo esc_attr(get_search_query()); ?></h1>

						<?php get_search_form(); ?>
						</div>

						<div class="postlist postlist-m cf" id="postlist-search">
							<?php if (have_posts()) :
								$count = 0;
								while (have_posts()) : the_post();
									$count++;
									$posClass = get_pl_posclass($count);
									$post_type = get_post_type();
									$post_type_class = "pt-" . $post_type;
									?>
									<article id="post-<?php the_ID(); ?>" <?php post_class( 'postlist-item cf ' . $post_type_class . " " . $posClass ); ?> role="article">

										<?php output_plitem_default($post) ?>

									</article>

								<?php endwhile; ?>

								<?php bones_page_navi(); ?>

							<?php else : ?>

								<article id="post-not-found" class="hentry cf">
									<header class="article-header">
										<h1><?php _e( 'Sorry, No Results.', 'bonestheme' ); ?></h1>
									</header>
									<section class="entry-content">
										<p><?php _e( 'Try your search again.', 'bonestheme' ); ?></p>
									</section>
									<footer class="article-footer">

									</footer>
								</article>

							<?php endif; ?>

							</div>

						</main>


					</div>

			</div>

<?php get_footer(); ?>
