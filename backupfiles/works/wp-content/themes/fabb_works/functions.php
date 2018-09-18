<?php
/*
Author: Eddie Machado
URL: http://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

// LOAD BONES CORE (if you remove this, the theme will break)
require_once( 'library/bones.php' );

// CUSTOMIZE THE WORDPRESS ADMIN (off by default)
// require_once( 'library/admin.php' );

/*********************
LAUNCH BONES
Let's get everything up and running.
*********************/

function bones_ahoy() {

  //Allow editor style.
  add_editor_style( get_stylesheet_directory_uri() . '/library/css/editor-style.css' );

  // let's get language support going, if you need it
  load_theme_textdomain( 'bonestheme', get_template_directory() . '/library/translation' );

  // USE THIS TEMPLATE TO CREATE CUSTOM POST TYPES EASILY
  require_once( 'library/custom-post-type.php' );

  // launching operation cleanup
  add_action( 'init', 'bones_head_cleanup' );
  // A better title
  add_filter( 'wp_title', 'rw_title', 10, 3 );
  // remove WP version from RSS
  add_filter( 'the_generator', 'bones_rss_version' );
  // remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'bones_remove_wp_widget_recent_comments_style', 1 );
  // clean up comment styles in the head
  add_action( 'wp_head', 'bones_remove_recent_comments_style', 1 );
  // clean up gallery output in wp
  add_filter( 'gallery_style', 'bones_gallery_style' );

  // enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'bones_scripts_and_styles', 999 );
  // ie conditional wrapper

  // launching this stuff after theme setup
  bones_theme_support();

  // adding sidebars to Wordpress (these are created in functions.php)
  add_action( 'widgets_init', 'bones_register_sidebars' );

  // cleaning up random code around images
  add_filter( 'the_content', 'bones_filter_ptags_on_images' );
  // cleaning up excerpt
  //add_filter( 'excerpt_more', 'bones_excerpt_more' );

} /* end bones ahoy */

// let's get this party started
add_action( 'after_setup_theme', 'bones_ahoy' );


/************* OEMBED SIZE OPTIONS *************/

if ( ! isset( $content_width ) ) {
	$content_width = 1080;
}

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
//add_image_size( 'bones-thumb-600', 600, 150, true );
//add_image_size( 'bones-thumb-300', 300, 100, true );
//add_image_size( 'bnl-header-wide', 1200, 400, true);
add_image_size( 'bnl-thumb-large', 1080, 0, false);
add_image_size( 'bnl-thumb-medium', 640, 0, false);
add_image_size( 'bnl-thumb-small', 320, 0, false);

/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 100 sized image,
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 150 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

//add_filter( 'image_size_names_choose', 'bones_custom_image_sizes' );

function bones_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'bones-thumb-600' => __('600px by 150px'),
        'bones-thumb-300' => __('300px by 100px'),
    ) );
}

/*
The function above adds the ability to use the dropdown menu to select
the new images sizes you have just created from within the media manager
when you add media to your content blocks. If you add more image sizes,
duplicate one of the lines in the array and name it according to your
new image size.
*/

/************* THEME CUSTOMIZE *********************/

/* 
  A good tutorial for creating your own Sections, Controls and Settings:
  http://code.tutsplus.com/series/a-guide-to-the-wordpress-theme-customizer--wp-33722
  
  Good articles on modifying the default options:
  http://natko.com/changing-default-wordpress-theme-customization-api-sections/
  http://code.tutsplus.com/tutorials/digging-into-the-theme-customizer-components--wp-27162
  
  To do:
  - Create a js for the postmessage transport method
  - Create some sanitize functions to sanitize inputs
  - Create some boilerplate Sections, Controls and Settings
*/

function bones_theme_customizer($wp_customize) {
  // $wp_customize calls go here.
  //
  // Uncomment the below lines to remove the default customize sections 

  // $wp_customize->remove_section('title_tagline');
  // $wp_customize->remove_section('colors');
  // $wp_customize->remove_section('background_image');
  // $wp_customize->remove_section('static_front_page');
  // $wp_customize->remove_section('nav');

  // Uncomment the below lines to remove the default controls
  // $wp_customize->remove_control('blogdescription');
  
  // Uncomment the following to change the default section titles
  // $wp_customize->get_section('colors')->title = __( 'Theme Colors' );
  // $wp_customize->get_section('background_image')->title = __( 'Images' );
}

add_action( 'customize_register', 'bones_theme_customizer' );

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar1',
		'name' => __( 'Sidebar 1', 'bonestheme' ),
		'description' => __( 'The first (primary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	/*
	to add more sidebars or widgetized areas, just copy
	and edit the above sidebar code. In order to call
	your new sidebar just use the following code:

	Just change the name to whatever your new
	sidebar's id is, for example:

	register_sidebar(array(
		'id' => 'sidebar2',
		'name' => __( 'Sidebar 2', 'bonestheme' ),
		'description' => __( 'The second (secondary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	To call the sidebar in your template, you can just copy
	the sidebar.php file and rename it to your sidebar's name.
	So using the above example, it would be:
	sidebar-sidebar2.php

	*/
} // don't remove this bracket!


/************* COMMENT LAYOUT *********************/

// Comment Layout
function bones_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
  <div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
    <article  class="cf">
      <header class="comment-author vcard">
        <?php
        /*
          this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
          echo get_avatar($comment,$size='32',$default='<path_to_url>' );
        */
        ?>
        <?php // custom gravatar call ?>
        <?php
          // create variable
          $bgauthemail = get_comment_author_email();
        ?>
        <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=40" class="load-gravatar avatar avatar-48 photo" height="40" width="40" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
        <?php // end custom gravatar call ?>
        <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'bonestheme' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'bonestheme' ),'  ','') ) ?>
        <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'bonestheme' )); ?> </a></time>

      </header>
      <?php if ($comment->comment_approved == '0') : ?>
        <div class="alert alert-info">
          <p><?php _e( 'Your comment is awaiting moderation.', 'bonestheme' ) ?></p>
        </div>
      <?php endif; ?>
      <section class="comment_content cf">
        <?php comment_text() ?>
      </section>
      <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </article>
  <?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!


// add birnimal
// Close comments on the front-end
function wptips_disable_comments_status() {
    return false;
}
add_filter('comments_open', 'wptips_disable_comments_status', 20, 2);
add_filter('pings_open', 'wptips_disable_comments_status', 20, 2);



/*
This is a modification of a function found in the
twentythirteen theme where we can declare some
external fonts. If you're using Google Fonts, you
can replace these fonts, change it in your scss files
and be up and running in seconds.
*/
function bones_fonts() {
  wp_enqueue_style('googleFonts', 'http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic');
}

//add_action('wp_enqueue_scripts', 'bones_fonts');

// Enable support for HTML5 markup.
	add_theme_support( 'html5', array(
		'comment-list',
		'search-form',
		'comment-form'
	) );

/* DON'T DELETE THIS CLOSING TAG */ ?>
<?php

function is_login_page(){
	if ( in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ) {
		return true;
	} else {
		return false;
	}
}

function load_jquery_cdn() {
    if( !is_admin() && !is_login_page()){
        wp_deregister_script('jquery');
        wp_enqueue_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js', array(), '1.11.3');
        //wp_enqueue_script('jquery-migrate', '//code.jquery.com/jquery-migrate-1.2.1.min.js', array('jquery'), '1.2.1');
        wp_enqueue_script('jquery-migrate'); // WP同梱使用
    }
}
add_action('init', 'load_jquery_cdn');



function is_dev_server() {
    if(strstr($_SERVER["SERVER_NAME"], 'dev.otocoto.jp')){
         return true;
    }
    return false;
}



function is_tree( $pid ) {      // $pid = 指定したページの ID
    global $post;         // $post に現在の固定ページの情報をロード

    if ( is_page($pid) )
        return true;            // その固定ページまたはサブページの場合

    $anc = get_post_ancestors( $post->ID );
    foreach ( $anc as $ancestor ) {
        if( is_page() && $ancestor == $pid ) {
            return true;
        }
    }

    return false;  // その固定ページではない、または親ページではない場合
}



