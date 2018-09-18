<?php
/*
Template Name:ブログ記事一覧
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

<section id="news-dt">
	<div class="inBox">

	<div class="blogWrap blogs">
		<ul class="blogs">
			<?php
			$paged = (int) get_query_var('paged');
			$args = array(
				'posts_per_page' => 9,
				'paged' => $paged,
				'orderby' => 'post_date',
				'order' => 'DESC',
				'post_type' => 'post',
				'post_status' => 'publish'
			);
			$the_query = new WP_Query($args);
			if ( $the_query->have_posts() ) :
				while ( $the_query->have_posts() ) : $the_query->the_post();
					get_template_part( 'bloglist', get_post_format() );
				endwhile;
			else:
				get_template_part( 'bloglist', 'none' );
			endif;
			wp_reset_postdata();
			?>
			
		</ul>
		
		<div class="paging">
			<?php
			if ($the_query->max_num_pages > 1) {
				echo paginate_links(array(
					'base' => get_pagenum_link(1) . '%_%',
					'format' => '/page/%#%/',
					'current' => max(1, $paged),
					'total' => $the_query->max_num_pages
				));
			}
			wp_reset_postdata();
			?>
		</div>
	</div>
	
	
<?php get_sidebar(); ?>
	
</div>
</section>



<?php get_footer(); ?>