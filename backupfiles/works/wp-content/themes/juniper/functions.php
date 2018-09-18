<?php

/* **************************************************************************************************** */
// Setup Theme
/* **************************************************************************************************** */

add_action('after_setup_theme', 'juniper_setup');

if (!function_exists('juniper_setup')){

    function juniper_setup() {

       // Localization

        $lang_local = get_template_directory() . '/lang';
        load_theme_textdomain('juniper', $lang_local);

        // Register Thumbnail Sizes

        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(1170, 9999, true);
        add_image_size('juniper_750_500', 750, 500, true);

        // Load feed links

        add_theme_support('automatic-feed-links');
        
        // Let WordPress manage the document title.

		add_theme_support( 'title-tag' );

        // Support Custom Background

        $juniper_custom_background_defaults = array(
            'default-color' => 'e7e7e7'
        );
        add_theme_support( 'custom-background', $juniper_custom_background_defaults );
        
        // Set Content Width

        global $content_width;
        if ( ! isset( $content_width ) ) {
            $content_width = 720;
        }

        // Register Menus

        register_nav_menu('primary', __('Primary Menu', 'juniper'));
        
    }
}



/* **************************************************************************************************** */
// Customizer stuff
/* **************************************************************************************************** */

require_once(get_template_directory() . '/inc/kirki/kirki.php' );
require_once(get_template_directory() . '/inc/options.php' );
require_once(get_template_directory() . '/inc/pro/class-customize.php' );


/* **************************************************************************************************** */
// Do TGM
/* **************************************************************************************************** */

require_once(get_template_directory() . '/inc/tgm/tgm-init.php' );


/* **************************************************************************************************** */
// Custom NavWalker
/* **************************************************************************************************** */
 
require_once(get_template_directory() . '/inc/wp_bootstrap_navwalker.php');


/* **************************************************************************************************** */
// Meta Boxes
/* **************************************************************************************************** */

require_once(get_template_directory() . '/inc/meta_boxes.php');


/* **************************************************************************************************** */
// Do Title 
/* **************************************************************************************************** */

add_action('wp_title', 'juniper_title');
  
function juniper_title() {
    global $wp_query;
    $title = get_bloginfo('name');
    $seporate = ' | ';
    if (is_front_page()) {
        $title = get_bloginfo('name');
    } else if (is_feed()) {
        $title = '';
    } else if (is_page() || is_single()) {
        $postid = $wp_query->post->ID;
        $title = the_title('','',false) . $seporate . get_bloginfo('name');
    }
    wp_reset_query();
    return $title;
}



/* **************************************************************************************************** */
// Modify Search Form
/* **************************************************************************************************** */

if (!function_exists('juniper_modify_search_form')){
    function juniper_modify_search_form($form) {
        $form = '<form method="get" id="searchform" action="'.esc_url( home_url( '/' ) ).'" >';
        if (is_search()) {
            $form .='<input type="text" value="' . esc_attr(apply_filters('the_search_query', get_search_query())) . '" name="s" id="s" />';
        } else {
            $form .='<input type="text" value="'.esc_attr(__('Search','juniper')).'" name="s" id="s"  onfocus="if(this.value==this.defaultValue)this.value=\'\';" onblur="if(this.value==\'\')this.value=this.defaultValue;"/>';
        }
        $form .= '<input type="image" id="searchsubmit" src="' . get_template_directory_uri() . '/assets/images/search_icon.png" />
                </form>';
        return $form;
    }
}
add_filter('get_search_form', 'juniper_modify_search_form');


/* **************************************************************************************************** */
// Override gallery style
/* **************************************************************************************************** */

add_filter( 'use_default_gallery_style', '__return_false' );



/* **************************************************************************************************** */
// Register Sidebars
/* **************************************************************************************************** */

add_action('widgets_init', 'juniper_register_sidebars');

if (!function_exists('juniper_register_sidebars')){
    function juniper_register_sidebars() {
       
        
    register_sidebar(array(
        'name' => __('Default Page Sidebar', 'juniper'),
        'id' => 'sidebar_pages',
        'description' => __('Widgets in this area will be displayed in the sidebar on the pages.', 'juniper'),
        'before_widget' => '<div id="%1$s" class="widget %2$s widget sidebar_widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget_title">',
        'after_title' => '</h3>'
    ));

    register_sidebar(array(
        'name' => __('Default Blog Sidebar', 'juniper'),
        'id' => 'sidebar_blog',
        'description' => __('Widgets in this area will be displayed in the sidebar on the blog and posts.', 'juniper'),
        'before_widget' => '<div id="%1$s" class="widget %2$s widget sidebar_widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget_title">',
        'after_title' => '</h3>'
    ));    
        
        // create 50 alternate sidebar widget areas for use on post and pages
        $i = 1;
        while ($i <= 10) {
            register_sidebar(array(
                'name' => __('Alternate Sidebar #', 'juniper') . $i,
                'id' => 'sidebar_' . $i,
                'description' => __('Widgets in this area will be displayed in the sidebar for any posts, pages or portfolio items that are taged with sidebar', 'juniper') . $i . '.',
                'before_widget' => '<div class="widget">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widget_title">',
                'after_title' => '</h3>'
            ));
            $i++;
        }
    }
}

