<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>


<!-- ===============================================
	CONTENTS
================================================== -->

  <!-- コンセプト -->
  <section id="to_concept">
    <h2 class="inner">
      <p><img src="<?php echo get_template_directory_uri(); ?>/images/fabbwork_text.png" alt="FABB.WORKとは？"></p>
      <a href="/concept/"><img src="<?php echo get_template_directory_uri(); ?>/images/concept_botton.png" alt="コンセプトをみる"></a>
    </h2>
  </section> 
<!-- サービス  -->
  <section id="to_service" class="inner">
    <h2><img src="<?php echo get_template_directory_uri(); ?>/images/service_title.png" alt="サービス"></h2>
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
            <li class="t_se_box1">
                <div class="t_circle">
                    <img src="<?php echo $iconurl ?>" alt="<?php echo $term->name ?>">
                </div>
                <div class="t_se_rightbox">
                    <h3>
                        <?php echo $term->name ?>
                    </h3>
                    <div class="t_se_box2">
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
    <a id="to_se_page" href="/service/"><p>サービス一覧ページへ</p></a> 
  </section>
<!-- お知らせ-->
  <section id="to_info">
    <h2><img src="<?php echo get_template_directory_uri(); ?>/images/information.png" alt="インフォメーション"></h2>
    <div class="inner">
		<dl>
			<?php
			$newslist = get_posts( array(
			//ここに取得条件を色々書く
			'posts_per_page' => 4
			));
			foreach( $newslist as $post ):
			setup_postdata( $post );
			?>
		  <dt><?php the_time('Y.n.j'); ?></dt>
		  <dd><a href="<?php the_permalink(); ?>">
		  <?php the_title(); ?>
		  </a></dd>
			<?php
			endforeach;
			wp_reset_postdata();
			?>
		</dl>
    </div>
    <a id="to_info_con" href="/news/"><p id="to_info_botton">お知らせ一覧ページへ</p></a>
  </section>


<?php get_footer(); ?>