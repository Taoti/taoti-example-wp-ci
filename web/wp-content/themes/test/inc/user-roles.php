<?php

### Only keep the Administrator, Editor, and Author roles
function taoti_remove_unused_roles(){

    if( get_role('subscriber') ){
        remove_role( 'subscriber' );
    }

    if( get_role('contributor') ){
        remove_role( 'contributor' );
    }

}
add_action( 'after_setup_theme', 'taoti_remove_unused_roles' );

if( get_role('subscriber') ){
    taoti_remove_unused_roles();
}





### Remove Yoast `SEO Manager` role
if ( get_role('wpseo_manager') ) {
    remove_role( 'wpseo_manager' );
}

### Remove Yoast `SEO Editor` role
if ( get_role('wpseo_editor') ) {
    remove_role( 'wpseo_editor' );
}
