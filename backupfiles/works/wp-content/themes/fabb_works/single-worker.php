<?php

get_header();

$template_url = get_template_directory_uri();

$term = get_current_tax($post->ID, 'service_cat');

?>


<!-- ===============================================
	CONTENTS
================================================== -->

<script>
    jQuery(function($) {


    });
</script>

<section id="wo_workers">
    <h2 class="inner">
        <img src="<?php echo $template_url ?>/library/images/works/worker/workers_word.png" alt="ワーカー">
    </h2>
</section>

<div id="d_main">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <!--紹介-->
        <?php
        $thumbn_url = get_thumb_url('large');

        $prevpost = get_previous_post();
        $nextpost = get_next_post();

        ?>
        <section id="wo_syokai" class="inner">
            <div id="shokai_box">
                <h2 id="shokai_logo"><?php the_title() ?><br><span><?php the_field('wrkr_job') ?></span></h2>
                <p class="blue_border"><?php echo $term->name ?></p>
            </div>
            <div id="wo_profie">
                <?php
                if (!empty($prevpost)) {
                    ?>
                    <a href="<?php echo get_permalink($prevpost->ID) ?>"> <img src="<?php echo $template_url ?>/library/images/works/worker/left_kakko.png" alt="左カッコ"></a>
                    <?php
                } else {
                    ?>
                    <span class="disable"><img src="<?php echo $template_url ?>/library/images/works/worker/left_kakko.png" alt="左カッコ"></span>
                    <?php
                }
                ?>
                <div id="wo_prof_box">
                    <div class="img_box">
                        <img src="<?php echo $thumbn_url ?>" alt="顔写真">
                    </div>
                    <div id="syokai_txt">
                        <h4>自己紹介</h4>
                        <?php the_content() ?>
                    </div>
                </div>
                <?php
                if (!empty($nextpost)) {
                    ?>
                    <a href="<?php echo get_permalink($nextpost->ID) ?>"> <img src="<?php echo $template_url ?>/library/images/works/worker/right_kakko.png" alt="右カッコ"></a>
                    <?php
                } else {
                    ?>
                    <span class="disable"><img src="<?php echo $template_url ?>/library/images/works/worker/right_kakko.png" alt="右カッコ"></span>
                    <?php
                }
                ?>
            </div>
            <div id="syokai_contact">
                <a href="/contact/"><span>お問い合わせはこちら</span></a>
            </div>
        </section>
        <!-- 提供可能サービス -->
        <?php
        $srvposts = get_field('wrkr_srvpost');
        if (is_array($srvposts) && count($srvposts) > 0) {
            ?>
            <section id="wo_service" class="inner">
                <h3 class="wo_h3_1">提供可能サービス</h3>
                <div class="wo_h3_2"><!-ライン-></div>
                <div id="wo_se_boxes">
                    <?php
                    foreach ($srvposts as $post) {
                        setup_postdata($post);
                        $thumbn_url = get_thumb_url('large');
                        $postterm = get_current_tax($post->ID, 'service_cat');
                        ?>
                        <div class="wo_se_box">
                            <a href="<?php the_permalink() ?>">
                                <img src="<?php echo $thumbn_url ?>" alt="<?php the_title() ?>">
                                <div class="wo_se_rightbox">
                                    <ul>
                                        <li class="wo_se24"><?php echo $postterm->name ?></li>
                                        <li class="wo_se18"><?php the_title() ?></li>
                                        <li class="wo_se36">￥<?php the_field('srv_price') ?><span>（税込）</span></li>
                                    </ul>
                                    <p><?php the_field('srv_description') ?></p>
                                </div>
                            </a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </section>
            <?php
            wp_reset_postdata();
        }
        ?>

        <!--実績-->
        <?php
        $worker_name = get_the_title();
        $postParam = array(
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'DESC',
            'post_type' => "casestudy",
            'post_status' => 'publish',
            'no_found_rows' => false,
            'meta_query' => array(
                array(
                    "key" => "csstd_worker",
                    "value" => $post->ID
                )
            )
        );

        $query = new WP_Query($postParam);

        if ($query->found_posts != 0) {

            ?>
            <section id="wo_works" class="inner">
                <h3 class="wo_h3_1">実績</h3>
                <div class="wo_h3_2"><!-ライン-></div>
                <div id="wo_site_boxes">
                    <?php
                    while ( $query->have_posts() ) {
                        $query->the_post();

                        $thumbnail_url = get_thumb_url(false, "large");
                        $postterm = get_current_tax($post->ID, 'service_cat');

                        ?>
                        <div class="wo_si_box">
                        <span>
                            <div class="wo_si_img_txt">
                                <div class="wo_si_img">
                                    <img src="<?php echo $thumbnail_url ?>" alt="<?php the_title() ?>">
                                </div>
                                <div class="wo_si_txt">
                                    <p class="blue_border1"><?php echo $postterm->name ?></p>
                                </div>
                            </div>
                            <p class="wo_si_txt2"><?php the_title() ?><br> <span>by <?php echo $worker_name ?></span></p>
                        </span>
                        </div>
                        <?php
                    }
                    wp_reset_postdata();
                    ?>
                </div>
            </section>

            <?php
        }
        ?>

    <?php endwhile; ?>

    <?php endif; ?>

</div>

<?php get_footer(); ?>
