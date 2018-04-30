<?php

function jp_mce_buttons_2( $buttons ){
    array_unshift($buttons, 'styleselect');
    return $buttons;
}
add_filter('mce_buttons_2', 'jp_mce_buttons_2');



function jp_mce_before_init( $settings ){

    $style_formats = array(
		array(
    		'title' => 'Button',
    		'selector' => 'a',
    		'classes' => 'button'
    	)
    );

    $settings['style_formats'] = json_encode( $style_formats );

    return $settings;

}
add_filter('tiny_mce_before_init', 'jp_mce_before_init');