if ( function_exists('register_sidebar') ) {
    register_sidebar(array('id' => 'sidebar-1'));
}

function isFirst(){
    global $wp_query;
    return ($wp_query->current_post === 0);
}

function isLast(){
    global $wp_query;
    return ($wp_query->current_post+1 === $wp_query->post_count);
}

function isOdd(){
    global $wp_query;
    return ((($wp_query->current_post+1) % 2) === 1);
}

function isEvery(){
    global $wp_query;
    return ((($wp_query->current_post+1) % 2) === 0);
}


/**
* 文字数制限
*/
function cn2_truncate($message, $length) {
	
	$getLength = mb_strlen($message);
	$shorterMessage = mb_substr($message, 0, $length);
	
	if ($getLength <= $length)
	{
		return $message;
	}
	else if ( $getLength > $length )
	{
		$shorterMessage .= "...";
		return $shorterMessage;
	}
	
}



/**
* add sugimori
*/

function bnl_redirect($url, $statusCode = 301)
{
   header('Location: ' . $url, true, $statusCode);
   die();
}



function shortcode_templateurl() {
    return get_bloginfo('template_url');
}
add_shortcode('template_url', 'shortcode_templateurl');

function sc_bloginfo($atts, $content = null) {
    extract(shortcode_atts(array(
                                 'arg' => ''
                                 ), $atts));

    return get_bloginfo($arg);
}

add_shortcode('bloginfo', 'sc_bloginfo');


function sc_pager() {
    return wp_link_pages('before=<div id="page-links">&after=</div>&link_before=<span>&link_after=</span>');
}
add_shortcode('link_pages', 'sc_pager');

function is_exist_cf($cfname) {
	$cfvalue = post_custom($cfname);
	if(empty($cfvalue) || strcmp($cfvalue,"http://") == 0) return false;
	return true;
}





function shortcode_jcsnsbutton($arg) {

    if (is_feed()) return '';

    extract(shortcode_atts(array (
        'title' => get_the_title(),
        'url' => get_permalink(),
        'hashtag' => ''
    ), $arg));
    $html = outputSNSbuttons($url,$title,$hashtag,false);
    return $html;
}

add_shortcode('jcsnsbutton', 'shortcode_jcsnsbutton');


// ループ内で使用すること
function outputNextLink($text01, $text02) {

    $post_type = get_post_type();
    $tax = $post_type . "_cat";

    $nextpost = get_adjacent_post( true, "", false, $tax );
    if (empty($nextpost)) {
        echo '<div class="nextpost_block">';

        if (!empty($text01)) {
            echo '<span class="text01">' . $text01 . '</span>';
        }
        if (!empty($text02)) {
            echo '<span class="text02">' . $text02 . '</span>';
        }
        echo '</div>';
    }
    else {
        echo '<div class="nextpost_block">';
        echo '<a class="nextlink" href="' . get_the_permalink($nextpost->ID) . '"><span>→ </span>' . get_the_title($nextpost->ID) . '</a>';
        echo '</div>';
    }
}

function shortcode_jcnextpost($arg) {

    if (is_feed()) return '';

    extract(shortcode_atts(array (
        'text01' => "",
        'text02' => ""
    ), $arg));

// sample
//    $html = '<!-- mfunc '.W3TC_DYNAMIC_SECURITY.' -->' .
//            "echo 'The time is '.date( 'H:i:s', time() );" .
//            '<!-- /mfunc '.W3TC_DYNAMIC_SECURITY.' -->';

    $html = '<!-- mfunc '.W3TC_DYNAMIC_SECURITY.' -->' .
            "outputNextLink('" . $text01 . "','" . $text02 . "');" .
            '<!-- /mfunc '.W3TC_DYNAMIC_SECURITY.' -->';

    return $html;
}

add_shortcode('jcnextpost', 'shortcode_jcnextpost');



/**
 * Add prev and next links to a numbered page link list
 */
function wp_link_pages_args_prevnext_add($args)
{
    global $page, $numpages, $more, $pagenow;

    if ($args['next_or_number'] != 'next_and_number')
        return $args; # exit early

    $args['next_or_number'] = 'number'; # keep numbering for the main part
    if (!$more)
        return $args; # exit early

    if($page-1) {
        # there is a previous page
        $args['before'] .= _wp_link_page($page-1)
            . '<span class="prev link_text">'. $args['previouspagelink'] . '</span>' . '</a>';
    }
    else {
        $args['before'] .= '<span class="prev link_text link_disable">'. $args['previouspagelink'] . '</span>';
    }

    if ($page<$numpages) {
        # there is a next page
        $args['after'] = _wp_link_page($page+1)
            . '<span class="next link_text">' . $args['nextpagelink'] . '</span>' . '</a>'
            . $args['after'];
    }
    else {
        $args['after'] = '<span class="next link_text link_disable">' . $args['nextpagelink'] . '</span>'
        . $args['after'];
    }

    return $args;
}

add_filter('wp_link_pages_args', 'wp_link_pages_args_prevnext_add');


function shortcode_nextpage($arg) {

    if (is_feed()) return '';

    extract(shortcode_atts(array (
        'title' => "次のページ",
        'first' => false
    ), $arg));

    $linkpages = wp_link_pages( array(
        'before' => '',
        'after' => '',
	    'next_or_number' => 'next',
	    'echo' => 0
	) );

    $url = "";

    if ($first) {
        $url = get_the_permalink();
    }
    else {
        if(preg_match_all('(https?://[-_.!~*\'()a-zA-Z0-9;/?:@&=+$,%#]+)', $linkpages, $result) !== false){
            $last = count($result[0]) - 1;
            if ($last >= 0) $url = $result[0][$last];
        }
    }

    $html = '<div class="nextpage_block"><a href="' . $url . '">' . $title . '</a></div>';
    return $html;
}

add_shortcode('jcnextpage', 'shortcode_nextpage');





// for simple page ordering
add_post_type_support( 'post', 'page-attributes' );

// 固定ページも抜粋対応
add_post_type_support( 'page', 'excerpt' );



$template_baseurl = get_template_directory() . "/";


/* csv読み込み文字化け対策 20120706 */
/* macの改行コードはデフォルトで認識されないため、UNIXかWinに変更必要 */
function fgetcsv_reg (&$handle, $length = null, $d = ',', $e = '"') {
    $eof = false;
        $d = preg_quote($d);
        $e = preg_quote($e);
        $_line = "";
        while (($eof != true)and(!feof($handle))) {
            $_line .= (empty($length) ? fgets($handle) : fgets($handle, $length));
            $itemcnt = preg_match_all('/'.$e.'/', $_line, $dummy);
            if ($itemcnt % 2 == 0) $eof = true;
        }
        $_csv_line = preg_replace('/(?:\\r\\n|[\\r\\n])?$/', $d, trim($_line));
        $_csv_pattern = '/('.$e.'[^'.$e.']*(?:'.$e.$e.'[^'.$e.']*)*'.$e.'|[^'.$d.']*)'.$d.'/';
        preg_match_all($_csv_pattern, $_csv_line, $_csv_matches);
        $_csv_data = $_csv_matches[1];
        for($_csv_i=0;$_csv_i<count($_csv_data);$_csv_i++){
            $_csv_data[$_csv_i]=preg_replace('/^'.$e.'(.*)'.$e.'$/s','$1',$_csv_data[$_csv_i]);
            $_csv_data[$_csv_i]=str_replace($e.$e, $e, $_csv_data[$_csv_i]);
        }
        return empty($_line) ? false : $_csv_data;
    }



register_nav_menus( array( 'primary' => __( 'Primary Navigation' ), ) );



/**
 *  GET&OUTPUT
 */

function outputGA() {
    ?>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-62086471-4', 'auto');
    ga('send', 'pageview');

</script>
    <?php
}

