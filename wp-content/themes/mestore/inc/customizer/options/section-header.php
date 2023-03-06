<?php
/**
 * Theme Customizer Controls
 *
 * @package mestore
 */


if ( ! function_exists( 'mestore_customizer_header_register' ) ) :
function mestore_customizer_header_register( $wp_customize ) {

	$wp_customize->add_panel(
        'mestore_header_settings_panel',
        array (
            'priority'      => 30,
            'capability'    => 'edit_theme_options',
            'title'         => esc_html__( 'Header Settings', 'mestore' ),
        )
    );

	// Section Top bar ===================================================
    $wp_customize->add_section(
        'mestore_header_topbar_settings',
        array (
            'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'title'         => esc_html__( 'Top Bar', 'mestore' ),
            'panel'          => 'mestore_header_settings_panel',
        )
    ); 

    // Title label
	$wp_customize->add_setting( 
		'mestore_label_header_topbar_show', 
		array(
		    'sanitize_callback' => 'mestore_sanitize_title',
		) 
	);

	$wp_customize->add_control( 
		new MeStore_Title_Info_Control( $wp_customize, 'mestore_label_header_topbar_show', 
		array(
		    'label'       => esc_html__( 'Top Bar Settings', 'mestore' ),
		    'section'     => 'mestore_header_topbar_settings',
		    'type'        => 'mestore-title',
		    'settings'    => 'mestore_label_header_topbar_show',
		) 
	));

	// Add an option to enable the top bar
	$wp_customize->add_setting( 
		'mestore_enable_header_topbar', 
		array(
		    'default'           => true,
		    'type'              => 'theme_mod',
		    'sanitize_callback' => 'mestore_sanitize_checkbox',
		) 
	);

	$wp_customize->add_control( 
		new MeStore_Toggle_Control( $wp_customize, 'mestore_enable_header_topbar', 
		array(
		    'label'       => esc_html__( 'Show Topbar', 'mestore' ),
		    'section'     => 'mestore_header_topbar_settings',
		    'type'        => 'mestore-toggle',
		    'settings'    => 'mestore_enable_header_topbar',
		) 
	));

	// Info label
    $wp_customize->add_setting( 
        'mestore_label_top_bar_info', 
        array(
            'sanitize_callback' => 'mestore_sanitize_title',
        ) 
    );

    $wp_customize->add_control( 
        new MeStore_Info_Control( $wp_customize, 'mestore_label_top_bar_info', 
        array(
            'label'       => esc_html__( 'To show top bar, Go to Appearance -> Widgets and drag widgets to the Topbar Sidebar', 'mestore' ),
            'section'     => 'mestore_header_topbar_settings',
            'type'        => 'mestore-info',
            'settings'    => 'mestore_label_top_bar_info',
            'active_callback' => 'mestore_header_topbar_enable',
        ) 
    ));


    if ( mestore_is_active_woocommerce() ) :

		// Section Category Menu ===================================================
	    $wp_customize->add_section(
	        'mestore_header_category_menu_settings',
	        array (
	            'priority'      => 25,
	            'capability'    => 'edit_theme_options',
	            'title'         => esc_html__( 'Category Menu', 'mestore' ),
	            'panel'          => 'mestore_header_settings_panel',
	        )
	    ); 

	    // Title label
		$wp_customize->add_setting( 
			'mestore_label_header_category_menu_show', 
			array(
			    'sanitize_callback' => 'mestore_sanitize_title',
			) 
		);

		$wp_customize->add_control( 
			new MeStore_Title_Info_Control( $wp_customize, 'mestore_label_header_category_menu_show', 
			array(
			    'label'       => esc_html__( 'Category Menu Settings', 'mestore' ),
			    'section'     => 'mestore_header_category_menu_settings',
			    'type'        => 'mestore-title',
			    'settings'    => 'mestore_label_header_category_menu_show',
			) 
		));

		// Add an option to enable the category menu
		$wp_customize->add_setting( 
			'mestore_enable_header_category_menu', 
			array(
			    'default'           => true,
			    'type'              => 'theme_mod',
			    'sanitize_callback' => 'mestore_sanitize_checkbox',
			) 
		);

		$wp_customize->add_control( 
			new MeStore_Toggle_Control( $wp_customize, 'mestore_enable_header_category_menu', 
			array(
			    'label'       => esc_html__( 'Show Category Menu', 'mestore' ),
			    'section'     => 'mestore_header_category_menu_settings',
			    'type'        => 'mestore-toggle',
			    'settings'    => 'mestore_enable_header_category_menu',
			) 
		));

		// Title label
		$wp_customize->add_setting( 
			'mestore_label_header_category_menu_heading', 
			array(
			    'sanitize_callback' => 'mestore_sanitize_title',
			) 
		);

		$wp_customize->add_control( 
			new MeStore_Title_Info_Control( $wp_customize, 'mestore_label_header_category_menu_heading', 
			array(
			    'label'       => esc_html__( 'Category Menu Heading', 'mestore' ),
			    'section'     => 'mestore_header_category_menu_settings',
			    'type'        => 'mestore-title',
			    'settings'    => 'mestore_label_header_category_menu_heading',
			    'active_callback' => 'mestore_header_product_category_menu_enable',
			) 
		));

		// Add category heading text
	    $wp_customize->add_setting(
	        'mestore_header_category_heading_text',
	        array(
	            'type' => 'theme_mod',
	            'default'           => esc_html__( 'All Departments', 'mestore' ),
	            'sanitize_callback' => 'mestore_sanitize_text_field',
	        )
	    );

	    $wp_customize->add_control(
	        'mestore_header_category_heading_text',
	        array(
	            'settings'      => 'mestore_header_category_heading_text',
	            'section'       => 'mestore_header_category_menu_settings',
	            'type'          => 'textbox',
	            'label'         => esc_html__( 'Category Menu Heading', 'mestore' ),
	            'active_callback' => 'mestore_header_product_category_menu_enable',
	        )
	    );

		// Info label
	    $wp_customize->add_setting( 
	        'mestore_label_header_product_custom_menu_info', 
	        array(
	            'sanitize_callback' => 'mestore_sanitize_title',
	        ) 
	    );

	    $wp_customize->add_control( 
	        new MeStore_Info_Control( $wp_customize, 'mestore_label_header_product_custom_menu_info', 
	        array(
	            'label'       => esc_html__( 'To show the menu, Please first create a new menu ( Appearance -> Menus ) and then set its display location to "Category Menu". You can create a menu up to 3 nested levels.', 'mestore' ),
	            'section'     => 'mestore_header_category_menu_settings',
	            'type'        => 'mestore-info',
	            'settings'    => 'mestore_label_header_product_custom_menu_info',
	            'active_callback'  => 'mestore_header_product_custom_menu_enable',
	        ) 
	    ));


		// Section Product Search ===================================================
	    $wp_customize->add_section(
	        'mestore_header_product_search_settings',
	        array (
	            'priority'      => 25,
	            'capability'    => 'edit_theme_options',
	            'title'         => esc_html__( 'Product Search', 'mestore' ),
	            'panel'          => 'mestore_header_settings_panel',
	        )
	    ); 

	    // Title label
		$wp_customize->add_setting( 
			'mestore_label_header_product_search_show', 
			array(
			    'sanitize_callback' => 'mestore_sanitize_title',
			) 
		);

		$wp_customize->add_control( 
			new MeStore_Title_Info_Control( $wp_customize, 'mestore_label_header_product_search_show', 
			array(
			    'label'       => esc_html__( 'Product Search Settings', 'mestore' ),
			    'section'     => 'mestore_header_product_search_settings',
			    'type'        => 'mestore-title',
			    'settings'    => 'mestore_label_header_product_search_show',
			) 
		));

		// Add an option to enable the product search
		$wp_customize->add_setting( 
			'mestore_enable_header_product_search', 
			array(
			    'default'           => true,
			    'type'              => 'theme_mod',
			    'sanitize_callback' => 'mestore_sanitize_checkbox',
			) 
		);

		$wp_customize->add_control( 
			new MeStore_Toggle_Control( $wp_customize, 'mestore_enable_header_product_search', 
			array(
			    'label'       => esc_html__( 'Show Product Search', 'mestore' ),
			    'section'     => 'mestore_header_product_search_settings',
			    'type'        => 'mestore-toggle',
			    'settings'    => 'mestore_enable_header_product_search',
			) 
		));

		// Title label
		$wp_customize->add_setting( 
			'mestore_label_header_product_search_placeholder', 
			array(
			    'sanitize_callback' => 'mestore_sanitize_title',
			) 
		);

		$wp_customize->add_control( 
			new MeStore_Title_Info_Control( $wp_customize, 'mestore_label_header_product_search_placeholder', 
			array(
			    'label'       => esc_html__( 'Search placeholder Settings', 'mestore' ),
			    'section'     => 'mestore_header_product_search_settings',
			    'type'        => 'mestore-title',
			    'settings'    => 'mestore_label_header_product_search_placeholder',
			    'active_callback' => 'mestore_header_product_search_enable',
			) 
		));

		// Add placeholder for search
	    $wp_customize->add_setting(
	        'mestore_header_product_search_placeholder',
	        array(
	            'type' => 'theme_mod',
	            'default'           => esc_html__( 'Search Products', 'mestore' ),
	            'sanitize_callback' => 'mestore_sanitize_text_field',
	        )
	    );

	    $wp_customize->add_control(
	        'mestore_header_product_search_placeholder',
	        array(
	            'settings'      => 'mestore_header_product_search_placeholder',
	            'section'       => 'mestore_header_product_search_settings',
	            'type'          => 'textbox',
	            'label'         => esc_html__( 'Placeholder Text', 'mestore' ),
	            'active_callback' => 'mestore_header_product_search_enable',
	        )
	    );

		// Section Login Links ===================================================
	    $wp_customize->add_section(
	        'mestore_header_login_register_links_settings',
	        array (
	            'priority'      => 25,
	            'capability'    => 'edit_theme_options',
	            'title'         => esc_html__( 'Login Link', 'mestore' ),
	            'panel'          => 'mestore_header_settings_panel',
	        )
	    ); 

	    // Title label
		$wp_customize->add_setting( 
			'mestore_label_header_login_register_links_show', 
			array(
			    'sanitize_callback' => 'mestore_sanitize_title',
			) 
		);

		$wp_customize->add_control( 
			new MeStore_Title_Info_Control( $wp_customize, 'mestore_label_header_login_register_links_show', 
			array(
			    'label'       => esc_html__( 'Login Link Settings', 'mestore' ),
			    'section'     => 'mestore_header_login_register_links_settings',
			    'type'        => 'mestore-title',
			    'settings'    => 'mestore_label_header_login_register_links_show',
			) 
		));

		// Add an option to enable the links
		$wp_customize->add_setting( 
			'mestore_enable_header_login_register_links', 
			array(
			    'default'           => true,
			    'type'              => 'theme_mod',
			    'sanitize_callback' => 'mestore_sanitize_checkbox',
			) 
		);

		$wp_customize->add_control( 
			new MeStore_Toggle_Control( $wp_customize, 'mestore_enable_header_login_register_links', 
			array(
			    'label'       => esc_html__( 'Show Link', 'mestore' ),
			    'section'     => 'mestore_header_login_register_links_settings',
			    'type'        => 'mestore-toggle',
			    'settings'    => 'mestore_enable_header_login_register_links',
			) 
		));


		// Section Cart ===================================================
	    $wp_customize->add_section(
	        'mestore_header_menucart_settings',
	        array (
	            'priority'      => 25,
	            'capability'    => 'edit_theme_options',
	            'title'         => esc_html__( 'Cart', 'mestore' ),
	            'panel'          => 'mestore_header_settings_panel',
	        )
	    ); 

	    // Title label
		$wp_customize->add_setting( 
			'mestore_label_header_menucart_show', 
			array(
			    'sanitize_callback' => 'mestore_sanitize_title',
			) 
		);

		$wp_customize->add_control( 
			new MeStore_Title_Info_Control( $wp_customize, 'mestore_label_header_menucart_show', 
			array(
			    'label'       => esc_html__( 'Cart Settings', 'mestore' ),
			    'section'     => 'mestore_header_menucart_settings',
			    'type'        => 'mestore-title',
			    'settings'    => 'mestore_label_header_menucart_show',
			) 
		));

		// Add an option to enable the menu cart
		$wp_customize->add_setting( 
			'mestore_enable_header_menucart', 
			array(
			    'default'           => true,
			    'type'              => 'theme_mod',
			    'sanitize_callback' => 'mestore_sanitize_checkbox',
			) 
		);

		$wp_customize->add_control( 
			new MeStore_Toggle_Control( $wp_customize, 'mestore_enable_header_menucart', 
			array(
			    'label'       => esc_html__( 'Show Cart', 'mestore' ),
			    'section'     => 'mestore_header_menucart_settings',
			    'type'        => 'mestore-toggle',
			    'settings'    => 'mestore_enable_header_menucart',
			) 
		));

		// Title label
		$wp_customize->add_setting( 
			'mestore_label_header_menucart_style_show', 
			array(
			    'sanitize_callback' => 'mestore_sanitize_title',
			) 
		);

		$wp_customize->add_control( 
			new MeStore_Title_Info_Control( $wp_customize, 'mestore_label_header_menucart_style_show', 
			array(
			    'label'       => esc_html__( 'Change Cart Style', 'mestore' ),
			    'section'     => 'mestore_header_menucart_settings',
			    'type'        => 'mestore-title',
			    'settings'    => 'mestore_label_header_menucart_style_show',
			    'active_callback' => 'mestore_header_menucart_enable',
			) 
		));

		// Add an option to enable the dark style cart
		$wp_customize->add_setting( 
			'mestore_enable_header_menucart_dark_style', 
			array(
			    'default'           => false,
			    'type'              => 'theme_mod',
			    'sanitize_callback' => 'mestore_sanitize_checkbox',
			) 
		);

		$wp_customize->add_control( 
			new MeStore_Toggle_Control( $wp_customize, 'mestore_enable_header_menucart_dark_style', 
			array(
			    'label'       => esc_html__( 'Change Cart Style to Black', 'mestore' ),
			    'section'     => 'mestore_header_menucart_settings',
			    'type'        => 'mestore-toggle',
			    'settings'    => 'mestore_enable_header_menucart_dark_style',
			    'active_callback' => 'mestore_header_menucart_enable',
			) 
		));
	endif;


}
endif;

add_action( 'customize_register', 'mestore_customizer_header_register' );