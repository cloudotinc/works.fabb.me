<?php
/**
 * The template for displaying all single posts
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
		<div class="blogWrap">

			<ul class="blog detail">
				<li>
					<dl>
						<dt>
							<p class="date"><?php the_time('Y.n.j'); ?></p>
							<h2 class="blog-listT"><?php the_title(); ?></h2>
						</dt>
						<dd>
							<?php the_post_thumbnail('large'); ?>
							<?php while ( have_posts() ) : the_post(); ?>
								<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'none' ) ); ?>
								<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'none' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
							<?php endwhile; ?>
	
						</dd>
					 </dl>
				</li>
				
				<!--preview next-->
				<li class="prenex">
					<dl>
						<dt><?php previous_post_link('&laquo; %link', '%title', false, ''); ?></dt>
						<dd><?php next_post_link('%link &raquo;', '%title', false, ''); ?></dd>
					 </dl>
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
		<ul>
		</ul>
		</div>
		<!-- SIDEMENU END-->
		
	</div>
</section>


<!-- MAIN BOX END -->
<?php get_footer(); ?>
