<?php
### Include various customizations/tweaks to WordPress here.
### Like CSS Reset, but for WordPress.

### Quality of life improvements for things like adding theme support for featured images, adding excerpts to pages, removing a bunch of useless widgets, and a bunch of stuff.

### Add/remove/modify anything you need in here for your own theme (never modify anything in `jp-base`, it will cause git conflicts).

### Note
### Tweaks for ACF go in theme-folder/inc/acf/acf.php
### Tweaks for TinyMCE go in theme-folder/inc/tinyMCE/{{3 different files}}



### Remove some default widgets, including some from Jetpack, Constant Contact, and others.
function jp_unregister_default_widgets(){
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
add_action('widgets_init', 'jp_unregister_default_widgets', 11);





function jp_theme_setup(){

	### Theme support stuff
	add_theme_support( 'menus' ); // Navigation Menus
	add_theme_support( 'post-thumbnails' ); // Post Thumnbails
	add_theme_support( 'html5' ); // HTML5 in WP Generated Elemements
	add_theme_support( 'title-tag' );

}
add_action( 'after_setup_theme', 'jp_theme_setup' );





### Remove tags support from posts
function jp_unregister_tags(){
    unregister_taxonomy_for_object_type('post_tag', 'post');
}
//add_action('init', 'jp_unregister_tags');





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





### Taxonomy term order
// Prevents the taxonomy checkbox lists from reordering themselves when one or more terms are checked.
// http://stackoverflow.com/questions/4830913/wordpress-category-list-order-in-post-edit-page
function jp_taxonomy_checklist_checked_ontop_filter ( $args ){
    $args['checked_ontop'] = false;
    return $args;

}
add_filter('wp_terms_checklist_args','jp_taxonomy_checklist_checked_ontop_filter');





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



### Set a custom word length for excerpts.
function jp_custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'jp_custom_excerpt_length', 999 );





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
if( is_admin() && !wp_doing_ajax() ){
	add_filter('posts_search', __NAMESPACE__ . '\\jp_search_by_title_only', 500, 2);
}





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





/**
 * Filters the output of 'wp_calculate_image_sizes()'. Use this to tweak the value of the 'sizes' attribute on images.
 *
 * @since 4.4.0
 *
 * @param string       $sizes         A source size value for use in a 'sizes' attribute.
 * @param array|string $size          Requested size. Image size or array of width and height values in pixels (in that order).
 * @param string|null  $image_src     The URL to the image file or null.
 * @param array|null   $image_meta    The image meta data as returned by wp_get_attachment_metadata() or null.
 * @param int          $attachment_id Image attachment ID of the original image or 0.
 */
function taoti_tweak_image_sizes($sizes, $size, $image_src, $image_meta, $attachment_id){

	// See what the arguments for this filter look like; example of this output is below.
	// $args = [
	// 	'sizes' => $sizes,
	// 	'size' => $size,
	// 	'image_src' => $image_src,
	// 	'image_meta' => $image_meta,
	// 	'attachment_id' => $attachment_id,
	// ];
	// echo "<pre>"; print_r($args); echo "</pre>";
	// die('');

	if( isset($image_meta['sizes']['medium_large']) ){
		$sizes = '(max-width: 768px) 768px, '.$sizes;
	}

	// Sample of a custom image size being added:
	// if( isset($image_meta['sizes']['small-feature']) ){
	// 	$sizes = '(max-width: 490px) 490px, '.$sizes;
	// }

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'taoti_tweak_image_sizes', 10, 5);

/*
// EXAMPLE of the arguments that are passed to the 'wp_calculate_image_sizes' filter.
Array
(
    [sizes] => (max-width: 827px) 100vw, 827px
    [size] => Array
        (
            [0] => 827
            [1] => 1121
        )

    [image_src] => http://localhost:8888/taoti-19/web/wp-content/uploads/2018/07/cyclists-hero.png
    [image_meta] => Array
        (
            [width] => 827
            [height] => 1121
            [file] => 2018/07/cyclists-hero.png
            [sizes] => Array
                (
                    [thumbnail] => Array
                        (
                            [file] => cyclists-hero-150x150.png
                            [width] => 150
                            [height] => 150
                            [mime-type] => image/png
                        )

                    [medium] => Array
                        (
                            [file] => cyclists-hero-221x300.png
                            [width] => 221
                            [height] => 300
                            [mime-type] => image/png
                        )

                    [medium_large] => Array
                        (
                            [file] => cyclists-hero-768x1041.png
                            [width] => 768
                            [height] => 1041
                            [mime-type] => image/png
                        )

                    [large] => Array
                        (
                            [file] => cyclists-hero-755x1024.png
                            [width] => 755
                            [height] => 1024
                            [mime-type] => image/png
                        )

                    [720p] => Array
                        (
                            [file] => cyclists-hero-827x720.png
                            [width] => 827
                            [height] => 720
                            [mime-type] => image/png
                        )

                    [small-feature] => Array
                        (
                            [file] => cyclists-hero-490x490.png
                            [width] => 490
                            [height] => 490
                            [mime-type] => image/png
                        )

                    [large-feature] => Array
                        (
                            [file] => cyclists-hero-827x910.png
                            [width] => 827
                            [height] => 910
                            [mime-type] => image/png
                        )

                )

            [image_meta] => Array
                (
                    [aperture] => 0
                    [credit] =>
                    [camera] =>
                    [caption] =>
                    [created_timestamp] => 0
                    [copyright] =>
                    [focal_length] => 0
                    [iso] => 0
                    [shutter_speed] => 0
                    [title] =>
                    [orientation] => 0
                    [keywords] => Array
                        (
                        )

                )

        )

    [attachment_id] => 146
)
*/






### Disable comments (won't work for existing comments)
// You should now use the "Disable Comments" plugin.





### SVG in media uploader
// You should now use the "Safe SVG" plugin
