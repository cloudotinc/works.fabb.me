<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Thirteen
 * already has tag.php for Tag archives, category.php for Category archives,
 * and author.php for Author archives.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>



<!--メイン部分-->
<div id="se_title">
    <div class="ser_title">
        <img src="http://works.fabb.me/wp-content/themes/type-TN17/images/service/se.sevice.png" alt="サービス文字">
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
