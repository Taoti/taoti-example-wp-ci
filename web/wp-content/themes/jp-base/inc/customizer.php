<?php
### Options for Appearance > Customize

function jp_customize_register_cb($wp_customize){

    ### Section - Contact Details
    $wp_customize->add_section( 'jp_section_contact_details' , array(
        'title' => __( 'Contact Details', 'jp' ),
        'description' => 'Enter your contact details that will appear throughout the website.',
        'priority' => 20,
    ) );

    // Phone Number
    $wp_customize->add_setting( 'jp_phone_number' , array(
        'default'   => '(123) 456-7890',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'jp_phone_number', array(
    	'label' => __( 'Phone Number', 'jp' ),
    	'section' => 'jp_section_contact_details',
    	'settings' => 'jp_phone_number',
        'type' => 'text',
        'description' => 'This is for the phone number as it would appear within copy for a person to read, e.g., (123) 456-7890',
    ) ) );

    // Street Address
    $wp_customize->add_setting( 'jp_address' , array(
        'default'   => '',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'jp_address', array(
    	'label' => __( 'Street Address', 'jp' ),
    	'section' => 'jp_section_contact_details',
    	'settings' => 'jp_address',
        'type' => 'textarea',
        'description' => 'Enter your address as it will appear throughout the website.'
    ) ) );

    // Facebook
    $wp_customize->add_setting( 'jp_facebook_url' , array(
        'default'   => '',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'jp_facebook_url', array(
    	'label' => __( 'Facebook Page URL', 'jp' ),
    	'section' => 'jp_section_contact_details',
    	'settings' => 'jp_facebook_url',
        'type' => 'url',
        'description' => 'Copy and paste the URL to your Facebook page here.',
    ) ) );

    // Twitter
    $wp_customize->add_setting( 'jp_twitter_url' , array(
        'default'   => '',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'jp_twitter_url', array(
    	'label' => __( 'Twitter Page URL', 'jp' ),
    	'section' => 'jp_section_contact_details',
    	'settings' => 'jp_twitter_url',
        'type' => 'url',
        'description' => 'Copy and paste the URL to your Twitter page here.',
    ) ) );



    ### Remove default sections and panels
    $wp_customize->remove_section('title_tagline');
    $wp_customize->remove_section('colors');
    $wp_customize->remove_section('header_image');
    $wp_customize->remove_section('background_image');
    $wp_customize->remove_section('static_front_page');
    $wp_customize->remove_section('custom_css');
    // $wp_customize->remove_panel('widgets');


    return $wp_customize;
}
add_action( 'customize_register', 'jp_customize_register_cb' );
