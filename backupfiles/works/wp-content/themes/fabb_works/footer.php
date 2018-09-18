
<?php

$hide_instructor = false;

if (is_page('instructor')) {
    $hide_instructor = true;
}




function output_news() {
    global $post;

    $postParam = array(
        'posts_per_page' => 6,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_type' => "post",
        'post_status' => 'publish',
        'no_found_rows' => false
    );

    $count = 0;
    $query = new WP_Query($postParam);

    if ($query->found_posts == 0) return;

    echo '<div class="std-content wrap footer-news">';

    echo '<h2 class="std-title">お知らせ</h2>';


    echo '<div class="postlist postlist-text cf">';


    while ( $query->have_posts() ) {
        $query->the_post();
        $count++;
        $posClass = "";

        ?>

        <div class="postlist-item <?php echo $posClass ?> cf">
            <a class="" href="<?php the_permalink() ?>">
                <div class="postinfo">
                    <?php
                    echo '<p class="date">' . get_post_time("Y.n.j.D",false,$post->ID) . '</p>';

                    $category = get_the_category();
                    $catname = $category[0]->cat_name;
                    ?>
                    <p class="cat"><?php echo $catname ?></p>
                    <h3 class="title"><?php echo get_the_title() ?></h3>
                </div>
            </a>

        </div>
        <?php
    }
    wp_reset_postdata();


    echo '</div>';

    echo '</div>';

} // output_top_news
?>



			<?php //get_template_part( "menu", "left" ); ?>

                <?php
//                if (!$hide_instructor) output_instructor();
                output_news();
                ?>
                 <div class="content-bottom wrap">

                    <a class="bnr-bottom" href="http://works.fabb.me/" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/library/images/bnr01.jpg" /></a>
                </div>


			</div><?php //#base for pjax ?>


            <?php

//            $esTermIds = get_estation_columns();
//            $topicsTermIds = get_topics_columns();
            ?>
			<footer class="footer" role="contentinfo" itemscope itemtype="http://schema.org/WPFooter">

				<div id="inner-footer" class="wrap cf">

<!--					<a class="gototop pgscrl" href="#pagetop"><img src="--><?php //echo get_template_directory_uri(); ?><!--/library/images/gototop.png" /></a>-->

					<a class="footer-logo" href="<?php echo get_option('home'); ?>" rel="nofollow"><img src="<?php echo get_template_directory_uri(); ?>/library/images/logo_w.svg" alt="<?php bloginfo('name'); ?>" /></a>


                    <ul class="exlinks cf">
                        <li class="exlinkitem exbtn-fb">
                            <a href="https://www.facebook.com/fabbmag/" target="_blank">
                                <span class="icon icon-facebook"></span>
                            </a>
                        </li>
                        <li class="exlink-item exbtn-email">
                            <a href="<?php echo get_option('home'); ?>/contact/">
                                <span class="icon icon-email"></span>
                            </a>
                        </li>
                        <li class="exlink-item exbtn-fabb">
                            <a href="http://fabb.me/" target="_blank">
                                <img src="<?php echo get_template_directory_uri(); ?>/library/images/btn_fabbme.png" alt="FABB.ME" />
                            </a>
                        </li>
                    </ul>

                    <div class="footer-nav1 footer-nav cf">
                        <ul>
                            <li><a href="<?php echo get_option('home'); ?>">HOME</a></li>
                            <li><a href="<?php echo get_option('home'); ?>/worker/">ワーカーを探す</a></li>
                            <li><a href="<?php echo get_option('home'); ?>/casestudy/">制作事例</a></li>
                        </ul>
                    </div>

                    <div class="footer-nav2 footer-nav cf">
                        <ul>
                            <li><a href="<?php echo get_option('home'); ?>/company/">運営会社</a></li>
                            <li><a href="<?php echo get_option('home'); ?>/faq/">よくある質問</a></li>
                            <li><a href="<?php echo get_option('home'); ?>/privacy/">プライバシーポリシー</a></li>
                            <li><a href="<?php echo get_option('home'); ?>/tokusho/">特定商取引法の表示</a></li>
                            <li><a href="<?php echo get_option('home'); ?>/contact/">お問い合わせ</a></li>
                        </ul>
                    </div>


                    <a href="http://www.cloudot.co.jp/" class="source-org copyright" target="_blank">Copyright © Cloudot Inc. All Rights Reserved.</a>

				</div>

			</footer>

		</div>

		<?php // all js scripts are loaded in library/bones.php ?>
		<?php wp_footer(); ?>

            <script type="text/javascript" src="https://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>
			<script src="https://apis.google.com/js/platform.js" async defer>
				{lang: 'ja'}
			</script>
	</body>

</html> <!-- end of site. what a ride! -->
