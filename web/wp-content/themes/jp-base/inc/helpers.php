<?php
### Helper functions


### Give this a string and a integer length and it will return a string that is cut to that length of characters. If the string was indeed shortened it will add ... (ellipsis) to the end.
function jp_substr( $string, $length=50, $ellipsis = true ){
    $excerpt = wp_strip_all_tags($string, true);

    if( strlen($excerpt) > $length ){
        $excerpt = substr($excerpt, 0, $length);
        $excerpt .= ($ellipsis)? '<em class="ellipsis">&hellip;</em>' : '';
    }

    return $excerpt;
}


### Give this a string and a integer limit and it will return a string that is limited to that many words. If the string was indeed shortened it will add ... (ellipsis) to the end.
function jp_limit_words($string, $limit, $ellipsis = true){
	$excerpt = explode(' ', $string, $limit);

    if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		$excerpt = trim(implode(" ",$excerpt), ",;(&:'\"");
		$excerpt .= ($ellipsis) ? '<em class="ellipsis">&hellip;</em>' : '';

    } else {
    	$excerpt = implode(" ",$excerpt);

    }

    return $excerpt;
}
