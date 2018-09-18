
<?php

$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));

if (!user_can( $curauth, "publish_products" )) {
    bnl_redirect(get_option('home'));
}

get_header();



function output_author_course() {
    global $post, $curauth;

    $postParam = array(
        'posts_per_page' => 4,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_type' => "product",
        'author' => $curauth->ID,
        'post_status' => 'publish',
        'no_found_rows' => false
    );

    $count = 0;
    $query = new WP_Query($postParam);

    if ($query->found_posts == 0) return;

    echo '<div class="author-course" >';

    echo '<h2 class="std-title std-title-wsub">主催講座</h2>';
    echo '<p class="std-subtitle">講師が主催する講座をご紹介します</p>';


    echo '<div class="postlist postlist-course cf">';


    while ( $query->have_posts() ) {
        $query->the_post();
        $count++;
        $posClass = "";

        if (get_post_meta($post->ID, "_stock_status", true) != "instock") {
            $posClass = "outofstock";
        }

        ?>

        <div class="postlist-item <?php echo $posClass ?> cf">
            <a class="postimage" href="<?php the_permalink() ?>">
                <?php
                $thumbnail_url = get_thumb_url(false, "medium");
                ?>
                <img class="" src="<?php echo $thumbnail_url ?>" />
                <?php output_status($post) ?>
            </a>
            <div class="postinfo">
                <?php
                output_infoheader($post, true);
                ?>
                <h3 class="title"><?php echo get_the_title() ?></h3>
            </div>
        </div>
        <?php
    }
    wp_reset_postdata();


    echo '</div>';
    echo '<div class="btn-wrapper"><a class="std-btn-arrow btn-viewall" href="' . get_option('home') . '/course/">講座一覧を見る</a></div>';
    echo '</div>';

} // output_author_course
?>

			<div class="content" id="author">

				<div id="inner-content" class="wrap cf">

                    <div id="sidebar" class="sidebar cf" role="complementary">

                        <?php
                        $author_id = $curauth->ID;
                        $usercf = 'user_' . $author_id;

                        $name = $curauth->display_name;
                        $mainimg = get_field('ir_mainimg', $usercf);
                        $area = get_field('ir_area', $usercf);
                        $cat = get_field('ir_cat', $usercf);
                        $prof_short = get_field('ir_prof_short', $usercf);
                        $content = get_field('ir_content', $usercf);


                        $headerimg = get_field('ir_headerimg', $usercf);
                        $company = get_field('ir_company', $usercf);
                        $job = get_field('ir_job', $usercf);
                        $prof = get_field('ir_prof', $usercf);

                        $contact = get_field('ir_contact', $usercf);
                        $facebook = get_field('ir_url_fb', $usercf);
                        $web = get_field('ir_url_web', $usercf);
                        $blog = get_field('ir_url_blog', $usercf);


                        echo '<div class="prof-card">';

                        echo '<span>';

                        $size = 'medium';
                        if ($mainimg) {
                            $mainthumb = $mainimg['sizes'][ $size ];
                        }
                        else {
                            $mainthumb = get_template_directory_uri() . "/library/images/default_thumb.jpg";
                        }

                        echo '<div class="mainimg liquidimg"><img src="' . $mainthumb . '" /></div>';
//                        if ($area) echo '<span class="area">' . $area->name . '</span>';
                        if ($name) echo '<p class="name">' . $name . '</p>';
                        if ($prof_short) echo '<p class="prof-short">' . $prof_short . '</p>';

                        echo '</span>';

                        echo '</div>'; // prod-card

                        ?>

                        <div class="author-meta">
                            <?php
                            if ($area) echo '<a class="area" href="' . get_term_link( $area->term_id, "area" ) . '"><span class="icon icon-area"></span><span class="txt">' . $area->name . '</span></a>';
                            if ($cat) echo '<a class="cat" href="' . get_term_link( $cat->term_id, "product_cat" ) . '"><span class="icon icon-category"></span><span class="txt">' . $cat->name . '</span></a>';
                            ?>
                        </div>


                        <div class="author-prof">
                            <h3>プロフィール</h3>
                            <?php
                            if ($company) echo '<p class="company">' . $company . '</p>';
                            if ($job) echo '<p class="job">' . $job . '</p>';
                            if ($prof) echo '<p class="profile">' . $prof . '</p>';

                            if ($contact) {
                                echo '<div class="btn-wrapper"><a class="std-btn-arrow btn-viewall" href="' . $contact . '">講師を依頼する</a></div>';
                            }

                            ?>
                        </div>

                        <div class="author-link">
                            <ul>
                                <?php
                                if ($facebook) echo '<li><a href="' . $facebook .
                                    '" target="_blank"><span class="icon icon-facebook2"></span><span>facebook</span></a>';
                                if ($web) echo '<li><a href="' . $web .
                                    '" target="_blank"><span class="icon icon-home"></span><span>web</span></a>';
                                if ($blog) echo '<li><a href="' . $blog .
                                    '" target="_blank"><span class="icon icon-blog"></span><span>blog</span></a>';
                                ?>
                            </ul>
                        </div>

                    </div>

                    <main id="main" class="m-all t-all d-all cf" role="main" itemscope itemprop="mainEntity" itemtype="http://schema.org/Blog">

                        <?php
                        $size = 'large';
                        if ($headerimg) {
                            $headerthumb = $headerimg['sizes'][ $size ];
                            echo '<div class="headerimg liquidimg"><img src="' . $headerthumb . '" /></div>';
                        }


                        echo '<div class="prof-content">';

                        if ($content) echo $content;

                        echo '</div>'; // prod-content


                        output_author_course();

                        ?>


                    </main>


				</div>

			</div>

<?php get_footer(); ?>
