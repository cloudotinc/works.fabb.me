<?php
/*
Template Name: ALL CATEGORY
*/
?>

<?php

get_header();



?>

<div class="content" id="allcategory">

    <div id="inner-content" class="wrap cf">

        <main id="main" class="m-all t-all d-all cf" role="main" itemscope itemprop="mainEntity" itemtype="http://schema.org/Blog">

            <article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

                <header class="article-header std-title-block">

                    <h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>

                </header> <?php // end article header ?>

                <section class=" cf" itemprop="articleBody">

                    <?php
                    output_productcat();
                    ?>

                </section> <?php // end article section ?>

                <footer class="article-footer cf">

                </footer>


            </article>

        </main>


    </div>

</div>

<?php get_footer(); ?>
