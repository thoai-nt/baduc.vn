<?php
/**
 * Theme Customizer Controls
 *
 * @package mestore
 */


if ( ! function_exists( 'mestore_customizer_misc_register' ) ) :
function mestore_customizer_misc_register( $wp_customize ) {
 
 	$wp_customize->add_section(
        'mestore_misc_settings',
        array (
            'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'title'         => esc_html__( 'Misc Settings', 'mestore' )
        )
    );

    // Title label
	$wp_customize->add_setting( 
		'mestore_label_wbe_settings_title', 
		array(
		    'sanitize_callback' => 'mestore_sanitize_title',
		) 
	);

	$wp_customize->add_control( 
		new MeStore_Title_Info_Control( $wp_customize, 'mestore_label_wbe_settings_title', 
		array(
		    'label'       => esc_html__( 'Widgets Block Editor Settings', 'mestore' ),
		    'section'     => 'mestore_misc_settings',
		    'type'        => 'mestore-title',
		    'settings'    => 'mestore_label_wbe_settings_title',
		) 
	));

	// Add an option to disable the widgets block editor
	$wp_customize->add_setting( 
		'mestore_disable_widgets_block_editor', 
		array(
		    'default'           => true,
		    'type'              => 'theme_mod',
		    'sanitize_callback' => 'mestore_sanitize_checkbox',
		) 
	);

	$wp_customize->add_control( 
		new MeStore_Toggle_Control( $wp_customize, 'mestore_disable_widgets_block_editor', 
		array(
		    'label'       => esc_html__( 'Disable Widgets Block Editor', 'mestore' ),
		    'section'     => 'mestore_misc_settings',
		    'type'        => 'mestore-toggle',
		    'settings'    => 'mestore_disable_widgets_block_editor',
		) 
	));

}
endif;

add_action( 'customize_register', 'mestore_customizer_misc_register' );