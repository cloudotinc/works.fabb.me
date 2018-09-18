<?php
/**
 * The template for displaying Category pages
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>


<!-- ===============================================
	BLOG
================================================== -->
<!--ブログ記事-->
<?php
	$category = get_the_category();
	$cat_id   = $category[0]->cat_ID;
	$cat_name = $category[0]->cat_name;
	$cat_slug = $category[0]->category_nicename;
?>
<section id="news-dt">
	<div class="inBox">
	
	
	<div class="blogWrap blogs">
		
		<h3>カテゴリー：<?php echo $cat_name; ?></h3>
		
		<ul class="blogs">
		
			<?php if ( have_posts() ) : ?>

				<?php if ( category_description() ) : // Show an optional category description ?>
				<p class="textC point"><?php echo category_description(); ?></p>
				<?php endif; ?>

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'bloglist', get_post_format() ); ?>
			<?php endwhile; ?>


		<?php else : ?>
			<?php get_template_part( 'bloglist', 'none' ); ?>
		<?php endif; ?>
				
		</ul>
		
		<div class="paging">
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
				'current' => ($paged ? $paged : 1),
				'prev_text' => '« 前へ',
				'next_text' => '次へ »',
			)); ?>
		</div>
			
		<a href="<?php echo home_url(); ?>/bloglist" class="pageback">お知らせ一覧へ</a>

	</div>
	
	<?php get_sidebar(); ?>
		
</div>
</section>



<?php get_footer(); ?>











