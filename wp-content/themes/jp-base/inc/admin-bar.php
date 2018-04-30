<?php
### Add 'Edit' and 'View' buttons to the toolbar for custom options pages that manage post type archives.
// https://codex.wordpress.org/Function_Reference/add_node

function jp_toolbar_customize(){
    global $wp_admin_bar;

    ### EXAMPLE ###
    // If viewing the reviews archive, add a link to the toolbar to the ACF edit screen.
    // if( is_post_type_archive('review') ){
    //
    //     $args = array(
    //         'id' => 'edit', // This is what adds the pencil icon to the button.
    //         'title' => 'Edit Reviews Page',
    //         'href' => admin_url('edit.php?post_type=review&page=acf-options-reviews-archive-page'),
    //     );
    //
    //     $wp_admin_bar->add_node( $args );
    //
    // }
    //
    // // If on the ACF edit screen for the reviews archive, add a 'view' link to the toolbar.
    // if( function_exists('get_current_screen') ){
    //     $screen = get_current_screen();
    //     // echo "<pre>"; print_r($screen); echo "</pre>";
    //
    //     if( is_admin() && isset($screen->id) && $screen->id=='review_page_acf-options-reviews-archive-page' ){
    //         $args = array(
    //             'title' => 'View Reviews Archive',
    //             'href' => get_post_type_archive_link( 'review' ),
    //         );
    //
    //         $wp_admin_bar->add_node( $args );
    //     }
    //
    // }

}

// add_action( 'admin_bar_menu', 'jp_toolbar_customize', 75 );
