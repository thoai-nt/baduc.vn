<?php
/**
 * Theme Customizer Controls
 *
 * @package mestore
 */


if ( ! function_exists( 'mestore_customizer_color_register' ) ) :
function mestore_customizer_color_register( $wp_customize ) {
 
 	$wp_customize->add_section(
        'mestore_color_settings',
        array (
            'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'title'         => esc_html__( 'Color Settings', 'mestore' )
        )
    );

    // Title label
	$wp_customize->add_setting( 
		'mestore_label_color_settings_title', 
		array(
		    'sanitize_callback' => 'mestore_sanitize_title',
		) 
	);

	$wp_customize->add_control( 
		new MeStore_Title_Info_Control( $wp_customize, 'mestore_label_color_settings_title', 
		array(
		    'label'       => esc_html__( 'Color Settings', 'mestore' ),
		    'section'     => 'mestore_color_settings',
		    'type'        => 'mestore-title',
		    'settings'    => 'mestore_label_color_settings_title',
		) 
	));

	// Primary color
    $wp_customize->add_setting(
        'mestore_site_primary_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#ed516c',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        	$wp_customize,
        	'mestore_site_primary_color',
	        array(
	        	'label'      => esc_html__( 'Primary Color', 'mestore' ),
	        	'section'    => 'mestore_color_settings',
	        	'settings'   => 'mestore_site_primary_color',
	        )
	    )
    );

    // Secondary color
    $wp_customize->add_setting(
        'mestore_site_secondary_color',
        array(
            'type' => 'theme_mod',
            'default'           => '#ca2e49',
            'sanitize_callback' => 'sanitize_hex_color'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
        	$wp_customize,
        	'mestore_site_secondary_color',
	        array(
	        	'label'      => esc_html__( 'Secondary Color', 'mestore' ),
	        	'section'    => 'mestore_color_settings',
	        	'settings'   => 'mestore_site_secondary_color',
	        )
	    )
    );

}
endif;

add_action( 'customize_register', 'mestore_customizer_color_register' );