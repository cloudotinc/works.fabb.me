<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<?php // force Internet Explorer to use the latest rendering engine available ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<title><?php wp_title(''); ?></title>

		<?php // mobile meta (hooray!) ?>
		<meta name="HandheldFriendly" content="True">
        <?php if (false) { ?>
		<meta name="MobileOptimized" content="320">
        <?php } ?>
        <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1, maximum-scale=1"/>

		<?php // icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) ?>
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-touch-icon.png">
        <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/library/images/android-chrome-192x192.png" sizes="192x192">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->
		<?php // or, set /favicon.ico for IE10 win ?>
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">
        <meta name="theme-color" content="#ffffff">

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

        <!-- HTML5 Shiv -->
        <!--[if lt IE 9]>
        <script src="<?php echo get_template_directory_uri(); ?>/library/js/libs/html5shiv.min.js"></script>
        <![endif]-->

        <?php

        wp_enqueue_script( 'mmenu-js', get_template_directory_uri().'/library/js/libs/jquery.mmenu.all.min.js', array( 'jquery' ));
        wp_enqueue_style("mmenu-style", get_template_directory_uri() .'/library/css/jquery.mmenu.all.css', array() );

        wp_enqueue_script( 'biggerlinkjs', get_template_directory_uri().'/library/js/libs/jquery.biggerlink.min.js', array( 'jquery' ));
        wp_enqueue_script( 'easingjs', get_template_directory_uri().'/library/js/libs/jquery.easing.js', array( 'jquery' ));
        wp_enqueue_script("imgliquidjs",get_bloginfo("template_directory")."/library/js/libs/imgLiquid-min.js", array('jquery'));
        wp_enqueue_script( 'mobiledetect-js', get_template_directory_uri() .'/library/js/libs/mobile-detect.min.js', array(), '20150807');
        wp_enqueue_script("imagesloadedjs",get_bloginfo("template_directory")."/library/js/libs/imagesloaded.pkgd.min.js", array('jquery'));
//        wp_enqueue_script("velocktyjs",get_bloginfo("template_directory")."/library/js/libs/velocity.min.js", array('jquery'));
        wp_enqueue_script("detectfontjs",get_bloginfo("template_directory")."/library/js/libs/jquery.detectfontmod.js", array('jquery'));
//        wp_enqueue_script("cookiejs",get_bloginfo("template_directory")."/library/js/libs/js.cookie.js", array('jquery'));
        wp_enqueue_script("slickjs","//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js", array('jquery'));
        wp_enqueue_style("slick-style", '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css', array() );

        wp_enqueue_style("layoutpc-style", get_template_directory_uri() .'/library/css/layout_pc.css', array() );
        wp_enqueue_style("layoutsp-style", get_template_directory_uri() .'/library/css/layout_sp.css', array() );

        ?>

		<?php // wordpress head functions ?>
		<?php wp_head(); ?>
		<?php // end of wordpress head ?>




	</head>

<?php
    $bodyClass = "";


    $curmenu = "";
    if (is_page('instructor')) {
        $curmenu = "instructor";
    }
    else if (is_post_type_archive('service') || is_tax('service_cat') || is_singular('service')) {
        $curmenu = 'service';
    }
    else if (is_post_type_archive('casestudy') || is_tax('casestudy') || is_singular('casestudy')) {
        $curmenu = 'casestudy';
    }
    else if (is_post_type_archive('worker') || is_tax('worker') || is_singular('worker')) {
        $curmenu = 'worker';
    }
    else if (is_page()) {
        $curmenu = $post->post_name;
    }


function is_active_class($curmenu, $menu) {

    if ($curmenu == $menu) echo 'active';

}

    // メニュー内容
function output_hdr_menulist($curmenu) {

    ?>
	
    <ul class="menulist cf">
		<li class="<?php is_active_class($curmenu, "service") ?>">
			<a href="<?php echo get_option('home'); ?>/service/">サービス一覧</a>
		</li>
		<li class="<?php is_active_class($curmenu,"casestudy") ?>">
			<a href="<?php echo get_option('home'); ?>/casestudy/">制作事例</a>
		</li>
		<li class="<?php is_active_class($curmenu, "worker") ?>">
			<a href="<?php echo get_option('home'); ?>/worker/">ワーカー一覧</a>
		</li>
		<li class="<?php is_active_class($curmenu,"faq") ?>">
			<a href="<?php echo get_option('home'); ?>/faq/">よくある質問</a>
		</li>
		<li class="<?php is_active_class($curmenu, "about") ?>">
			<a href="<?php echo get_option('home'); ?>/about/">FABBWORKSについて</a>
		</li>
		<li class="<?php is_active_class($curmenu,"contact") ?>">
			<a href="<?php echo get_option('home'); ?>/contact/">お問い合わせ</a>
		</li>
    </ul>
    <?php
}


function output_hdr_usermenu() {
    if ( is_user_logged_in() ) {
        $user = wp_get_current_user();
        $name = $user->user_lastname . "" . $user->user_firstname;
        if (empty($name)) $name = $user->display_name;
        ?>
        <span class="welcome">こんにちは、<?php echo $name ?>さん</span>
        <a class="std-btn std-btn-small btn-mypage" href="<?php echo get_option('home'); ?>/wp-admin/">マイページ</a>
        <?php
    }
    else {
        ?>
        <a class="std-btn std-btn-small btn-register" href="<?php echo get_option('home'); ?>/register/">会員登録</a>
        <a class="std-btn std-btn-small-inv btn-login" href="<?php echo get_option('home'); ?>/login/">ログイン</a>
        <?php
    }
}

