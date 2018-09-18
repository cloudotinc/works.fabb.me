<?php

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
        <p><img src="<?php echo $template_url ?>/library/images/works/casestudy/works.png" alt="WORKS 実績"></p>
    </h2>
    <!--セレクトボタン-->
    <div id="works_button">
        <ul class="works_sortnav">
            <li class="btn_all"><a href="<?php echo get_option('home') ?>/casestudy/" class="<?php if (empty($srvcat)) echo 'active' ?>">実績一覧</a></li>
            <?php
            foreach ($terms as $term) {
                $active_class = outputActiveTerm($term->slug);
                $name = $term->name;
                $shorname = get_field('srvcat_shortname', $term);
                if (!empty($shorname)) $name = $shorname;
                echo '<li class="btn_all"><a href="' . get_option('home') . "/casestudy/?service_cat=" . $term->slug .
                    '" class="' . $active_class . '">' . $name . '</a></li>';
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
                            <img src="<?php echo $thumbn_url ?>" alt="<?php the_title() ?>">
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
