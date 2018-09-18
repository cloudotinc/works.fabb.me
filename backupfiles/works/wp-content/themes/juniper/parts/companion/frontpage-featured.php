<?php
$juniper_left_featured = juniper_get_option('juniper_left_featured');
$juniper_center_featured = juniper_get_option('juniper_center_featured');
$juniper_right_featured = juniper_get_option('juniper_right_featured');
$juniper_featured = array(
    'juniper_left_featured'              =>  $juniper_left_featured,
    'juniper_center_featured'            =>  $juniper_center_featured,
    'juniper_right_featured'             =>  $juniper_right_featured,
);
$section_bg=juniper_get_option('fp-featured-background-image');
if (!empty($section_bg)) {
    $juniper_parallax="data-parallax='scroll' data-image-src='" . esc_url($section_bg) . "' style='background: transparent;padding:220px 0 200px;background: rgba(0, 0, 0, 0.3);'";
    $parallax_active="parallax_active";
} 
if (juniper_get_option('fp-featured-toggle') == '1') { ?>
   <section id="<?php if (juniper_get_option('fp-featured-slug')=='') {echo "featured";} else {echo esc_attr(juniper_get_option('fp-featured-slug'));} ?>" class="frontpage-row frontpage-featured <?php if(isset($parallax_active)){echo $parallax_active;} ?>" <?php if(isset($juniper_parallax)){echo $juniper_parallax;} ?>>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php if (juniper_get_option('fp-featured-title') != '') { ?>
                        <div class="featured-title h1"><span><?php echo esc_html(juniper_get_option('fp-featured-title')); ?></span></div>
                    <?php } ?>
                    <?php if (juniper_get_option('fp-featured-sub-title') != '') { ?>
                        <div class="featured-sub-title h4"><?php echo esc_html(juniper_get_option('fp-featured-sub-title')); ?></div>
                    <?php } ?>
                    <div class="row row-centered">
                    <?php
                    foreach ($juniper_featured as $key => $featured) {
                        if (!empty($featured)) {
                            $original_query = $wp_query;
                            $wp_query = null;
                            $wp_query = new WP_Query(array('page_id' => $featured, 'posts_per_page' => 1, 'post__not_in' => get_option( 'sticky_posts' )));
                            if (have_posts()) {
                                while (have_posts()) {
                                    the_post();
                                    $juniper_thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id($featured), 'juniper_750_500' );
                                    $juniper_thumb_url = $juniper_thumb_src[0];
                                    ?>
                                    <div class="col-sm-4 col-centered featured-item-col" data-sr="wait 0.2s, enter left and move 50px after 1s">
                                        <a class="featured-item" href="<?php echo get_permalink($featured); ?>">
                                            <img src="<?php echo $juniper_thumb_url; ?>" class="img-responsive center-block">
                                            <h4 class="featured-item-title"><?php the_title(); ?></h4>
                                            <p class="featured-item-sub-title"><?php $the_excerpt = juniper_get_the_excerpt_by_id($featured); if (!empty($the_excerpt)) { echo $the_excerpt;  } else { juniper_clear(8); } ?></p>
                                            <p class="featured-button"><span><?php _e('Learn More', 'juniper'); ?></span></p>
                                        </a>
                                    </div> 
                                    <?php
                                }
                            } else {
                                    get_template_part( 'parts/error', 'no_results');
                            }
                            $wp_query = null;
                            $wp_query = $original_query;
                            wp_reset_postdata();
                        }
                    }
                    ?> 
                    </div>
                </div> 
            </div>    
        </div>    
    </section> 
<?php } else if (juniper_get_option('fp-featured-toggle') == '3') {
    // Don't do anything
} else { ?>  
   <section id="<?php if (juniper_get_option('fp-featured-slug')=='') {echo "featured";} else {echo esc_attr(juniper_get_option('fp-featured-slug'));} ?>" class="frontpage-row frontpage-featured preview">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="featured-title h1"><span><?php _e('Theme Features', 'juniper'); ?></span></div>
                    <div class="featured-sub-title h4"><?php _e('Three reasons to choose Juniper for your next website project!', 'juniper'); ?></div>
                    <div class="row row-centered">
                        <div class="col-sm-4 col-centered featured-item-col" data-sr="wait 0.2s, enter left and move 50px after 1s">
                            <a class="featured-item" href="#">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/preview/750x500-<?php echo rand(1,8); ?>.jpg"class="img-responsive center-block">
                                <h4 class="featured-item-title"><?php _e('One-Page Layout', 'juniper'); ?></h4>
                                <p class="featured-item-sub-title"><?php _e('Beautiful one-page frontpage with smooth scrolling navigation.', 'juniper'); ?></p>
                                <p class="featured-button"><span><?php _e('Learn More', 'juniper'); ?></span></p>
                            </a>
                        </div>          
                        <div class="col-sm-4 col-centered featured-item-col" data-sr="wait 0.2s, enter left and move 50px after 1s">
                            <a class="featured-item" href="#">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/preview/750x500-<?php echo rand(1,8); ?>.jpg"class="img-responsive center-block">
                                <h4 class="featured-item-title"><?php _e('Customizer', 'juniper'); ?></h4>
                                <p class="featured-item-sub-title"><?php _e('Uses the WordPress Core customizer for easy administration.', 'juniper'); ?></p>
                                <p class="featured-button"><span><?php _e('Learn More', 'juniper'); ?></span></p>
                            </a>
                        </div> 
                        <div class="col-sm-4 col-centered featured-item-col" data-sr="wait 0.2s, enter left and move 50px after 1s">
                            <a class="featured-item" href="#">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/preview/750x500-<?php echo rand(1,8); ?>.jpg"class="img-responsive center-block">
                                <h4 class="featured-item-title"><?php _e('Parallax Effects', 'juniper'); ?></h4>
                                <p class="featured-item-sub-title"><?php _e('Graceful scroll-activated parallax effects throughout the theme.', 'juniper'); ?></p>
                                <p class="featured-button"><span><?php _e('Learn More', 'juniper'); ?></span></p>
                            </a>
                        </div> 
                    </div>    
                </div> 
            </div>    
        </div>    
    </section> 
<?php } ?>