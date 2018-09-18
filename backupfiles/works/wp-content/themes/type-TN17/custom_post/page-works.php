<?php
/*
Template Name:ワークス一覧
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
<section class="topMgn25">

	<div class="title leftsp spCenter"><h2>Works</h2></div>

	<div class="inBox">
	
			<ul>
			
				<?php $paged = get_query_var('paged'); ?>
				<?php query_posts( array( 'post_type' => 'works',
				'posts_per_page' => 6,
				'paged' => $paged
				)); ?>
				<?php if(have_posts()): while(have_posts()): the_post(); ?>
				<li class="col3 works heightitem">
					<a href="<?php the_permalink(); ?>">
					<figure class="works">
					  <?php the_post_thumbnail('thumb140', array( 'alt' =>$title, 'title' => $title)); ?>
					  <figcaption class="overray-cap"><p><?php the_title(); ?></p></figcaption>
					</figure>
					</a>
				</li>
				<?php endwhile; endif; ?>

			</ul>
		
			<div class="paging btmMgn40">
				<?php global $wp_rewrite;
				$paginate_base = get_pagenum_link(1);
				if(strpos($paginate_base, '?') || ! $wp_rewrite->using_permalinks()){
				$paginate_format = '';
				$paginate_base = add_query_arg('paged','%#%');
				}
				else{
				$paginate_format = (substr($paginate_base,-1,1) == '/' ? '' : '/') .
				user_trailingslashit('page/%#%/','paged');;
				$paginate_base .= '%_%';
				}
				echo paginate_links(array(
				'base' => $paginate_base,
				'format' => $paginate_format,
				'total' => $wp_query->max_num_pages,
				'mid_size' => 6,
				'current' => ($paged ? $paged : 1),
				'prev_text' => '« 前へ',
				'next_text' => '次へ »',
				)); ?>
				
		</div>
		
	</div>
</section>
 

<!-- MAIN BOX END -->
<?php get_footer(); ?>
