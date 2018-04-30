<?php
### Add custom post types.

function jp_register_post_types() {

	// Add all your post type info into this array.
	$jp_magic_post_type_maker_array = array(
		// array(
		// 	'cpt_single' => 'Resource',
		// 	'cpt_plural' => 'Resources',
		// 	'slug' => 'resource',
		// 	'cpt_icon' => 'dashicons-index-card',
		// 	'exclude_from_search' => false,
		// ),

	);

	foreach( $jp_magic_post_type_maker_array as $post_type ){
		$cpt_single = $post_type['cpt_single'];
		$cpt_plural = $post_type['cpt_plural'];
		$slug = $post_type['slug'];
		$cpt_icon = $post_type['cpt_icon'];
		$exclude_from_search = $post_type['exclude_from_search'];

		// Admin Labels
	  	$labels = jp_generate_label_array($cpt_plural, $cpt_single);

	  	// Arguments
		$args = jp_generate_post_type_args($labels, $cpt_plural, $cpt_icon, $exclude_from_search);

		// Just do it
		register_post_type( $slug, $args );
	}

}

// Hook into the 'init' action
add_action( 'init', 'jp_register_post_types', 0 );




function jp_generate_label_array($cpt_plural, $cpt_single){
	$labels = array(
            'name'               => __( $cpt_plural, 'base' ),
            'singular_name'      => __( $cpt_single, 'base' ),
            'add_new'            => __( 'Add New '.$cpt_single, 'base' ),
            'add_new_item'       => __( 'Add New '.$cpt_single, 'base' ),
            'edit_item'          => __( 'Edit '.$cpt_single, 'base' ),
            'new_item'           => __( 'New '.$cpt_single, 'base' ),
            'all_items'          => __( 'All '.$cpt_plural, 'base' ),
            'view_item'          => __( 'View '.$cpt_single.' Page', 'base' ),
            'search_items'       => __( 'Search '.$cpt_plural, 'base' ),
            'not_found'          => __( 'No '.$cpt_plural.' found', 'base' ),
            'not_found_in_trash' => __( 'No '.$cpt_plural.' found in the Trash', 'base' ),
            'parent_item_colon'  => '',
            'menu_name'          => $cpt_plural,
        );

	return $labels;
}

function jp_generate_post_type_args($labels, $cpt_plural, $cpt_icon, $exclude_from_search){
	$args = array(
        'labels'        	  => $labels,
        'description'   	  => __('Manage '.$cpt_plural, 'base'),
        'public'        	  => true,
        'menu_position' 	  => 10,
        'hierarchical'		  => true,
        'supports'      	  => array( 'title', 'editor', 'page-attributes', 'thumbnail', 'excerpt' ),
        'has_archive'   	  => true,
        'menu_icon'			  => $cpt_icon,
        'exclude_from_search' => $exclude_from_search
    );

	return $args;
}
