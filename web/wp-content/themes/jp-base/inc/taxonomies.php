<?php
### Add custom taxonomies.

function jp_registers_taxonomies(){

    $jp_magic_taxonomy_maker_array = array(
        // Example post type - "Issue"
        // array(
        //     'tax_singular' => 'Issue',
        //     'tax_plural'   => 'Issues',
        //     'tax_slug'     => 'issue', // lowercase letters and dashes only
        //     'applicable_post_types' => array(
        //         'resource',
        //         'press-release',
        //         'expert',
        //         'staff',
        //     )
        // ),
    );

    foreach( $jp_magic_taxonomy_maker_array as $taxonomy ){
        $tax_singular = $taxonomy['tax_singular'];
        $tax_plural   = $taxonomy['tax_plural'];
        $tax_slug     = $taxonomy['tax_slug'];
        $applicable_post_types = $taxonomy['applicable_post_types'];

        $labels = jp_generate_tax_labels_array($tax_singular, $tax_plural);
        $args = jp_generate_tax_args_array($labels, $tax_slug);
        register_taxonomy( $tax_slug, $applicable_post_types, $args );
    }

}
add_action( 'init', 'jp_registers_taxonomies', 0 ); // hook into the init action



function jp_generate_tax_labels_array( $tax_singular, $tax_plural ){
    $labels = array(
        'name'              => __( $tax_plural, 'base' ),
        'singular_name'     => __( $tax_singular, 'base' ),
        'search_items'      => __( 'Search '.$tax_plural, 'base' ),
        'all_items'         => __( 'All '.$tax_plural, 'base' ),
        'parent_item'       => __( 'Parent '.$tax_singular, 'base' ),
        'parent_item_colon' => __( 'Parent '.$tax_singular.':', 'base' ),
        'edit_item'         => __( 'Edit '.$tax_singular, 'base' ),
        'update_item'       => __( 'Update '.$tax_singular, 'base' ),
        'add_new_item'      => __( 'Add New '.$tax_singular, 'base' ),
        'new_item_name'     => __( 'New '.$tax_singular.' Name', 'base' ),
        'menu_name'         => __( $tax_plural, 'base' ),
    );
    return $labels;
}

function jp_generate_tax_args_array( $labels, $tax_slug ){
    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => $tax_slug ),
    );
    return $args;
}
