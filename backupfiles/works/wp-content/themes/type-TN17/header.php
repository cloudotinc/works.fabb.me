<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="description" content="ディスクリプション" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
<![endif]-->
<?php

wp_enqueue_script("imgliquidjs",get_bloginfo("template_directory")."/js/imgLiquid-min.js", array('jquery'));

wp_head(); ?>
<!--
<?php
global $template;
$template_name = basename($template, '.php');
echo $template_name;
?>
-->
</head>

<body>

<!-- ===============================================
	HEADER
================================================== -->
<header>
<div class="inner clearfix">
  <div id="f_m_icon">
	<adress id="mail_icon"><a href="/contact"><img src="<?php echo get_template_directory_uri(); ?>/images/mail_icon.png" alt="メールアイコン"></a></adress>
	<a id="facebook_icon" href="https://ja-jp.facebook.com/socialhubspacefabb/" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/facebook_icon.png" alt="facebookアイコン"></a>
  </div>
<h1 id="logo"><a href="/"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="FABBWORKS"></a></h1>     
<!--グローバルナビゲーション-->
	<ul id="gnav">
      <li><a href="/concept/">コンセプト</a></li>
	  <li><a href="/service/">サービス</a></li>
      <li><a href="/worker/">ワーカー一覧</a></li>
	  <li><a href="/casestudy/">制作事例</a></li>
	  <li><a href="/faq/">よくある質問</a></li>
	  <li><a href="/guide/">ご利用ガイド</a></li>
	  <li><a href="http://fabb.me"><img src="<?php echo get_template_directory_uri(); ?>/images/fabb_me_botton.png" alt="fabb.meボタン"></a></li>
	</ul>
</div>
</header> 







