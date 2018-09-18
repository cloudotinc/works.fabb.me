<?php
/*
Template Name: CONTACT
*/
?>

<?php get_header(); ?>

<script>

	function successProcess() {
		//jQuery("#entry_info").hide();
		jQuery("#contact_form").hide();
		jQuery("#contact_thanks").show();
		jQuery(window).scrollTop(0);
	}


	function confirmProcess() {
		jQuery('.wpcf7-form').addClass("step_confirm");

		jQuery(".wpcf7-list-item").hide();
		jQuery('.contact-type .wpcf7c-conf-hidden').parents(".wpcf7-list-item").show();
	}

	jQuery(function(){

		jQuery(".wpcf7-back").click(function() {
			jQuery('.wpcf7-form').removeClass("step_confirm");
			jQuery(".wpcf7-list-item").show();
		});

        $('#termsblock').html($('#pp').html());

	});
</script>

			<div class="content" id="contact">

				<div id="inner-content" class="wrap cf">

						<main id="main" class="m-all t-all d-all cf" role="main" itemscope itemprop="mainEntity" itemtype="http://schema.org/Blog">

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<header class="article-header std-title-block">

									<h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>

								</header> <?php // end article header ?>

								<section class="entry-content cf" itemprop="articleBody">

									<div class="contact_content" id="contact_form">
										<div class="wrap_thin">
											<?php the_content(); ?>
										</div>
									</div>

									<div class="contact_content" id="contact_thanks">
										<div class="wrap_thin">
											<p class="title">お問い合わせありがとうございました。</p>
											<p>
												※迷惑メール設定をされている方は、stily.co.jpドメインからのメールを受信可能なようにしてください。
											</p>
										</div>
									</div>


								</section> <?php // end article section ?>

								<footer class="article-footer cf">

								</footer>

							</article>

							<?php endwhile; else : ?>


							<?php endif; ?>

						</main>

				</div>

                <div id="pp">
                    <?php
                    $json = getCompanyPage("privacy");
                    $json = json_decode($json, true);
                    $data = $json[0];
                    echo $data["content"]["rendered"];
                    ?>
                </div>

			</div>

<?php get_footer(); ?>
