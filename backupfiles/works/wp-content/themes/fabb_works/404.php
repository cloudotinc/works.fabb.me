<?php
global $wp;
$current_url = home_url(add_query_arg(array(),$wp->request));

$isJournal = false;
if(strpos($current_url,'journal') !== false){
    $isJournal = true;
}

if ($isJournal) {
    get_header();
}
else {
    get_header('app');
}

?>

			<div class="content" id="notfound">

				<div id="inner-content" class="wrap cf">

					<main id="main" class="m-all t-all d-all cf" role="main" itemscope itemprop="mainEntity" itemtype="http://schema.org/Blog">

						<article id="post-not-found" class="hentry cf">

							<header class="article-header">

								<h1><?php _e( 'Epic 404 - Article Not Found', 'bonestheme' ); ?></h1>

							</header>

							<section class="entry-content">

								<p><?php _e( 'The article you were looking for was not found, but maybe try looking again!', 'bonestheme' ); ?></p>

							</section>

							<section class="search">

									<p>
                                        <?php if ($isJournal) get_search_form(); ?>
                                    </p>

							</section>

							<footer class="article-footer">


							</footer>

						</article>

					</main>

				</div>

			</div>

<?php

if ($isJournal) {
    get_footer();
}
else {
    get_footer('app');
}
?>
