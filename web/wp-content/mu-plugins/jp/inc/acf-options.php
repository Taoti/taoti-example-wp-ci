<?php

### NOTE - For simple things like phone or address, I started using the Customizer API. See inc/customizer.php in the theme folder.

##### Global Settings page
if( function_exists('acf_add_options_page') ) {

	// Settings page for things across the entire website, or at least multiple pages.
	// acf_add_options_page('Global Settings');


	/* Example for adding in a child options page
	// Success Stories Options
	acf_add_options_page(
		array(
			'page_title' => 'Success Stories Intro Text and Options',
			'parent_slug' => 'edit.php?post_type=success-story'
		)
	);
	*/

}
