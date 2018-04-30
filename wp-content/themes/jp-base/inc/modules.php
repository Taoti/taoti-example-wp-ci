<?php
### This file runs include() on the main module files and adds their 'views' folders to Timber.

// Set up an array of all the directories within the 'modules' folder.
$module_paths = glob( get_template_directory().'/modules/*', GLOB_ONLYDIR );

// A blank array for the modules' 'views' folders to be added to.
$timber_paths = [];

// Loop through each folder 'modules' and figure out what the main module php file would be called, based on the name of the module folder.
foreach( $module_paths as $module_path ){
    $module_name = basename( $module_path );
    $file_name = get_template_directory().'/modules/'.$module_name.'/'.$module_name.'.php';

    // As long as the main module php file exists, include() that file and add the 'views' folder to Timber.
    if( file_exists($file_name) ){
	    include $file_name;
        $timber_paths[] = 'modules/'.$module_name.'/views';
	}

}

// Add the 'views' folder at the end of the array, to use this folder as a backup in case there is no view in the module.
$timber_paths[] = 'views';

// Set the paths for Timber to look for .twig files in.
Timber::$dirname = $timber_paths;