function getGenre($post_id) {
    $post_genres = get_the_terms($post_id, 'genre');
    $post_genre = "";
//    $post_genre_link = "";
    if (!empty($post_genres)) {
        foreach ($post_genres as $term) {
            if ($term->parent) continue;
            $post_genre = $term->slug;
//            $post_genre_link = get_term_link($post_genre, 'genre');
            break;
        }
    }
    return $post_genre;
}

function get_current_tax($post_id, $tax) {
    $cats = get_the_terms($post_id, $tax);
    $current_cat = '';
    if (!empty($cats)) {
        foreach ( $cats as $cat ) {
            if ( ! $current_cat || term_is_ancestor_of( $current_cat, $cat, $tax ) ) {
                $current_cat = $cat;
            }
        }
    }
    return $current_cat;
}

function get_current_cat($post_id) {
    $cats = get_the_category($post_id);
    $current_cat = '';
    foreach ( $cats as $cat ) {
        if ( ! $current_cat || cat_is_ancestor_of( $current_cat, $cat ) ) {
            $current_cat = $cat;
        }
    }
    return $current_cat;
}

function get_parent_cat($post_id) {
    $cats = get_the_category($post_id);
    $parent_cat = '';
    foreach ( $cats as $cat ) {
        if ( is_parent_cat($cat->cat_ID) ) {
            $parent_cat = $cat;
            break;
        }
    }

    if (empty($parent_cat)) {
        foreach ( $cats as $cat ) {
            if ( $cat->parent ) {
                $parent_cat = get_category($cat->parent);
                break;
            }
        }
    }

    return $parent_cat;
}

function is_parent_cat($cat_id) {
    $children = get_term_children( $cat_id, "category" );
    if (empty($children)) {
        return false;
    }
    else {
        return true;
    }
}




function get_pl_posclass($count) {
    $pos_class = "";
    if (($count % 3) == 0) {
        $pos_class = " right3";
    }
    if (($count % 2) == 0) {
        $pos_class .= " right2";
    }
    if (($count % 3) == 1) {
        $pos_class .= " left3";
    }
    if (($count % 2) == 1) {
        $pos_class .= " left2";
    }

    if (($count % 4) == 0) {
        $pos_class .= " right4";
    }
    if (($count % 4) == 1) {
        $pos_class .= " left4";
    }

    return $pos_class;
}


function get_posttype_tax($posttype) {
    return $posttype . "_cat";
}

function get_posttype_name($posttype) {
    $posttype_names = array(
        "interview" => "INTERVIEW",
        "news" => "NEWS",
        "story" => "STORY",
        "special" => "SPECIAL",
        "column" => "COLUMN",
        "page" => ""
    );

    return $posttype_names[$posttype];
}



// ループ内
function get_thumb_url($show_force = true, $size = "bnl-thumb-medium", $show_default = true, &$sizearray = 0) {
    // $show_force = trueで常にアーカイブ用画像を使用する

    $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), $size);
    $thumbnail_url = $thumbnail[0];

    if (empty($thumbnail_url) && $show_default) {
        $thumbnail_url = get_template_directory_uri() . "/library/images/default_thumb.jpg";
    }
    else {
        if (!empty($thumbnail_url) && is_array($sizearray)) {
            $sizearray = array($thumbnail[1],$thumbnail[2]);
        }
    }

    return $thumbnail_url;
}

function get_title_for_archive($post_id = null) {
    $archive_title = get_field('poststg_title2', $post_id);
    if (empty($archive_title)) {
        $archive_title = get_the_title($post_id);
    }
    return $archive_title;
}


function output_sns_counter($post_id) {
    if(function_exists('scc_get_share_total')) {
        $sns_count = 0;
        if (!empty($post_id)) {
            $sns_count = scc_get_share_total(array( 'post_id' => $post_id));
        }
        else {
            $sns_count = scc_get_share_total();
        }
        if ($sns_count > 9999) $sns_count = "10K+";

        echo '<span class="sns_counter"><span class="icon icon-heart"></span>' . $sns_count . '</span>';
    }
}



function output_infoheader($post, $output_area = false) {
    $ex_date_class = "";
    echo '<div class="infoheader">';
    echo '<p class="date ' . $ex_date_class . '">' . get_post_time("Y.n.j.D",false,$post->ID) . '</p>' . "\n";
    $terms = get_the_terms($post->ID, "area");
    $term = "";
    if ($terms) $term = $terms[0];
    if ($output_area) echo '<span class="area">' . $term->name . '</span>';
    echo '</div>';
}



function output_status($post) {
    $status_text = "受付終了";
    $status_class = "outofstock";
    if (get_post_meta($post->ID, "_stock_status", true) == "instock") {
        $status_text = "受付中";
        $status_class = "instock";
    }
    echo '<p class="status status-' . $status_class . '">';
    echo $status_text;
    echo '</p>';
}



function output_plitem_default($post) {
    $thumbnail_url = get_thumb_url();
?>
    <a class="postimage" href="<?php echo get_permalink($post->ID) ?>">
        <img src="<?php echo $thumbnail_url; ?>"/>
    </a>

    <div class="postinfo">
        <?php
        output_infoheader($post);
        ?>

        <h3 class="title"><?php echo get_title_for_archive($post->ID) ?></h3>

    </div>
<?php
}


function output_taglist($post_id) {
    $areas = get_the_terms($post_id, 'area');
    $tags = wp_get_post_tags( $post_id );

    if (count($tags) > 0 || ( $areas != false && count($areas) > 0)) {
    ?>
    <div class="taglist">
        <ul>
            <?php
            if (!empty($areas)) {
                foreach ($areas as $area) {
                    echo '<li class="tag-area"><a class="tagitem" href="' . get_term_link($area->term_id, 'area') . '"><span class="icon icon-area"></span><span class="tagtext">' . $area->name . '</span></a></li>';
                }
            }
            if (!empty($tags)) {
                foreach ($tags as $tag) {
                    echo '<li><a class="tagitem" href="' . get_tag_link($tag->term_id) . '"><span class="icon icon-taghead"></span><span class="tagtext">' . $tag->name . '</span></a></li>';
                }
            }
            ?>
        </ul>
    </div>
    <?php
    }
}




 function outputSNSbuttons($url = "", $text = "", $hashtag = "", $output = true) {

    global $url_canonical;

//    $outputHashtag = "";
//    if (!empty($hashtag)) {
//        $outputHashtag = 'data-hashtags="' . $hashtag . '"';
//    }

    $template_dir = get_template_directory_uri();

    $twurl = urlencode($url);
    $fburl = $url;
    if (empty($url)) {
        // get_parmalinkだとページ分割URLではなく最初のページのURLになるnaru
        // ページ分割後のURLにする場合はcanonicalを利用
//        if (!empty($url_canonical)) {
//            $twurl = urlencode($url_canonical);
//        } else {
            $twurl = urlencode(get_permalink());
            $fburl = get_permalink();
//        }
    }
    $twtext = urlencode($text);
    if (empty($text)) {
        $text = str_replace(array("<br>", "<br />"),' ',get_the_title());
        $text = str_replace('&#038;', '&', $text);
        $twtext = urlencode($text);
    }
    $twhash = "";
    if (!empty($hashtag)) {
        $twhash = "&hashtags=" . urlencode($hashtag);
    }

$string = <<< EOM
     <div class="std_socialbuttons">
         <div class="fbbutton">
             <div class="fb-like" data-href="$fburl" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
         </div>
         <div class="tweetbutton snsbtn_item">
             <a href="http://twitter.com/intent/tweet?url=$twurl&text=$twtext{$twhash}" target="_blank">
                <img class="btn_img" src="$template_dir/library/images/btn_tw.png" />
             </a>
         </div>
         <div class="gplusonebutton">
            <div class="g-plusone" data-href="$fburl" data-size="medium"></div>
         </div>
         <div class="hatenabutton">
             <a href="http://b.hatena.ne.jp/entry/$fburl" class="hatena-bookmark-button" data-hatena-bookmark-title="$text" data-hatena-bookmark-layout="simple-balloon" title="このエントリーをはてなブックマークに追加"><img src="https://b.st-hatena.com/images/entry-button/button-only@2x.png" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a>
         </div>
         <div class="linebutton">
         <span>
            <script type="text/javascript" src="//media.line.me/js/line-button.js?v=20140411" ></script>
            <script type="text/javascript">
            new media_line_me.LineButton({"pc":false,"lang":"ja","type":"a"});
            </script>
         </span>
         </div>
     </div>
EOM;

    if ($output) {
        echo $string;
    }
    else {
        return $string;
    }

 }




