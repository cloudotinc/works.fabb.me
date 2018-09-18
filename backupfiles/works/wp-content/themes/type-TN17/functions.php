<?php
/**
 * Twenty Thirteen functions and definitions
 *
 * Sets up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

/*
 * Set up the content width value based on the theme's design.
 *
 * @see twentythirteen_content_width() for template-specific adjustments.
 */
if ( ! isset( $content_width ) )
	$content_width = 1024;

/**
 * Add support for a custom header image.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Twenty Thirteen only works in WordPress 3.6 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '3.6-alpha', '<' ) )
	require get_template_directory() . '/inc/back-compat.php';

/**
 * Twenty Thirteen setup.
 *
 * Sets up theme defaults and registers the various WordPress features that
 * Twenty Thirteen supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add Visual Editor stylesheets.
 * @uses add_theme_support() To add support for automatic feed links, post
 * formats, and post thumbnails.
 * @uses register_nav_menu() To add support for a navigation menu.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Thirteen 1.0
 */
function twentythirteen_setup() {
	/*
	 * Makes Twenty Thirteen available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Thirteen, use a find and
	 * replace to change 'twentythirteen' to the name of your theme in all
	 * template files.
	 */
	load_theme_textdomain( 'twentythirteen', get_template_directory() . '/languages' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', 'fonts/genericons.css', twentythirteen_fonts_url() ) );

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Switches default core markup for search form, comment form,
	 * and comments to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * This theme supports all available post formats by default.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
	) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Navigation Menu', 'twentythirteen' ) );

	/*
	 * This theme uses a custom image size for featured images, displayed on
	 * "standard" posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );
//	add_image_size('thumb140', 300, 300, true);
	add_image_size('thumb-sq', 400, 400, true);

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
}
add_action( 'after_setup_theme', 'twentythirteen_setup' );

/**
 * Return the Google font stylesheet URL, if available.
 *
 * The use of Source Sans Pro and Bitter by default is localized. For languages
 * that use characters not supported by the font, the font can be disabled.
 *
 * @since Twenty Thirteen 1.0
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function twentythirteen_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Source Sans Pro, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$source_sans_pro = _x( 'on', 'Source Sans Pro font: on or off', 'twentythirteen' );

	/* Translators: If there are characters in your language that are not
	 * supported by Bitter, translate this to 'off'. Do not translate into your
	 * own language.
	 */
	$bitter = _x( 'on', 'Bitter font: on or off', 'twentythirteen' );

	if ( 'off' !== $source_sans_pro || 'off' !== $bitter ) {
		$font_families = array();

		if ( 'off' !== $source_sans_pro )
			$font_families[] = 'Source Sans Pro:300,400,700,300italic,400italic,700italic';

		if ( 'off' !== $bitter )
			$font_families[] = 'Bitter:400,700';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}

/**
 * Enqueue scripts and styles for the front end.
 *
 * @since Twenty Thirteen 1.0
 */
function twentythirteen_scripts_styles() {
	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	// Adds Masonry to handle vertical alignment of footer widgets.
	if ( is_active_sidebar( 'sidebar-1' ) )
		wp_enqueue_script( 'jquery-masonry' );

	// Loads JavaScript file with functionality specific to Twenty Thirteen.
	wp_enqueue_script( 'twentythirteen-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '2014-03-18', true );

	// Add Source Sans Pro and Bitter fonts, used in the main stylesheet.
	wp_enqueue_style( 'twentythirteen-fonts', twentythirteen_fonts_url(), array(), null );

	// Add Genericons font, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/fonts/genericons.css', array(), '2.09' );

	// Loads our main stylesheet.
	wp_enqueue_style( 'normalize', get_template_directory_uri() . '/css/normalize.css' );
	wp_enqueue_style( 'basic-style-pc', get_stylesheet_uri());
        wp_enqueue_style( 'layout_pc', get_template_directory_uri() . '/css/layout_pc.css', array(), "20171231");
        wp_enqueue_style( 'layout_sp', get_template_directory_uri() . '/css/layout_sp.css', array(), "20171231");

	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'twentythirteen-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentythirteen-style' ), '2013-07-18' );
	wp_style_add_data( 'twentythirteen-ie', 'conditional', 'lt IE 9' );

}
add_action( 'wp_enqueue_scripts', 'twentythirteen_scripts_styles' );

