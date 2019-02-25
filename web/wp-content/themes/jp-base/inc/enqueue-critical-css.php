<?php

### HOW TO USE
### You can output critical CSS only on the template that uses those styles.
### On any template, before the get_header() call, run the following:
### taoti_enqueue_critical_css( $css_src_filepath );
### Example:
### taoti_enqueue_critical_css( get_template_directory().'/styles/css/critical/front-page-critical.min.css' );
### You can also supply an array of CSS files.



// Set an array to store the path strings for CSS files. Should be used as a global variable.
$taoti_critical_css_queue = [];



// Adds file path strings to the global $taoti_critical_css_queue array.
// $src can be a string, or an array of strings, with a filepath to a CSS file.
function taoti_enqueue_critical_css( $src ){
    global $taoti_critical_css_queue;

    if( is_string($src) ){
        $taoti_critical_css_queue[] = $src;

    } elseif( is_array($src) ){
        foreach( $src as $filepath ){
            if( is_string($filepath) ){
                $taoti_critical_css_queue[] = $filepath;

            }
        }

    }

}



// Goes through each file in the global array, gets the contents of the file, and outputs it all within a <style> tag. Attach it to the `jp_css` to output this in the <head>.
function taoti_output_critical_css(){

    // Make an array to store the output for each critical CSS file. Will get echoed at the end.
    $css_output = [];

	// Global Critical CSS
	// Load the global critical CSS first.
    $critical_css = file_get_contents( get_template_directory().'/styles/css/style-critical.min.css' );
    if( $critical_css ){
        $css_output[] = $critical_css;
    }

    // Get the global $taoti_critical_css_queue array where the theme files add filepaths.
    global $taoti_critical_css_queue;

    // Go through the array to get the file contents (the CSS code) for each CSS file in the array.
    if( !empty($taoti_critical_css_queue) ):

        foreach( $taoti_critical_css_queue as $src ):

            if( file_exists($src) ):
                $file_contents = file_get_contents( $src );

                if( $file_contents !== false ):
                    $css_output[] = $file_contents;
                endif;

            endif;

        endforeach;

    endif;


    // For everything added to $css_output, output it within <style> tags.
    if( !empty($css_output) ):
        echo '<style>';

        foreach( $css_output as $css_code ):
            echo $css_code;
        endforeach;

        echo "</style>\r\n";
    endif;

}
add_action('jp_css', 'taoti_output_critical_css');