function get_image_id_by_url($img_url) {
    if ( preg_match( '/^(.*)(\-\d*x\d*)(\.\w{1,})/i', $img_url, $matches ) ){
        $url = $matches[1] . $matches[3];
        $img_id = attachment_url_to_postid( $url );
//                        var_dump($url);
    }
    else {
        $img_id = attachment_url_to_postid($img_url);
    }

    return $img_id;
}




function output_servicecat() {
    $args = array(
        'orderby'       => 'count',
        'order'         => 'DESC',
        'hide_empty'    => true,
    );

    $terms = get_terms( "service_cat", $args );

    if (count($terms) > 0) {
        ?>
        <div class="catlist cf">
            <ul>
                <?php
                foreach ($terms as $term) {

                    $iconurl = "";
                    $iconimg = get_field('srvcat_img_icon', $term);
                    if ($iconimg) {
                        $iconurl = $iconimg['sizes'][ 'medium' ];
                    }

                    $args = array(
                      'posts_per_page'   => 1,
                      'post_type' => "service",
                      'tax_query' => array(
                            array(
                                'taxonomy' => 'service_cat',
                                'field' => 'slug',
                                'terms' => $term->slug,
                                'operator' => 'IN',
                            ),
                        )
                    );

                    $posts = get_posts($args);

                    if (count($posts) > 0) {
                        echo '<li>
                                <img class="" src="'. $iconurl . '" />
                                <p>' . $term->name . '</p>
                                <div class="btn-wrapper">
                                    <a class="std-btn-arrow" href="' . get_permalink($posts[0]) . '">詳しくはこちら</a>
                                </div>
                            </li>';
                    }
                }
                ?>
            </ul>
        </div>
    <?php }
}




function output_area() {
    $args = array(
//        'orderby'       => 'name',
//        'order'         => 'DESC',
        'hide_empty'    => true,
    );

    $terms = get_terms( "area", $args );

    if (count($terms) > 0) {
        ?>
        <div class="arealist cf">
            <ul>
                <?php
                foreach ($terms as $term) {
                    $color = get_field('area_color_border', $term);
                    $style = "";
                    if (!empty($color)) $style = 'style="border-bottom-color:' . $color . ';" ';

                    echo '<li><a ' . $style . 'href="' . get_term_link($term) . '">'
                        . $term->name . " (" . $term->count . ")" .
                    '</a></li>';
                }
                ?>
            </ul>
        </div>
    <?php }
}




// 投稿内に出てくる一番最初の画像を取得する
function catch_post_image() {
    global $post;
    $first_img = '';
    preg_match('/<img[^>]+src=[\'"]([^\'">]+)[\'"][^>]*>/si',$post->post_content, $m);
//    preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);

    if (isset($m) && isset($m[1])) {
        $first_img = $m[1];
    }

    if(empty($first_img)){
        $first_img = '';
    }

    return $first_img;
}



/**
 *  contact form 7
 */
add_filter( 'wpcf7_validate_email', 'wpcf7_text_validation_filter_extend', 11, 2 );
add_filter( 'wpcf7_validate_email*', 'wpcf7_text_validation_filter_extend', 11, 2 );
function wpcf7_text_validation_filter_extend( $result, $tag ) {
    $type = $tag['type'];
    $name = $tag['name'];
    $_POST[$name] = trim( strtr( (string) $_POST[$name], "\n", " " ) );
    if ( 'email' == $type || 'email*' == $type ) {
        if (preg_match('/(.*)_confirm$/', $name, $matches)){
            $target_name = $matches[1];
            if ($_POST[$name] != $_POST[$target_name]) {
                if (method_exists($result, 'invalidate')) {
                    $result->invalidate( $tag,"確認用のメールアドレスが一致していません");
                } else {
                    $result['valid'] = false;
                    $result['reason'][$name] = '確認用のメールアドレスが一致していません';
                }
            }
        }
    }
    return $result;
}

if(strstr($_SERVER["REQUEST_URI"], 'mailuser-registration')){
    remove_action( 'init', 'wpcf7c_control_init', 10 );
}


/**
 *  Browser
 */
function check_ie8() {
preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches);
if(count($matches)<2){
    preg_match('/Trident\/\d{1,2}.\d{1,2}; rv:([0-9]*)/', $_SERVER['HTTP_USER_AGENT'], $matches);
}

    $ret = false;
    if (count($matches)>1){
        //Then we're using IE
        $version = $matches[1];

        switch(true){
            case ($version<=8):
                //IE 8 or under!
                $ret = true;
                break;

            case ($version==9 || $version==10):
                //IE9 & IE10!
                break;

            case ($version==11):
                //Version 11!
                break;

            default:
                //You get the idea
        }
    }
    return $ret;
}



/**
 *  TIME
 */
// 日付けの差分をとる関数 function版
define( "gONE_DAY_SEC", 24 * 3600 );
function fn_dateDiff( $date1, $date2 ) {
    return ( strtotime( $date1 ) - strtotime( $date2 ) ) / gONE_DAY_SEC;
}
function fn_datetimeDiff( $date1, $date2 ) {
    return strtotime( $date1 ) - strtotime( $date2 );
}


/**
 * 抜粋
 */
function new_excerpt_mblength($length) {
     return 84;
}
add_filter('excerpt_mblength', 'new_excerpt_mblength');

function new_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');






//add_action('do_meta_boxes', 'arrange_metabox', 999);

function arrange_metabox(){
    global $wp_meta_boxes;

    $posttypes = get_basic_post_types();

    foreach ($posttypes as $post_type) {
        remove_meta_box( 'tagsdiv-post_tag', $post_type, 'side' );
        remove_meta_box( 'linediv', $post_type, 'side' );
        remove_meta_box( 'stationdiv', $post_type, 'side' );
        remove_meta_box( 'areadiv', $post_type, 'side' );
        remove_meta_box( 'formatdiv', $post_type, 'side' );
    }
    remove_meta_box( 'tagsdiv-post_tag', 'post', 'side' );
    remove_meta_box( 'formatdiv', 'post', 'side' );
    remove_meta_box('commentstatusdiv', 'post', 'normal');
    remove_meta_box( 'commentsdiv','post','normal' );

}




/**
 * query
 */
function bnl_filter( $query )
{
    if ( is_admin() || !$query->is_main_query() ) return;

    if ( $query->is_tag() ) {
        $query->set( 'post_type', get_all_post_types() );
    }

    if ( $query->is_archive() ) {
        $query->set( 'orderby', 'date' );
        $query->set( 'order', 'DESC' );

        if ( $query->is_post_type_archive('book')) {
            $query->set( 'tax_query', array(
                array(
                    'taxonomy' => 'book_cat',
                    'field' => 'slug',
                    'terms' => 'works',
                    'operator' => 'NOT IN'
                    )
                )
            );
        }

        // 投稿別に一覧に表示するかどうか
        $query->set( 'meta_query', array(
        'relation' => 'OR',
        array(
              'key' => 'poststg_hide_list',
              'compare' => 'NOT EXISTS'
        ),
        array(
              'key' => 'poststg_hide_list',
              'value' => '0',
              'compare' => '='
        ),
        array(
              'key' => 'poststg_hide_list',
              'value' => '2',
              'compare' => '='
        )
    ));

        return;
    }
}
add_action( 'pre_get_posts', 'bnl_filter' );






/**
 * 管理画面カスタマイズ
 */


