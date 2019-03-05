<?php
### This is the Page Builder (which is a 'flex content' field in ACF).
### A flex content field has subfields called 'layouts', which act as the page builder modules.

### An ACF flex content field called 'modules' is already set up in the ACF Field Group "Page Builder". Edit that field to add layouts required by your project.


### Run this function to output all of the page builder module content.
function the_page_builder(){

    // If there are modules added to the page builder.
    if( have_rows('modules') ):

     	// Loop through each module.
        while( have_rows('modules') ): the_row();

    		// Each layout in the flex content field should correspond to a PHP file in the .../flex-content/layouts/ directory.
    		$layout_name = get_row_layout();
            $layout_file = get_stylesheet_directory().'/flex-content/layouts/' . $layout_name . '.php';

            // Make sure the layout file exists before including it.
            if( file_exists($layout_file) ):

                // Including the layout file should output the markup for this layout.
                include($layout_file);

            endif;

        endwhile;

    else :

        // no layouts found

    endif;

}