function output_hdr_snslinks() {
    ?>
    <ul class="snslinks cf mm-nolistview">
        <li class="snslink_item snsbtn_fb">
            <a href="https://www.facebook.com/fabbmag/" target="_blank">
                <span class="icon icon-facebook2"></span>
            </a>
        </li>
        <li class="snslink_item snsbtn_ln">
            <a href="https://www.facebook.com/fabbmag/" target="_blank">
                <span class="icon icon-line"></span>
            </a>
        </li>
    </ul>
    <?php
}


function output_sitelist() {
    ?>
        <ul class="site-list mm-nolistview">
            <li class="me"><a href="https://fabb.me/">FABB.ME</a></li>
            <li><a href="http://fabb.me/nagano/">» FABB.nagano</a></li>
            <li><a href="https://works.fabb.me/">» FABB.works</a></li>
            <li><a href="https://school.fabb.me/">» FABB.school</a></li>
            <li><a href="https://market.fabb.me/">» FABB.market</a></li>
            <li><a href="https://space.fabb.me/">» FABB.space</a></li>
        </ul>
    <?php
}
function output_hdr_sitesw() {
    ?>
    <div class="site-switcher pc">
        <div class="tile">
            <span class="icon icon-tile"></span>
        </div>
        <?php output_sitelist() ?>
    </div>
    <?php
}

?>
	<body <?php body_class($bodyClass); ?> itemscope itemtype="http://schema.org/WebPage" id="pagetop">

		<div id="container">

            <?php if (false) { ?>
                <div id="fb-root"></div>
                <script>(function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) return;
                        js = d.createElement(s); js.id = id;
                        js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.5&appId=755221161191822";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>
            <?php } ?>

			<header id="header" class="header" role="banner" itemscope itemtype="http://schema.org/WPHeader">

				<div id="inner-header" class="cf">

                    <a class="togglebutton mobile"><span class="icon icon-tile"></span></a>

                    <?php output_hdr_sitesw() ?>


					<a id="logo" class="" href="<?php echo get_option('home'); ?>" rel="nofollow">
                        <img class="" src="<?php echo get_template_directory_uri(); ?>/library/images/logo.svg?v=20170507" alt="<?php bloginfo('name'); ?>" />
                    </a>
                    <p class="site-description"><?php bloginfo('description'); ?></p>


                    <nav id="headermenu" class=" mainmenu pc" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
                        <?php output_hdr_menulist($curmenu) ?>
                    </nav>


                    <div class="header-toolbar cf pc">

                        <?php
                        output_hdr_usermenu();
                        output_hdr_snslinks();
                        ?>

                    </div>


					<nav id="sidemenu" class="sidemenu mainmenu mobile" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
                        <div id="sidemenu-inner">

                            <?php
                            output_hdr_menulist($curmenu);
                            echo '<div class="usermenu-wrapper">';
                            output_hdr_usermenu();
                            echo '</div>';
                            output_hdr_snslinks();

                            output_sitelist();
                            ?>


<!--                            <div class="sb-snslinks">-->
<!--                                <ul class="snslinks cf mm-nolistview">-->
<!--                                    <li class="snslink_item snsbtn_fb">-->
<!--                                        <a href="https://www.facebook.com/fabbmag/" target="_blank">-->
<!--                                            <span class="icon icon-facebook2"></span>-->
<!--                                        </a>-->
<!--                                    </li>-->
<!--                                    <li class="snslink_item snsbtn_ln">-->
<!--                                        <a href="https://www.facebook.com/fabbmag/" target="_blank">-->
<!--                                            <span class="icon icon-line"></span>-->
<!--                                        </a>-->
<!--                                    </li>-->
<!--                                </ul>-->
<!--                            </div>-->

                        </div>
					</nav>

				</div>

			</header>


            <div id="header-fixed">
                <?php
                output_hdr_sitesw();
                ?>
                <div class="wrap cf">
                    <a class="logo" href="<?php echo get_option('home'); ?>" rel="nofollow">
                        <img class="" src="<?php echo get_template_directory_uri(); ?>/library/images/logo.svg?v=20170507" alt="<?php bloginfo('name'); ?>" />
                    </a>

                    <div class="menu-wrapper">
                        <ul class="menulist cf">
                            <li class="<?php is_active_class($curmenu, "service") ?>">
                                <a href="<?php echo get_option('home'); ?>/service/">サービス一覧</a>
                            </li>
                            <li class="<?php is_active_class($curmenu,"casestudy") ?>">
                                <a href="<?php echo get_option('home'); ?>/casestudy/">制作事例</a>
                            </li>
                            <li class="<?php is_active_class($curmenu, "worker") ?>">
                                <a href="<?php echo get_option('home'); ?>/worker/">ワーカー一覧</a>
                            </li>
                            <li class="<?php is_active_class($curmenu,"contact") ?>">
                                <a href="<?php echo get_option('home'); ?>/contact/">お問い合わせ</a>
                            </li>
                        </ul>
                    <?php
                    output_hdr_usermenu();
                    ?>
                    </div>
                </div>
                <?php
                output_hdr_snslinks();
                ?>
            </div>


            <?php if (false) { ?>
            <div id="loading"><div class="loader"></div></div>
            <?php } ?>

            <div id="base"><?php //for plax ?>





