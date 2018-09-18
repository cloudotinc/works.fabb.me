<?php

$template_url = get_template_directory_uri();

get_header(); ?>

<!--メイン部分-->
<div id="se_title">
    <div class="ser_title">
        <img src="<?php echo $template_url ?>/library/images/works/service/se.sevice.png" alt="サービス文字">
    </div>
</div>
<!--サービス一覧-->
<h2 class="ser">サービス一覧</h2>
<section id="se_service" class="inner">
    <ul>
        <?php
        $taxonomies = array(
            'service_cat'
        );

        $args = array(
            'orderby'       => 'name',
            'order'         => 'ASC',
            'hide_empty'    => false
        );

        $terms = get_terms( $taxonomies, $args );

        foreach ($terms as $term) {

            $iconurl = "";
            $iconimg = get_field('srvcat_img_icon', $term);
            if ($iconimg) {
                $iconurl = $iconimg['sizes'][ 'medium' ];
            }

            $postParam = array(
                'posts_per_page' => -1,
                'orderby' => 'date',
                'order' => 'DESC',
                'post_type' => "service",
                'post_status' => 'publish',
                'no_found_rows' => true,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'service_cat',
                        'field' => 'slug',
                        'terms' => $term->slug
                    ),
                ),
            );

            $query = new WP_Query($postParam);

            ?>
            <li class="s_se_box1">
                <div class="s_circle">
                    <img src="<?php echo $iconurl ?>" alt="<?php echo $term->name ?>">
                </div>
                <div class="s_se_rightbox">
                    <h3>
                        <?php echo $term->name ?>
                    </h3>
                    <div class="s_se_box2">
                        <?php
                        while ( $query->have_posts() ) {
                            $query->the_post();
                            ?>
                            <h4><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h4>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </li>
            <?php
        }
        ?>
    </ul>
</section>

<?php get_footer(); ?>
