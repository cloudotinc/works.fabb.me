<?php
/*
Template Name: TOP
*/

//$nowtime = date( "Y-m-d H:i:s" );
//
//$viewstgParam = array(
//    'posts_per_page' => 1,
//    'orderby' => 'date',
//    'order' => 'DESC',
//    'post_type' => array('viewstg'),
//    'post_status' => 'publish',
//    'no_found_rows' => true
//);
//$viewstg = get_posts($viewstgParam);
//$viewstg_id = $viewstg[0]->ID;

require_once 'library/php/Mobile_Detect.php';
$detect = new Mobile_Detect;



function output_top_area() {

    echo '<div class="std-content top-content" id="toparea">';

    echo '<h2 class="std-title">学べるエリア</h2>';

    output_area();

    echo '</div>';

} // output_top_area



function output_top_category() {

    echo '<div class="std-content top-content" id="topcat">';

    echo '<h2 class="std-title std-title-wsub">カテゴリー</h2>';
    echo '<p class="std-subtitle">ご提供できるサービス内容</p>';


    output_servicecat();


    echo '</div>';

} // output_top_category


function output_top_casestudy() {
    global $post;

    $postParam = array(
        'posts_per_page' => 6,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_type' => "casestudy",
        'post_status' => 'publish',
        'no_found_rows' => false
    );

    $count = 0;
    $query = new WP_Query($postParam);

    if ($query->found_posts == 0) return;

    echo '<div class="std-content top-content wrap" id="topcasestudy">';

    echo '<h2 class="std-title std-title-wsub">制作事例</h2>';
    echo '<p class="std-subtitle">最近登録された制作事例を紹介します</p>';


    echo '<div class="postlist postlist-m cf">';


    while ( $query->have_posts() ) {
        $query->the_post();
        $count++;
        $posClass = "";

        ?>

        <div class="postlist-item <?php echo $posClass ?> cf">
            <span class="postimage">
                <?php
                $size = array();
                $sizeclass = "";
                $thumbnail_url = get_thumb_url(false, "bnl-thumb-large",true, $size);
                if (!empty($size) && ($size[1] / $size[0]) <= 0.6724) $sizeclass = "adjust-h";
                ?>
                <img class="<?php echo $sizeclass ?>" src="<?php echo $thumbnail_url ?>" />
                <?php //output_status($post) ?>
            </span>
            <div class="postinfo">
                <?php
//                output_infoheader($post, true);
                ?>
                <h3 class="title"><?php echo get_the_title() ?></h3>
            </div>
        </div>
        <?php
    }
    wp_reset_postdata();


    echo '</div>';
    echo '<div class="btn-wrapper"><a class="std-btn-arrow btn-viewall" href="' . get_option('home') . '/casestudy/">制作事例一覧を見る</a></div>';
    echo '</div>';

} // output_top_casestudy



?>

<?php
wp_enqueue_script( 'mobiledetect-js', get_template_directory_uri() .'/library/js/libs/mobile-detect.min.js', array(), '20150807');


get_header(); ?>

<script>

    var md = new MobileDetect(window.navigator.userAgent);

	var wheight = 0;
	var wwidth = 0;

    function setBulletPos() {
        var target_width = wwidth;
        if (isMobileWidthLarge()) target_width *= 0.5;
        $('.rsBullets').css('top', (target_width - 30) + 'px');
    }


	$(function() {
		wheight = $(window).height();
		wwidth = $(window).width();

        $('.spcontent').biggerlink();

        $('.topslider-img').imgLiquid();
        $('.postlist-top .postimage').imgLiquid();

        var sliderRatio = 2/1;

        var sliderWidth = $(window).width();
        var sliderHeight = sliderWidth * sliderRatio;

        $("#topslider").slick({
            mobileFirst: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            touchThreshold: 20,
            dots: true,
            arrows : false,
            responsive: [
                {
                    breakpoint: 900,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4,
                        dots: false,
                        arrows : true
                    }
                },
                {
                    breakpoint: 640,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        arrows : true
                    }
                },
                {
                    breakpoint: 481,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        arrows : true
                    }
                }
                ]
        });

        setBulletPos();


		$(window).resize(function() {
			var preWidth = wwidth;
			wheight = $(window).height();
			wwidth = $(window).width();
			if (isMobileWidth() && (preWidth != wwidth)) {
                setBulletPos();
			}
		});

    });

    $(window).load(function() {

    });


</script>

    <div class="content" id="top">

        <div id="inner-content" class="cf">

            <main id="main" class="m-all t-all d-all cf" role="main" itemscope itemprop="mainEntity" itemtype="http://schema.org/Blog">

                <div id="topvisual">
                    <div class="cover">
                        <div class="intro">
                            <p>仕事を頼んでみよう！
                            <span>在宅ワーカーやリモートワーカーによる<br>高品質なアウトソーシングをご提供します</span>
                            </p>
                            <div class="btn-wrapper"><a class="std-btn-arrow btn-viewall" href="<?php echo get_option('home') ?>/guide/">FABB WORKSについて</a></div>
                        </div>
                    </div>
                </div>

                <?php
                output_top_category();

                output_top_casestudy();

                ?>

            </main>

        </div>

    </div>

<?php get_footer(); ?>

