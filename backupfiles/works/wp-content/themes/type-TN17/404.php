<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>



<!--メイン部分-->
<div id="nf">
  <div id="nf_box" class="clearfix">
    <div id="nf_icon"><img src="http://works.fabb.me/wp-content/themes/type-TN17/images/404/404_icon.png" alt="not found 404"></div>
    <div id="nf_messege">
    <strong>お客様のお探しのページは見つかりませんでした。</strong>
    <div id="nf_line"></div>
    <p>大変申し訳ありません。<br>
      お探しのページは、ＵＲＬが変更または削除された可能性がございます。<br>
      お手数ですが、上部のメニューより該当するページをお探しください。</p>
      </div>
    <a href="/" class="nf_right"><img src="http://works.fabb.me/wp-content/themes/type-TN17/images/cart_botton.gif" alt="TOPページに戻る"><span>TOPページに戻る</span></a>
  </div>
</div>	

<?php get_footer(); ?>