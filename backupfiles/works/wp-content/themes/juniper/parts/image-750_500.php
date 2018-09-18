<?php
if (has_post_thumbnail()) {
    the_post_thumbnail('juniper_750_500', array('class' => 'juniper_750_500 img-responsive'));
} else { ?>
    <?php if ( (juniper_get_option('fp-news-thumbs-toggle') == "1") || (juniper_get_option('fp-news-thumbs-toggle') == "") ) { ?>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/preview/750x500-<?php echo rand(1,8); ?>.jpg" class="juniper_750_500 img-responsive" alt="<?php the_title(); ?>" />
    <?php } ?>
<?php } ?>