/* メールアドレスログイン (Force Email Login参照) */
//remove_filter( 'authenticate', 'wp_authenticate_username_password', 20, 3 );
//add_filter( 'authenticate', 'bnl_authenticate', 20, 3 );

function bnl_authenticate( $user, $username, $password )
{
    if ( is_a( $user, 'WP_User' ) ) {
        return $user;
    }
    if ( ! empty( $username ) && is_email( $username ) ) {
        $user = get_user_by( 'email', $username );
        if ( isset( $user, $user->user_login, $user->user_status ) ) {
            if ( 0 === intval( $user->user_status ) ) {
                $username = $user->user_login;
                return wp_authenticate_username_password( null, $username, $password );
            }
        }
    }
    if ( ! empty( $username ) || ! empty( $password ) ) {
        return false;
    } else {
        return wp_authenticate_username_password( null, "", "" );
    }
}


/* ユーザー画面項目追加(連絡先) */
function modify_user_contact_methods( $user_contact ){

    /* 追加をしたい場合 */
    $user_contact['twitter'] = 'Twitterユーザー名';
    $user_contact['facebook'] = 'Facebook URL';

    return $user_contact;
}

add_filter('user_contactmethods', 'modify_user_contact_methods');


// removes the `profile.php` admin color scheme options
remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );

if ( ! function_exists( 'cor_remove_personal_options' ) ) {
    /**
     * Removes the leftover 'Visual Editor', 'Keyboard Shortcuts' and 'Toolbar' options.
     */
    function cor_remove_personal_options( $subject ) {
        $subject = preg_replace( '#<h3>個人設定</h3>.+?/table>#s', '', $subject, 1 );
        return $subject;
    }

    function cor_profile_subject_start() {
        ob_start( 'cor_remove_personal_options' );
    }

    function cor_profile_subject_end() {
        ob_end_flush();
    }
}
add_action( 'admin_head-profile.php', 'cor_profile_subject_start' );
add_action( 'admin_footer-profile.php', 'cor_profile_subject_end' );


/* 姓名削除はcssでやる */


/* ユーザー一覧の項目 */
function custom_users_columns( $columns ) {
    $columns['nickname'] = 'ニックネーム';
    unset($columns['name']);
    return $columns;
}
function custom_users_custom_column( $dummy, $column, $user_id ) {
    if ( $column == 'nickname' ) {
        $user_info = get_userdata($user_id);

        return $user_info->nickname;
    }
}
add_filter( 'manage_users_columns', 'custom_users_columns' );
add_filter( 'manage_users_custom_column', 'custom_users_custom_column', 10, 3 );


/* プロフィールにhtmlタグ使用させる */
remove_filter('pre_user_description', 'wp_filter_kses');
add_filter('pre_user_description', 'wp_filter_post_kses');



/* 独自スタイル */
function bnl_custom_enqueue($hook_suffix) {
    // 新規投稿または編集画面、プロフィール画面のみ
    if( 'user-edit.php' == $hook_suffix ||
        'post-new.php' == $hook_suffix ||
        'post.php' == $hook_suffix ||
        'user-new.php' == $hook_suffix ||
        'profile.php' == $hook_suffix ) {
        wp_enqueue_style( 'bnl_admin_style', get_template_directory_uri().'/library/css/admin.css' );
    }
    if (is_admin() && !current_user_can('delete_pages')) { //管理者とオペレーター以外は制限
        if ('edit-tags.php' == $hook_suffix) {
            wp_enqueue_style( 'bnl_admin_cat_style', get_template_directory_uri().'/library/css/admin_cat.css' );
        }
    }
}
add_action( 'admin_enqueue_scripts', 'bnl_custom_enqueue' );





function customize_menus(){
	global $menu;
	$menu[19] = $menu[10];  //メディアの移動
	unset($menu[10]);
}
add_action( 'admin_menu', 'customize_menus' );


/* 左メニューから削除 */
function bnl_remove_sub_menus() {
//    remove_menu_page('edit.php');

    if (!current_user_can('delete_pages')) {
        //管理者とオペレーター以外は制限
        remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=genre');
        remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');
        remove_menu_page( 'options-general.php' );
    }

    // 管理者以外は制限
    if (!current_user_can('install_plugins')) {
        remove_menu_page( 'tools.php' );
        remove_menu_page( 'wpcf7' );

        remove_menu_page( 'wpseo_dashboard' );
        remove_menu_page( 'siteguard' );
        remove_menu_page( 'w3tc_dashboard' );
    }
}

if (is_admin() && !current_user_can('install_plugins')) {
    add_action( 'wp_before_admin_bar_render', 'wlwp_admin_bar' ); //管理者以外は制限
}
add_action('admin_menu', 'bnl_remove_sub_menus'); //全員

// ACFは下記でメニュー削除
add_filter('acf/settings/show_admin', 'bnl_acf_show_admin');
function bnl_acf_show_admin( $show ) {
    return current_user_can('install_plugins');

}
// ツールバーのSEOメニュー削除
function wlwp_admin_bar(){
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wpseo-menu');
}




/* 投稿画面の新規カテゴリーを追加を削除 */
function bnl_hide_category_add() {
    global $pagenow;
    global $post_type;//投稿タイプで切り分けたいときに使う
    if (is_admin() && ($pagenow=='post-new.php' || $pagenow=='post.php') ){
        echo '<style type="text/css">
       #category-adder {display:none;}
       #category-tabs li.hide-if-no-js{display:none;}
       #genre-adder {display:none;}
       #genre-tabs li.hide-if-no-js{display:none;}
       </style>';
    }
}
//add_action( 'admin_head', 'bnl_hide_category_add'  );


add_filter( 'hidden_meta_boxes', 'my_hidden_meta_boxes', 10, 3 );
function my_hidden_meta_boxes( $hidden, $screen, $use_defaults ) {
    if ( $use_defaults && ( $found = array_search( 'postexcerpt', $hidden ) ) !== false )
        unset( $hidden[$found] );
    return $hidden;
}


/* adminbar 非表示 */
add_filter( 'show_admin_bar', '__return_false' );




/* カテゴリ選択時にツリーが崩れる問題の対処 */
function lig_wp_category_terms_checklist_no_top( $args, $post_id = null ) {
    $args['checked_ontop'] = false;
    return $args;
}
add_action( 'wp_terms_checklist_args', 'lig_wp_category_terms_checklist_no_top' );


//メディア挿入時のデフォルトのリンク先を「なし」に設定する
function bnl_default_noimagelink() {
    $webshufu_default_imagelink = get_option( 'image_default_link_type' );

    if ($webshufu_default_imagelink !== 'none') {
        update_option('image_default_link_type', 'none');
    }
}
add_action('admin_init', 'bnl_default_noimagelink', 10);



//ACF オプションページ有効化
//if(function_exists('acf_add_options_page')) {
//
//    acf_add_options_page();
//    acf_add_options_sub_page(
//    array(
//		'page_title' 	=> 'コラム関連設定',
//		'menu_title'	=> 'コラム関連設定',
//		'menu_slug'	    => 'acf-options-columns',
//		'capability'	=> 'delete_pages',
//	));
//	acf_add_options_sub_page(
//	array(
//		'page_title' 	=> '人気記事設定',
//		'menu_title'	=> '人気記事設定',
//		'menu_slug'	    => 'acf-options-popularposts',
//		'capability'	=> 'delete_pages',
//	)
//	);
//
//
//}
//if( function_exists('acf_set_options_page_capability') )
//{
//    acf_set_options_page_capability( 'delete_pages' );
//}




/**
 * tinyMCE
 */
