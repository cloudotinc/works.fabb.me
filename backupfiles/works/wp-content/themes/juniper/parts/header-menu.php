<nav id="menu_row" class="navbar navbar-default inbanner" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only"><?php _e('Toggle navigation', 'juniper' ); ?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
            <?php 
            $juniper_text_logo = trim(esc_html(juniper_get_option('logo')));
            if (!empty($juniper_text_logo)) { echo $juniper_text_logo; } else { echo get_bloginfo( 'name' ); } 
            ?>
            </a>
        </div>

        <?php
            wp_nav_menu( array(
                'theme_location'    => 'primary',
                'depth'             => 2,
                'container'         => 'div',
                'container_class'   => 'collapse navbar-collapse navbar-ex1-collapse',
                'menu_class'        => 'nav navbar-nav',
                'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                'walker'            => new wp_bootstrap_navwalker()
            ));
        ?>
    </div>
</nav>


