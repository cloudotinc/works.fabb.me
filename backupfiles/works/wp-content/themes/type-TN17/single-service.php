<?php
/**
 * The template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header();

$template_url = get_template_directory_uri();

$term = get_current_tax($post->ID, 'service_cat');

$termimg = get_field('srvcat_img_main', $term);
if ($termimg) {
    $termimg_url = $termimg['sizes'][ 'large' ];
}
?>


<!-- ===============================================
	CONTENTS
================================================== -->

<script>
    jQuery(function($) {

        $('#s_kv').imgLiquid({
            verticalAlign: "top",
            horizontalAlign: "left"
        });

    });
</script>

    <div id="s_kv" class="clearfix">
        <img src="<?php echo $termimg_url ?>" />
        <h2><?php echo $term->name ?></h2>
    </div>

    <div id="d_main">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <section id="d_item">
            <?php
            $thumbn_url = get_thumb_url('large');
            ?>
            <img src="<?php echo $thumbn_url ?>" />
            <div id="d_plan">
                <h3><?php the_title() ?><strong><br class="clear">&yen;&nbsp;<?php the_field('srv_price') ?><span>(税込)</span></strong></h3>
                <div class="d_line"></div>
                <p><?php the_field('srv_description') ?></p>
                <a href="/contact/"><div id="d_app_btn">お申し込みはこちら</div></a>
            </div>
        </section>
        <section id="detail">
            <h2>詳細</h2>
            <?php
            the_content();
            ?>
            <a href="/service/" class="d_btn"><p>サービス一覧へ</p></a>
        </section>

<?php endwhile; ?>

<?php endif; ?>

    </div>

<?php get_footer(); ?>