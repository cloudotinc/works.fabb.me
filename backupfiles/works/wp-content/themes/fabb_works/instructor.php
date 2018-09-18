<?php
/*
Template Name: INSTRUCTOR
*/
?>

<?php

get_header();


function output_all_instructor() {

    echo '<div class="instructor-wrapper">';


    $args = array(
        'role'         => 'author',
        'meta_query'   => array(
            'relation' => 'AND',
            array(
                'key' => 'ir_enabled',
                'value' => '1',
                'compare' => '='
            )
        ),
        'orderby'      => 'id',
        'order'        => 'DESC'
    );

    $users = get_users($args);


    echo '<div class="prof-card-list">';


    foreach ( $users as $user ) {

        $userid = $user->ID;

        $usercf = 'user_' . $userid;

        $name = get_the_author_meta('display_name', $userid);
        $mainimg = get_field('ir_mainimg', $usercf);
        $area = get_field('ir_area', $usercf);
        $prof_short = get_field('ir_prof_short', $usercf);

        echo '<div class="prof-card">';

        echo '<a href="' . get_author_posts_url($userid) . '">';

        $size = 'bnl-thumb-medium';
        if ($mainimg) {
            $mainthumb = $mainimg['sizes'][ $size ];
        }
        else {
            $mainthumb = get_template_directory_uri() . "/library/images/default_thumb.jpg";
        }

        echo '<div class="mainimg liquidimg"><img src="' . $mainthumb . '" />';
        if ($area) echo '<span class="area">' . $area->name . '</span>';
        echo '</div>';
        if ($name) echo '<p class="name">' . $name . '</p>';
        if ($prof_short) echo '<p class="prof-short">' . $prof_short . '</p>';

        echo '</a>';

        echo '</div>'; // prod-card
    }

    echo '</div>';

    echo '</div>';

} // output_instructor

?>

			<div class="content" id="instructor">

				<div id="inner-content" class="wrap cf">

						<main id="main" class="m-all t-all d-all cf" role="main" itemscope itemprop="mainEntity" itemtype="http://schema.org/Blog">

                            <article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

                                <header class="article-header std-title-block">

                                    <h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>

                                </header> <?php // end article header ?>

                                <section class=" cf" itemprop="articleBody">

                                    <?php
                                    output_all_instructor();
                                    ?>

                                </section> <?php // end article section ?>

                                <footer class="article-footer cf">

                                </footer>


                            </article>

						</main>


				</div>

			</div>

<?php get_footer(); ?>
