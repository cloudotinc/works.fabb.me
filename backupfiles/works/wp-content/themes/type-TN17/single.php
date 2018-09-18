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
<!--contents-->
<section id="news-dt">
	<div class="inBox">
		<ul class="blogs detail">
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
					<dt><?php previous_post_link('%link', '%title', false, ''); ?></dt>
					<dd><?php next_post_link('%link', '%title', false, ''); ?></dd>
				 </dl>
			</li>
			
			<li>
				<div class="fb-like" data-href="<?php echo get_permalink(); ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
			</li>
			
		</ul>
		
	<?php get_sidebar(); ?>
	
	
	</div>
	
</section>



<?php get_footer(); ?>