<?php
/*
Template Name:確認画面
*/
?>

<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>




<!-- ===============================================
	BLOG
================================================== -->

<section id="form" class="contact">
	<h2 class="c05">
	<img src="<?php echo get_template_directory_uri(); ?>/images/icon_form.png" alt="お問い合わせ">
	Contact Form<span> お問い合わせフォーム</span>
	</h2>
	<div class="inBox">
		
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>


						<?php 
						remove_filter('the_content', 'wpautop');
						the_content();
						add_filter('the_content', 'wpautop');

						 ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>


				<?php comments_template(); ?>
			<?php endwhile; ?>
		
	</div>
</section>



<?php get_footer(); ?>