/**
 * Filter the page title.
 *
 * Creates a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Twenty Thirteen 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep   Optional separator.
 * @return string The filtered title.
 */
function twentythirteen_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'twentythirteen' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'twentythirteen_wp_title', 10, 2 );

/**
 * Register two widget areas.
 *
 * @since Twenty Thirteen 1.0
 */
function twentythirteen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Main Widget Area', 'twentythirteen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Appears in the footer section of the site.', 'twentythirteen' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Secondary Widget Area', 'twentythirteen' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'twentythirteen' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'twentythirteen_widgets_init' );

if ( ! function_exists( 'twentythirteen_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since Twenty Thirteen 1.0
 */
function twentythirteen_paging_nav() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 )
		return;
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'twentythirteen' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentythirteen' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentythirteen' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'twentythirteen_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
*
* @since Twenty Thirteen 1.0
*/
function twentythirteen_post_nav() {
	global $post;

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
	?>
				<li class="prenex">
				<dl>
					<dt><?php previous_post_link('&laquo; %link', '%title', TRUE, ''); ?></dt>
					<dd><?php next_post_link('%link &raquo;', '%title', TRUE, ''); ?></dd>
				 </dl>
			</li>

	<?php
}
endif;

if ( ! function_exists( 'twentythirteen_entry_meta' ) ) :
/**
 * Print HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own twentythirteen_entry_meta() to override in a child theme.
 *
 * @since Twenty Thirteen 1.0
 */
function twentythirteen_entry_meta() {
	if ( is_sticky() && is_home() && ! is_paged() )
		echo '<span class="featured-post">' . __( 'Sticky', 'twentythirteen' ) . '</span>';

	if ( ! has_post_format( 'link' ) && 'post' == get_post_type() )
		twentythirteen_entry_date();

	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'twentythirteen' ) );
	if ( $categories_list ) {
		echo '<span class="categories-links">' . $categories_list . '</span>';
	}
/*
	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'twentythirteen' ) );
	if ( $tag_list ) {
		echo '<span class="tags-links">' . $tag_list . '</span>';
	}

	// Post author
	if ( 'post' == get_post_type() ) {
		printf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'twentythirteen' ), get_the_author() ) ),
			get_the_author()
		);
	}
*/
}
endif;

if ( ! function_exists( 'twentythirteen_entry_date' ) ) :
/**
 * Print HTML with date information for current post.
 *
 * Create your own twentythirteen_entry_date() to override in a child theme.
 *
 * @since Twenty Thirteen 1.0
 *
 * @param boolean $echo (optional) Whether to echo the date. Default true.
 * @return string The HTML-formatted post date.
 */
function twentythirteen_entry_date( $echo = true ) {
	if ( has_post_format( array( 'chat', 'status' ) ) )
		$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'twentythirteen' );
	else
		$format_prefix = '%2$s';

	$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
		esc_url( get_permalink() ),
		esc_attr( sprintf( __( 'Permalink to %s', 'twentythirteen' ), the_title_attribute( 'echo=0' ) ) ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
	);

	if ( $echo )
		echo $date;

	return $date;
}
endif;

if ( ! function_exists( 'twentythirteen_the_attached_image' ) ) :
/**
 * Print the attached image with a link to the next attached image.
 *
 * @since Twenty Thirteen 1.0
 */
