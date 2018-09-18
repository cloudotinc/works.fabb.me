<?php
/*
Template Name: SPECIAL
*/
?>

<?php

wp_enqueue_script("infinitescrolljs",get_bloginfo("template_directory")."/library/js/libs/jquery.infinitescroll.min.js");
wp_enqueue_script( 'archive-js', get_template_directory_uri().'/library/js/archive.js', array( 'jquery' ));

get_header(); ?>

			<div class="content" id="special">

				<div id="inner-content" class="wrap cf">

						<main id="main" class="m-all t-all d-all cf" role="main" itemscope itemprop="mainEntity" itemtype="http://schema.org/Blog">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

								<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

									<header class="article-header std-title-block">

										<h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>
										<p class="subtitle">特設ページ一覧</p>


									</header> <?php // end article header ?>

									<section class="entry-content cf" itemprop="articleBody">

										<div class="postlist postlist-m postlist_columnlist cf">
											<?php
											global $featurelist;

											$count = 0;
											foreach($featurelist as $key => $row){
												$count++;
												$posClass = get_pl_posclass($count);

												$internal = false;
												if ($row["type"] == "page") {
													$page = get_page_by_path($row["slug"]);
													$post_title = $page->post_title;
													$post_permalink = get_permalink($page->ID);
													$post_thumb = wp_get_attachment_image_src(get_post_thumbnail_id($page->ID),"large");
													$post_thumb = $post_thumb[0];
													$post_description = $page->post_excerpt;
													$internal = true;
												}
												else {
													//$categories[$key]->name
													$post_title = $row["title"];
													$post_permalink = $row["url"];
													$post_thumb = get_template_directory_uri() . "/library/images/feature/" . $row["image"];
													$post_description = $row["description"];
												}
												?>
												<div class="postlist-item<?php echo $posClass ?>">
													<a class="postimage" href="<?php echo $post_permalink ?>" <?php if (!$internal) { ?>target="_blank"<?php } ?>>
														<img src="<?php echo $post_thumb ?>" />
													</a>
													<div class="postinfo">
														<p class="title"><?php echo $post_title ?></p>
														<p class="posttitle"><?php echo $post_description ?></p>
													</div>
												</div>
												<?php
											}

											?>
										</div>

									</section> <?php // end article section ?>

									<footer class="article-footer cf">

									</footer>


								</article>

							<?php endwhile;

                                bones_page_navi();

                            else : ?>


							<?php endif; ?>

						</main>


				</div>

			</div>

<?php get_footer(); ?>
