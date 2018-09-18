<?php
/**
 * The default template for displaying bloglist
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 */
?>

		
<li class="heightitem">
	<!--カテゴリー名-->
	<p class="cate">
	<?php $cat = get_the_category(); ?>
	<?php $cat = $cat[0]; ?>
	<?php echo get_cat_name($cat->term_id); ?>
	</p>
	<a href="<?php the_permalink(); ?>">
	<dl>
		<dt>
			<?php if (has_post_thumbnail()) : ?>
				<?php the_post_thumbnail(); ?>
			<?php else : ?>
				<img src="<?php echo get_template_directory_uri(); ?>/images/noimage.jpg" alt="Bee Tree News">
			<?php endif ; ?>
		</dt>
		<dd>
			<p class="date"><?php the_time('Y.n.j'); ?></p>
			<h2><?php the_title(); ?></h2>
			<?php the_excerpt(); ?>
			<p class="readmore">続きを読む</p>
		</dd>
	</dl>
	</a>
</li>




