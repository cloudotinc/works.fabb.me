<?php 
$section_bg=juniper_get_option('fp-social-background-image');
if (!empty($section_bg)) {
    $juniper_parallax="data-parallax='scroll' data-image-src='" . esc_url($section_bg) . "' style='background: transparent;padding:220px 0 200px;background: rgba(0, 0, 0, 0.3);'";
    $parallax_active="parallax_active";
} 
if (juniper_get_option('fp-social-toggle') == '1') { ?>
    <section id="<?php if (juniper_get_option('fp-social-slug')=='') {echo "social";} else {echo esc_attr(juniper_get_option('fp-social-slug'));} ?>" class="frontpage-row frontpage-social <?php if(isset($parallax_active)){echo $parallax_active;} ?>" <?php if(isset($juniper_parallax)){echo $juniper_parallax;} ?>>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php if (juniper_get_option('fp-social-title') != '') { ?>
                        <div class="social-title h1"><span><?php echo esc_html(juniper_get_option('fp-social-title')); ?></span></div>
                    <?php } ?>
                    <?php if (juniper_get_option('fp-social-sub-title') != '') { ?>
                        <div class="social-sub-title h4"><?php echo esc_html(juniper_get_option('fp-social-sub-title')); ?></div>
                    <?php } ?>
                    <div class="inline-center-wrapper">  
                    <?php if ( is_active_sidebar( 'frontpage-social-media' ) ) { ?>
                    	<?php dynamic_sidebar( 'frontpage-social-media' ); ?>
                    <?php } ?>
                    </div>
                </div> 
            </div>    
        </div>    
    </section> 
<?php } else if (juniper_get_option('fp-social-toggle') == '3') {
    // Don't do anything
} else { ?>  
    <section id="<?php if (juniper_get_option('fp-social-slug')=='') {echo "social";} else {echo esc_attr(juniper_get_option('fp-social-slug'));} ?>" class="frontpage-row frontpage-social preview parallax_active" data-parallax='scroll' data-image-src='<?php echo get_template_directory_uri(); ?>/assets/images/preview/hills.jpg' style='background: transparent;padding:220px 0 200px;background: rgba(0, 0, 0, 0.3);'>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="social-title h1"><span><?php _e('Connect With Us', 'juniper'); ?></span></div>
                    <div class="social-sub-title h4"><?php _e('There are lots of ways to connect with us, and we want you to try them all!', 'juniper'); ?></div>
                    <div class="inline-center-wrapper">  
                        <div data-sr="wait 0.2s, scale up 25%">
                            <a href="#"><i class="fa fa-bitbucket"></i><br><span class="social-item-title h5"><?php _e('BitBucket', 'juniper'); ?></span><br><span class="social-item-sub-title h5"><?php _e('Follow our code.', 'juniper'); ?></span></a>
                        </div>
                        <div data-sr="wait 0.2s, scale up 25%">
                            <a href="#"><i class="fa fa-twitter"></i><br><span class="social-item-title h5"><?php _e('Twitter', 'juniper'); ?></span><br><span class="social-item-sub-title h5"><?php _e('Latest tweets.', 'juniper'); ?></span></a>
                        </div>
                        <div data-sr="wait 0.2s, scale up 25%">
                            <a href="#"><i class="fa fa-facebook"></i><br><span class="social-item-title h5"><?php _e('Facebook', 'juniper'); ?></span><br><span class="social-item-sub-title h5"><?php _e('Be our friend.', 'juniper'); ?></span></a>
                        </div>
                        <div data-sr="wait 0.2s, scale up 25%">
                            <a href="#"><i class="fa fa-instagram"></i><br><span class="social-item-title h5"><?php _e('Instagram', 'juniper'); ?></span><br><span class="social-item-sub-title h5"><?php _e('See our pics.', 'juniper'); ?></span></a>
                        </div>
                        <div data-sr="wait 0.2s, scale up 25%">
                            <a href="#"><i class="fa fa-linkedin"></i><br><span class="social-item-title h5"><?php _e('Linkedin', 'juniper'); ?></span><br><span class="social-item-sub-title h5"><?php _e('Let\'s network.', 'juniper'); ?></span></a>
                        </div>
                    </div>
                </div> 
            </div>    
        </div>    
    </section> 
<?php } ?> 

