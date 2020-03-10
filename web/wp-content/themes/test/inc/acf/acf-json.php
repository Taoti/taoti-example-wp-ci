<?php

### Set up the folder for ACF to save JSON files to. This is where the options will be stored.
// https://www.advancedcustomfields.com/resources/local-json/
function taoti_acf_json_load_point( $paths ) {

    // remove original path (optional)
    unset($paths[0]);

    // append path
    $paths[] = get_stylesheet_directory() . '/inc/acf/json';

    // return
    return $paths;

}
add_filter('acf/settings/load_json', 'taoti_acf_json_load_point');

function taoti_acf_json_save_point( $path ) {

    // update path
    $path = get_stylesheet_directory() . '/inc/acf/json';

    // return
    return $path;

}
add_filter('acf/settings/save_json', 'taoti_acf_json_save_point');