function bnl_customize_tinymce_settings($initArray) {
    global $allowedposttags;

    $initArray['block_formats'] = '段落=p; 見出し1=h2; 見出し2=h3; 見出し3=h4; 見出し4=h5;';

    // set font size
    $initArray['fontsize_formats'] = '0.8em 0.9em 1.0em 1.2em 1.4em 1.6em 1.8em 2.0em';

    // set style formats
    $style_formats = array(
        array(
            'title' => '回り込み解除',
            'selector' => 'p',
            'classes' => 'alignclear'
        ),
        array(
            'title' => '画像50%',
            'selector' => 'img',
            'classes' => 'image50'
        ),
        array(
            'title' => 'テキスト下マージンなし',
            'selector' => 'p',
            'classes' => 'no_margin_bottom'
        ),
        array(
            'title' => '2カラムラッパー',
            'block' => 'div',
            'classes' => 'col_wrapper col2',
            'wrapper' => true
        ),
        array(
            'title' => 'カラム左',
            'block' => 'div',
            'classes' => 'col_item col_l',
            'wrapper' => true
        ),
        array(
            'title' => 'カラム右',
            'block' => 'div',
            'classes' => 'col_item col_r',
            'wrapper' => true
        )

    );
    $initArray['style_formats'] = json_encode($style_formats);

    $initArray['valid_elements'] = '*[*]';
	$initArray['extended_valid_elements'] = '*[*]';
    $initArray['valid_children'] = '+a[' . implode( '|', array_keys( $allowedposttags ) ) . '],+p[span],+body[style],+div[div|span],+span[span]';
    $initArray['verify_html'] = false;

    return $initArray;
}
add_filter( 'tiny_mce_before_init', 'bnl_customize_tinymce_settings', 10000 );




/**
 * グローバル
 */

$url_canonical = "";



/**
 * Disable the emoji's by Disable Emoji plugin
 */
function disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );

/**
 * Filter function used to remove the tinymce emoji plugin.
 *
 * @param    array  $plugins
 * @return   array             Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
        return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
        return array();
    }
}


/**
 * 自動整形関連
 */
remove_filter ('the_content', 'wpautop');
remove_filter('the_excerpt', 'wpautop');
remove_filter ('acf_the_content', 'wpautop');
function filter_ptags_on_images($content){
    return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter('the_content', 'filter_ptags_on_images');
remove_filter( 'the_title', 'wptexturize' ); //ツイート文字化け対策


/**
 * ログイン画面
 */
function bnl_login_logo() {
    echo '<style type="text/css">
            #login h1 a {
                background: url(' . '/wp-content/themes/fabb_works/library/images/logo.svg) no-repeat !important;
                width: 255.2px;
                height: 43.2px;
                background-size: contain !important;
            }
    </style>';
}
add_action('login_head', 'bnl_login_logo');

function login_logo_url() {
    return get_bloginfo('url');
}
add_filter('login_headerurl', 'login_logo_url');


/**
 * SEO by Yoast
 */
add_filter( 'wpseo_use_page_analysis', '__return_false' );
add_filter( 'wpseo_metabox_prio', function() { return 'low';});






/**
 * Hooks the WP cpt_post_types filter
 *
 * @param array $post_types An array of post type names that the templates be used by
 * @return array The array of post type names that the templates be used by
 **/
function my_cpt_post_types( $post_types ) {
    $post_types = array('interview','news');
    return $post_types;
}
//add_filter( 'cpt_post_types', 'my_cpt_post_types' );




/**
 * SSLページですべてのリンクがHTTPSになってしまうのを修正する
 * @param string $url
 * @param string $path
 * @param string $orig_scheme
 * @return string
 */

function _ssl_home_url($url, $path = '', $orig_scheme = 'http'){
    error_log($url);
    if(is_ssl() && strpos($path, 'wp-content') === false && strpos($url, 'contact') === false){
        $url = str_replace('https:', 'http:', $url);
    }
    return $url;
}
//add_filter('home_url', '_ssl_home_url');




add_filter('img_caption_shortcode', 'my_img_caption_shortcode_filter',10,3);

/**
 * Filter to replace the [caption] shortcode text with HTML5 compliant code
 *
 * @return text HTML content describing embedded figure
 **/
function my_img_caption_shortcode_filter($val, $attr, $content = null)
{
    extract(shortcode_atts(array(
        'id'    => '',
        'class' => '',
        'align' => '',
        'width' => '',
        'caption' => ''
    ), $attr));

    if ( 1 > (int) $width || empty($caption) )
        return $val;

    $capid = '';
    if ( $id ) {
        $id = esc_attr($id);
        $capid = 'id="figcaption_'. $id . '" ';
        $id = 'id="' . $id . '" aria-labelledby="figcaption_' . $id . '" ';
    }

    return '<div ' . $id . 'class="wp-caption ' . esc_attr($align) . ' ' . esc_attr($class) . '">' . do_shortcode( $content ) . '<p class="wp-caption-text">' . $caption . '</p></div>';
}



/**
* gallery
 */

add_filter( 'wp_get_attachment_link', 'bnl_get_attachment_link', 10, 6);

function bnl_get_attachment_link ($content, $id, $size, $permalink, $icon, $text) {
    if ($permalink) {
        return $content;
    }
    $image = wp_get_attachment_image_src($id,'full');
    $width = $image[1];
    $height = $image[2];
    $content = str_replace('<a','<a data-size="' . $width . 'x' . $height . '"',$content);
    return $content;
}

add_filter( 'image_send_to_editor', 'bnl_image_send_to_editor', 10, 6);

function bnl_image_send_to_editor ($content, $id, $caption, $title, $align, $url, $size) {
    if(!strstr($content, '<a')){
        return $content;
    }
    $image = wp_get_attachment_image_src($id,'full');
    $width = $image[1];
    $height = $image[2];
    $content = str_replace('<a','<a data-size="' . $width . 'x' . $height . '"',$content);
    return $content;
}

//ギャラリーのリンク先をデフォルトでメディアファイルに変更
function image_gallery_default_link( $settings ) {
    $settings['galleryDefaults']['link'] = 'file';
    return $settings;
}
add_filter( 'media_view_settings', 'image_gallery_default_link');






/*
Plugin Name: Parent Category Toggler
Plugin URI: http://wordpress.org/extend/plugins/parent-category-toggler/
Description: Automatically toggle the parent categories when a sub category is selected.
Version: 1.3.2
Author: Ben Lobaugh
Author URI: http://ben.lobaugh.net
Original Author: Aw Guo
Original Author URI: http://www.ifgogo.com
Licence: GPL
*/

function super_category_toggler() {

    $taxonomies = apply_filters('super_category_toggler',array());
    for($x=0;$x<count($taxonomies);$x++)
    {
        $taxonomies[$x] = '#'.$taxonomies[$x].'div .selectit input';
    }
    $selector = implode(',',$taxonomies);
    if($selector == '') $selector = '.selectit input';

    echo '
		<script>
		jQuery("'.$selector.'").change(function(){
			var $chk = jQuery(this);
			var ischecked = $chk.is(":checked");
			$chk.parent().parent().siblings().children("label").children("input").each(function(){
var b = this.checked;
ischecked = ischecked || b;
})
			checkParentNodes(ischecked, $chk);
		});
		function checkParentNodes(b, $obj)
		{
			$prt = findParentObj($obj);
			if ($prt.length != 0)
			{
			 $prt[0].checked = b;
			 checkParentNodes(b, $prt);
			}
		}
		function findParentObj($obj)
		{
			return $obj.parent().parent().parent().prev().children("input");
		}
		</script>
		';

}
add_action('admin_footer-post.php', 'super_category_toggler');
add_action('admin_footer-post-new.php', 'super_category_toggler');





/**
 * SEO by Yoast
 */
/* ツイートボタンのために保持 */
function retain_wpseo_canonical( $canonical ) {
    global $url_canonical;
    $url_canonical = $canonical;
    return $canonical;
}
add_filter( 'wpseo_canonical', 'retain_wpseo_canonical' );

// nouse
function get_nonpaged_url($url) {
    $pattern = '#^(.+/)([0-9]+/*)$#';
    $custom_url = preg_replace($pattern, '${1}', $url);
    return $custom_url;
}
function bnl_custom_ogp_url( $url ) {
    if ( is_single() ){
        $custom_url = get_permalink(); //ページ分割元URLにするため
        return $custom_url;
    }
    return $url;
}
add_filter( 'wpseo_opengraph_url', 'bnl_custom_ogp_url');




