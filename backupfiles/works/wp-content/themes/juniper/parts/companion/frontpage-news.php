<?php 
$section_bg=juniper_get_option('fp-news-background-image');
if (!empty($section_bg)) {
    $juniper_parallax="data-parallax='scroll' data-image-src='" . esc_url($section_bg) . "' style='background: transparent;padding:220px 0 200px;background: rgba(0, 0, 0, 0.3);'";
    $parallax_active="parallax_active";
} 
if ((juniper_get_option('fp-news-toggle') == '1') || (juniper_get_option('fp-news-toggle') == '')) { ?>
    <?php if ( get_option( 'show_on_front' ) == 'page' ) { ?>
        <section id="<?php if (juniper_get_option('fp-news-slug')=='') {echo "news";} else {echo esc_attr(juniper_get_option('fp-news-slug'));} ?>" class="frontpage-row frontpage-news <?php if(isset($parallax_active)){echo $parallax_active;} ?>" <?php if(isset($juniper_parallax)){echo $juniper_parallax;} ?>>
            <div class="container">
                <div class="row">
                    <div class="col-md-12 content-column">
                        <?php if (juniper_get_option('fp-news-title') != '') { ?>
                            <div class="news-title h1"><span><?php echo esc_html(juniper_get_option('fp-news-title')); ?></span></div>
                        <?php } ?>
                        <?php if (juniper_get_option('fp-news-sub-title') != '') { ?>
                            <div class="news-sub-title h4"><?php echo esc_html(juniper_get_option('fp-news-sub-title')); ?></div>
                        <?php } ?>
                        <?php the_content(); ?>
                    </div> 
                </div>    
            </div>    
        </section>
    <?php } else { ?>
        <section id="<?php if (juniper_get_option('fp-news-slug')=='') {echo "news";} else {echo esc_attr(juniper_get_option('fp-news-slug'));} ?>" class="frontpage-row frontpage-news" <?php if(isset($juniper_parallax)){echo $juniper_parallax;} ?>>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <?php if (juniper_get_option('fp-news-title') != '') { ?>
                            <div class="news-title h1"><span><?php echo esc_html(juniper_get_option('fp-news-title')); ?></span></div>
                        <?php } else { ?>
                            <div class="news-title h1"><span><?php _e('Latest Articles', 'juniper'); ?></span></div>
                        <?php } ?>
                        <?php if (juniper_get_option('fp-news-sub-title') != '') { ?>
                            <div class="news-sub-title h4"><?php echo esc_html(juniper_get_option('fp-news-sub-title')); ?></div>
                        <?php } else { ?>
                            <div class="news-sub-title h4"><?php _e('Get up to date with the latest news from our newsroom.', 'juniper'); ?></div>
                        <?php } ?>
                        <?php get_template_part( 'parts/content', 'blog'); ?>
                    </div> 
                </div>    
            </div>    
        </section>
    <?php } ?>
<?php } else if (juniper_get_option('fp-news-toggle') == '2') {
    // Don't do anything
}  ?>