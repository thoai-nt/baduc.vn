<?php
/**
 * Theme Customizer Controls
 *
 * @package mestore
 */


if ( ! function_exists( 'mestore_customizer_footer_register' ) ) :
function mestore_customizer_footer_register( $wp_customize ) {
 	
 	$wp_customize->add_section(
        'mestore_footer_settings',
        array (
            'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'title'         => esc_html__( 'Footer Settings', 'mestore' )
        )
    );

    // Title label
	$wp_customize->add_setting( 
		'mestore_label_footer_settings_title', 
		array(
		    'sanitize_callback' => 'mestore_sanitize_title',
		) 
	);

	$wp_customize->add_control( 
		new MeStore_Title_Info_Control( $wp_customize, 'mestore_label_footer_settings_title', 
		array(
		    'label'       => esc_html__( 'Footer Settings', 'mestore' ),
		    'section'     => 'mestore_footer_settings',
		    'type'        => 'mestore-title',
		    'settings'    => 'mestore_label_footer_settings_title',
		) 
	));

	// Copyright text
    $wp_customize->add_setting(
        'mestore_footer_copyright_text',
        array(
            'type' => 'theme_mod',
            'sanitize_callback' => 'mestore_sanitize_textarea_field'
        )
    );

    $wp_customize->add_control(
        'mestore_footer_copyright_text',
        array(
            'settings'      => 'mestore_footer_copyright_text',
            'section'       => 'mestore_footer_settings',
            'type'          => 'textarea',
            'label'         => esc_html__( 'Footer Copyright Text', 'mestore' ),
            'description'   => esc_html__( 'Copyright text to be displayed in the footer. No HTML allowed.', 'mestore' )
        )
    ); 

}
endif;

add_action( 'customize_register', 'mestore_customizer_footer_register' );