<?php

/* **************************************************************************************************** */
// METABOX - SIDEBAR +++ START
/* **************************************************************************************************** */

$meta_box_options['juniper_sidebar_meta_box']['id'] = 'sidebar_meta_box';
$meta_box_options['juniper_sidebar_meta_box']['title'] = 'juniper Sidebar Options';
$meta_box_options['juniper_sidebar_meta_box']['callback'] = 'juniper_call_sidebar_meta_box'; #create
$meta_box_options['juniper_sidebar_meta_box']['post_type'] = 'post,page';
$meta_box_options['juniper_sidebar_meta_box']['context'] = 'side';
$meta_box_options['juniper_sidebar_meta_box']['priority'] = 'high';
$meta_box_options['juniper_sidebar_meta_box']['fields']['sidebar_select']
    = array('type'=>'radio',
            'options'=>array('left'=>__('Left','juniper'), 'right'=>__('Right','juniper'), 'none'=>__('None','juniper')),
            'default'=>'none',
            'script'=>'',
            'help'=>__('Sidebar Display Options:','juniper')
            );
$meta_box_options['juniper_sidebar_meta_box']['fields']['sidebar_number']
    = array('type'=>'textbox',
            'default'=>'',
            'script'=>'',
            'label'=>__('Sidebar #:','juniper'),
            'help'=>__('Enter the number of the alternate sidebar you would like to apply. Leave blank to use default.','juniper'),
            'size'=>2
            );
add_action("admin_init", "juniper_sidebar_meta_box");
add_action('save_post', 'juniper_save_sidebar_meta_box');


function juniper_sidebar_meta_box() {
    $key = 'juniper_sidebar_meta_box';
    global $meta_box_options;
    $id = $meta_box_options[$key]['id'];
    $title = $meta_box_options[$key]['title'];
    $callback = $meta_box_options[$key]['callback'];
    $post_type = $meta_box_options[$key]['post_type'];
    $context = $meta_box_options[$key]['context'];
    $priority = $meta_box_options[$key]['priority'];
    $arr = explode(',', $post_type);
    foreach($arr as $v){
        add_meta_box($id, $title, $callback, $v, $context, $priority);
    }
}

function juniper_call_sidebar_meta_box() {
    $key = 'juniper_sidebar_meta_box';
    global $meta_box_options;
    global $post;
    $fields = $meta_box_options[$key]['fields'];
    juniper_output_metabox_style($meta_box_options['juniper_sidebar_meta_box']['id'], $meta_box_options['juniper_sidebar_meta_box']['context']);
    juniper_metabox_nonce();
    juniper_draw_fields($fields, $post->ID);
}

function juniper_save_sidebar_meta_box($post_id) {

    $key = 'juniper_sidebar_meta_box';
    global $meta_box_options;
    global $post;

    // verify nonce
    if (isset($_POST['meta_box_nonce'])) {
        $pid = juniper_verify_nonce($_POST['meta_box_nonce'], $post_id);
        if($pid) return $pid;
    }

    // check autosave
    $pid = juniper_check_autosave($post_id);
    if($pid) return $pid;

    // check permissions
    if (isset($_POST['post_type'])) {
        $pid = juniper_verify_permissions($post_id, $_POST['post_type']);
        if($pid) return $pid;
    }

    $fields = $meta_box_options[$key]['fields'];
    foreach($fields as $k=>$f){
        $field_name = $k;
        if(isset($_POST[$field_name])) {
            $raw_value=$_POST[$field_name];
            $type=$f['type'];
            $value=sanitize_meta_field_value($type,$raw_value);
            update_post_meta($post_id, $field_name, $value);
        }
    }
}



/*** HELPER FUNCTIONS ***/

// Sanitize all input

function sanitize_meta_field_value($type,$raw_value) {
    switch($type){
                case 'radio':
                            $value = sanitize_key($raw_value);
                            return $value;
                            break;
                case 'textbox':
                            $value = sanitize_text_field($raw_value);
                            return $value;
                            break;
                case 'textarea':
                            $value = wp_kses_post($raw_value);
                            return $value;
                            break;
                case 'select':
                            $value = sanitize_key( $raw_value );
                            return $value;
                            break;
                case 'colorbox':
                            $value = sanitize_hex_color($raw_value);
                            return $value;
                            break;
    }
}





### FORM FIELDS ###

function juniper_draw_fields($fields, $post_id){
    foreach($fields as $k=>$f){
        $field_name = $k;
        $field_value = get_post_meta($post_id, $field_name, true);
        echo '<p>' . $f['help'] .'</p>';
        echo $f['script'];
        switch($f['type']){
            case 'radio':
                        juniper_draw_radio_buttons($f['options'], $f['default'], $field_name, $field_value);
                        break;
            case 'textbox':
                        juniper_draw_textbox($f['label'], $field_name, $field_value, $f['size']);
                        break;
            case 'textarea':
                        juniper_draw_textarea($f['label'], $field_name, $field_value, $f['cols'], $f['rows']);
                        break;
            case 'select':
                        juniper_draw_select($f['options'], $f['default'], $field_name, $field_value);
                        break;
            case 'colorbox':
                        juniper_draw_colorbox($f['label'], $field_name, $field_value, $f['size']);
                        break;
        }
    }
}


