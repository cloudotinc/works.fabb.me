<?php


// #################################################
// Kirki
// #################################################


Kirki::add_config( 'juniper-config', array(
	'capability'    => 'edit_theme_options',
	'option_type'   => 'theme_mod',
) );

Kirki::add_section( 'setup', array(
    'title'          => __( 'Theme Userguide', 'juniper' ),
    'description'    => '',
    'panel'          => '', 
    'priority'       => 1,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
) );

Kirki::add_field( 'juniper-config', array(
	'settings' => 'userguide-info',
	'label'    => __( 'Userguide', 'juniper' ),
	'section'  => 'setup',
	'type'     => 'custom',
	'priority' => 1,
	'description'   => __( 'This theme was designed to be very easy to set up but just in case we\'ve created a userguide to assist: ', 'juniper' ) . '<a href="https://docs.google.com/document/d/1n4ETvz89uFhUfp9SSJ3hPHiFSlN4fIPzsSAz2jw4yzA/" target="_blank" class="button button-juniper-secondary">View User Guide</a>',
) );

Kirki::add_section( 'theme_gen_settings', array(
    'title'          => __( 'General Theme Settings', 'juniper' ),
    'description'    => '',
    'panel'          => '',
    'priority'       => 1,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
) );

Kirki::add_field( 'juniper-config', array(
	'settings' => 'logo',
	'label'    => __( 'Text Logo', 'juniper' ),
	'section'  => 'theme_gen_settings',
	'type'     => 'text',
	'priority' => 1,
	'default'  => get_bloginfo( 'name' ),
) );

Kirki::add_field( 'juniper-config', array(
	'settings' => 'copyright',
	'label'    => __( 'Copyright Text', 'juniper' ),
	'section'  => 'theme_gen_settings',
	'type'     => 'text',
	'priority' => 1,
	'default'  => get_bloginfo( 'name' ),
) );

Kirki::add_field( 'juniper-config', array(
	'settings' => 'home-slug',
	'label'    => __( 'Top of Homepage Navigation Menu ID', 'juniper' ),
	'section'  => 'theme_gen_settings',
	'type'     => 'text',
	'priority' => 1,
	'default'  => 'home',
	'description'   => __( 'The frontpage section IDs (what shows up in the hover state and the address bar when clicked) have already been set to a default shown in this field. If you would like to change the ID so that a different term comes up in the slug for that section (ie. http://example.com/#top instead of /#home), then change the term below for the corresponding section. You will also want to add the custom menu items in the Menus section of your dashboard (click "Links," then add the entire URL, such as http://example.com/#top). IMPORTANT: You must also add this term to the title field in the menu editor. If you do not see this field you may have to activate it by selecting the Screen Options tab in the top right of the page and then checking the Title Attribute box.', 'juniper' ),
) );


Kirki::add_panel( 'banner_settings', array(
    'priority'    => 2,
    'title'       => __( 'Banner Settings', 'juniper' ),
    'description' => '',
) );


Kirki::add_section( 'fp_banner_options', array(
    'title'          => __( 'Frontpage General Options', 'juniper' ),
    'description'    => '',
    'panel'          => 'banner_settings',
    'priority'       => 1,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
) );


Kirki::add_field( 'juniper-config', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'fp-banner-toggle',
	'label'       => __( 'Frontpage Banner Status', 'juniper' ),
	'section'     => 'fp_banner_options',
	'default'     => '2',
	'priority'    => 1,
	'choices'     => array(
		'1'   => esc_attr__( 'Customizer', 'juniper' ),
		'2' => esc_attr__( 'Post/Page', 'juniper' ),
	),
) );

Kirki::add_field( 'juniper-config', array(
	'type'        => 'color',
	'settings'    => 'fp-banner-background-color',
	'label'       => __( 'Row Background Color', 'juniper' ),
	'section'     => 'fp_banner_options',
	'default'     => '#ea940d',
	'priority'    => 1,
	'alpha'       => true,
	'description'   => __( 'Pick a background color for the row.', 'juniper' ),
	'output' => array(
		array(
			'element'  => '.frontpage-banner',
			'property' => 'background-color',
		),
	),
) );