function twentythirteen_the_attached_image() {
	/**
	 * Filter the image attachment size to use.
	 *
	 * @since Twenty thirteen 1.0
	 *
	 * @param array $size {
	 *     @type int The attachment height in pixels.
	 *     @type int The attachment width in pixels.
	 * }
	 */
	$attachment_size     = apply_filters( 'twentythirteen_attachment_size', array( 724, 724 ) );
	$next_attachment_url = wp_get_attachment_url();
	$post                = get_post();

	/*
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID'
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id )
			$next_attachment_url = get_attachment_link( $next_id );

		// or get the URL of the first image attachment.
		else
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
	}

	printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
		esc_url( $next_attachment_url ),
		the_title_attribute( array( 'echo' => false ) ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

/**
 * Return the post URL.
 *
 * @uses get_url_in_content() to get the URL in the post meta (if it exists) or
 * the first link found in the post content.
 *
 * Falls back to the post permalink if no URL is found in the post.
 *
 * @since Twenty Thirteen 1.0
 *
 * @return string The Link format URL.
 */
function twentythirteen_get_link_url() {
	$content = get_the_content();
	$has_url = get_url_in_content( $content );

	return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}

/**
 * Extend the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Active widgets in the sidebar to change the layout and spacing.
 * 3. When avatars are disabled in discussion settings.
 *
 * @since Twenty Thirteen 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function twentythirteen_body_class( $classes ) {
	if ( ! is_multi_author() )
		$classes[] = 'single-author';

	if ( is_active_sidebar( 'sidebar-2' ) && ! is_attachment() && ! is_404() )
		$classes[] = 'sidebar';

	if ( ! get_option( 'show_avatars' ) )
		$classes[] = 'no-avatars';

	return $classes;
}
add_filter( 'body_class', 'twentythirteen_body_class' );

/**
 * Adjust content_width value for video post formats and attachment templates.
 *
 * @since Twenty Thirteen 1.0
 */
function twentythirteen_content_width() {
	global $content_width;

	if ( is_attachment() )
		$content_width = 724;
	elseif ( has_post_format( 'audio' ) )
		$content_width = 484;
}
add_action( 'template_redirect', 'twentythirteen_content_width' );

/**
 * Add postMessage support for site title and description for the Customizer.
 *
 * @since Twenty Thirteen 1.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function twentythirteen_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'twentythirteen_customize_register' );

/**
 * Enqueue Javascript postMessage handlers for the Customizer.
 *
 * Binds JavaScript handlers to make the Customizer preview
 * reload changes asynchronously.
 *
 * @since Twenty Thirteen 1.0
 */
function twentythirteen_customize_preview_js() {
	wp_enqueue_script( 'twentythirteen-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20130226', true );
}
add_action( 'customize_preview_init', 'twentythirteen_customize_preview_js' );



// 抜粋テキスト文字数制限
function new_excerpt_mblength($length) {
     return 73;
}  
add_filter('excerpt_mblength', 'new_excerpt_mblength');

// サイト表示時の上部ステータスバーの非表示
add_filter( 'show_admin_bar', '__return_false' );

// pタグを非表示
remove_filter('term_description', 'wpautop');

// ログイン画面の変更
function custom_login() { ?>
	<style>
		.login {
			background: -webkit-repeating-linear-gradient(-45deg, #b8bec3, #b8bec3 5px, #c8cfd5 5px, #c8cfd5 15px);
			background: repeating-linear-gradient(-45deg, #b8bec3, #b8bec3 5px, #c8cfd5 5px, #c8cfd5 15px);
		}
		.login #login h1 a {
			width: 120px;
			height:120px;
			background: url(<?php echo get_stylesheet_directory_uri(); ?>/images/w-logo-black_c.png) no-repeat 0 0;
		}
		body.login div#login form#loginform { background:rgba(0,0,0,0.5)}
		body.login div#login p#nav a, body.login div#login form#loginform p label, body.login div#login p#backtoblog a { color:#fff !important;}
	</style>
<?php }
add_action( 'login_enqueue_scripts', 'custom_login' );


//カスタム投稿タイプ追加項目+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

//カスタム投稿タイプ -blogs
add_action('init', 'blogs_init');
function blogs_init()
{
  $labels = array(
    'name' => _x('blogs', 'post type general name'),
    'singular_name' => _x('blogs', 'post type singular name'),
    'add_new' => _x('ブログの記事を書く', 'blogs'),
    'add_new_item' => __('ブログの記事を書く'),
    'edit_item' => __('ブログの記事を編集'),
    'new_item' => __('新しい記事'),
    'view_item' => __('記事を見てみる'),
    'search_items' => __('記事を探す'),
    'not_found' =>  __('記事はありません'),
    'not_found_in_trash' => __('ゴミ箱に記事はありません'),
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => 5,
    'supports' => array('title','editor','thumbnail','custom-fields','excerpt','revisions','page-attributes','comments'),
    'has_archive' => true
  );
  register_post_type('blogs',$args);
  
  
//カテゴリータイプ
$args = array(
'label' => 'ブログカテゴリー',
'public' => true,
'show_ui' => true,
'hierarchical' => true
);
register_taxonomy('blogs_category','blogs',$args);

//タグタイプ
$args = array(
'label' => 'ブログタグ',
'public' => true,
'show_ui' => true,
'hierarchical' => false
);
register_taxonomy('blogs_tag','blogs',$args);
}


//カテゴリーのアーカイブページにカスタム投稿を含める
function add_post_category_archive( $wp_query ) {
if ($wp_query->is_main_query() && $wp_query->is_category()) {
$wp_query->set( 'post_type', array('post','blogs'));
}
}
add_action( 'pre_get_posts', 'add_post_category_archive' , 10 , 1);


// カスタム投稿月別アーカイブ
global $my_archives_post_type;
add_filter( 'getarchives_where', 'my_getarchives_where', 10, 2 );
function my_getarchives_where( $where, $r ) {
  global $my_archives_post_type;
	if ( isset($r['post_type']) ) {
		$my_archives_post_type = $r['post_type'];
		$where = str_replace( '\'post\'', '\'' . $r['post_type'] . '\'', $where );
	} else {
		$my_archives_post_type = '';
	}
	return $where;
}
add_filter( 'get_archives_link', 'my_get_archives_link' );
function my_get_archives_link( $link_html ) {
	global $my_archives_post_type;
	if ( '' != $my_archives_post_type )
		$add_link .= '?post_type=' . $my_archives_post_type;
	$link_html = preg_replace("/href=\'(.+)\'\s/","href='$1".$add_link."'",$link_html);

	return $link_html;
}

// カスタム投稿パーマリンクをIDに変更
add_action('init', 'myposttype_rewrite');
function myposttype_rewrite() {
    global $wp_rewrite;
    $queryarg = 'post_type=blogs&p=';
    $wp_rewrite->add_rewrite_tag('%blogs_id%', '([^/]+)',$queryarg);
    $wp_rewrite->add_permastruct('blogs', '/blogs/%blogs_id%', false);
}
add_filter('post_type_link', 'myposttype_permalink', 1, 3);
function myposttype_permalink($post_link, $id = 0, $leavename) {
    global $wp_rewrite;
    $post = &get_post($id);
    if ( is_wp_error( $post ) )
        return $post;
    $newlink = $wp_rewrite->get_extra_permastruct($post->post_type);
    $newlink = str_replace('%'.$post->post_type.'_id%', $post->ID, $newlink);
    $newlink = home_url(user_trailingslashit($newlink));
    return $newlink;
}

//

function get_basic_post_types() {
    return array('service','casestudy','worker');
}

function custom_post_service() {
    // creating (registering) the custom type
    register_post_type( 'service', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
        // let's now add all the options for this post type
        array( 'labels' => array(
            'name' => 'サービス', /* This is the Title of the Group */
            'singular_name' => 'サービス', /* This is the individual type */
            'all_items' => '全ての投稿', /* the all items menu item */
            'add_new' => '追加する', /* The add new menu item */
            'add_new_item' => 'サービス記事の追加', /* Add New Display Title */
            'edit' => '編集する', /* Edit Dialog */
            'edit_item' => 'サービス記事の編集', /* Edit Display Title */
            //'new_item' => __( 'New Post Type', 'bonestheme' ), /* New Display Title */
            //'view_item' => __( 'View Post Type', 'bonestheme' ), /* View Display Title */
            //'search_items' => __( 'Search Post Type', 'bonestheme' ), /* Search Custom Type Title */
            //'not_found' =>  __( 'Nothing found in the Database.', 'bonestheme' ), /* This displays if there are no entries yet */
            //'not_found_in_trash' => __( 'Nothing found in Trash', 'bonestheme' ), /* This displays if there is nothing in the trash */
            'parent_item_colon' => ''
        ), /* end of arrays */
            'description' => 'サービス用投稿', /* Custom Type Description */
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'show_ui' => true,
            'query_var' => true,
            'menu_position' => 5, /* this is what order you want it to appear in on the left hand side menu */
            //'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
            'rewrite'	=> array( 'slug' => 'service', 'with_front' => false ), /* you can specify its url slug */
            'has_archive' => 'service', /* you can rename the slug here */
            'capability_type'     => 'post',
            'map_meta_cap'        => true,
            'hierarchical' => false,
            /* the next one is important, it tells what's enabled in the post editor */
            'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'page-attributes', 'custom-fields', 'revisions', 'sticky')
        ) /* end of options */
    ); /* end of register post type */

    /* this adds your post categories to your custom post type */
    //register_taxonomy_for_object_type( 'category', 'custom_type' );
    /* this adds your post tags to your custom post type */
    register_taxonomy_for_object_type( 'post_tag', 'service' );
}

function custom_post_casestudy() {
    // creating (registering) the custom type
    register_post_type( 'casestudy', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
        // let's now add all the options for this post type
        array( 'labels' => array(
            'name' => '制作事例', /* This is the Title of the Group */
            'singular_name' => '制作事例', /* This is the individual type */
            'all_items' => '全ての投稿', /* the all items menu item */
            'add_new' => '追加する', /* The add new menu item */
            'add_new_item' => '制作事例記事の追加', /* Add New Display Title */
            'edit' => '編集する', /* Edit Dialog */
            'edit_item' => '制作事例記事の編集', /* Edit Display Title */
            //'new_item' => __( 'New Post Type', 'bonestheme' ), /* New Display Title */
            //'view_item' => __( 'View Post Type', 'bonestheme' ), /* View Display Title */
            //'search_items' => __( 'Search Post Type', 'bonestheme' ), /* Search Custom Type Title */
            //'not_found' =>  __( 'Nothing found in the Database.', 'bonestheme' ), /* This displays if there are no entries yet */
            //'not_found_in_trash' => __( 'Nothing found in Trash', 'bonestheme' ), /* This displays if there is nothing in the trash */
            'parent_item_colon' => ''
        ), /* end of arrays */
            'description' => '制作事例用投稿', /* Custom Type Description */
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'show_ui' => true,
            'query_var' => true,
            'menu_position' => 5, /* this is what order you want it to appear in on the left hand side menu */
            //'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
            'rewrite'	=> array( 'slug' => 'casestudy', 'with_front' => false ), /* you can specify its url slug */
            'has_archive' => 'casestudy', /* you can rename the slug here */
            'capability_type'     => 'post',
            'map_meta_cap'        => true,
            'hierarchical' => false,
            /* the next one is important, it tells what's enabled in the post editor */
            'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'page-attributes', 'custom-fields', 'revisions', 'sticky')
        ) /* end of options */
    ); /* end of register post type */

    /* this adds your post categories to your custom post type */
    //register_taxonomy_for_object_type( 'category', 'custom_type' );
    /* this adds your post tags to your custom post type */
    register_taxonomy_for_object_type( 'post_tag', 'casestudy' );
}

function custom_post_worker() {
    // creating (registering) the custom type
    register_post_type( 'worker', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
        // let's now add all the options for this post type
        array( 'labels' => array(
            'name' => 'ワーカー', /* This is the Title of the Group */
            'singular_name' => 'ワーカー', /* This is the individual type */
            'all_items' => '全ての投稿', /* the all items menu item */
            'add_new' => '追加する', /* The add new menu item */
            'add_new_item' => 'ワーカー記事の追加', /* Add New Display Title */
            'edit' => '編集する', /* Edit Dialog */
            'edit_item' => 'ワーカー記事の編集', /* Edit Display Title */
            //'new_item' => __( 'New Post Type', 'bonestheme' ), /* New Display Title */
            //'view_item' => __( 'View Post Type', 'bonestheme' ), /* View Display Title */
            //'search_items' => __( 'Search Post Type', 'bonestheme' ), /* Search Custom Type Title */
            //'not_found' =>  __( 'Nothing found in the Database.', 'bonestheme' ), /* This displays if there are no entries yet */
            //'not_found_in_trash' => __( 'Nothing found in Trash', 'bonestheme' ), /* This displays if there is nothing in the trash */
            'parent_item_colon' => ''
        ), /* end of arrays */
            'description' => 'ワーカー用投稿', /* Custom Type Description */
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'show_ui' => true,
            'query_var' => true,
            'menu_position' => 5, /* this is what order you want it to appear in on the left hand side menu */
            //'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
            'rewrite'	=> array( 'slug' => 'worker', 'with_front' => false ), /* you can specify its url slug */
            'has_archive' => 'worker', /* you can rename the slug here */
            'capability_type'     => 'post',
            'map_meta_cap'        => true,
            'hierarchical' => false,
            /* the next one is important, it tells what's enabled in the post editor */
            'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'page-attributes', 'custom-fields', 'revisions', 'sticky')
        ) /* end of options */
    ); /* end of register post type */

    /* this adds your post categories to your custom post type */
    //register_taxonomy_for_object_type( 'category', 'custom_type' );
    /* this adds your post tags to your custom post type */
    register_taxonomy_for_object_type( 'post_tag', 'worker' );
}


add_action( 'init', 'custom_post_service');
add_action( 'init', 'custom_post_casestudy');
add_action( 'init', 'custom_post_worker');

function add_servicecat_taxonomy(){

    //set the name of the taxonomy
    $taxonomy = 'service_cat';
    //set the post types for the taxonomy
    $object_type = array("service","casestudy","worker");

    //populate our array of names for our taxonomy
    $labels = array(
        'name'               => 'サービスカテゴリ',
        'singular_name'      => 'サービスカテゴリ',
        'search_items'       => 'サービスカテゴリを検索',
        'all_items'          => 'サービスカテゴリ一覧',
        'parent_item'        => '親サービスカテゴリ',
        'parent_item_colon'  => '親サービスカテゴリ:',
        'update_item'        => '更新',
        'edit_item'          => 'サービスカテゴリの編集',
        'add_new_item'       => 'サービスカテゴリの追加',
        'new_item_name'      => '名前',
        'menu_name'          => 'サービスカテゴリ'
    );

    //define arguments to be used
    $args = array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'show_ui'           => true,
        'how_in_nav_menus'  => true,
        'public'            => true,
        'show_admin_column' => false,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'service-cat')
    );

    //call the register_taxonomy function
    register_taxonomy($taxonomy, $object_type, $args);
}
add_action('init','add_servicecat_taxonomy');

