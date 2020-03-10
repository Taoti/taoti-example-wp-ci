<?php
// Options for Appearance > Customize

function jp_customize_register_cb( $wp_customize ) {

	// Section - Contact Details
	$wp_customize->add_section(
		'jp_section_contact_details',
		array(
			'title'       => __( 'Contact Details', 'jp' ),
			'description' => 'Enter your contact details that will appear throughout the website.',
			'priority'    => 20,
		)
	);

	// Phone Number
	$wp_customize->add_setting(
		'jp_phone_number',
		array(
			'default' => '(123) 456-7890',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'jp_phone_number',
			array(
				'label'       => __( 'Phone Number', 'jp' ),
				'section'     => 'jp_section_contact_details',
				'settings'    => 'jp_phone_number',
				'type'        => 'text',
				'description' => 'This is for the phone number as it would appear within copy for a person to read, e.g., (123) 456-7890',
			)
		)
	);

	// Street Address
	$wp_customize->add_setting(
		'jp_address',
		array(
			'default' => '',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'jp_address',
			array(
				'label'       => __( 'Street Address', 'jp' ),
				'section'     => 'jp_section_contact_details',
				'settings'    => 'jp_address',
				'type'        => 'textarea',
				'description' => 'Enter your address as it will appear throughout the website.',
			)
		)
	);

	// Facebook
	$wp_customize->add_setting(
		'jp_facebook_url',
		array(
			'default' => '',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'jp_facebook_url',
			array(
				'label'       => __( 'Facebook Page URL', 'jp' ),
				'section'     => 'jp_section_contact_details',
				'settings'    => 'jp_facebook_url',
				'type'        => 'url',
				'description' => 'Copy and paste the URL to your Facebook page here.',
			)
		)
	);

	// Twitter
	$wp_customize->add_setting(
		'jp_twitter_url',
		array(
			'default' => '',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'jp_twitter_url',
			array(
				'label'       => __( 'Twitter Page URL', 'jp' ),
				'section'     => 'jp_section_contact_details',
				'settings'    => 'jp_twitter_url',
				'type'        => 'url',
				'description' => 'Copy and paste the URL to your Twitter page here.',
			)
		)
	);

	// Section - 404 Page
	$wp_customize->add_section(
		'jp_section_404_page',
		array(
			'title'       => __( '404 Page', 'jp' ),
			'description' => 'Add a custom title and message to your 404 page.',
			'priority'    => 20,
		)
	);

	// 404 page title
	$wp_customize->add_setting(
		'jp_404_page_title',
		array(
			'default'   => 'Not Found (404)',
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'jp_404_page_title',
			array(
				'label'       => __( 'Page Title', 'jp' ),
				'section'     => 'jp_section_404_page',
				'settings'    => 'jp_404_page_title',
				'type'        => 'text',
				'description' => 'Set the main page title.',
			)
		)
	);

	// 404 page content
	$wp_customize->add_setting(
		'jp_404_content',
		array(
			'default'   => 'The content you were looking for could not be found.',
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'jp_404_content',
			array(
				'label'       => __( 'Message', 'jp' ),
				'section'     => 'jp_section_404_page',
				'settings'    => 'jp_404_content',
				'type'        => 'textarea',
				'description' => 'Set the message that lets a user know what to do.',
			)
		)
	);

	// Remove default sections and panels
	$wp_customize->remove_section( 'title_tagline' );
	$wp_customize->remove_section( 'colors' );
	$wp_customize->remove_section( 'header_image' );
	$wp_customize->remove_section( 'background_image' );
	$wp_customize->remove_section( 'static_front_page' );
	$wp_customize->remove_section( 'custom_css' );
	// $wp_customize->remove_panel('widgets');

	return $wp_customize;
}
add_action( 'customize_register', 'jp_customize_register_cb' );





function taoti_customizer_live_preview() {
	wp_enqueue_script( 'taoti-themecustomizer', get_template_directory_uri() . '/js/admin/theme-customizer.js', array( 'jquery', 'customize-preview' ), '1.0', true );
}
add_action( 'customize_preview_init', 'taoti_customizer_live_preview', 0, 99 );