Kirki::add_field( 'juniper-config', array(
	'type'        => 'image',
	'settings'    => 'fp-banner-background-image',
	'label'       => __( 'Parallax Row Background', 'juniper' ),
	'section'     => 'fp_banner_options',
	'default'     => '',
	'priority'    => 1,
) );


Kirki::add_section( 'fp_banner_customizer_options', array(
    'title'          => __( 'Frontpage Custom Banner Options', 'juniper' ),
    'description'    => '',
    'panel'          => 'banner_settings',
    'priority'       => 1,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
) );

Kirki::add_field( 'juniper-config', array(
	'settings' => 'fp-banner-title',
	'label'    => __( 'Banner - Main Title', 'juniper' ),
	'section'  => 'fp_banner_customizer_options',
	'type'     => 'text',
	'priority' => 1,
	'default'  => '',
	'description'   => __( 'This is the big text in the banner. Leave blank to hide.', 'juniper' ),
) );

Kirki::add_field( 'juniper-config', array(
	'settings' => 'fp-banner-sub-title',
	'label'    => __( 'Banner - Sub Title', 'juniper' ),
	'section'  => 'fp_banner_customizer_options',
	'type'     => 'text',
	'priority' => 1,
	'default'  => '',
	'description'   => __( 'This is the smaller text in the banner. Leave blank to hide.', 'juniper' ),
) );

Kirki::add_field( 'juniper-config', array(
	'settings' => 'fp-banner-button-text',
	'label'    => __( 'Banner - Button Text', 'juniper' ),
	'section'  => 'fp_banner_customizer_options',
	'type'     => 'text',
	'priority' => 1,
	'default'  => '',
	'description'   => __( 'This is the button in the banner. Leave blank to hide.', 'juniper' ),
) );

Kirki::add_field( 'juniper-config', array(
	'settings' => 'fp-banner-button-url',
	'label'    => __( 'Banner - Button Destination URL', 'juniper' ),
	'section'  => 'fp_banner_customizer_options',
	'type'     => 'text',
	'priority' => 1,
	'default'  => '',
	'description'   => __( 'This is the button link destination in the banner.', 'juniper' ),
	'sanitize_callback' => 'juniper_sanitize_url'
) );

Kirki::add_field( 'juniper-config', array(
	'settings' => 'fp-banner-video-button-text',
	'label'    => __( 'Banner - Video Button Text', 'juniper' ),
	'section'  => 'fp_banner_customizer_options',
	'type'     => 'text',
	'priority' => 1,
	'default'  => '',
	'description'   => __( 'This is the button in the banner. Leave blank to hide.', 'juniper' ),
) );

Kirki::add_field( 'juniper-config', array(
	'settings' => 'fp-banner-video-button-url',
	'label'    => __( 'Banner - Video Button Destination URL', 'juniper' ),
	'section'  => 'fp_banner_customizer_options',
	'type'     => 'text',
	'priority' => 1,
	'default'  => '',
	'description'   => __( 'This is the button link destination in the banner.', 'juniper' ),
	'sanitize_callback' => 'juniper_sanitize_url'
) );

Kirki::add_field( 'juniper-config', array(
	'settings' => 'fp-banner-map-button-text',
	'label'    => __( 'Banner - Map Button Text', 'juniper' ),
	'section'  => 'fp_banner_customizer_options',
	'type'     => 'text',
	'priority' => 1,
	'default'  => '',
	'description'   => __( 'This is the button in the banner. Leave blank to hide.', 'juniper' ),
) );

Kirki::add_field( 'juniper-config', array(
	'settings' => 'fp-banner-map-button-url',
	'label'    => __( 'Banner - Map Button Destination URL', 'juniper' ),
	'section'  => 'fp_banner_customizer_options',
	'type'     => 'text',
	'priority' => 1,
	'default'  => '',
	'description'   => __( 'This is the button link destination in the banner.', 'juniper' ),
	'sanitize_callback' => 'juniper_sanitize_url'
) );


Kirki::add_section( 'fp_banner_pp_options', array(
    'title'          => __( 'Frontpage Post/Page Banner Options', 'juniper' ),
    'description'    => '',
    'panel'          => 'banner_settings',
    'priority'       => 1,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
) );