add_filter( 'post_type_link', 'bnl_post_type_link', 1, 2 );
function bnl_post_type_link( $link, $post ){
    if ( 'service' === $post->post_type ) {
        return home_url( '/service/' . $post->ID . "/" );
    }
    else if ( 'casestudy' === $post->post_type ) {
        return home_url( '/casestudy/' . $post->ID . "/" );
    }
    else if ( 'worker' === $post->post_type ) {
        return home_url( '/worker/' . $post->ID . "/" );
    }
    else {
        return $link;
    }
}



add_action( 'init', 'bnl_rewrites_init' );
function bnl_rewrites_init(){

    $types = get_basic_post_types();
    foreach($types as $posttype) {
        add_rewrite_rule(
            $posttype . '/([0-9]+)/?$',
            'index.php?post_type=' . $posttype . '&p=$matches[1]',
            'top' );
        add_rewrite_rule(
            $posttype . '/([0-9]+)/([0-9]{1,})/?$',
            'index.php?post_type=' . $posttype . '&p=$matches[1]&page=$matches[2]',
            'top' );
        add_rewrite_rule(
            $posttype . '/([0-9]+)/amp/?$',
            'index.php?post_type=' . $posttype . '&p=$matches[1]&amp=1',
            'top' );
    }
}

/*
 * singleページ不要の投稿タイプはトップに転送
 */