function juniper_metabox_nonce(){
    echo '<input type="hidden" name="meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
}


function juniper_draw_radio_buttons($options, $default, $field_name, $field_value){
    $checked_option = $default;
    foreach($options as $val=>$lab){
        if($field_value == $val && $field_value != $default)
            $checked_option = $val;
    }
    foreach($options as $val=>$lab){
        $checked = $val == $checked_option ? 'checked' : '';
        $id = $field_name . '-' . $val;
        echo '<input class="" type="radio" name="'.esc_attr($field_name).'" id="'.esc_attr($id) .'" value="'.esc_attr($val).'" ' . esc_attr($checked) . '><label style="float:none;" for="'.esc_attr($id).'">'.esc_html($lab).'</label><br />';
    }
}

function juniper_draw_select($options, $default, $field_name, $field_value){
    echo '<select name="'.esc_attr($field_name).'">';
    foreach($options as $val=>$lab){
        $selected = $field_value == $val ? 'selected' : '';
        if($checked == '') $checked = $val == $default ? 'selected' : '';
        echo '<option value="'.esc_attr($val).'" ' . esc_attr($selected) . '>'.esc_html($lab).'</option>';
    }
    echo '</select>';
}

function juniper_draw_textbox($label, $field_name, $field_value, $size){
    echo '<label>' . esc_html($label) . ' </label>';
    echo '<input type="text" id="'.esc_attr($field_name).'" name="'.esc_attr($field_name).'" value="'.esc_html($field_value).'" size="'.esc_attr($size).'" />';
}

function juniper_draw_colorbox($label, $field_name, $field_value, $size){
    echo '<label>' . esc_html($label) . ' </label>';
    echo '<input type="text" class="color {required:false}" id="colorbox_'.esc_attr($field_name).'" name="'.esc_attr($field_name).'" value="'.esc_attr($field_value).'" size="'.esc_attr($size).'" />';
}

function juniper_draw_textarea($label, $field_name, $field_value, $cols, $rows){
    echo '<label>' . esc_html($label) . '</label><br />';
    echo '<textarea name="'.esc_attr($field_name).'" id="'.esc_attr($field_name).'" cols="'.esc_attr($cols).'" rows="'.esc_attr($rows).'">' . esc_html($field_value) . '</textarea>';
}

### VERIFICATION FUNCTIONS ###

function juniper_verify_nonce($meta_box_nonce, $post_id){
    if (isset($meta_box_nonce)) {
        if (!wp_verify_nonce($meta_box_nonce, basename(__FILE__))) {
            return $post_id;
        }
    }
    return false;
}

function juniper_check_autosave($post_id){
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    return false;
}

function juniper_verify_permissions($post_id, $post_type){
     if (isset($post_type)) {
        if ('page' == $post_type) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }
        return false;
    }
    return false;
}

function juniper_output_metabox_style($meta_box_id, $context='normal'){

    if(!is_admin()) return;

$str_normal =
'<style>
form .counter{ font-size:13px; font-weight:normal; display:block; padding-left:26%; }
form .warning{ color:#600; }
form .exceeded{ color:#e00; }
#[META_BOX_ID] { background:#e9f7ff!important; }
#[META_BOX_ID] h3.hndle { background-color:#90c9e9;background-image:-ms-linear-gradient(top,#abdaf4,#90c9e9)!important; background-image:-moz-linear-gradient(top,#abdaf4,#90c9e9)!important; background-image:-o-linear-gradient(top,#abdaf4,#90c9e9)!important; background-image:-webkit-gradient(linear,left top,left bottom,from(#abdaf4),to(#90c9e9))!important; background-image:-webkit-linear-gradient(top,#abdaf4,#90c9e9)!important; background-image:linear-gradient(top,#abdaf4,#90c9e9)!important; color:#000; }
#[META_BOX_ID] label {float:left; width:25%; margin-right:0.5em; padding-top:0.2em; font-weight:bold;}}
</style>';

$str_side =
'<style>
form .counter{ font-size:13px; font-weight:normal; display:block; padding-left:26%; }
form .warning{ color:#600; }
form .exceeded{ color:#e00; }
#[META_BOX_ID] { background:#e9f7ff!important; }
#[META_BOX_ID] h3.hndle { background-color:#90c9e9;background-image:-ms-linear-gradient(top,#abdaf4,#90c9e9)!important; background-image:-moz-linear-gradient(top,#abdaf4,#90c9e9)!important; background-image:-o-linear-gradient(top,#abdaf4,#90c9e9)!important; background-image:-webkit-gradient(linear,left top,left bottom,from(#abdaf4),to(#90c9e9))!important; background-image:-webkit-linear-gradient(top,#abdaf4,#90c9e9)!important; background-image:linear-gradient(top,#abdaf4,#90c9e9)!important; color:#000; }
</style>';
$str = $context == 'normal' ? $str_normal : $str_side;
echo str_replace('[META_BOX_ID]', $meta_box_id, $str);
}
?>