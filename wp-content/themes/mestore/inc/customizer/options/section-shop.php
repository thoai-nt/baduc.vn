<?php
/**
 * Theme Customizer Controls
 *
 * @package mestore
 */


if ( ! function_exists( 'mestore_customizer_shop_register' ) ) :
function mestore_customizer_shop_register( $wp_customize ) {


    // Section Product Archive Page ===================================================
    $wp_customize->add_section(
        'mestore_shop_page_settings',
        array (
            'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'title'         => esc_html__( 'Product Archive', 'mestore' ),
            'panel'          => 'woocommerce',
        )
    ); 

    // Title label
    $wp_customize->add_setting( 
        'mestore_label_shop_page_show', 
        array(
            'sanitize_callback' => 'mestore_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new MeStore_Title_Info_Control( $wp_customize, 'mestore_label_shop_page_show', 
        array(
            'label'       => esc_html__( 'Product Archive Settings', 'mestore' ),
            'section'     => 'mestore_shop_page_settings',
            'type'        => 'mestore-title',
            'settings'    => 'mestore_label_shop_page_show',
        ) 
    ));

    // Sidebar layout
    $wp_customize->add_setting(
        'mestore_shop_page_sidebar_layout',
        array(
            'default'           => 'right',
            'type'              => 'theme_mod',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'mestore_sanitize_select'
        )
    );
    $wp_customize->add_control(
        new MeStore_Radio_Image_Control( $wp_customize,'mestore_shop_page_sidebar_layout',
            array(
                'settings'      => 'mestore_shop_page_sidebar_layout',
                'section'       => 'mestore_shop_page_settings',
                'label'         => esc_html__( 'Sidebar Layout', 'mestore' ),
                'choices'       => array(
                    'right'         => MESTORE_DIR_URI . '/inc/customizer/assets/images/cr.png',
                    'left'          => MESTORE_DIR_URI . '/inc/customizer/assets/images/cl.png',
                    'no'            => MESTORE_DIR_URI . '/inc/customizer/assets/images/cn.png',
                )
            )
        )
    );

	// Section Cart Sidebar ===================================================
    $wp_customize->add_section(
        'mestore_cart_sidebar_settings',
        array (
            'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'title'         => esc_html__( 'Cart Sidebar', 'mestore' ),
            'panel'          => 'woocommerce',
        )
    ); 

    // Title label
	$wp_customize->add_setting( 
		'mestore_label_cart_page_show', 
		array(
		    'sanitize_callback' => 'mestore_sanitize_title',
		) 
	);

	$wp_customize->add_control( 
		new MeStore_Title_Info_Control( $wp_customize, 'mestore_label_cart_page_show', 
		array(
		    'label'       => esc_html__( 'Cart Page Sidebar', 'mestore' ),
		    'section'     => 'mestore_cart_sidebar_settings',
		    'type'        => 'mestore-title',
		    'settings'    => 'mestore_label_cart_page_show',
		) 
	));

	// Sidebar layout
    $wp_customize->add_setting(
        'mestore_cart_page_sidebar_layout',
        array(
            'default'			=> 'no',
            'type'				=> 'theme_mod',
            'capability'		=> 'edit_theme_options',
            'sanitize_callback'	=> 'mestore_sanitize_select'
        )
    );
    $wp_customize->add_control(
        new MeStore_Radio_Image_Control( $wp_customize,'mestore_cart_page_sidebar_layout',
            array(
                'settings'		=> 'mestore_cart_page_sidebar_layout',
                'section'		=> 'mestore_cart_sidebar_settings',
                'label'			=> esc_html__( 'Sidebar Layout', 'mestore' ),
                'choices'		=> array(
                    'right'	        => MESTORE_DIR_URI . '/inc/customizer/assets/images/cr.png',
                    'left' 	        => MESTORE_DIR_URI . '/inc/customizer/assets/images/cl.png',
                    'no' 	        => MESTORE_DIR_URI . '/inc/customizer/assets/images/cn.png',
                )
            )
        )
    );


	// Section Checkout Page ===================================================
    $wp_customize->add_section(
        'mestore_checkout_sidebar_settings',
        array (
            'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'title'         => esc_html__( 'Checkout Sidebar', 'mestore' ),
            'panel'          => 'woocommerce',
        )
    ); 

    // Title label
	$wp_customize->add_setting( 
		'mestore_label_checkout_page_show', 
		array(
		    'sanitize_callback' => 'mestore_sanitize_title',
		) 
	);

	$wp_customize->add_control( 
		new MeStore_Title_Info_Control( $wp_customize, 'mestore_label_checkout_page_show', 
		array(
		    'label'       => esc_html__( 'Checkout Page Sidebar', 'mestore' ),
		    'section'     => 'mestore_checkout_sidebar_settings',
		    'type'        => 'mestore-title',
		    'settings'    => 'mestore_label_checkout_page_show',
		) 
	));
	
	// Sidebar layout
    $wp_customize->add_setting(
        'mestore_checkout_page_sidebar_layout',
        array(
            'default'			=> 'no',
            'type'				=> 'theme_mod',
            'capability'		=> 'edit_theme_options',
            'sanitize_callback'	=> 'mestore_sanitize_select'
        )
    );
    $wp_customize->add_control(
        new MeStore_Radio_Image_Control( $wp_customize,'mestore_checkout_page_sidebar_layout',
            array(
                'settings'		=> 'mestore_checkout_page_sidebar_layout',
                'section'		=> 'mestore_checkout_sidebar_settings',
                'label'			=> esc_html__( 'Sidebar Layout', 'mestore' ),
                'choices'		=> array(
                    'right'	        => MESTORE_DIR_URI . '/inc/customizer/assets/images/cr.png',
                    'left' 	        => MESTORE_DIR_URI . '/inc/customizer/assets/images/cl.png',
                    'no' 	        => MESTORE_DIR_URI . '/inc/customizer/assets/images/cn.png',
                )
            )
        )
    );

}
endif;

add_action( 'customize_register', 'mestore_customizer_shop_register' );