<?php

//wp_enqueue_script( 'focuspoint-js', get_template_directory_uri().'/library/js/libs/jquery.focuspoint.min.js', array( 'jquery' ));
wp_enqueue_script( 'mobiledetect-js', get_template_directory_uri() .'/library/js/libs/mobile-detect.min.js', array(), '20150807');

wp_enqueue_style("photoswipecss", get_bloginfo('template_directory').'/library/css/photoswipe/photoswipe.css' );
wp_enqueue_style("photoswipeskincss", get_bloginfo('template_directory').'/library/css/photoswipe/default-skin/default-skin.css' );
wp_enqueue_script("photoswipejs",get_bloginfo("template_directory")."/library/js/libs/photoswipe/photoswipe.min.js");
wp_enqueue_script("photoswipeuijs",get_bloginfo("template_directory")."/library/js/libs/photoswipe/photoswipe-ui-default.min.js");
wp_enqueue_script("photoswipehelperjs",get_bloginfo("template_directory")."/library/js/photoswipehelper.js");

get_header();

$posttype = get_post_type();
$posttype_tax = get_posttype_tax($posttype);

$term_data = get_current_tax($post->ID, $posttype_tax);
$term_id = "";
if (!empty($term_data)) $term_id = $term_data->term_id;

$author_id = $post->post_author;

$col_class = "";
$colstg = get_field('poststg_col');
if (!empty($colstg)) {
    $col_class = "poststg-" . $colstg;
}
$hide_sidebar = false;
if ($colstg == 'col1' || $colstg == 'col1-full') {
    $hide_sidebar = true;
}

?>

<script>

	$(function() {
        setupPhotoSwipeGallery({
            fullscreenEl: false,
            zoomEl: true,
            shareEl: false,
            bgOpacity: 0.9,
            showHideOpacity: true
        });
    });


    function setPopupImage($elm) {
        setupPhotoSwipeOne($elm, {
            fullscreenEl: false,
            zoomEl: true,
            shareEl: false,
            bgOpacity: 0.9,
            showHideOpacity: true
        });
    }

	$(window).load(function() {

	    $('.entry-content a img').each(function() {

            if ($(this).parents('.gallery').length > 0) return;

            var $parent = $(this).parent('a');

            if (!(/\.(gif|jpg|jpeg|tiff|png)$/i).test($parent.attr("href"))) return;

            if ($parent.data('size')) {
                console.log("sized");
                setPopupImage($parent);
            }
            else {
                var theImage = new Image();
                theImage.src = $parent.attr("href");
//            console.log(theImage.src);

                $(theImage).one('load',function(){
                    // Get accurate measurements from that.
                    var imageWidth = theImage.width;
                    var imageHeight = theImage.height;
                    $parent.data('size',imageWidth+'x'+imageHeight);

//                console.log($parent.data('size'));

                    setPopupImage($parent);

                });
            }
        });

	});

</script>
			<div class="content" id="single">

				<div id="inner-content" class="wrap wrap-single cf <?php echo $col_class ?>">

					<main id="main" class="cf" role="main" itemscope itemprop="mainEntity" itemtype="http://schema.org/Blog">

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<?php
								/*
								 * Ah, post formats. Nature's greatest mystery (aside from the sloth).
								 *
								 * So this function will bring in the needed template file depending on what the post
								 * format is. The different post formats are located in the post-formats folder.
								 *
								 *
								 * REMEMBER TO ALWAYS HAVE A DEFAULT ONE NAMED "format.php" FOR POSTS THAT AREN'T
								 * A SPECIFIC POST FORMAT.
								 *
								 * If you want to remove post formats, just delete the post-formats folder and
								 * replace the function below with the contents of the "format.php" file.
								*/
								get_template_part( 'post-formats/format', get_post_format() );
							?>

						<?php endwhile; ?>

						<?php else : ?>

							<article id="post-not-found" class="hentry cf">
									<header class="article-header">
										<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
									</header>
									<section class="entry-content">
										<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
									</section>
									<footer class="article-footer">
											<p><?php _e( 'This is the error message in the single.php template.', 'bonestheme' ); ?></p>
									</footer>
							</article>

						<?php endif; ?>


                        <?php
                        $postnav_types = array("column","news");
                        if (in_array($posttype, $postnav_types)) {
                            ?>
                            <div class="std-content post-nav std-postnav">
                                <?php
                                $prevpost = get_previous_post();
                                $nextpost = get_next_post();

                                $pt_name_short = get_posttype_name_jp($posttype, true);
                                $pt_name = "記事"; //名称が長くなったため変更
                                ?>
                                <div class="page-links-inner">
                                    <?php
                                    if (empty($prevpost)) {
                                        ?>
                                        <span class="pl-prev pl-btn">
                                            <span class="icon icon-arrowleftthin"></span>
                                            <span class="pl-text">前の<?php echo $pt_name ?>へ</span>
                                        </span>
                                        <?php
                                    } else {
                                        ?>
                                        <a class="pl-prev pl-btn" href="<?php echo get_permalink($prevpost->ID) ?>">
                                            <span class="icon icon-arrowleftthin"></span>
                                            <span class="pl-text">前の<?php echo $pt_name ?>へ</span>
                                        </a>
                                        <?php
                                    }
                                    ?>

                                    <a class="pl-archive" href="<?php echo get_post_type_archive_link($post_type) ?>">
                                        <?php echo $pt_name_short ?> 一覧へ
                                    </a>

                                    <?php
                                    if (empty($nextpost)) {
                                        ?>
                                        <span class="pl-next pl-btn">
                                            <span class="pl-text">次の<?php echo $pt_name ?>へ</span>
                                            <span class="icon icon-arrowrightthin"></span>
                                        </span>
                                        <?php
                                    } else {
                                        ?>
                                        <a class="pl-next pl-btn" href="<?php echo get_permalink($nextpost->ID) ?>">
                                            <span class="pl-text">次の<?php echo $pt_name ?>へ</span>
                                            <span class="icon icon-arrowrightthin"></span>
                                        </a>
                                        <?php
                                    }
                                    ?>

                                </div>
                            </div>
                            <?php
                        }
                        ?>

                        <div class="std-content single-property">
                            <?php
                            //output_bookslider();
                            ?>

                        </div>

					</main>



                    <?php if (!$hide_sidebar) { ?>
					<div id="sidebar" class="sidebar cf" role="complementary">


					</div>
                    <?php } ?>

				</div>

			</div>
<?php get_template_part("inc","photoswipe") ?>
<?php get_footer(); ?>