/* **************************************************************************************************** */
// Excerpt Modifications
/* **************************************************************************************************** */

// Excerpt Length

add_filter('excerpt_length', 'juniper_excerpt_length');
if (!function_exists('juniper_excerpt_length')){
    function juniper_excerpt_length($length) {
        return 40;
    }
}

// Excerpt More

add_filter('excerpt_more', 'juniper_excerpt_more');

if (!function_exists('juniper_excerpt_more')){
    function juniper_excerpt_more($more) {
        return '';
    }
}

// Add to pages

add_action('init', 'juniper_add_excerpts_to_pages');

if (!function_exists('juniper_add_excerpts_to_pages')){
    function juniper_add_excerpts_to_pages() {
        add_post_type_support('page', 'excerpt');
    }
}


// Get my ID

function juniper_get_the_excerpt_by_id($post_id) {
  global $post;
  $save_post = $post;
  $post = get_post($post_id);
  $output = get_the_excerpt();
  $post = $save_post;
  return $output;
}

/* **************************************************************************************************** */
// Enable Threaded Comments
/* **************************************************************************************************** */

add_action('wp_enqueue_scripts', 'juniper_threaded_comments');

function juniper_threaded_comments() {
    if (is_singular() && comments_open() && (get_option('thread_comments') == 1)) {
        wp_enqueue_script('comment-reply');
    }
}

/* **************************************************************************************************** */
// Modify Comments Output
/* **************************************************************************************************** */

