<?php
### Errors
if( defined('WP_DEBUG') && WP_DEBUG ){
// if( $_SERVER['SERVER_NAME']==='localhost' ){
    ini_set('display_startup_errors', '1');
    ini_set('display_errors', '1');
    error_reporting(E_ALL);

} else {
    ini_set('display_startup_errors', '0');
    ini_set('display_errors', '0');
    error_reporting(0);

}




### Function includes
include 'inc/acf/acf.php';
include 'inc/wp-reset.php';
include 'inc/post-types.php';
include 'inc/taxonomies.php';
include 'inc/helpers.php';
include 'inc/globals.php';
include 'inc/database.php';
include 'inc/walkers.php';
include 'inc/enqueue-critical-css.php';
include 'inc/enqueue.php';
include 'inc/image-sizes.php';
include 'inc/shortcodes.php';
include 'inc/navigation.php';
include 'inc/options.php';
include 'inc/customizer.php';
include 'inc/widgets.php';
include 'inc/admin-bar.php';
include 'inc/tinyMCE/tinymce.styles.php';
include 'inc/tinyMCE/tinymce.toolbars.php';



### Modules
include 'inc/modules.php';
