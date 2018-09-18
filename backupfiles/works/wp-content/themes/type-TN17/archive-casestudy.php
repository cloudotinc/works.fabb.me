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



<section id="works_wrap">
    <h2 class="works_kv inner">
        <p><img src="<?php echo $template_url ?>/images/casestudy/works.png" alt="WORKS 実績"></p>
    </h2>
    <!--セレクトボタン-->
    <div id="works_button">
        <ul class="works_sortnav">
            <li class="btn_all"><a href="<?php echo get_option('home') ?>/casestudy/" class="<?php if (empty($srvcat)) echo 'active' ?>">実績一覧</a></li>
            <?php
            foreach ($terms as $term) {
                $active_class = outputActiveTerm($term->slug);
                echo '<li class="btn_all"><a href="' . get_option('home') . "/casestudy/?service_cat=" . $term->slug .
                    '" class="' . $active_class . '">' . $term->name . '</a></li>';
            }
            ?>
        </ul>
    </div>
    <!--ギャラリ--->
    <section id="works_contents" class="inner">
        <?php if ( have_posts() ) : ?>
            <ul class="works_flexbox">

                <?php
                while ( have_posts() ) : the_post();

                    $thumbn_url = get_thumb_url('large');
                    $postterm = get_current_tax($post->ID, "service_cat");
//                    $author = get_the_author();
                    $author = get_field('csstd_worker');
                    ?>
                    <li class="<?php echo $postterm->slug ?>">
                        <span>
                            <img src="<?php echo $thumbn_url ?>" alt="<?php the_title() ?>"><br/>
                            <span class="category"><?php echo $postterm->name ?></span>
                            <h3><?php the_title() ?><br/>
                                <span class="team_name">by <?php echo $author->post_title ?></span>
                            </h3>
                        </span>
                    </li>
                <?php endwhile; ?>
            </ul>

        <?php endif; ?>

    </section>
</section>



<?php get_footer(); ?>
