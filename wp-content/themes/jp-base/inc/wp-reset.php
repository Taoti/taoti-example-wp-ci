<?php
### Remove some default widgets, including some from Jetpack, Constant Contact, and others.
function unregister_default_widgets(){
	unregister_widget('WP_Widget_Pages');
	unregister_widget('WP_Widget_Calendar');
	unregister_widget('WP_Widget_Archives');
	unregister_widget('WP_Widget_Links');
	unregister_widget('WP_Widget_Meta');
	unregister_widget('WP_Widget_Search');
	unregister_widget('WP_Widget_Text');
	unregister_widget('WP_Widget_Categories');
	unregister_widget('WP_Widget_Recent_Posts');
	unregister_widget('WP_Widget_Recent_Comments');
	unregister_widget('WP_Widget_RSS');
	unregister_widget('WP_Widget_Tag_Cloud');
	unregister_widget('WP_Nav_Menu_Widget');
	unregister_widget('Twenty_Eleven_Ephemera_Widget');
	unregister_widget( 'Jetpack_Subscriptions_Widget' );
	unregister_widget( 'WPCOM_Widget_Facebook_LikeBox' );
	unregister_widget( 'Jetpack_Gallery_Widget' );
	unregister_widget( 'Jetpack_Gravatar_Profile_Widget' );
	unregister_widget( 'Jetpack_Image_Widget' );
	unregister_widget( 'Jetpack_Readmill_Widget' );
	unregister_widget('Jetpack_RSS_Links_Widget');
	unregister_widget( 'Jetpack_Top_Posts_Widget' );
	unregister_widget( 'Jetpack_Twitter_Timeline_Widget' );
	unregister_widget( 'Jetpack_Display_Posts_Widget' );
	unregister_widget( 'constant_contact_form_widget' );
	unregister_widget( 'constant_contact_events_widget' );
	unregister_widget( 'constant_contact_api_widget' );
	unregister_widget( 'bcn_widget' );
}
add_action('widgets_init', 'unregister_default_widgets', 11);





function jp_theme_setup(){

	### Theme support stuff
	add_theme_support( 'menus' ); // Navigation Menus
	add_theme_support( 'post-thumbnails' ); // Post Thumnbails
	add_theme_support( 'html5' ); // HTML5 in WP Generated Elemements
	add_theme_support( 'title-tag' );

}
add_action( 'after_setup_theme', 'jp_theme_setup' );





### Remove tags support from posts
function myprefix_unregister_tags(){
    unregister_taxonomy_for_object_type('post_tag', 'post');
}
//add_action('init', 'myprefix_unregister_tags');





### Make image links default to "none"
// You know how when you add an image in TinyMCE and it defaults to linking to the original size or to its attachment page? Well this makes it default to having no link.
function wpb_imagelink_setup(){
	$image_set = get_option( 'image_default_link_type' );
	if ($image_set !== 'none') {
		update_option('image_default_link_type', 'none');
	}
}
add_action('admin_init', 'wpb_imagelink_setup', 10);





### Remove dashboard menus
function jp_remove_menus(){

	// Remove top level menu pages
	// remove_menu_page( 'edit-comments.php' );

	// Remove sub menu pages
	// remove_submenu_page( 'themes.php', 'widgets.php' );

}
add_action( 'admin_menu', 'jp_remove_menus' );





### Move the SEO By Yoast plugin's meta box to a lower priority so it appears at the bottom of Edit screens.
// https://wordpress.org/support/topic/plugin-wordpress-seo-by-yoast-position-seo-meta-box-priority-above-custom-meta-boxes
add_filter( 'wpseo_metabox_prio', function(){return 'low';} );





