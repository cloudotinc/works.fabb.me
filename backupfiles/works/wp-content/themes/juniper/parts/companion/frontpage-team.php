<?php 
$section_bg=juniper_get_option('fp-team-background-image');
if (!empty($section_bg)) {
    $juniper_parallax="data-parallax='scroll' data-image-src='" . esc_url($section_bg) . "' style='background: transparent;padding:220px 0 200px;background: rgba(0, 0, 0, 0.3);'";
    $parallax_active="parallax_active";
} 
if (juniper_get_option('fp-team-toggle') == '1') { ?>
    <section id="<?php if (juniper_get_option('fp-team-slug')=='') {echo "team";} else {echo esc_attr(juniper_get_option('fp-team-slug'));} ?>" class="frontpage-row frontpage-team <?php if(isset($parallax_active)){echo $parallax_active;} ?>" <?php if(isset($juniper_parallax)){echo $juniper_parallax;} ?>>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="team-title h1"><span><?php echo esc_html(juniper_get_option('fp-team-title')); ?></span></div>
                    <div class="team-sub-title h4"><?php echo esc_html(juniper_get_option('fp-team-sub-title')); ?></div>
                    
                    <div class="row row-centered">
                        <?php if ( is_active_sidebar( 'frontpage-team-left' ) ) { ?>
                        	<div class="col-sm-3 col-centered">
                        		<?php dynamic_sidebar( 'frontpage-team-left' ); ?>
                        	</div>
                        <?php } ?>
                        <?php if ( is_active_sidebar( 'frontpage-team-center-left' ) ) { ?>
                        	<div class="col-sm-3 col-centered">
                        		<?php dynamic_sidebar( 'frontpage-team-center-left' ); ?>
                        	</div>
                        <?php } ?>
                        <?php if ( is_active_sidebar( 'frontpage-team-center-right' ) ) { ?>
                        	<div class="col-sm-3 col-centered">
                        		<?php dynamic_sidebar( 'frontpage-team-center-right' ); ?>
                        	</div>
                        <?php } ?>
                        <?php if ( is_active_sidebar( 'frontpage-team-right' ) ) { ?>
                        	<div class="col-sm-3 col-centered">
                        		<?php dynamic_sidebar( 'frontpage-team-right' ); ?>
                        	</div>
                        <?php } ?>
                    </div>    

                </div> 
            </div>    
        </div>    
    </section> 
<?php } else if (juniper_get_option('fp-team-toggle') == '3') {
    // Don't do anything
} else { ?>  
    <section id="<?php if (juniper_get_option('fp-team-slug')=='') {echo "team";} else {echo esc_attr(juniper_get_option('fp-team-slug'));} ?>" class="frontpage-row frontpage-team preview">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="team-title h1"><span><?php _e('Meet the Team', 'juniper'); ?></span></div>
                    <div class="team-sub-title h4"><?php _e('Showcase the great people behind your company.', 'juniper'); ?></div>
                    
                    <div class="row row-centered">

                        <div class="col-sm-3 col-centered">
                            <div class="team-item" data-sr="wait 0.3s, enter right and move 50px after 1s">
                                <img class="img-responsive center-block" src="<?php echo get_template_directory_uri(); ?>/assets/images/preview/262x262-6.jpg" />
                                <h4 class="team-item-title"><?php _e('Sally Brown', 'juniper'); ?></h4>
                                <h5 class="team-item-sub-title"><?php _e('CEO and Chair Woman', 'juniper'); ?></h5>
                                <p class="team-social-icons"><a href="#"><i class="fa fa-youtube"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-facebook"></i></a></p>
                            </div>
                        </div> 

                       <div class="col-sm-3 col-centered">
                            <div class="team-item" data-sr="wait 0.3s, enter right and move 50px after 1s">
                                <img class="img-responsive center-block" src="<?php echo get_template_directory_uri(); ?>/assets/images/preview/262x262-1.jpg" />
                                <h4 class="team-item-title"><?php _e('John Smith', 'juniper'); ?></h4>
                                <h5 class="team-item-sub-title"><?php _e('CFO and Mascot', 'juniper'); ?></h5>
                                <p class="team-social-icons"><a href="#"><i class="fa fa-youtube"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-facebook"></i></a></p>
                            </div>
                        </div>           
                        
                        <div class="col-sm-3 col-centered">
                            <div class="team-item" data-sr="wait 0.3s, enter right and move 50px after 1s">
                                <img class="img-responsive center-block" src="<?php echo get_template_directory_uri(); ?>/assets/images/preview/262x262-2.jpg" />
                                <h4 class="team-item-title"><?php _e('Emma Kline', 'juniper'); ?></h4>
                                <h5 class="team-item-sub-title"><?php _e('Vice President', 'juniper'); ?></h5>
                                <p class="team-social-icons"><a href="#"><i class="fa fa-youtube"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-facebook"></i></a></p>
                            </div>
                        </div> 
                        
                        <div class="col-sm-3 col-centered">
                            <div class="team-item" data-sr="wait 0.3s, enter right and move 50px after 1s">
                                <img class="img-responsive center-block" src="<?php echo get_template_directory_uri(); ?>/assets/images/preview/262x262-3.jpg" />
                                <h4 class="team-item-title"><?php _e('Tom Baggins', 'juniper'); ?></h4>
                                <h5 class="team-item-sub-title"><?php _e('Project Manager', 'juniper'); ?></h5>
                                <p class="team-social-icons"><a href="#"><i class="fa fa-youtube"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-facebook"></i></a></p>
                            </div>
                        </div> 
                    </div>    

                </div> 
            </div>    
        </div>    
    </section> 
<?php } ?> 

