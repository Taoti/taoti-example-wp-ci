<?php
// Set up image sizes and their descriptions.

// Add custom image sizes.
function jp_image_size_setup() {

	add_image_size( '1080p', 1920, 1080, true );
	add_image_size( '720p', 1280, 720, true );
	add_image_size( 'article', 720, 480, true );

}
add_action( 'after_setup_theme', 'jp_image_size_setup' );



// Give human-readable names the image sizes.
function jp_custom_size_names( $sizes ) {

	return array_merge(
		$sizes,
		array(
			'1080p'   => 'Standard 1080p',
			'720p'    => 'Standard 720p',
			'article' => 'Article Photo',
		)
	);

}
add_filter( 'image_size_names_choose', 'jp_custom_size_names' );