### SVG in media uploader
function cc_mime_types( $mimes ){
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');





### Taxonomy term order
// Prevents the taxonomy checkbox lists from reordering themselves when one or more terms are checked.
// http://stackoverflow.com/questions/4830913/wordpress-category-list-order-in-post-edit-page
function taxonomy_checklist_checked_ontop_filter ( $args ){
    $args['checked_ontop'] = false;
    return $args;

}
add_filter('wp_terms_checklist_args','taxonomy_checklist_checked_ontop_filter');





### Add excerpts to pages
function jp_add_excerpts_to_pages(){
     add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'jp_add_excerpts_to_pages' );





### Change the excerpt ellipsis
function jp_new_excerpt_more($more) {
    return '&hellip;';
}
add_filter('excerpt_more', 'jp_new_excerpt_more');





### On the Dashboard, get searches to look in the post title only (exclude the post content from search).
// http://wpsnipp.com/index.php/functions-php/limit-search-to-post-titles-only/
function jp_search_by_title_only( $search, $wp_query ){

	global $wpdb;
	if (empty($search))
	return $search; // skip processing - no search term in query

	$q = $wp_query->query_vars;
	$n = ! empty($q['exact']) ? '' : '%';
	$search =
	$searchand = '';

	foreach ((array) $q['search_terms'] as $term) {
		$term = esc_sql( $wpdb->esc_like($term) );
		$search .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
		$searchand = ' AND ';
	}

	if (! empty($search)) {
		$search = " AND ({$search}) ";
		if (! is_user_logged_in())
		$search .= " AND ($wpdb->posts.post_password = '') ";
	}

	return $search;

}
if( is_admin() ){
	add_filter('posts_search', __NAMESPACE__ . '\\jp_search_by_title_only', 500, 2);
}





### Filter into ACF to allow URL fields to accept strings that start with "tel:" as valid URLs.
// Notet that this currently does not work with checking if '#' is the first character in $value. I think the default browser validation is preventing this from working, so will need to figure out a JS solution for that.
function jp_acf_validate_url( $valid, $value, $field, $input ){
	// echo "<pre>"; var_dump($valid); echo "</pre>";

	// bail early if value is already invalid
	if(!$valid) {
		return $valid;
	}

	// echo "<pre>"; var_dump($value); echo "</pre>";
	// echo "<pre>"; var_dump($field); echo "</pre>";
	// echo "<pre>"; var_dump($input); echo "</pre>";

	if( strpos($value, 'tel:')===0 || strpos($value, '#')===0 ){
		$valid = true;
	}

	return $valid;

}
add_filter('acf/validate_value/type=url', 'jp_acf_validate_url', 20, 4);





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

    return '<div ' . $id . 'class="wp-caption ' . esc_attr($align) . '">' . do_shortcode($content) . '<p>' . $caption . '</p></div>';
}
add_shortcode('wp_caption', 'fixed_img_caption_shortcode');
add_shortcode('caption', 'fixed_img_caption_shortcode');





### Add categories to pages
// http://spicemailer.com/wordpress/add-categories-tags-pages-wordpress/
function jp_add_taxonomies_to_pages() {
	register_taxonomy_for_object_type( 'post_tag', 'page' );
	register_taxonomy_for_object_type( 'category', 'page' );
}
// add_action( 'init', 'jp_add_taxonomies_to_pages' );

function jp_category_and_tag_archives( $wp_query ) {
	$my_post_array = array('post','page');

	if( $wp_query->get('category_name') || $wp_query->get('cat') ){
		$wp_query->set('post_type', $my_post_array);
	}

	if( $wp_query->get('tag' ) ){
		$wp_query->set('post_type', $my_post_array);
	}

}
if( !is_admin() ){
	// add_action( 'pre_get_posts', 'jp_category_and_tag_archives' );
}






### Remove type="javascript" from <script> elements.
// https://wordpress.stackexchange.com/questions/287830/remove-type-attribute-from-script-and-style-tags-added-by-wordpress/287833#287833
function jp_remove_type_attr($tag, $handle) {
    return preg_replace( "/type=['\"]text\/(javascript|css)['\"]/", '', $tag );
}
add_filter('style_loader_tag', 'jp_remove_type_attr', 10, 2);
add_filter('script_loader_tag', 'jp_remove_type_attr', 10, 2);





function jp_deregister_scripts(){
  wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_enqueue_scripts', 'jp_deregister_scripts' );