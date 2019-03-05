<?php
### Add custom post types.

function jp_register_post_types() {

	// Add all your post type info into this array.
	$jp_magic_post_type_maker_array = [

		/*
		HOW TO USE

		Copy the array below for 'product' and edit as needed. $jp_magic_post_type_maker_array should be an array of arrays, and those arrays make it easier to create custom post types.

		The 'slug', 'singular', and 'plural' parameters are explained below in the example array's comments.

		For the 'register_args' array, add whichever arguments you need to the array (Except for the 'labels' argument, that's automatically generated for you).

		Use the documentation on https://codex.wordpress.org/Function_Reference/register_post_type

		*** Common arguments (that you'll definitely want to use) are `menu_icon` and `description`. ***

		The most common arguments are here for you to copy/paste, but again you can add whichever arguments are supported by the register_post_type() function.

		'menu_icon'  => 'dashicons-clipboard',
		'description' => 'Manage your PLURAL POST NAME here.',
		'menu_position' => 10,
		'hierarchical' => true,
		'public' => true,
		'has_archive' => true,
		'exclude_from_search' => false,

		*/

		[
			'slug' => 'product', // Lowercase letters, dashes only
			'singular' => 'Product', // Capitalized, something like 'Product' or 'Staff Member'
			'plural' => 'Products (REPLACE ME)', // Capitalized, something like 'Products' or 'Staff Members'
			'register_args' => [ // Explained above.
				'menu_icon' => 'dashicons-clipboard',
				'description' => 'Manage your Products.',
			],

		],

	];

	foreach( $jp_magic_post_type_maker_array as $post_type_args ){
		$singular = $post_type_args['singular'];
		$plural = $post_type_args['plural'];
		$slug = $post_type_args['slug'];
		$register_args = $post_type_args['register_args'];

	  	// Arguments
		$final_args = jp_generate_post_type_args( $register_args );

		// Admin Labels
		$labels = jp_generate_label_array([
			'singular' => $singular,
			'plural' => $plural,
			'slug' => $slug,
		]);

		$final_args['labels'] = $labels;

		// Just do it
		register_post_type( $slug, $final_args );
	}

}

// Hook into the 'init' action
add_action( 'init', 'jp_register_post_types', 0 );




// function jp_generate_label_array($cpt_plural, $cpt_single){
function jp_generate_label_array( $args = [] ){

	$defaults = [
		'singular' => false,
		'plural' => false,
		'slug' => false,
	];

	$merged = array_merge($defaults, $args);

	if( in_array(false, $merged, true) ){
		return false;
	}

	$singular = $merged['singular'];
	$plural = $merged['plural'];
	$slug = $merged['slug'];
	$singular_lowercase = strtolower( $singular );
	$plural_lowercase = strtolower( $plural );

	$labels = array(
		'name' => $plural,  //- general name for the post type, usually plural. The same and overridden by $post_type_object->label. Default is Posts/Pages
		'singular_name' => $singular, //  name for one object of this post type. Default is Post/Page
		'add_new' => _x('Add New', $slug), //  the add new text. The default is "Add New" for both hierarchical and non-hierarchical post types.
		'add_new_item' => 'Add New ' . $singular, //  Default is Add New Post/Add New Page.
		'edit_item' => 'Edit ' . $singular, 'base', //  Default is Edit Post/Edit Page.
		'new_item' => 'New ' . $singular, 'base', //  Default is New Post/New Page.
		'view_item' => 'View ' . $singular, 'base', //  Default is View Post/View Page.
		'view_items' => 'View ' . $plural, 'base', //  Label for viewing post type archives. Default is 'View Posts' / 'View Pages'.
		'search_items' => 'Search ' . $plural, 'base', //  Default is Search Posts/Search Pages.
		'not_found' => 'No ' . $plural_lowercase . ' found.', 'base', //  Default is No posts found/No pages found.
		'not_found_in_trash' => 'No ' . $plural_lowercase . ' replaces found in Trash.', 'base', //  Default is No posts found in Trash/No pages found in Trash.
		'parent_item_colon' => 'Parent ' . $singular . ':', 'base', //  This string isn't used on non-hierarchical types. In hierarchical ones the default is 'Parent Page:'.
		'all_items' => 'All ' . $plural, 'base', //  String for the submenu. Default is All Posts/All Pages.
		'archives' => $singular . ' Archives', 'base', //  String for use with archives in nav menus. Default is Post Archives/Page Archives.
		'attributes' => $singular . ' Attributes', 'base', //  Label for the attributes meta box. Default is 'Post Attributes' / 'Page Attributes'.
		'insert_into_item' => 'Insert into ' . $singular . '.', 'base', //  String for the media frame button. Default is Insert into post/Insert into page.
		'uploaded_to_this_item' => 'Uploaded to this ' . $singular . '.',
    );

	return $labels;
}

function jp_generate_post_type_args( $args = [] ){

	$defaults = array(
		'public'        	  => true,
		'menu_position' 	  => 10,
		'hierarchical'		  => true,
		'supports'      	  => array( 'title', 'editor', 'page-attributes', 'thumbnail', 'excerpt' ),
		'has_archive'   	  => true,
		'exclude_from_search' => false
    );

	$merged = array_merge($defaults, $args);

	return $merged;
}
