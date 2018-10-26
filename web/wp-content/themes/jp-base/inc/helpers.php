<?php
### Helper functions

// These functions help other areas in the code process or retrieve something. Most likely, helper functions will have a return value.


### Give this a string and a integer length and it will return a string that is cut to that length of characters. If the string was indeed shortened it will add ... (ellipsis) to the end.
function jp_substr( $string, $length=50, $ellipsis = true ){
    $excerpt = wp_strip_all_tags($string, true);

    if( strlen($excerpt) > $length ){
        $excerpt = substr($excerpt, 0, $length);
        $excerpt .= ($ellipsis)? '<em class="ellipsis">&hellip;</em>' : '';
    }

    return $excerpt;
}
