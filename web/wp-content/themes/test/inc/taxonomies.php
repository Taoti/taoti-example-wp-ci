<?php
### Add custom taxonomies.

function jp_registers_taxonomies(){

    $jp_magic_taxonomy_maker_array = [

        /*
		HOW TO USE

		Copy the array below for 'product-type' and edit as needed. $jp_magic_taxonomy_maker_array should be an array of arrays, and those arrays make it easier to create custom taxonomies.

		The 'slug', 'singular', and 'plural' parameters are explained below in the example array's comments.

        'applicable_post_types' is an array of the post type slugs that this taxonomy should apply to.

		For the 'register_args' array, add whichever arguments you need to the array (Except for the 'labels' argument, that's automatically generated for you). The defaults will should work well 99% of the time, but you can add/override anything with this array.

		Use the documentation on https://codex.wordpress.org/Function_Reference/register_taxonomy

		The most common argument you might need for taxonomies is 'hierarchical'. `true` means there are parent/child relationships (like categories) and `false` is a flat structure (like tags).

        If you don't need to add anything to the 'register_args' array, just leave it as an empty array.

		*/

        // Comment out or change this example:
        [
			'slug' => 'product-type', // Lowercase letters, dashes only
			'singular' => 'Product Type', // Capitalized, something like 'Product Type' or 'Topic'
			'plural' => 'Product Types (REPLACE ME)', // Capitalized, something like 'Product Types' or 'Topics'
            'applicable_post_types' => [ // Post type slugs
                'post',
                'products',
            ],
			'register_args' => [ // Explained above. Leave as an empty array if not needed.
				'hierarchical' => true,
			],

		],

    ];

    foreach( $jp_magic_taxonomy_maker_array as $tax_args ){

        // Collect the data from the array.
        $singular = $tax_args['singular'];
        $plural   = $tax_args['plural'];
        $slug     = $tax_args['slug'];
        $applicable_post_types = $tax_args['applicable_post_types'];
        $register_args = $tax_args['register_args'];

        // Generate the arguments that will be passed to register_taxonomy().
        $final_args = jp_generate_tax_args_array( $slug, $register_args );

        // Generate the labels and add them to $final_args.
        $labels = jp_generate_tax_labels_array([
			'singular' => $singular,
			'plural' => $plural,
		]);

        $final_args['labels'] = $labels;

        // Finally register the taxonomy.
        register_taxonomy( $slug, $applicable_post_types, $final_args );
    }

}
add_action( 'init', 'jp_registers_taxonomies', 0 );



function jp_generate_tax_labels_array( $args = [] ){

    $defaults = [
		'singular' => false,
		'plural' => false,
	];

	$merged = array_merge($defaults, $args);

	if( in_array(false, $merged, true) ){
		return false;
	}

	$singular = $merged['singular'];
	$plural = $merged['plural'];
	$singular_lowercase = strtolower( $singular );
	$plural_lowercase = strtolower( $plural );

    $labels = array(
        'name' => $plural,
        'singular_name' => $singular,
        'menu_name' => $plural,
        'all_items' => sprintf( _x( 'All %s', 'referring to a taxonomy', 'base' ), $plural ),
        'edit_item' => sprintf( _x( 'Edit %s', 'referring to a taxonomy', 'base' ), $singular ),
        'view_item' => sprintf( _x( 'View %s', 'referring to a taxonomy', 'base' ), $singular ),
        'update_item' => sprintf( _x( 'Update %s', 'referring to a taxonomy', 'base' ), $singular ),
        'add_new_item' => sprintf( _x( 'Add New %s', 'referring to a taxonomy', 'base' ), $singular ),
        'new_item_name' => sprintf( _x( 'New %s Name', 'referring to a taxonomy', 'base' ), $singular ),
        'parent_item' => sprintf( _x( 'Parent %s', 'referring to a taxonomy', 'base' ), $singular ),
        'parent_item_colon' => sprintf( _x( 'Parent %s:', 'referring to a taxonomy', 'base' ), $singular ),
        'search_items' => sprintf( _x( 'Search %s', 'referring to a taxonomy', 'base' ), $plural ),
        'popular_items' => sprintf( _x( 'Popular %s', 'referring to a taxonomy', 'base' ), $plural ),
        'separate_items_with_commas' => sprintf( _x( 'Separate %s with commas', 'referring to a taxonomy', 'base' ), $plural_lowercase ),
        'add_or_remove_items' => sprintf( _x( 'Add or remove %s', 'referring to a taxonomy', 'base' ), $plural_lowercase ),
        'choose_from_most_used' => sprintf( _x( 'Choose from the most used  %s', 'referring to a taxonomy', 'base' ), $plural_lowercase ),
        'not_found' => sprintf( _x( 'No %s found.', 'referring to a taxonomy', 'base' ), $plural_lowercase ),
        'back_to_items' => sprintf( _x( 'Back to %s', 'referring to a taxonomy', 'base' ), $plural_lowercase ),
    );
    return $labels;
}



function jp_generate_tax_args_array( $slug, $args = [] ){

    // These are the default arguments we use for taxonomies 99% of the time.
    $defaults = [
        'hierarchical' => true,
        'show_admin_column' => true,
        'rewrite' => [
            'slug' => $slug
        ],
    ];

	$merged = array_merge($defaults, $args);

	return $merged;

}
