<?php
/*
Template Name:コンセプト
*/
?>
<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>


<!-- ===============================================
	ABOUT
================================================== -->

<?php /* The loop */ ?>
<?php while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<?php 
			remove_filter('the_content', 'wpautop');
			the_content();
			add_filter('the_content', 'wpautop');

			 ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>

	</article><!-- #post -->

	<?php comments_template(); ?>
<?php endwhile; ?>


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