<?php
/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>


<section id="news-dt">
	<div class="inBox">
	

	<div class="blogWrap blog">
		<h3><?php printf( __( 'Search Results for: %s', 'twentythirteen' ), get_search_query() ); ?></h3>

		<ul class="blog">
	
			<?php if ( have_posts() ) : ?>

				<?php if ( category_description() ) : // Show an optional category description ?>
				<p class="textC point"><?php echo category_description(); ?></p>
				<?php endif; ?>

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'bloglist', get_post_format() ); ?>
			<?php endwhile; ?>

			<?php else : ?>
				<h4>見つかりませんでした。</h4>
				<p class="textC">ご指定の検索条件に合う投稿はありませんでした。他のキーワードでもう一度お探しください。</p>
			<?php endif; ?>
				
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
				'current' => ($paged ? $paged : 1),
				'prev_text' => '« 前へ',
				'next_text' => '次へ »',
			)); ?>
		</div>
			
		<ul class="blog detail tolist">
			<!--preview next-->
			<li class="prenex">
				<p class="textC normal btmMgn0">« <a href="<?php echo home_url(); ?>/newslist">お知らせ一覧へ</a></p>
			</li>
		</ul>
	</div>
	
	<?php get_sidebar(); ?>
		
</div>
</section>



<?php get_footer(); ?>
