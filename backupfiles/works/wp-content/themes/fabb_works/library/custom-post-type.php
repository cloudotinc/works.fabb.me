<?php
/* Bones Custom Post Type Example
This page walks you through creating 
a custom post type and taxonomies. You
can edit this one or copy the following code 
to create another one. 

I put this in a separate file so as to 
keep it organized. I find it easier to edit
and change things if they are concentrated
in their own file.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/

// Flush rewrite rules for custom post types
add_action( 'after_switch_theme', 'bones_flush_rewrite_rules' );

// Flush your rewrite rules
function bones_flush_rewrite_rules() {
	flush_rewrite_rules();
}

function get_postid_post_types() {
    return array('casestudy','worker');
}
function get_basic_post_types() {
    return array('service','casestudy','worker');
}
function get_all_post_types() {
    return array('service','casestudy','worker');
}

// let's create the function for the custom type

function custom_post_news() {
    // creating (registering) the custom type
    register_post_type( 'news', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
        // let's now add all the options for this post type
        array( 'labels' => array(
            'name' => 'ニュース', /* This is the Title of the Group */
            'singular_name' => 'ニュース', /* This is the individual type */
            'all_items' => '全ての投稿', /* the all items menu item */
            'add_new' => '追加する', /* The add new menu item */
            'add_new_item' => 'ニュース記事の追加', /* Add New Display Title */
            'edit' => '編集する', /* Edit Dialog */
            'edit_item' => 'ニュース記事の編集', /* Edit Display Title */
            //'new_item' => __( 'New Post Type', 'bonestheme' ), /* New Display Title */
            //'view_item' => __( 'View Post Type', 'bonestheme' ), /* View Display Title */
            //'search_items' => __( 'Search Post Type', 'bonestheme' ), /* Search Custom Type Title */
            //'not_found' =>  __( 'Nothing found in the Database.', 'bonestheme' ), /* This displays if there are no entries yet */
            //'not_found_in_trash' => __( 'Nothing found in Trash', 'bonestheme' ), /* This displays if there is nothing in the trash */
            'parent_item_colon' => ''
        ), /* end of arrays */
            'description' => 'ニュース用投稿', /* Custom Type Description */
            'public' => true,
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'show_ui' => true,
            'query_var' => true,
            'menu_position' => 5, /* this is what order you want it to appear in on the left hand side menu */
            //'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
            'rewrite'	=> array( 'slug' => 'news', 'with_front' => false ), /* you can specify its url slug */
            'has_archive' => 'journal/news', /* you can rename the slug here */
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
    register_taxonomy_for_object_type( 'post_tag', 'news' );

//    register_taxonomy_for_object_type( 'genre', 'news' );
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


function custom_post_viewstg() {
	// creating (registering) the custom type
	register_post_type( 'viewstg', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		// let's now add all the options for this post type
		array( 'labels' => array(
			'name' => 'サイト表示設定', /* This is the Title of the Group */
			'singular_name' => 'サイト表示設定', /* This is the individual type */
			'all_items' => '全ての設定', /* the all items menu item */
			'add_new' => '追加する', /* The add new menu item */
			'add_new_item' => 'サイト表示設定の追加', /* Add New Display Title */
			'edit' => '編集する', /* Edit Dialog */
			'edit_item' => 'サイト表示設定の編集', /* Edit Display Title */
			//'new_item' => __( 'New Post Type', 'bonestheme' ), /* New Display Title */
			//'view_item' => __( 'View Post Type', 'bonestheme' ), /* View Display Title */
			//'search_items' => __( 'Search Post Type', 'bonestheme' ), /* Search Custom Type Title */
			//'not_found' =>  __( 'Nothing found in the Database.', 'bonestheme' ), /* This displays if there are no entries yet */
			//'not_found_in_trash' => __( 'Nothing found in Trash', 'bonestheme' ), /* This displays if there is nothing in the trash */
			'parent_item_colon' => ''
		), /* end of arrays */
			'description' => 'サイト表示設定用投稿', /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 6, /* this is what order you want it to appear in on the left hand side menu */
			//'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
			'rewrite'	=> array( 'slug' => 'viewstg', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => false, /* you can rename the slug here */
			'capability_type'     => 'post',
			'map_meta_cap'        => true,
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'author', 'page-attributes', 'custom-fields', 'revisions', 'sticky')
		) /* end of options */
	); /* end of register post type */

	/* this adds your post categories to your custom post type */
	//register_taxonomy_for_object_type( 'category', 'custom_type' );
	/* this adds your post tags to your custom post type */
//	register_taxonomy_for_object_type( 'post_tag', 'special' );

//    register_taxonomy_for_object_type( 'genre', 'column' );
}


	// adding the function to the Wordpress init
//add_action( 'init', 'custom_post_viewstg');
add_action( 'init', 'custom_post_service');
add_action( 'init', 'custom_post_casestudy');
add_action( 'init', 'custom_post_worker');

	/*
	for more information on taxonomies, go here:
	http://codex.wordpress.org/Function_Reference/register_taxonomy
	*/


// now let's add custom categories (these act like categories)

register_taxonomy('news_cat',
    array('news'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
    array('hierarchical' => true,     /* if this is true, it acts like categories */
        'labels' => array(
            'name' => 'ニュースカテゴリ', /* name of the custom taxonomy */
            'singular_name' => 'ニュースカテゴリ', /* single taxonomy name */
            'search_items' => 'ニュースカテゴリを検索', /* search title for taxomony */
            'all_items' => 'ニュースカテゴリ一覧', /* all title for taxonomies */
            'parent_item' => '親ニュースカテゴリ', /* parent title for taxonomy */
            'parent_item_colon' => '親ニュースカテゴリ:', /* parent taxonomy title */
            'edit_item' => 'ニュースカテゴリの編集', /* edit custom taxonomy title */
            'update_item' => 'ニュースカテゴリの更新', /* update title for taxonomy */
            'add_new_item' => 'ニュースカテゴリの追加', /* add new title for taxonomy */
            'new_item_name' => 'ニュースカテゴリ名' /* name title for taxonomy */
        ),
        'show_admin_column' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'news/newscat')
    )
);


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


function add_area_taxonomy(){

    //set the name of the taxonomy
    $taxonomy = 'area';
    //set the post types for the taxonomy
    $object_type = "product";

    //populate our array of names for our taxonomy
    $labels = array(
        'name'               => 'エリア',
        'singular_name'      => 'エリア',
        'search_items'       => 'エリアを検索',
        'all_items'          => 'エリア一覧',
        'parent_item'        => '親エリア',
        'parent_item_colon'  => '親エリア:',
        'update_item'        => '更新',
        'edit_item'          => 'エリアの編集',
        'add_new_item'       => 'エリアの追加',
        'new_item_name'      => '名前',
        'menu_name'          => 'エリア'
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
        'rewrite'           => array('slug' => 'area')
    );

    //call the register_taxonomy function
    register_taxonomy($taxonomy, $object_type, $args);
}
add_action('init','add_area_taxonomy');

	
	/*
		looking for custom meta boxes?
		check out this fantastic tool:
		https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
	*/


add_filter( 'post_type_link', 'bnl_post_type_link', 1, 2 );
function bnl_post_type_link( $link, $post ){
//    if ( 'service' === $post->post_type ) {
//        return home_url( '/service/' . $post->ID . "/" );
//    }
    if ( 'casestudy' === $post->post_type ) {
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

    $types = get_postid_post_types();
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
    $exclude_types = array('viewstg','casestudy');

    if(in_array($post_type, $exclude_types) && is_single()){
        wp_safe_redirect(home_url(), 301);
        exit;
    }
}

?>
