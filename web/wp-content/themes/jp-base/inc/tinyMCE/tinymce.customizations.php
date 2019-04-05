<?php
### Any other customizations/tweaks for the TinyMCE editor.





### Make image links default to "none"
// You know how when you add an image in TinyMCE and it defaults to linking to the original size or to its attachment page? Well this makes it default to having no link.
// https://www.wpbeginner.com/wp-tutorials/automatically-remove-default-image-links-wordpress/
function wpb_imagelink_setup(){

	$image_set = get_option( 'image_default_link_type' );

	if ($image_set !== 'none') {
		update_option('image_default_link_type', 'none');
	}

}
add_action('admin_init', 'wpb_imagelink_setup', 10);





### Use Paste As Text by default in the editor
// https://anythinggraphic.net/paste-as-text-by-default-in-wordpress
function ag_tinymce_paste_as_text( $init ) {
	$init['paste_as_text'] = true;
	return $init;
}
add_filter('tiny_mce_before_init', 'ag_tinymce_paste_as_text');





### Remove the inline styles from .wp-caption <div>s
function fixed_img_caption_shortcode( $attr, $content=null ){
    if (! isset($attr['caption'])) {
        if (preg_match('#((?:<a [^>]+>\s*)?<img [^>]+>(?:\s*</a>)?)(.*)#is', $content, $matches)) {
        $content = $matches[1];
        $attr['caption'] = trim($matches[2]);
        }
    }

    $output = apply_filters('img_caption_shortcode', '', $attr, $content);
    if ($output != '')
    return $output;

    extract(shortcode_atts(array(
        'id' => '',
        'align' => 'alignnone',
        'width' => '',
        'caption' => ''
  ), $attr));

    if (1 > (int) $width || empty($caption))
    return $content;

    if ($id) $id = 'id="' . esc_attr($id) . '" ';

    return '<div ' . $id . 'class="wp-caption ' . esc_attr($align) . '" style="max-width:'.$width.'px">' . do_shortcode($content) . '<p>' . $caption . '</p></div>';
}
add_shortcode('wp_caption', 'fixed_img_caption_shortcode');
add_shortcode('caption', 'fixed_img_caption_shortcode');





### Remove the inline styles from .wp-video <div>s
function taoti_remove_excess_video_attributes($output, $atts, $video, $post_id, $library){
	$style_attribute_pattern = '/ style="[^\"]*"/';
	$filtered_output = preg_replace( $style_attribute_pattern, '', $output );

	return $filtered_output;
}
add_filter( 'wp_video_shortcode', 'taoti_remove_excess_video_attributes', 10, 5 );