Kirki::add_field( 'juniper-config', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'fp-pp-banner-toggle',
	'label'       => __( 'Use Post or Page?', 'juniper' ),
	'section'     => 'fp_banner_pp_options',
	'default'     => 'post',
	'priority'    => 1,
	'choices'     => array(
		'post'    => esc_attr__( 'Use Post', 'juniper' ),
		'page'    => esc_attr__( 'Use Page', 'juniper' ),
	),
) );


Kirki::add_field( 'juniper-config', array(
	'type'        => 'select',
	'settings'    => 'fp_pp_banner_posts',
	'label'       => __( 'Choose a Post (from latest 50)', 'juniper' ),
	'section'     => 'fp_banner_pp_options',
	'default'     => 'option-1',
	'priority'    => 1,
	'multiple'    => 1,
	'choices'     => Kirki_Helper::get_posts( array( 'posts_per_page' => 50, 'post_type' => 'post' ) ),
) );

Kirki::add_field( 'juniper-config', array(
	'type'        => 'select',
	'settings'    => 'fp_pp_banner_page',
	'label'       => __( 'Choose a Page (from latest 50)', 'juniper' ),
	'section'     => 'fp_banner_pp_options',
	'default'     => 'option-1',
	'priority'    => 1,
	'multiple'    => 1,
	'choices'     => Kirki_Helper::get_posts( array( 'posts_per_page' => 50, 'post_type' => 'page' ) ),
) );

Kirki::add_field( 'juniper-config', array(
	'settings' => 'fp-pp-banner-sub-title-override',
	'label'    => __( 'Banner - Sub Title - Override', 'juniper' ),
	'section'  => 'fp_banner_pp_options',
	'type'     => 'text',
	'priority' => 10,
	'default'  => '',
	'description'   => __( 'This is the smaller text in the banner. This will override the automatically generated exerpt.', 'juniper' ),
) );


Kirki::add_section( 'sub_banner_options', array(
    'title'          => __( 'Subpage Banner Options', 'juniper' ),
    'description'    => '',
    'panel'          => 'banner_settings',
    'priority'       => 1,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
) );


Kirki::add_field( 'juniper-config', array(
	'type'        => 'color',
	'settings'    => 'sub-banner-background-color',
	'label'       => __( 'Row Background Color', 'juniper' ),
	'section'     => 'sub_banner_options',
	'default'     => '#ea940d',
	'priority'    => 1,
	'alpha'       => true,
	'description'   => __( 'Pick a background color for the row.', 'juniper' ),
	'output' => array(
		array(
			'element'  => '.frontpage-banner',
			'property' => 'background-color',
		),
	),
) );

Kirki::add_field( 'juniper-config', array(
	'type'        => 'image',
	'settings'    => 'sub-banner-background-image',
	'label'       => __( 'Parallax Row Background', 'juniper' ),
	'section'     => 'sub_banner_options',
	'default'     => '',
	'priority'    => 1,
) );



Kirki::add_section( 'blog-settings', array(
    'title'          => __( 'Blog Settings', 'juniper' ),
    'description'    => '',
    'panel'          => '', 
    'priority'       => 10,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '',
) );

Kirki::add_field( 'juniper-config', array(
	'type'        => 'radio-buttonset',
	'settings'    => 'juniper_blog_sidebar_position',
	'label'       => __( 'Blog Sidebar Position', 'juniper' ),
	'section'     => 'blog-settings',
	'default'     => 'right',
	'priority'    => 1,
	'choices'     => array(
		'right'   => esc_attr__( 'Right', 'juniper' ),
		'left'  => esc_attr__( 'Left', 'juniper' ),
	),
) );



// #################################################
// Get Options
// #################################################
    
function juniper_get_option($optionID, $default_data = false) {
    if (get_theme_mod( $optionID )) {
        return get_theme_mod( $optionID );   
    } else {
        return NULL;
    }
}



// #################################################
// Some Custom Sanitize Functions
// #################################################

function juniper_sanitize_url( $value ) {

    $value=esc_url( $value );

    return $value;

}

function juniper_sanitize_email( $value ) {

    $value=sanitize_email( $value );

    return $value;

}