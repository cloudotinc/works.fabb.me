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
	BLOG
================================================== -->
<section id="news-dt">
	<div class="inBox">
	

	<div class="blogWrap blogs">
		<h3>
		<?php
			if ( is_day() ) :
				printf( __( 'Daily Archives: %s', 'none' ), get_the_date() );
			elseif ( is_month() ) :
				printf( __( 'Monthly Archives: %s', 'none' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'none' ) ) );
			elseif ( is_year() ) :
				printf( __( 'Yearly Archives: %s', 'none' ), get_the_date( _x( 'Y', 'yearly archives date format', 'none' ) ) );
			else :
				_e( 'Archives', 'none' );
			endif;
		?>
		</h3>

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
			
		<a href="<?php echo home_url(); ?>/bloglist" class="pageback">お知らせ一覧へ</a>
		
	</div>
	
	<?php get_sidebar(); ?>
		
</div>
</section>



<?php get_footer(); ?>
