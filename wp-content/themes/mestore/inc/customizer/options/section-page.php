<?php
/**
 * Theme Customizer Controls
 *
 * @package mestore
 */


if ( ! function_exists( 'mestore_customizer_page_register' ) ) :
function mestore_customizer_page_register( $wp_customize ) {
 
 	$wp_customize->add_section(
        'mestore_page_settings',
        array (
            'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'title'         => esc_html__( 'Pages Settings', 'mestore' )
        )
    );

    // Title label
	$wp_customize->add_setting( 
		'mestore_label_page_settings_title', 
		array(
		    'sanitize_callback' => 'mestore_sanitize_title',
		) 
	);

	$wp_customize->add_control( 
		new MeStore_Title_Info_Control( $wp_customize, 'mestore_label_page_settings_title', 
		array(
		    'label'       => esc_html__( 'Page Settings', 'mestore' ),
		    'section'     => 'mestore_page_settings',
		    'type'        => 'mestore-title',
		    'settings'    => 'mestore_label_page_settings_title',
		) 
	));

	// Add an option to enable the page title
	$wp_customize->add_setting( 
		'mestore_enable_page_title', 
		array(
		    'default'           => true,
		    'type'              => 'theme_mod',
		    'sanitize_callback' => 'mestore_sanitize_checkbox',
		) 
	);

	$wp_customize->add_control( 
		new MeStore_Toggle_Control( $wp_customize, 'mestore_enable_page_title', 
		array(
		    'label'       => esc_html__( 'Show Page Title', 'mestore' ),
		    'section'     => 'mestore_page_settings',
		    'type'        => 'mestore-toggle',
		    'settings'    => 'mestore_enable_page_title',
		) 
	));

	// Add an option to enable the page title background
	$wp_customize->add_setting( 
		'mestore_enable_page_title_bg', 
		array(
		    'default'           => false,
		    'type'              => 'theme_mod',
		    'sanitize_callback' => 'mestore_sanitize_checkbox',
		) 
	);

	$wp_customize->add_control( 
		new MeStore_Toggle_Control( $wp_customize, 'mestore_enable_page_title_bg', 
		array(
		    'label'       => esc_html__( 'Show Page Title background', 'mestore' ),
		    'section'     => 'mestore_page_settings',
		    'type'        => 'mestore-toggle',
		    'settings'    => 'mestore_enable_page_title_bg',
		    'active_callback' => 'mestore_page_title_enable',
		) 
	));

	// Title label
	$wp_customize->add_setting( 
		'mestore_label_page_sidebar_settings', 
		array(
		    'sanitize_callback' => 'mestore_sanitize_title',
		) 
	);

	$wp_customize->add_control( 
		new MeStore_Title_Info_Control( $wp_customize, 'mestore_label_page_sidebar_settings', 
		array(
		    'label'       => esc_html__( 'Sidebar Settings', 'mestore' ),
		    'section'     => 'mestore_page_settings',
		    'type'        => 'mestore-title',
		    'settings'    => 'mestore_label_page_sidebar_settings',
		) 
	));

	// Add an option to enable the page sidebar
	$wp_customize->add_setting( 
		'mestore_enable_page_sidebar', 
		array(
		    'default'           => false,
		    'type'              => 'theme_mod',
		    'sanitize_callback' => 'mestore_sanitize_checkbox',
		) 
	);

	$wp_customize->add_control( 
		new MeStore_Toggle_Control( $wp_customize, 'mestore_enable_page_sidebar', 
		array(
		    'label'       => esc_html__( 'Show Sidebar', 'mestore' ),
		    'section'     => 'mestore_page_settings',
		    'type'        => 'mestore-toggle',
		    'settings'    => 'mestore_enable_page_sidebar',
		) 
	));

	// Sidebar layout
    $wp_customize->add_setting(
        'mestore_page_sidebar_layout',
        array(
            'default'			=> 'no',
            'type'				=> 'theme_mod',
            'capability'		=> 'edit_theme_options',
            'sanitize_callback'	=> 'mestore_sanitize_select',
        )
    );
    $wp_customize->add_control(
        new MeStore_Radio_Image_Control( $wp_customize,'mestore_page_sidebar_layout',
            array(
                'settings'		=> 'mestore_page_sidebar_layout',
                'section'		=> 'mestore_page_settings',
                'label'			=> esc_html__( 'Sidebar Layout', 'mestore' ),
                'choices'		=> array(
                    'right'	        => MESTORE_DIR_URI . '/inc/customizer/assets/images/cr.png',
                    'left' 	        => MESTORE_DIR_URI . '/inc/customizer/assets/images/cl.png',
                    'no' 	        => MESTORE_DIR_URI . '/inc/customizer/assets/images/cn.png',
                ),
                'active_callback' => 'mestore_page_sidebar_enable',
            )
        )
    );

}
endif;

add_action( 'customize_register', 'mestore_customizer_page_register' );