<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?>


<!-- ===============================================
	FOOTER
================================================== -->
<!-- お問い合わせ -->
  <section id="to_contact" class="inner">
    <img src="<?php echo get_template_directory_uri(); ?>/images/brn.jpg" alt="お問い合わせ">
    <p>サービス一覧にない個別案件もお気軽にお問い合わせください。</p>
    <a href="/contact"><span>お問い合わせはこちら</span></a>
  </section>
<!--フッター部分-->
  <footer>
    <div id="footer_topbox">
      <div class="inner">
        <ul id="etc">
          <li id="cash"><a href=""><img src="<?php echo get_template_directory_uri(); ?>/images/cart_botton.gif" alt="支払いページへ"><span>支払いページへ</span></a></li>
          <li id="f_fbk_icon"><a href="https://ja-jp.facebook.com/socialhubspacefabb/" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/images/footer_fbook_icon.png" alt="facebookアイコン"></a></li>
          <li id="f_mail_icon"><adress><a href="/contact/"><img src="<?php echo get_template_directory_uri(); ?>/images/footer_mail_icon.png" alt="メールアイコン"></a></adress></li>
          <li id="fabbme_botton"><a href="/about/"><img src="<?php echo get_template_directory_uri(); ?>/images/fabb.me_botton.png" alt="fabb.meボタン"></a></li>
        </ul> 
      </div>
    </div>
    <div id=logo_footer><img src="<?php echo get_template_directory_uri(); ?>/images/logo_footer.png" alt="FABB.WORKロゴ"></div>
<!--    <div id="footer_downbox">-->
      <div class="inner" id="footer_downbox">
        <ul id="f_nav">
          <li><a href="/">HOME</a></li>
          <li><a href="/concept/">コンセプト</a></li>
          <li><a href="/service/">サービス</a></li>
          <li><a href="/worker/">ワーカー一覧</a></li>
          <li><a href="/casestudy/">制作事例</a></li>
          <li><a href="/faq/">よくある質問</a></li>
          <li><a href="/guide/">ご利用ガイド</a></li>
          <li><a href="/sitemap/">サイトマップ</a></li>
        </ul>
          <small>Copyright &copy; Cloudot Inc. All Rights Reserved.</small>       
      </div>
  </footer>


</body>
</html>