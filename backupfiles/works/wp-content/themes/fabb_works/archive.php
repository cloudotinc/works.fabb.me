<?php

wp_enqueue_script("infinitescrolljs",get_bloginfo("template_directory")."/library/js/libs/jquery.infinitescroll.min.js");
wp_enqueue_script( 'archive-js', get_template_directory_uri().'/library/js/archive.js', array( 'jquery' ), "20161115");

get_header(); ?>

<div class="content" id="archive">

	<div id="inner-content" class="wrap cf">

		<main id="main" class="m-all t-all d-all cf" role="main" itemscope itemprop="mainEntity" itemtype="http://schema.org/Blog">

			<?php if (is_category()) { ?>
				<h1 class="archive-title h2">
					<?php
                    $catname = single_cat_title('', false);
                    switch($catname) {
                        default:
                            break;
                    }
                    echo $catname;
                    ?>
				</h1>

			<?php } elseif (is_tax()) {
			    $type_title = get_query_var('taxonomy');
                if (is_post_type_archive( get_all_post_types() )) {
                    $type_title = get_query_var('post_type');
                }
                $type_title = str_replace("_cat","",$type_title);
			    ?>
                <p class="archive-type"><?php echo $type_title ?></p>
				<h1 class="archive-title h2">
					<?php single_tag_title(); ?>
				</h1>

			<?php } elseif (is_tag()) { ?>
                <p class="archive-type">Tag</p>
				<h1 class="archive-title h2">
					<span class="icon icon-taghead"></span><?php single_tag_title(); ?>
				</h1>

            <?php } else if( is_post_type_archive( get_all_post_types() ) ) {
                $type_title = get_query_var('post_type');
                $page_title = post_type_archive_title( '', false );
                ?>
                <?php if (false) { ?>
                    <p class="archive-type"><?php echo $type_title ?></p>
                <?php } ?>
                <h1 class="archive-title h2 wdesc">
                    <?php echo $page_title; ?>
                </h1>
                <p class="title-descriptiion"><?php echo get_posttype_description($type_title) ?></p>

			<?php } elseif (is_author()) {
				global $post;
				$author_id = $post->post_author;
				?>
				<h1 class="archive-title h2">

					<span><?php _e( 'Posts By:', 'bonestheme' ); ?></span> <?php the_author_meta('display_name', $author_id); ?>

				</h1>
			<?php } elseif (is_day()) { ?>
				<h1 class="archive-title h2">
					<span><?php _e( 'Daily Archives:', 'bonestheme' ); ?></span> <?php the_time('l, F j, Y'); ?>
				</h1>

			<?php } elseif (is_month()) { ?>
				<h1 class="archive-title h2">
					<span><?php _e( 'Monthly Archives:', 'bonestheme' ); ?></span> <?php the_time('F Y'); ?>
				</h1>

			<?php } elseif (is_year()) { ?>
				<h1 class="archive-title h2">
					<span><?php _e( 'Yearly Archives:', 'bonestheme' ); ?></span> <?php the_time('Y'); ?>
				</h1>
			<?php } ?>



            <div class="postlist postlist-m cf">
                <?php if (have_posts()) :
                    $count = 0;

                    while (have_posts()) : the_post();

                        $count++;
                        $posClass = get_pl_posclass($count);
                        $post_type = get_post_type();
                        $post_type_class = "pt-" . $post_type;
                        ?>
                        <article
                            id="post-<?php the_ID(); ?>" <?php post_class('postlist-item cf ' . $post_type_class . " " . $posClass); ?>
                            role="article">

                            <?php output_plitem_default($post) ?>

                        </article>

                    <?php endwhile; ?>

                    <?php bones_page_navi(); ?>

                <?php else : ?>

                    <article id="post-not-found" class="hentry cf">
                        <header class="article-header">
                            <h3>記事が見つかりませんでした</h3>
                        </header>
                        <section class="entry-content">

                        </section>
                        <footer class="article-footer">

                        </footer>
                    </article>

                <?php endif; ?>

            </div>


		</main>

		<?php //get_sidebar(); ?>

	</div>

</div>

<?php get_footer(); ?>
