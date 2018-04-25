<?php
// Run this function to run through all the layout files for the page builder.
function the_page_builder(){

    // check if the flexible content field has rows of data
    if( have_rows('modules') ):

     	// loop through the rows of data
        while ( have_rows('modules') ) : the_row();

    		// check current row layout
            $layout_file = get_stylesheet_directory().'/modules/flex-content/layouts/'.get_row_layout().'.php';
            if( file_exists($layout_file) ):
                include($layout_file);
            endif;

        endwhile;

    else :

        // no layouts found

    endif;

}
