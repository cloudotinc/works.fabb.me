<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Thirteen
 * already has tag.php for Tag archives, category.php for Category archives,
 * and author.php for Author archives.
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
<section class="topMgn25">
	<div class="title leftsp left0 spCenter"><h2>Works</h2></div>

	<div class="wrapper">
	
		<!--blog-->
		<div class="blogWrap">
			<h2 class="page_ttl btmMgn20">
			<!--トップページの時-->
			<?php if(is_home()):  ?>
						<?php bloginfo('name'); ?>
			<!--固定ページの時-->
			<?php elseif(is_page()): ?>
						<?php wp_title(''); ?> | <?php bloginfo('name'); ?>
			<!--カスタムタクソノミーのアーカイブページの時-->
			<?php elseif(is_tax()): ?>
						<?php $taxonomy = get_taxonomy(get_query_var('taxonomy'));
								echo sprintf('%s', single_term_title('', false)); ?>
			<!--アーカイブページの時-->
			<?php elseif(is_archive()): ?>
						<!--<?php echo esc_html(get_post_type_object(get_post_type())->label ); ?>-->
						月別アーカイブ：<?php the_time('n'); ?>月
			<!--投稿個別記事ページの時-->
			<?php elseif(is_single()): ?>
						<?php wp_title(''); ?> | <?php bloginfo('name'); ?>
			<?php endif; ?>
			</h2>

			<ul>
			
				<?php if ( have_posts() ) : ?>
		
					<?php if ( category_description() ) : // Show an optional category description ?>
					<p class="textC point"><?php echo category_description(); ?></p>
					<?php endif; ?>
		
				<?php /* The loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
				
				<li class="col3 works heightitem">
					<a href="<?php the_permalink(); ?>">
					<figure class="works">
					  <?php the_post_thumbnail('thumb140', array( 'alt' =>$title, 'title' => $title)); ?>
					  <figcaption class="overray-cap"><p><?php the_title(); ?></p></figcaption>
					</figure>
					</a>
				</li>
				
				<?php endwhile; ?>
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
				
			<ul class="blog detail">
				<!--preview next-->
				<li class="prenex">
					<p class="textC nomal btmMgn0 point"><a href="<?php echo home_url(); ?>/works">Works一覧ページへ</a></p>
				</li>
			</ul>
		
		</div>
		
		<!-- SIDEMENU-->
		<div id="sidemenu">
		<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
			<div id="widget-area" class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'sidebar-2' ); ?>
			</div><!-- .widget-area -->
		<?php endif; ?>
		</div>
		<!-- SIDEMENU END-->
		
	</div>
</section>
 




<!-- MAIN BOX END -->
<?php get_footer(); ?>