/**
 * RSS
 */
/**
 * 追加したカスタム投稿タイプをRSS配信対象にする
 */
function bnl_feed_request($vars)
{
    if ( isset( $vars['feed'] ) && !isset( $vars['post_type'] ) ) {
        $vars['post_type'] = get_basic_post_types();
    }
    return $vars;
}
add_filter( 'request', 'bnl_feed_request' );

/* netpageによる分割記事の全文出力対策 WP4.6以降で修正される？ */
function ftf_full_text_for_feeds( $content ) {
	if ( ! is_feed() )
		return $content;
	global $post;
	$content = $post->post_content;
	return $content;
}
add_filter( 'the_content', 'ftf_full_text_for_feeds', -100 );


// Custom Rss feed for SmartNews
add_action('init', 'add_custom_reed');

function add_custom_reed() {
    add_feed('smartnews', 'feed_smartnews');
}

function feed_smartnews() {
    get_template_part('feed','smartnews');
}

/**
 * RSSにアイキャッチ画像を配信
 */
function rss_post_thumbnail($content) {
    global $post;
    if(has_post_thumbnail($post->ID)) {
        $content = '<p>' . get_the_post_thumbnail($post->ID,'bnl-thumb-large') . '</p>' . $content;
    }
    return $content;
}
add_filter('the_excerpt_rss', 'rss_post_thumbnail');
add_filter('the_content_feed', 'rss_post_thumbnail');

/**
 * wp rest api でカスタム投稿タイプを使うための記述
 */
function sb_add_cpts_to_api() {
    global $wp_post_types;

    // Add CPT slugs here
    $arr = ['interview','story','news','column','special'];

    foreach( $arr as $key ) {

    // If the post type doesn't exist, skip it
    if( !$wp_post_types[$key] )
        continue;

        $wp_post_types[$key]->show_in_rest = true;
        $wp_post_types[$key]->rest_base = $key;
    }
}
//add_action( 'init', 'sb_add_cpts_to_api', 30 );

/**
 *  AMP
 */
add_action( 'amp_init', 'bnl_amp_add_cpt' );
function bnl_amp_add_cpt() {
    $types = get_basic_post_types();
    foreach($types as $posttype) {
        add_post_type_support( $posttype, AMP_QUERY_VAR );
    }
}

add_filter( 'amp_post_article_header_meta', 'bnl_amp_remove_author_meta' );
function bnl_amp_remove_author_meta( $meta_parts ) {
    foreach ( array_keys( $meta_parts, 'meta-author', true ) as $key ) {
        unset( $meta_parts[ $key ] );
    }
    return $meta_parts;
}

add_filter( 'amp_post_template_metadata', 'bnl_amp_modify_json_metadata', 10, 2 );
function bnl_amp_modify_json_metadata( $metadata, $post ) {
    $metadata['author'] = array(
        '@type' => 'Person',
        'name' => 'じぶん仲介journal'
    );

    return $metadata;
}



/**
 *  AddQuickTag
 */
// add custom function to filter hook 'addquicktag_post_types'
add_filter( 'addquicktag_post_types', 'my_addquicktag_post_types' );
/**
 * Return array $post_types with custom post types
 *
 * @param   $post_type Array
 * @return  $post_type Array
 */
function my_addquicktag_post_types( $post_types ) {

//    $post_types[] = 'edit-comments';
    $post_types = array_merge(get_basic_post_types(), $post_types);

    return $post_types;
}




/**
 * debug
 */
if(!function_exists('_log')){
  function _log($message) {
    if (WP_DEBUG === true) {
      if (is_array($message) || is_object($message)) {
        error_log(print_r($message, true));
      } else {
        error_log($message);
      }
    }
  }
}




/* WooCommerce */

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
add_action( 'woocommerce_before_single_product_summary', 'bnl_woocommerce_show_product_images', 20 );
add_action( 'woocommerce_before_single_product_summary', 'bnl_woocommerce_show_product_title', 50 );

function bnl_woocommerce_show_product_images() {
    global $post;
    if ( has_post_thumbnail() ) {
			$html  = '<div class="fabb-product-image liquidimg">';
			$html .= get_the_post_thumbnail( $post->ID, 'large' );
			$html .= '</div>';

			echo $html;
	}

}

function bnl_woocommerce_show_product_title() {
    global $product, $post;
    echo '<div class="fabb-product-title">';
    the_title( '<h1 class="product_title entry-title">', '</h1>' );
    echo '<div class="description">';
    echo mb_strimwidth(get_the_excerpt(), 0, 224, "...", "UTF-8");
    echo '</div>';

    echo '<p class="price"><span class="label">参加費</span><span class="amount-wrapper">' . $product->get_price_html() . '<span class="taxlabel">(税込)</span></span></p>';

    echo '</div>';

}



remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );


add_action( 'woocommerce_single_product_summary', 'bnl_woocommerce_show_product_basicinfo', 5 );

function bnl_woocommerce_show_product_basicinfo() {
    global $post;

    if (!get_field('prd_datetime_start') && !get_field('prd_place')) {
        return;
    }

    echo '<div class="fabb-product-basicinfo">';

    if (get_field('prd_datetime_start')) {

        $datetime_start = strtotime(get_field('prd_datetime_start'));
        $datetime_end = strtotime(get_field('prd_datetime_end'));

        $week = array('日','月','火','水','木','金','土');

        $dts_y = date("Y",$datetime_start);
        $dts_m = date("m",$datetime_start);
        $dts_d = date("d",$datetime_start);
        $dts_w = date("w",$datetime_start);
        $dts_a = date("A",$datetime_start);
        $dts_h = date("g",$datetime_start);
        $dts_mi = date("i",$datetime_start);

        $output_date = "";

        if ($datetime_end) {
            $dte_y = date("Y",$datetime_end);
            $dte_m = date("m",$datetime_end);
            $dte_d = date("d",$datetime_end);
            $dte_w = date("w",$datetime_end);
            $dte_a = date("A",$datetime_end);
            $dte_h = date("g",$datetime_end);
            $dte_mi = date("i",$datetime_end);

            if ($dts_y != $dte_y) $output_date = $dts_y . "年";
            $output_date .= $dts_m . "月" . $dts_d . "日" . " (" . $week[$dts_w] . ") " . $dts_a . $dts_h . ":" . $dts_mi . " 〜 ";
            if ($dts_y != $dte_y) $output_date .= $dte_y . "年";
            if ($dts_m != $dte_m) $output_date .= $dte_m . "月";
            if ($dts_d != $dte_d) $output_date .= $dte_d . "日" . " (" . $week[$dte_w] . ") ";
            $output_date .= $dte_a . $dte_h . ":" . $dte_mi;
        }
        else {
            $output_date = $dts_m . "月" . $dts_d . "日" . " (" . $week[$dts_w] . ") " . $dts_a . $dts_h . ":" . $dts_mi;
        }

        echo '<div class="date">';
        echo '<span class="icon icon-calendar"></span>';
        echo '<p>' . $output_date . '</p>';
        echo '</div>';
    }

    if (get_field('prd_place')) {
        echo '<div class="place">';
        echo '<span class="icon icon-area"></span>';
        echo '<div>';
        echo '<p>' . get_field('prd_place') . '</p>';

        $address = urlencode(strip_tags(get_field('prd_place')));
        echo '<a href="https://www.google.co.jp/maps?q=' . $address . '" target="_blank">地図を見る ></a>';

        echo '</div>';
        echo '</div>';
    }

    echo '</div>';

}


remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

add_action( 'woocommerce_after_single_product_summary', 'bnl_woocommerce_output_author_and_detail', 5 );