add_action( 'template_redirect', 'unused_singlepost_redirect' );
function unused_singlepost_redirect(){
    $post_type = get_post_type();
    $exclude_types = array('casestudy');

    if(in_array($post_type, $exclude_types) && is_single()){
        wp_safe_redirect(home_url(), 301);
        exit;
    }
}



/* Utilities */
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

function get_thumb_url($size = "large", $show_default = true, &$sizearray = 0) {
    $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), $size);
    $thumbnail_url = $thumbnail[0];

    if (empty($thumbnail_url) && $show_default) {
        $thumbnail_url = get_template_directory_uri() . "/images/default_thumb.jpg";
    }
    else {
        if (!empty($thumbnail_url) && is_array($sizearray)) {
            $sizearray = array($thumbnail[1],$thumbnail[2]);
        }
    }
    return $thumbnail_url;
}



function bnl_filter( $query )
{
    if ( is_admin() || !$query->is_main_query() ) return;

    if ( $query->is_archive() ) {
//        $query->set( 'orderby', 'date' );
//        $query->set( 'order', 'DESC' );

        if ( $query->is_post_type_archive('worker')) {
            $query->set( 'posts_per_page', '1' );
        }

        return;
    }
}
//add_action( 'pre_get_posts', 'bnl_filter' );


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