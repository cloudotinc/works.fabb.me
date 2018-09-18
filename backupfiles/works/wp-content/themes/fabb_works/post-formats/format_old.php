
              <?php
                /*
                 * This is the default post format.
                 *
                 * So basically this is a regular post. if you don't want to use post formats,
                 * you can just copy ths stuff in here and replace the post format thing in
                 * single.php.
                 *
                 * The other formats are SUPER basic so you can style them as you like.
                 *
                 * Again, If you want to remove post formats, just delete the post-formats
                 * folder and replace the function below with the contents of the "format.php" file.
                */
              ?>

              <?php

              function output_album($station_name) {

                  echo '<div class="std-content album-wrapper">';

                  echo '<div class="std-title-block">';
                  echo '<div class="std-title-inner">';
                  echo '<p class="std-title std-title-wsub">Room Album</p>';
                  echo '<h3 class="std-subtitle">' . $station_name . 'のルームアルバム</h3>';
                  echo '</div>';
                  echo '</div>';

              $maxcount = 4;
                  echo '<div class="albumlist cf">';
                  $count = 0;
                  for ($i=0;$i<$maxcount;$i++) {
                      $count++;
                      $pos_class = "";
                      if ($count % 2 == 0) $pos_class = " right2";
                      if ($count % 4 == 0) $pos_class .= " right4";

                      echo '<div class="albumlist-item' . $pos_class . '">';
                      echo '<a href="https://www.jibun-chukai.jp/lpb/" target="_blank">';
                      echo '<img src="' . get_template_directory_uri() . "/library/images/dummy_sq.jpg" . '" />';
                      echo '</a>';
                      echo '</div>';
                  }
                  echo '</div>';

                  echo '</div>';

              } // output_top_album

              $author_id = $post->post_author;

              $post_type = get_post_type();

              $isShowAuthor = false;
              if ($post_type === 'column') $isShowAuthor = true;


              // キャプション付き画像配色設定
              $captionstgClass = get_field("poststg_caption_color");
              if (empty($captionstgClass)) {
                  $captionstgClass = "cptstg_none";
              }
              else {
                  $captionstgClass = "cptstg_" . $captionstgClass;
              }
              // キャプション付き画像テキスト配置
              $captionAlignClass = get_field("poststg_caption_textalign");
              if (empty($captionAlignClass)) {
                  $captionAlignClass = "cptstg_left";
              }
              else {
                  $captionAlignClass = "cptstg_" . $captionAlignClass;
              }

           ?>


              <article id="post-<?php the_ID(); ?>" <?php post_class(array('cf',$captionstgClass,$captionAlignClass)); ?> role="article" itemscope itemprop="blogPost" itemtype="http://schema.org/BlogPosting">

                <header class="article-header entry-header">

                    <?php

                    $nextpost = get_next_post(true, '', $post_type . '_cat');
                    $thumbnail_url = get_thumb_url(false, 'bnl-thumb-large', false);

                    if (!empty($thumbnail_url) && get_field('poststg_hide_thumb') == false) {
                    ?>
                    <div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                        <img class="featuredimg" src="<?php echo $thumbnail_url ?>" />
                        <meta itemprop="url" content="<?php echo $thumbnail_url ?>">
                        <?php
                        $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(), "bnl-thumb-large");
                        ?>
                        <meta itemprop="width" content="<?php echo $thumbnail[1] ?>">
                        <meta itemprop="height" content="<?php echo $thumbnail[2] ?>">
                    </div>
                    <?php
                    }

                    output_infoheader($post);
                    ?>

                    <div class="title_wrapper cf">
                        <?php if (false) { ?>
                        <p class="column_title mobile"><?php echo $cat_data->cat_name ?></p>
                        <?php } ?>
                        <h1 class="entry-title single-title" itemprop="headline" rel="bookmark"><?php the_title(); ?></h1>

                        <?php if (false) { ?>
                        <div class="textsize_switcher">
                            <a class="tsw_small"><span>A</span></a>
                            <a class="tsw_large"><span>A</span></a>
                        </div>
                        <?php } ?>
                    </div>

                    <?php output_taglist($post->ID) ?>

                </header> <?php // end article header ?>

                <section class="entry-content cf" itemprop="articleBody">
                  <?php
                    // the content (pretty self explanatory huh)
                    the_content();

                    /*
                     * Link Pages is used in case you have posts that are set to break into
                     * multiple pages. You can remove this if you don't plan on doing that.
                     *
                     * Also, breaking content up into multiple pages is a horrible experience,
                     * so don't do it. While there are SOME edge cases where this is useful, it's
                     * mostly used for people to get more ad views. It's up to you but if you want
                     * to do it, you're wrong and I hate you. (Ok, I still love you but just not as much)
                     *
                     * http://gizmodo.com/5841121/google-wants-to-help-you-avoid-stupid-annoying-multiple-page-articles
                     *
                    */
                  global $page, $pages;
                  if (count($pages) > 1) {
                      $baseurl = trailingslashit(get_permalink());
                      $prevpage = $page - 1;
                      if ($prevpage < 1) $prevpage = 1;
                      $nextpage = $page + 1;
                      if ($nextpage > $pages) $nextpage = $pages;

                      $prevlink = trailingslashit($baseurl . $prevpage);
                      $nextlink = trailingslashit($baseurl . $nextpage);
                      ?>
                    <div class="page-links-custom std-postnav">
                        <?php
                        echo( '<p class="pagecount">(' . $page.' / '.count($pages) . ')</p>' );
                        ?>
                        <div class="page-links-inner">
                            <?php
                            if ($page == 1) {
                                ?>
                                <span class="pl-prev pl-btn">
                                    <span class="icon icon-arrowleftthin"></span>
                                    <span class="pl-text">前のページへ</span>
                                </span>
                            <?php
                            } else {
                                ?>
                                <a class="pl-prev pl-btn" href="<?php echo $prevlink ?>">
                                    <span class="icon icon-arrowleftthin"></span>
                                    <span class="pl-text">前のページへ</span>
                                </a>
                            <?php
                            }
                            ?>

                            <a class="pl-archive" href="<?php echo get_post_type_archive_link($post_type) ?>">
                                <?php echo get_posttype_name_jp($post_type) ?> 一覧へ
                            </a>

                            <?php
                            if ($page == count($pages)) {
                                ?>
                                <span class="pl-next pl-btn">
                                    <span class="pl-text">次のページへ</span>
                                    <span class="icon icon-arrowrightthin"></span>
                                </span>
                                <?php
                            } else {
                                ?>
                                <a class="pl-next pl-btn" href="<?php echo $nextlink ?>">
                                    <span class="pl-text">次のページへ</span>
                                    <span class="icon icon-arrowrightthin"></span>
                                </a>
                                <?php
                            }
                            ?>

                        </div>
                    </div>
                    <?php

                  }