function bnl_woocommerce_output_author_and_detail() {
    global $post;

    $author_id = $post->post_author;
    $author_name = get_the_author_meta('user_login');


    echo '<div class="fabb-product-author cf">';

    $usercf = 'user_' . $author_id;

    $name = get_the_author_meta('display_name');
    $mainimg = get_field('ir_mainimg', $usercf);
    $area = get_field('ir_area', $usercf);
    $prof_short = get_field('ir_prof_short', $usercf);

//    $content = get_field('ir_content', $usercf);
    $content = get_the_content($post);


    echo '<div class="prof-wrapper cf">';

    echo '<div class="prof-card-wrapper">';
    echo '<div class="prof-card">';

    echo '<span>';

    $size = 'bnl-thumb-medium';
    if ($mainimg) {
	    $mainthumb = $mainimg['sizes'][ $size ];
	}
	else {
        $mainthumb = get_template_directory_uri() . "/library/images/default_thumb.jpg";
	}

	echo '<div class="mainimg liquidimg"><img src="' . $mainthumb . '" />';
    if ($area) echo '<span class="area">' . $area->name . '</span>';
    echo '</div>';

    if ($name) echo '<p class="name">' . $name . '</p>';
    if ($prof_short) echo '<p class="prof-short">' . $prof_short . '</p>';

    echo '</span>';

    echo '</div>'; // prod-card

    echo '<div class="btn-wrapper"><a class="std-btn-arrow" href="' . get_author_posts_url($author_id) . '">プロフィールをみる</a></div>';

    echo '</div>'; // prod-wrapper


    echo '<div class="prof-content">';

    if ($content) echo $content;

    echo '</div>'; // prod-content

    echo '</div>'; // prod-wrapper

    $archiveurl = get_option('home') . "/course/?author_name=" . $author_name;
    echo '<div class="btn-wrapper"><a class="std-btn-arrow" href="' . $archiveurl . '">講座一覧を見る</a></div>';


    echo '</div>';

}



add_filter( 'woocommerce_get_availability', 'bnl_woocommerce_get_availability', 1, 2);

function bnl_woocommerce_get_availability( $availability, $_product ) {
  global $product;
  $stock = $product->get_total_stock();

  if ( $_product->is_in_stock() ) {
      if ($stock <= 3) {
        $availability['availability'] = "<span class='label'>残席数</span><span>残りわずか</span>";
      }
      else {
        $availability['availability'] = "<span class='label'>残席数</span><span>" . $stock . "</span>";
      }
  }
  if ( !$_product->is_in_stock() ) $availability['availability'] = "<span class='label'>残席数</span><span>受付終了</span>";

  return $availability;
}


add_filter( 'woocommerce_product_single_add_to_cart_text', 'bnl_custom_cart_button_text' );
add_filter('woocommerce_product_add_to_cart_text', 'bnl_custom_cart_button_text');   // 2.1 +

function bnl_custom_cart_button_text()
{
    return "受講する";
}


add_action('init', 'bnl_add_author_woocommerce', 999 );
function bnl_add_author_woocommerce() {
    add_post_type_support( 'product', 'author' );
}



// WOOCOMMERCE ARCHIVE
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

add_action( 'woocommerce_before_shop_loop_item_title', 'bnl_archive_product_thumbnail', 10 );

function bnl_archive_product_thumbnail() {
    global $post;
    $size = array();
    $sizeclass = "";

    echo '<div class="postimage">';
    $thumbnail_url = get_thumb_url(false, "large", true, $size);
    if (!empty($size) && ($size[1] / $size[0]) <= 0.6724) $sizeclass = "adjust-h";
    echo '<img class="' . $sizeclass . '" src="' . $thumbnail_url . '" />';
    output_status($post);
    echo '</div>';

}

add_action( 'woocommerce_before_shop_loop_item_title', 'bnl_archive_product_info', 20 );

function bnl_archive_product_info() {
    global $post;

    output_infoheader($post, true);

}


remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );



/* author -> instructor */
//add_action( 'init', 'bnl_cng_author_base');
//function bnl_cng_author_base() {
//    global $wp_rewrite;
//    $author_slug = 'instructor'; // change slug name
//    $wp_rewrite->author_base = $author_slug;
//    $wp_rewrite->flush_rules();
//}


function bnl_change_text_strings( $translated_text, $text, $domain ) {
switch ( $translated_text ) {
    case 'WooCommerce' :
        $translated_text = "FABB.SCHOOL基本";
        break;
}
return $translated_text;
}
add_filter( 'gettext', 'bnl_change_text_strings', 20, 3 );

add_filter( 'woocommerce_register_post_type_product', 'bnl_change_wc_post_type' );

function bnl_change_wc_post_type( $args ){
    $labels = array(
        'name'               => "スクール",
        'singular_name'      => "スクール",
        'menu_name'          => "スクール",
        'add_new'            => "スクールを追加",
        'add_new_item'       => "新スクールを追加",
//        'edit'               => __( 'Edit', 'your-custom-plugin' ),
        'edit_item'          => "スクールの編集",
        'new_item'           => "新しいスクール",
//        'view'               => __( 'View Tour', 'your-custom-plugin' ),
//        'view_item'          => __( 'View Tour', 'your-custom-plugin' ),
        'search_items'       => "スクールを検索",
        'not_found'          => "スクールが見つかりませんでした。",
        'not_found_in_trash' => "ゴミ箱にスクールが見つかりませんでした。",
//        'parent'             => __( 'Parent Tour', 'your-custom-plugin' )
    );

    $args['labels'] = $labels;
//    $args['description'] = __( 'This is where you can add new tours to your store.', 'your-custom-plugin' );
    return $args;
}

add_filter( 'woocommerce_taxonomy_args_product_cat', 'bnl_custom_wc_taxonomy_args_product_cat' );
function bnl_custom_wc_taxonomy_args_product_cat( $args ) {
	$args['label'] = "スクールカテゴリー";
	$args['labels'] = array(
        'name' 				=> "スクールカテゴリー",
        'singular_name' 	=> "スクールカテゴリー",
        'menu_name'			=> "カテゴリー",
//        'search_items' 		=> __( 'Search Product Categories', 'woocommerce' ),
//        'all_items' 		=> __( 'All Product Categories', 'woocommerce' ),
//        'parent_item' 		=> __( 'Parent Product Category', 'woocommerce' ),
//        'parent_item_colon' => __( 'Parent Product Category:', 'woocommerce' ),
//        'edit_item' 		=> __( 'Edit Product Category', 'woocommerce' ),
//        'update_item' 		=> __( 'Update Product Category', 'woocommerce' ),
//        'add_new_item' 		=> __( 'Add New Product Category', 'woocommerce' ),
//        'new_item_name' 	=> __( 'New Product Category Name', 'woocommerce' )
	);

	return $args;
}



//商品のパーマリンクを8桁揃えのポストIDにする
function auto_post_slug($slug, $post_ID, $post_status, $post_type) {
    $nowPostId  = 1;
    $digit      = 8;    //0埋めする桁数
    $format     = '%0' .$digit. 'd';

    if ($post_type == "product" && $post_ID != $nowPostId) {
        $slug = sprintf($format, $post_ID);
        //パーマリンクを編集できないよう、ボタンを非表示に
        $stylesheet =
            '<style>'.PHP_EOL.
            '.post-type-'.$post_type.' #edit-slug-buttons {'.PHP_EOL.
            '   display:none;'.PHP_EOL.
            '}'.PHP_EOL.
            '</style>'
        ;
        echo($stylesheet);
    }

    return $slug;
}
add_filter('wp_unique_post_slug', 'auto_post_slug', 10, 4);




/** ユーザー共通化 */
function synchro_roles ( $user_id ) {
    $role =  get_user_meta( $user_id, 'fabbworks_capabilities' );
    update_user_meta( $user_id, 'fabb_capabilities', $role[0] );
    update_user_meta( $user_id, 'fabbschool_capabilities', $role[0] );
    update_user_meta( $user_id, 'fabbspace_capabilities', $role[0] );
    update_user_meta( $user_id, 'fabbmarket_capabilities', $role[0] );
    update_user_meta( $user_id, 'fabbjob_capabilities', $role[0] );
}
add_action( 'user_register', 'synchro_roles' );
add_action( 'profile_update', 'synchro_roles' );
