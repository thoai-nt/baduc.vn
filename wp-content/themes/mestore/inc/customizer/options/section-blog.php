<?php
/**
 * Theme Customizer Controls
 *
 * @package mestore
 */


if ( ! function_exists( 'mestore_customizer_blog_register' ) ) :
function mestore_customizer_blog_register( $wp_customize ) {
	
	$wp_customize->add_panel(
        'mestore_blog_settings_panel',
        array (
            'priority'      => 30,
            'capability'    => 'edit_theme_options',
            'title'         => esc_html__( 'Blog Settings', 'mestore' ),
        )
    );

	// Section Posts ===================================================
    $wp_customize->add_section(
        'mestore_posts_settings',
        array (
        	'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'title'         => esc_html__( 'Posts', 'mestore' ),
            'panel'          => 'mestore_blog_settings_panel',
        )
    ); 

	// Title label
	$wp_customize->add_setting( 
		'mestore_label_sidebar_layout', 
		array(
		    'sanitize_callback' => 'mestore_sanitize_title',
		) 
	);

	$wp_customize->add_control( 
		new MeStore_Title_Info_Control( $wp_customize, 'mestore_label_sidebar_layout', 
		array(
		    'label'       => esc_html__( 'Sidebar', 'mestore' ),
		    'section'     => 'mestore_posts_settings',
		    'type'        => 'mestore-title',
		    'settings'    => 'mestore_label_sidebar_layout',
		) 
	));

	// Sidebar layout
    $wp_customize->add_setting(
        'mestore_blog_sidebar_layout',
        array(
            'default'			=> 'right',
            'type'				=> 'theme_mod',
            'capability'		=> 'edit_theme_options',
            'sanitize_callback'	=> 'mestore_sanitize_select'
        )
    );
    $wp_customize->add_control(
        new MeStore_Radio_Image_Control( $wp_customize,'mestore_blog_sidebar_layout',
            array(
                'settings'		=> 'mestore_blog_sidebar_layout',
                'section'		=> 'mestore_posts_settings',
                'label'			=> esc_html__( 'Sidebar Layout', 'mestore' ),
                'choices'		=> array(
                    'right'	        => MESTORE_DIR_URI . '/inc/customizer/assets/images/cr.png',
                    'left' 	        => MESTORE_DIR_URI . '/inc/customizer/assets/images/cl.png',
                    'no' 	        => MESTORE_DIR_URI . '/inc/customizer/assets/images/cn.png',
                )
            )
        )
    );


	// Section Single Post ===================================================
    $wp_customize->add_section(
        'mestore_single_post_settings',
        array (
        	'priority'      => 25,
            'capability'    => 'edit_theme_options',
            'title'         => esc_html__( 'Single Post', 'mestore' ),
            'panel'          => 'mestore_blog_settings_panel',
        )
    ); 

    // Title label
	$wp_customize->add_setting( 
		'mestore_label_single_post_category_show', 
		array(
		    'sanitize_callback' => 'mestore_sanitize_title',
		) 
	);

	$wp_customize->add_control( 
		new MeStore_Title_Info_Control( $wp_customize, 'mestore_label_single_post_category_show', 
		array(
		    'label'       => esc_html__( 'Post Category', 'mestore' ),
		    'section'     => 'mestore_single_post_settings',
		    'type'        => 'mestore-title',
		    'settings'    => 'mestore_label_single_post_category_show',
		) 
	));

	// Add an option to enable the category
	$wp_customize->add_setting( 
		'mestore_enable_single_post_cat', 
		array(
		    'default'           => true,
		    'type'              => 'theme_mod',
		    'sanitize_callback' => 'mestore_sanitize_checkbox',
		) 
	);

	$wp_customize->add_control( 
		new MeStore_Toggle_Control( $wp_customize, 'mestore_enable_single_post_cat', 
		array(
		    'label'       => esc_html__( 'Show Category', 'mestore' ),
		    'section'     => 'mestore_single_post_settings',
		    'type'        => 'mestore-toggle',
		    'settings'    => 'mestore_enable_single_post_cat',
		) 
	));

	// Title label
	$wp_customize->add_setting( 
		'mestore_label_single_post_tag_show', 
		array(
		    'sanitize_callback' => 'mestore_sanitize_title',
		) 
	);

	$wp_customize->add_control( 
		new MeStore_Title_Info_Control( $wp_customize, 'mestore_label_single_post_tag_show', 
		array(
		    'label'       => esc_html__( 'Post Tags', 'mestore' ),
		    'section'     => 'mestore_single_post_settings',
		    'type'        => 'mestore-title',
		    'settings'    => 'mestore_label_single_post_tag_show',
		) 
	));

	// Add an option to enable the tags
	$wp_customize->add_setting( 
		'mestore_enable_single_post_tags', 
		array(
		    'default'           => true,
		    'type'              => 'theme_mod',
		    'sanitize_callback' => 'mestore_sanitize_checkbox',
		) 
	);

	$wp_customize->add_control( 
		new MeStore_Toggle_Control( $wp_customize, 'mestore_enable_single_post_tags', 
		array(
		    'label'       => esc_html__( 'Show Tags', 'mestore' ),
		    'section'     => 'mestore_single_post_settings',
		    'type'        => 'mestore-toggle',
		    'settings'    => 'mestore_enable_single_post_tags',
		) 
	));

	// Title label
	$wp_customize->add_setting( 
		'mestore_label_single_pos_meta_show', 
		array(
		    'sanitize_callback' => 'mestore_sanitize_title',
		) 
	);

	$wp_customize->add_control( 
		new MeStore_Title_Info_Control( $wp_customize, 'mestore_label_single_pos_meta_show', 
		array(
		    'label'       => esc_html__( 'Post Meta', 'mestore' ),
		    'section'     => 'mestore_single_post_settings',
		    'type'        => 'mestore-title',
		    'settings'    => 'mestore_label_single_pos_meta_show',
		) 
	));

	// Add an option to enable the date
	$wp_customize->add_setting( 
		'mestore_enable_single_post_meta_date', 
		array(
		    'default'           => true,
		    'type'              => 'theme_mod',
		    'sanitize_callback' => 'mestore_sanitize_checkbox',
		) 
	);

	$wp_customize->add_control( 
		new MeStore_Toggle_Control( $wp_customize, 'mestore_enable_single_post_meta_date', 
		array(
		    'label'       => esc_html__( 'Show Date', 'mestore' ),
		    'section'     => 'mestore_single_post_settings',
		    'type'        => 'mestore-toggle',
		    'settings'    => 'mestore_enable_single_post_meta_date',
		) 
	));

	// Add an option to enable the author
	$wp_customize->add_setting( 
		'mestore_enable_single_post_meta_author', 
		array(
		    'default'           => true,
		    'type'              => 'theme_mod',
		    'sanitize_callback' => 'mestore_sanitize_checkbox',
		) 
	);

	$wp_customize->add_control( 
		new MeStore_Toggle_Control( $wp_customize, 'mestore_enable_single_post_meta_author', 
		array(
		    'label'       => esc_html__( 'Show Author', 'mestore' ),
		    'section'     => 'mestore_single_post_settings',
		    'type'        => 'mestore-toggle',
		    'settings'    => 'mestore_enable_single_post_meta_author',
		) 
	));

	// Add an option to enable the comments
	$wp_customize->add_setting( 
		'mestore_enable_single_post_meta_comments', 
		array(
		    'default'           => true,
		    'type'              => 'theme_mod',
		    'sanitize_callback' => 'mestore_sanitize_checkbox',
		) 
	);

	$wp_customize->add_control( 
		new MeStore_Toggle_Control( $wp_customize, 'mestore_enable_single_post_meta_comments', 
		array(
		    'label'       => esc_html__( 'Show Comments', 'mestore' ),
		    'section'     => 'mestore_single_post_settings',
		    'type'        => 'mestore-toggle',
		    'settings'    => 'mestore_enable_single_post_meta_comments',
		) 
	));

	// Title label
	$wp_customize->add_setting( 
		'mestore_label_single_sidebar_layout', 
		array(
		    'sanitize_callback' => 'mestore_sanitize_title',
		) 
	);

	$wp_customize->add_control( 
		new MeStore_Title_Info_Control( $wp_customize, 'mestore_label_single_sidebar_layout', 
		array(
		    'label'       => esc_html__( 'Sidebar', 'mestore' ),
		    'section'     => 'mestore_single_post_settings',
		    'type'        => 'mestore-title',
		    'settings'    => 'mestore_label_single_sidebar_layout',
		) 
	));

	// Sidebar layout
    $wp_customize->add_setting(
        'mestore_blog_single_sidebar_layout',
        array(
            'default'			=> 'no',
            'type'				=> 'theme_mod',
            'capability'		=> 'edit_theme_options',
            'sanitize_callback'	=> 'mestore_sanitize_select'
        )
    );
    $wp_customize->add_control(
        new MeStore_Radio_Image_Control( $wp_customize,'mestore_blog_single_sidebar_layout',
            array(
                'settings'		=> 'mestore_blog_single_sidebar_layout',
                'section'		=> 'mestore_single_post_settings',
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

add_action( 'customize_register', 'mestore_customizer_blog_register' );