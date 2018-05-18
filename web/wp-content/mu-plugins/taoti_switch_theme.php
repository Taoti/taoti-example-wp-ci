<?php
/*
  Plugin Name: Theme Switcher
  Description: Automatically switches to the base theme when WP realizes the twentyX themes have been removed.
  Version: 1.0
  Author: James Pfleiderer
  Author URI: https://www.taoti.com/
*/

// Since the twentyX themes are deleted from that repo, WordPress will normally complain that 'the twentyX theme does not exist.' until you go to the Dashboard and switch the theme.
// This plugin will automatically determine if a theme is not set, in which case it will switch to the 'jp-base' theme. Useful for when Pantheon deploys a new site based on our custom WordPress upstream.

function jp_switch_theme(){

    if( is_blog_installed() ){
        $current_theme = wp_get_theme();

        if( $current_theme->exists() === false ){
            switch_theme( 'jp-base' );
        }
    }

}
add_action( 'setup_theme', 'jp_switch_theme', 1 );
