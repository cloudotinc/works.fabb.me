<?php
/**
 * RSS2 Feed Template for displaying RSS2 Posts feed.
 *
 * @package otocoto.jp
 */

header('Content-Type: ' . feed_content_type('rss-http') . '; charset=' . get_option('blog_charset'), true);
$more = 1;

$copyright = '© ' . date('Y') . ' STiLy';
//$logo = get_template_directory_uri() . '/library/images/logo_feed.png'; // 290 x 50 px推奨
$logo = get_template_directory_uri() . '/library/images/logo.png'; // 290 x 50 px推奨
$ttl = 15; // 更新頻度（分）


echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';

/**
 * Fires between the xml and rss tags in a feed.
 *
 * @since 4.0.0
 *
 * @param string $context Type of feed. Possible values include 'rss2', 'rss2-comments',
 *                        'rdf', 'atom', and 'atom-comments'.
 */
do_action( 'rss_tag_pre', 'rss2' );
?>
<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	xmlns:media="http://search.yahoo.com/mrss/"
	xmlns:snf="http://www.smartnews.be/snf"
	<?php
	/**
	 * Fires at the end of the RSS root to add namespaces.
	 *
	 * @since 2.0.0
	 */
	do_action( 'rss2_ns' );
	?>
>

<channel>
	<title>じぶん仲介ジャーナル</title>
	<link><?php bloginfo_rss('url') ?></link>
	<description><?php bloginfo_rss("description") ?></description>
	<pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></pubDate>
	<language><?php bloginfo_rss( 'language' ); ?></language>
	<copyright><?php echo $copyright; ?></copyright>
	<ttl><?php echo $ttl; ?></ttl>
	<snf:logo><url><?php echo $logo; ?></url></snf:logo>
	<?php
	/**
	 * Fires at the end of the RSS2 Feed Header.
	 *
	 * @since 2.0.0
	 */
	do_action( 'rss2_head');

	while( have_posts()) : the_post();
	?>
	<item>
		<title><?php the_title_rss() ?></title>
		<link><?php the_permalink_rss() ?></link>
		<pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?></pubDate>
		<?php
//		$image_id = get_post_thumbnail_id();
//		$image_url = wp_get_attachment_image_src($image_id, true);
//        $image_url = $image_url[0];
        $image_url = get_thumb_url(true);
		?>
		<media:thumbnail><?php echo $image_url; ?></media:thumbnail>
		<?php if (false) { ?><dc:creator><![CDATA[<?php the_author() ?>]]></dc:creator><?php } ?>
		<?php //the_category_rss('rss2') ?>
		<category><?php print_category_rss_smartnews(); ?></category>
		<guid isPermaLink="false"><?php the_guid(); ?></guid>

		<description><![CDATA[<?php the_excerpt_rss(); ?>]]></description>
	<?php $content = get_the_content_feed('rss2'); ?>
	<?php if ( strlen( $content ) > 0 ) : ?>
		<content:encoded><![CDATA[<?php echo $content; ?>]]></content:encoded>
	<?php else : ?>
		<content:encoded><![CDATA[<?php the_excerpt_rss(); ?>]]></content:encoded>
	<?php endif; ?>
	     <snf:advertisement>
	        <snf:adcontent>
	        <![CDATA[ 
			<div align="center" style="vertical-align: middle;">
			        <p style="padding : 20px ;">
			        <img src="https://www.jibun-chukai.jp/journal/wp-content/themes/jibun-chukai/library/images/logo_home.png" alt="じぶん仲介" width="260">
			        </p>
			 <p style="font-size: 115%; padding : 20px;">お部屋以上のものをつなぎたい<br>
			        お部屋さがしアプリです。</p>
			    <p style="padding : 20px ;">
			    <a href="https://itunes.apple.com/jp/app/sutairyinojibun-zhong-jie/id1030295794?mt=8" target="_blank"><img src="https://www.jibun-chukai.jp/journal/wp-content/themes/jibun-chukai/library/images/appstore.svg"></a>
			    </p>
			</div>
	        ]]>
	        </snf:adcontent>
	    </snf:advertisement>
		<snf:analytics><![CDATA[
			<?php outputGA() ?>
				]]></snf:analytics>
