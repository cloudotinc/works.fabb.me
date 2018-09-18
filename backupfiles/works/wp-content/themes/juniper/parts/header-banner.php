<?php if (is_front_page() && !is_paged())  { ?>
    <?php if (juniper_get_option('fp-banner-toggle') == '1') { ?>
        <?php  $section_bg=juniper_get_option('fp-banner-background-image');
        if (!empty($section_bg)) {
            $juniper_parallax="data-parallax='scroll' data-image-src='" . esc_url($section_bg) . "' style='background: rgba(0, 0, 0, 0.35);'";
            $parallax_active="parallax_active";
        } ?>
        <section class="frontpage-banner <?php if(isset($parallax_active)){echo $parallax_active;} ?>" <?php if(isset($juniper_parallax)){echo $juniper_parallax;} ?>>
            <div class="container">
                <div class="banner-wrap" data-sr='wait 0.4s, scale up 25%'>
                    <?php if (juniper_get_option('fp-banner-title') != '') { ?>
                        <div class="banner-title"><?php echo esc_html(juniper_get_option('fp-banner-title')); ?></div>
                    <?php } ?>
                    <?php if (juniper_get_option('fp-banner-sub-title') != '') { ?>
                        <div class="banner-sub-title"><?php echo esc_html(juniper_get_option('fp-banner-sub-title')); ?></div>
                    <?php } ?>
                    <?php if (juniper_get_option('fp-banner-video-button-url') != '') { ?>
                        <div class="banner-video-button banner-pop-button"><a href="<?php echo esc_url(juniper_get_option('fp-banner-video-button-url')); ?>"><i class="fa fa-play-circle-o"></i> <?php echo esc_html(juniper_get_option('fp-banner-video-button-text')); ?></a></div>
                    <?php } ?>
                    <?php if (juniper_get_option('fp-banner-button-url') != '') { ?>
                        <div class="banner-link-button"><a href="<?php echo esc_url(juniper_get_option('fp-banner-button-url')); ?>"><?php echo esc_html(juniper_get_option('fp-banner-button-text')); ?></a></div>
                    <?php } ?>
                    <?php if (juniper_get_option('fp-banner-map-button-url') != '') { ?>
                        <div class="banner-map-button banner-pop-button"><a href="<?php echo esc_url(juniper_get_option('fp-banner-map-button-url')); ?>"><i class="fa fa-map"></i> <?php echo esc_html(juniper_get_option('fp-banner-map-button-text')); ?></a></div>
                    <?php } ?>
                </div>      
            </div>    
        </section>  
    <?php } else { ?>  
        <?php $juniper_pp_toggle=trim(juniper_get_option('fp-pp-banner-toggle'));
        $p='';
        if (!empty($juniper_pp_toggle)){
            if ($juniper_pp_toggle=='post') {
                $p=intval(juniper_get_option('fp_pp_banner_posts'));
                $custom_args = array('posts_per_page' => 1, 'post__not_in' => get_option( 'sticky_posts' ), 'p' => $p);
            } else if ($juniper_pp_toggle=='page') {
                $p=intval(juniper_get_option('fp_pp_banner_page'));
                $custom_args = array('posts_per_page' => 1, 'page_id' => $p);
            }
        } else {
            $custom_args = array('posts_per_page' => 1, 'post__not_in' => get_option( 'sticky_posts' ));
        }
        $custom_query = new WP_Query( $custom_args );
        if ( $custom_query->have_posts() ) {
            while ( $custom_query->have_posts() ) {
                $custom_query->the_post(); 
                $sub_title=trim(juniper_get_option('fp-pp-banner-sub-title-override'));
                if (empty($sub_title)) {
                    $content = get_the_content();
                    $sub_title=wp_trim_words( $content , '5' );
                }
                if ( has_post_thumbnail() ) {
                    $thumb_id = get_post_thumbnail_id();
                    $thumb_url_array = wp_get_attachment_image_src($thumb_id);
                    $thumb_url = $thumb_url_array[0];
                    if (!empty($thumb_url)) {
                        $juniper_parallax="data-parallax='scroll' data-image-src='" . esc_url($thumb_url) . "' style='background: rgba(0, 0, 0, 0.35);'";
                        $parallax_active="parallax_active";
                    } 
                } else {
                    $section_bg=juniper_get_option('fp-banner-background-image');
                    if (!empty($section_bg)) {
                        $juniper_parallax="data-parallax='scroll' data-image-src='" . esc_url($section_bg) . "' style='background: rgba(0, 0, 0, 0.35);'";
                        $parallax_active="parallax_active";
                    } else {
                        $juniper_parallax="data-parallax='scroll' data-image-src='" . get_template_directory_uri() . "/assets/images/preview/sky.jpg' style='background: rgba(0, 0, 0, 0.35);'";
                        $parallax_active="parallax_active";
                    }
                }
                ?>
                <section class="frontpage-banner <?php if(isset($parallax_active)){echo $parallax_active;} ?>" <?php if(isset($juniper_parallax)){echo $juniper_parallax;} ?>>
                    <div class="container">
                        <div class="banner-wrap" data-sr='wait 0.9s, scale up 25%'>
                            <?php the_title('<div class="banner-title">','</div>'); ?>
                            <div class="banner-sub-title"><?php echo $sub_title; ?></div>
                            <div class="banner-link-button"><a href="<?php the_permalink(); ?>"><?php _e('Learn More', 'juniper' ); ?></a></div>
                        </div>    
                    </div>    
                </section> 
            <?php  }      
        }
        wp_reset_postdata(); ?>
    <?php } ?> 
<?php } else { ?> 
    <?php  
    if ( has_post_thumbnail() ) {
        $thumb_id = get_post_thumbnail_id();
        $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'full');
        $thumb_url = $thumb_url_array[0];
        if (!empty($thumb_url)) {
            $juniper_parallax="data-parallax='scroll' data-image-src='" . esc_url($thumb_url) . "' style='background: rgba(0, 0, 0, 0.35);'";
            $parallax_active="parallax_active";
        } 
    } else {
        $section_bg=juniper_get_option('sub-banner-background-image');
        if (!empty($section_bg)) {
            $juniper_parallax="data-parallax='scroll' data-image-src='" . esc_url($section_bg) . "' style='background: rgba(0, 0, 0, 0.35);'";
            $parallax_active="parallax_active";
        } else {
            $juniper_parallax="data-parallax='scroll' data-image-src='" . get_template_directory_uri() . "/assets/images/preview/sky.jpg' style='background: rgba(0, 0, 0, 0.35);'";
            $parallax_active="parallax_active";
        }
    } 
    ?>
        <section class="subpage-banner <?php if(isset($parallax_active)){echo $parallax_active;} ?>"  <?php if(isset($juniper_parallax)){echo $juniper_parallax;} ?>>
            <div class="container">
                <div class="banner-wrap" data-sr='wait 0.4s, scale up 25%'>
                    <h1 class="banner-title"><?php get_template_part( 'parts/title'); ?></h1>
                </div>    
            </div>    
        </section> 
<?php } ?>