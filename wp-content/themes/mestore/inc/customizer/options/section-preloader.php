<?php
/**
 * Theme Customizer Controls
 *
 * @package mestore
 */


if ( ! function_exists( 'mestore_customizer_preloader_register' ) ) :
function mestore_customizer_preloader_register( $wp_customize ) {
 
 	$wp_customize->add_section(
        'mestore_preloader_settings',
        array (
            'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'title'         => esc_html__( 'Preloader Settings', 'mestore' )
        )
    );

    // Title label
	$wp_customize->add_setting( 
		'mestore_label_preloader_settings_title', 
		array(
		    'sanitize_callback' => 'mestore_sanitize_title',
		) 
	);

	$wp_customize->add_control( 
		new MeStore_Title_Info_Control( $wp_customize, 'mestore_label_preloader_settings_title', 
		array(
		    'label'       => esc_html__( 'Preloader Settings', 'mestore' ),
		    'section'     => 'mestore_preloader_settings',
		    'type'        => 'mestore-title',
		    'settings'    => 'mestore_label_preloader_settings_title',
		) 
	));

	// Add an option to enable the preloader
	$wp_customize->add_setting( 
		'mestore_enable_preloader', 
		array(
		    'default'           => true,
		    'type'              => 'theme_mod',
		    'sanitize_callback' => 'mestore_sanitize_checkbox',
		) 
	);

	$wp_customize->add_control( 
		new MeStore_Toggle_Control( $wp_customize, 'mestore_enable_preloader', 
		array(
		    'label'       => esc_html__( 'Show Preloader', 'mestore' ),
		    'section'     => 'mestore_preloader_settings',
		    'type'        => 'mestore-toggle',
		    'settings'    => 'mestore_enable_preloader',
		) 
	));

	// Title label
	$wp_customize->add_setting( 
		'mestore_label_preloader_text_title', 
		array(
		    'sanitize_callback' => 'mestore_sanitize_title',
		) 
	);

	$wp_customize->add_control( 
		new MeStore_Title_Info_Control( $wp_customize, 'mestore_label_preloader_text_title', 
		array(
		    'label'       => esc_html__( 'Preloader Text', 'mestore' ),
		    'section'     => 'mestore_preloader_settings',
		    'type'        => 'mestore-title',
		    'settings'    => 'mestore_label_preloader_text_title',
		) 
	));


	// Add text
    $wp_customize->add_setting(
        'mestore_preloader_text',
        array(
            'type' => 'theme_mod',
            'default'           => esc_html__( 'loading', 'mestore' ),
            'sanitize_callback' => 'mestore_sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'mestore_preloader_text',
        array(
            'settings'      => 'mestore_preloader_text',
            'section'       => 'mestore_preloader_settings',
            'type'          => 'textbox',
            'label'         => esc_html__( 'Preloader Text', 'mestore' ),
        )
    );

}
endif;

add_action( 'customize_register', 'mestore_customizer_preloader_register' );