//                    wp_link_pages( array(
//                        'before'      => '<div class="page-links"><div class="page-links-inner">',
//                        'after'       => '</div></div>',
//                        'next_or_number' => 'next',
//                        'link_before' => '<span>',
//                        'link_after'  => '</span>',
//                        'previouspagelink' => '<span class="icon icon-arrowleftthin"></span>',
//                        'nextpagelink' => '<span class="icon icon-arrowrightthin"></span>'
//                    ) );
                  ?>
                </section> <?php // end article section ?>

                  <?php
                  $profile_content = get_field("poststg_profile_content");
                  $prof_title = "話してくれた人";
                  if (!empty($profile_content)) {
                      ?>
                      <div class="profile-wrapper cf">
                          <p class="box-title"><?php echo $prof_title ?></p>
                          <?php
                          $profile_img = get_field("poststg_profile_img");
                          $prof_class = "";
                          if (!empty($profile_img)) {
                              ?>
                              <img class="box-img" src="<?php echo $profile_img['sizes']['large']; ?>" />
                          <?php
                          }
                          else {
                              $prof_class = "noimg";
                          }
                          ?>
                          <div class="box-info <?php echo $prof_class ?>">
                              <div class="description_short">
                                  <?php echo $profile_content ?>
                              </div>
                          </div>
                      </div>
                  <?php } ?>

                  <?php
                  $writer_content = get_field("poststg_writer_content");
                  $prof_title = "話を聞いてくれた人";
                  if ($post_type == "column" || $post_type == "special") $prof_title = "書いてくれた人";
                  if (!empty($writer_content)) {
                      ?>
                      <div class="writer-wrapper cf">
                          <p class="box-title"><?php echo $prof_title ?></p>
                          <?php
                          $writer_img = get_field("poststg_writer_img");
                          $writer_class = "";
                          if (!empty($writer_img)) {
                              ?>
                              <img class="box-img" src="<?php echo $writer_img['sizes']['large']; ?>" />
                              <?php
                          }
                          else {
                              $writer_class = "noimg";
                          }
                          ?>
                          <div class="box-info <?php echo $writer_class ?>">
                              <div class="description_short">
                                  <?php echo $writer_content ?>
                              </div>
                          </div>
                      </div>
                  <?php } ?>

                  <?php
                  $store_content = get_field("poststg_store_content");
                  if (!empty($store_content)) {
                      ?>
                      <div class="store-wrapper cf">
                          <?php
                          $store_img = get_field("poststg_store_img");
                          $store_class = "";
                          if (!empty($store_img)) {
                              ?>
                              <img class="storeimg" src="<?php echo $store_img['sizes']['large']; ?>" />
                          <?php }
                          $store_class = "noimg";
                          ?>
                          <div class="storeinfo <?php echo $store_class ?>">
                              <div class="description_short">
                                  <?php echo $store_content ?>
                              </div>
                          </div>
                      </div>
                  <?php } ?>

                  <?php
                  if ($post_type == "interview") {
                      $stations = get_the_terms($post->ID, 'station');
                      $station = "";
                      if ($stations && is_array($stations)) $station = $stations[0];
                      if (!empty($station)) {
                          output_album($station->name);
                      }
                  }

                  ?>


                <footer class="article-footer">

            <?php //printf( __( 'Filed under: %1$s', 'bonestheme' ), get_the_category_list(', ') ); ?>

              <?php outputSNSbuttons(); ?>

                    <?php
                    if ( is_user_logged_in() ) {
                        ?>
                        <div class="admin_menu" style="padding: 0;font-size: 14px;font-weight: bold;">
                            <a href="<?php echo get_admin_url(); ?>" style="padding-right: 15px">管理画面トップ</a>
                            <?php edit_post_link('編集する'); ?>
                        </div>
                        <?php
                    }
                    ?>

          </footer> <?php // end article footer ?>

          <?php //comments_template(); ?>

                  <div class="hidden-data" style="display:none;">
                      <a itemprop="mainEntityOfPage" href="<?php the_permalink(); ?>"><?php the_permalink(); ?></a>
                      <span itemprop="datePublished"><?php echo get_post_time("Y-n-j",false,$post->ID) ?></span>
                      <span itemprop="dateModified"><?php the_modified_date('Y-m-d') ?></span>
                      <span class="author post-author" itemprop="author" itemscope itemtype="http://schema.org/Person">
                          <span itemprop="name">じぶん仲介journal</span>
                      </span>
                      <div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
                          <span itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
                              <span itemprop="url" content="<?php echo get_template_directory_uri(); ?>/library/images/logo.png">
                                <img src="<?php echo get_template_directory_uri(); ?>/library/images/logo.png">
                              </span>
                          </span>
                          <span itemprop="name">STiLy Co.,Ltd.</span>
                      </div>
                  </div>

        </article> <?php // end article ?>