if (!function_exists('juniper_comment')){
    function juniper_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        ?>
        <li <?php comment_class(); ?> id="li_comment_<?php comment_ID() ?>">
            <div id="comment_<?php comment_ID(); ?>" class="comment_wrap clearfix">
                <?php echo get_avatar($comment, $size = '75'); ?>
                <div class="comment_content">
                    <p class="left"><strong><?php comment_author_link(); ?></strong><br />
                    <?php echo(get_comment_date()) ?> <?php edit_comment_link(__('(Edit)', 'juniper'), '  ', '') ?></p>
                    <p class="right"><?php comment_reply_link(array_merge($args, array('reply_text' => __('Leave a Reply', 'juniper'), 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?></p>
                    <div class="clear"></div>
                    <?php
                    if ($comment->comment_approved == '0') {
                    ?>
                        <em><?php _e('Your comment is awaiting moderation.', 'juniper') ?></em>
                    <?php
                    }
                    ?>
                    <?php comment_text() ?>
                </div>
                <div class="clear"></div>
            </div>
    <?php
    }
}


/* **************************************************************************************************** */
// Modify Ping Output
/* **************************************************************************************************** */

if (!function_exists('juniper_ping')){
    function juniper_ping($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;
        ?>
        <li id="comment_<?php comment_ID(); ?>"><?php comment_author_link(); ?> - <?php comment_excerpt(); ?>
    <?php
    }
}


/* **************************************************************************************************** */
// Modify Comment Text Fields
/* **************************************************************************************************** */

add_filter('comment_form_default_fields', 'juniper_comment_fields');

if (!function_exists('juniper_comment_fields')){
    function juniper_comment_fields($fields) {

        $commenter = wp_get_current_commenter();
        $req = get_option('require_name_email');
        $aria_req = ( $req ? " aria-required='true'" : '' );

        $fields['author'] = '<div class="row"><div class="col-md-4 comment_fields"><p class="comment-form-author">' . '<label for="author">' . __('Name', 'juniper') . '</label> ' . ( $req ? '<span class="required">*</span><br />' : '' ) . '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' /></p>';
        $fields['email'] = '<p class="comment-form-email"><label for="email">' . __('Email', 'juniper') . '</label> ' . ( $req ? '<span class="required">*</span><br />' : '' ) . '<input id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' /></p>';
        $fields['url'] = '<p class="comment-form-url"><label for="url">' . __('Website', 'juniper') . '</label><br />' . '<input id="url" name="url" type="text" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" /></p></div> ';

        return $fields;
    }
}


/* **************************************************************************************************** */
// Modify Avatar Classes
/* **************************************************************************************************** */

add_filter('get_avatar','juniper_avatar_class');

if (!function_exists('juniper_avatar_class')){
    function juniper_avatar_class($class) {
        $class = str_replace("class='avatar", "class='avatar img-responsive", $class) ;
        return $class;
    }
}

/* **************************************************************************************************** */
// Add Post Link Classes
/* **************************************************************************************************** */

add_filter('next_post_link', 'juniper_posts_link_next_class');

if (!function_exists('juniper_posts_link_next_class')){
    function juniper_posts_link_next_class($format){
         $format = str_replace('href=', 'class="post_next btn" href=', $format);
         return $format;
    }
}

add_filter('previous_post_link', 'juniper_posts_link_prev_class');

if (!function_exists('juniper_posts_link_prev_class')){
    function juniper_posts_link_prev_class($format) {
         $format = str_replace('href=', 'class="post_prev btn" href=', $format);
         return $format;
    }
}

/* **************************************************************************************************** */
// Add next_posts Link Classes
/* **************************************************************************************************** */

add_filter('next_posts_link_attributes', 'juniper_posts_link_class');
add_filter('previous_posts_link_attributes', 'juniper_posts_link_class');

if (!function_exists('juniper_posts_link_class')){
    function juniper_posts_link_class() {
        return 'class="btn"';
    }
}

/* **************************************************************************************************** */
// Add Image Classes ##Look for way to apply to exsisting
/* **************************************************************************************************** */

add_filter('get_image_tag_class','juniper_add_image_class');

if (!function_exists('juniper_add_image_class')){
    function juniper_add_image_class($class){
        $class .= ' img-responsive';
        return $class;
    }
}

/* **************************************************************************************************** */
// Load Public Scripts
/* **************************************************************************************************** */

add_action('wp_enqueue_scripts', 'juniper_public_scripts');

if (!function_exists('juniper_public_scripts')){
    function juniper_public_scripts() {
        if (!is_admin()) {
            wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), '2.2.2', true);
            wp_enqueue_script('jquery-waypoints', get_template_directory_uri() . '/assets/js/jquery.waypoints.min.js', array(), '2.2.2', true);
            wp_enqueue_script('nicescroll', get_template_directory_uri() . '/assets/js/nicescroll.min.js', array(), '3.6.0', true);
            wp_enqueue_script('parallax',get_template_directory_uri() . '/assets/js/parallax.min.js',array(),'1.3.1',true);
            wp_enqueue_script('scrollreveal',get_template_directory_uri() . '/assets/js/scrollReveal.min.js',array(),'2.3.2',true);
            wp_enqueue_script('jquery-easing',get_template_directory_uri() . '/assets/js/jquery.easing.min.js',array(),'1.3.0',true);
            wp_enqueue_script('magnific-popup',get_template_directory_uri() . '/assets/js/jquery.magnific-popup.min.js',array(),'1.0.1',true);
            wp_enqueue_script('juniper-public', get_template_directory_uri() . '/assets/js/public.js', array(), '2.0.0', true);
        }
    }
}


/* **************************************************************************************************** */
// Load Public Scripts in Conditional
/* **************************************************************************************************** */

add_action('wp_head', 'juniper_public_scripts_conditional');

if (!function_exists('juniper_public_scripts_conditional')){
    function juniper_public_scripts_conditional() {
        if (!function_exists('juniper_companion')) { ?>
            <style>.frontpage-banner{margin-bottom: 30px;}</style>
        <?php } ?>
        <!--[if lt IE 9]>
            <script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.js"></script>
            <script src="<?php echo get_template_directory_uri(); ?>/js/respond.min.js"></script>
        <![endif]-->
    <?php
    }
}


/* **************************************************************************************************** */
// Load Public CSS
/* **************************************************************************************************** */

add_action('wp_enqueue_scripts', 'juniper_public_styles');

if (!function_exists('juniper_public_styles')){
    function juniper_public_styles() {
        if (!is_admin()) {
            wp_enqueue_style("bootstrap", get_template_directory_uri() . "/assets/css/bootstrap.min.css", array(), "", "all");
            wp_enqueue_style("juniper_bootstrap_fix", get_template_directory_uri() . "/assets/css/bootstrap-fix.css", array(), "", "all");
            wp_enqueue_style( 'font-awesome', get_template_directory_uri() . "/assets/css/font-awesome.min.css", array(), "", "all");
            wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . "/assets/css/magnific-popup.css", array(), "", "all");
            wp_enqueue_style( 'font-lato', "//fonts.googleapis.com/css?family=Lato:100,300,400,700,900", array(), "", "all");
            wp_enqueue_style( 'juniper-style', get_bloginfo( 'stylesheet_url' ), false, get_bloginfo('version') );
        }
    }
}



/* **************************************************************************************************** */
// Clear Helper/s
/* **************************************************************************************************** */

function juniper_clear($ht = "0") {
echo "<div class='clear' style='height:" . $ht . "px;'></div>";
}