<?php rss_enclosure(); ?>
	<?php
	/**
	 * Fires at the end of each RSS2 feed item.
	 *
	 * @since 2.0.0
	 */
	do_action( 'rss2_item' );
	?>
	</item>
	<?php endwhile; ?>
</channel>
</rss>

<?php
function print_category_rss_smartnews() {
	global $post;
//	$terms = get_the_terms( $post->ID, "genre" );
//	$cat_names = [];
//    if ( ! empty( $terms ) ) {
//		foreach ( $terms as $term ) {
//			$cat_names[] = sanitize_term_field( 'slug', $term->slug, $term->term_id, 'genre', 'rss' );
//        }
//	}
//    $cat_names = array_unique( $cat_names );
//    echo implode( ',', $cat_names );
	echo $post->post_type;
}

function feed_related_posts() {

	global $post;
	$tags = wp_get_post_tags( $post->ID );
	$pcount_tag = 0;
    $postids_selected = array($post->ID);
	$related_posts = array();
	$maxposts = 5;

	if($tags) {
		$tag_arr = "";
		foreach ($tags as $tag) {
			$tag_arr .= $tag->slug . ',';
		}
		$args = array(
			'tag' => $tag_arr,
			'numberposts' => $maxposts, /* you can change this to show more */
			'post_type'        => get_basic_post_types(),
			'post__not_in' => array($post->ID)
		);
		$related_posts = get_posts($args);

		$pcount_tag = count($related_posts);

		foreach ($related_posts as $tpost) {
            $postids_selected[] = $tpost->ID;
		}
	}


    $pcount = 0;
    if ($pcount_tag < $maxposts) {
        $terms = get_the_terms( $post->ID, "station" );
        $term_arr = array();

        if (!empty($terms)) {
            foreach ($terms as $term) {
                $term_arr[] = $term->slug;
            }

            $args = array(
                'numberposts' => (8 - $pcount_tag),
                'post_type' => get_basic_post_types(),
                'tax_query' => array(
                    'relation' => 'OR',
                    array(
                        'taxonomy' => 'station',
                        'field' => 'slug',
                        'terms' => $term_arr
                    )
                ),
                'post__not_in' => $postids_selected
            );
            $relatedterm_posts = get_posts($args);
            $related_posts = array_merge($related_posts, $relatedterm_posts);

            foreach ($relatedterm_posts as $tpost) {
                $postids_selected[] = $tpost->ID;
            }

            $pcount = count($related_posts);
        }
    }

    if ($pcount < $maxposts) {
        $terms = get_the_terms( $post->ID, "line" );
        $term_arr = array();

        if (!empty($terms)) {
            foreach ($terms as $term) {
                $term_arr[] = $term->slug;
            }

            $args = array(
                'numberposts' => (8 - $pcount_tag),
                'post_type' => get_basic_post_types(),
                'tax_query' => array(
                    'relation' => 'OR',
                    array(
                        'taxonomy' => 'line',
                        'field' => 'slug',
                        'terms' => $term_arr
                    )
                ),
                'post__not_in' => $postids_selected
            );
            $relatedterm_posts = get_posts($args);
            $related_posts = array_merge($related_posts, $relatedterm_posts);

            $pcount = count($related_posts);
        }
    }

	$return_posts = [];
	if($related_posts) {
		foreach ( $related_posts as $post ) : setup_postdata( $post );

			$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(),'bnl-thumb-medium');
			$thumbnail_url = $thumbnail[0];
			if (empty($thumbnail_url)) {
				$thumbnail_url = get_template_directory_uri() . "/library/images/default_thumb.jpg";
			}

			$return_posts[] = [
				'title' => str_replace('<br>',' ',get_the_title()),
				'link' => get_the_permalink(),
				'thumbnail' => $thumbnail_url,
			];

		endforeach;
	}

	wp_reset_postdata();
	return $return_posts;
}
?>