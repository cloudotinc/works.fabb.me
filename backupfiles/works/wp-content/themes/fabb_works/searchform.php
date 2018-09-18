<?php
$viewstgParam = array(
    'posts_per_page' => 1,
    'orderby' => 'date',
    'order' => 'DESC',
    'post_type' => array('viewstg'),
    'post_status' => 'publish',
    'no_found_rows' => true
);
$viewstg = get_posts($viewstgParam);
$viewstg_id = $viewstg[0]->ID;

$placeholder = "";

if( $viewstg_id > 0 ):

    $placeholder = get_field('viewstg_search_placeholder',$viewstg_id);

endif;

?>

<form role="search" method="get" class="searchform" action="<?php echo home_url( '/' ); ?>">
    <div>
        <?php if (false) { ?><label for="s" class="screen-reader-text"><?php _e('Search for:','bonestheme'); ?></label><?php } ?>
        <input type="search" class="s" name="s" value="" placeholder="<?php echo $placeholder ?>" />

        <button type="submit" class="searchsubmit" ><span class="icon icon-search" title="search"></span></button>
    </div>
</form>