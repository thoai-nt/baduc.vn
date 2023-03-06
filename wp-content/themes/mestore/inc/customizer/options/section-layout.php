<?php
/**
 * Theme Customizer Controls
 *
 * @package mestore
 */


if ( ! function_exists( 'mestore_customizer_layout_register' ) ) :
function mestore_customizer_layout_register( $wp_customize ) {
 
 	$wp_customize->add_section(
        'mestore_layout_settings',
        array (
            'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'title'         => esc_html__( 'Layout Settings', 'mestore' )
        )
    );

    // Title label
	$wp_customize->add_setting( 
		'mestore_label_layout_settings_title', 
		array(
		    'sanitize_callback' => 'mestore_sanitize_title',
		) 
	);

	$wp_customize->add_control( 
		new MeStore_Title_Info_Control( $wp_customize, 'mestore_label_layout_settings_title', 
		array(
		    'label'       => esc_html__( 'Content Width Settings', 'mestore' ),
		    'section'     => 'mestore_layout_settings',
		    'type'        => 'mestore-title',
		    'settings'    => 'mestore_label_layout_settings_title',
		) 
	));

	//Layout options
    $wp_customize->add_setting(
        'mestore_layout_content_width_ratio',
        array(
            'type' => 'theme_mod',
            'default'           => 'os-container',
            'sanitize_callback' => 'mestore_layout_content_width_options_selection'
        )
    );

    $wp_customize->add_control(
        'mestore_layout_content_width_ratio',
        array(
            'settings'      => 'mestore_layout_content_width_ratio',
            'section'       => 'mestore_layout_settings',
            'type'          => 'radio',
            'label'         => esc_html__( 'Choose Content Width Option:', 'mestore' ),
            'choices' => array(
            	'os-container' => esc_html__('1350px (default)', 'mestore'),
            	'container' => esc_html__('1170px', 'mestore'),
            ),
        )
    );

    // Info label
    $wp_customize->add_setting( 
        'mestore_layout_width_ratio_label', 
        array(
            'sanitize_callback' => 'mestore_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new MeStore_Info_Control( $wp_customize, 'mestore_layout_width_ratio_label', 
        array(
            'label'       => esc_html__( 'You might need to refresh the page to see the changes', 'mestore' ),
            'section'     => 'mestore_layout_settings',
            'type'        => 'mestore-info',
            'settings'    => 'mestore_layout_width_ratio_label',
            'active_callback' => '',
        ) 
    ));

    // Info label
    $wp_customize->add_setting( 
        'mestore_layout_width_ratio_doc_check', 
        array(
            'sanitize_callback' => 'mestore_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new MeStore_Info_Control( $wp_customize, 'mestore_layout_width_ratio_doc_check', 
        array(
            'label'       => esc_html__( 'NOTE: Please refer to the online documentation ("How to Set Page Width in Elementor ?") also after you change this setting', 'mestore' ),
            'section'     => 'mestore_layout_settings',
            'type'        => 'mestore-info',
            'settings'    => 'mestore_layout_width_ratio_doc_check',
            'active_callback' => '',
        ) 
    ));

}
endif;

add_action( 'customize_register', 'mestore_customizer_layout_register' );