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

$template_url = get_template_directory_uri();

get_header();


$taxonomies = array(
    'service_cat'
);

$args = array(
    'orderby'       => 'name',
    'order'         => 'ASC',
    'hide_empty'    => false
);

$srvcat = get_query_var('service_cat');

$terms = get_terms( $taxonomies, $args );


function outputActiveTerm($name) {
    global $srvcat;
    if ($name == $srvcat) {
        return "active";
    }
    else {
        return "";
    }
}
?>


    <section id="wo_worker">
        <h2 class="wor_kv">
            <p><img src="<?php echo $template_url ?>/images/worker/workers_word.png" alt="ワーカー一覧"></p>
        </h2>
        <div id="works_button">
            <ul class="works_sortnav">
                <li class="btn_all"><a href="<?php echo get_option('home') ?>/worker/" class="<?php if (empty($srvcat)) echo 'active' ?>">実績一覧</a></li>
                <?php
                foreach ($terms as $term) {
                    $active_class = outputActiveTerm($term->slug);
                    echo '<li class="btn_all"><a href="' . get_option('home') . "/worker/?service_cat=" . $term->slug .
                        '" class="' . $active_class . '">' . $term->name . '</a></li>';
                }
                ?>
            </ul>
        </div>
        <section id="wo_contents">
            <?php if ( have_posts() ) : ?>
                <ul>

                    <?php
                    while ( have_posts() ) : the_post();

                        $thumbn_url = get_thumb_url('thumb-sq');
                        $postterm = get_current_tax($post->ID, 'service_cat');
                        $author = get_the_author();
                        ?>
                        <li class="<?php echo $postterm->slug ?>">
                            <a href="">
                                <img src="<?php echo $thumbn_url ?>" alt="<?php the_title() ?>" class="wor_face">
                                <h3 class="wor_tittle"><?php the_title() ?><br class="wor_none"><span class="hover"><?php echo $postterm->name ?></span></h3>
                                <p class="wor_team"><?php the_field('wrkr_job') ?></p>
                                <p class="wor_word"><?php echo get_the_excerpt() ?></p>
                            </a>
                        </li>
                    <?php endwhile; ?>
                </ul>

            <?php endif; ?>
        </section>

        <?php
        global $wp_query;
        $bignum = 999999999;
        if ( $wp_query->max_num_pages > 1 ) {
            echo '<nav id="wo_page">';
            echo paginate_links(array(
                'base' => str_replace($bignum, '%#%', esc_url(get_pagenum_link($bignum))),
                'format' => '',
                'current' => max(1, get_query_var('paged')),
                'total' => $wp_query->max_num_pages,
                'prev_text' => '<img src="' . $template_url . '/images/worker/pagenav_left.jpg" alt="左矢印">',
                'next_text' => '<img src="' . $template_url . '/images/worker/pagenav_right.jpg" alt="右矢印">',
                'type' => 'list',
                'end_size' => 1,
                'mid_size' => 3
            ));
            echo '</nav>';
        }
        ?>

    </section>



    <?php get_footer(); ?>
