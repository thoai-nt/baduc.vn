<?php
/**
 * Portfolio masonry/grid.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

return array(
	'weight' => -1,
	'name' => __( 'Portfolio Masonry and Grid', 'dt-the7-core' ),
	'base' => 'dt_portfolio_masonry',
	'class' => 'dt_vc_sc_portfolio_masonry',
	'icon' => 'dt_vc_ico_portfolio',
	'category' => __( 'by Dream-Theme', 'dt-the7-core' ),
	'admin_enqueue_js' => array( plugin_dir_url( __FILE__ ) . 'portfolio-masonry/js/vc-editor-scripts.js' ),
	'front_enqueue_js' => array( plugin_dir_url( __FILE__ ) . 'portfolio-masonry/js/vc-editor-scripts.js' ),
	'params' => array(
		// General group.
		array(
			'heading' => __('Show', 'dt-the7-core'),
			'param_name' => 'post_type',
			'type' => 'dropdown',
			'std' => 'category',
			'value' => array(
				'All posts' => 'posts',
				'Posts from categories' => 'category',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'type' => 'autocomplete',
			'heading' => __( 'Choose posts', 'dt-the7-core' ),
			'param_name' => 'posts',
			'settings' => array(
				'multiple' => true,
				'min_length' => 0,
			),
			'save_always' => true,
			'description' => __( 'Field accept post ID, title. Leave empty to show all posts.', 'dt-the7-core' ),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'post_type',
				'value' => 'posts',
			),
		),
		array(
			'type' => 'autocomplete',
			'heading' => __( 'Choose post categories', 'dt-the7-core' ),
			'param_name' => 'category',
			'settings' => array(
				'multiple' => true,
				'min_length' => 0,
			),
			'save_always' => true,
			'description' => __( 'Field accept category ID, title, slug. Leave empty to show all posts.', 'dt-the7-core' ),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'post_type',
				'value' => 'category',
			),
		),
		// - Layout Settings.
		array(
			'heading' => __( 'Layout Settings', 'dt-the7-core' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
		),
		array(
			'heading' => __('Mode', 'dt-the7-core'),
			'param_name' => 'mode',
			'type' => 'dropdown',
			'value' => array(
				'Masonry' => 'masonry',
				'Grid' => 'grid',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			"heading" => __("Loading effect", 'dt-the7-core'),
			"param_name" => "loading_effect",
			"type" => "dropdown",
			"value" => array(
				'None' => 'none',
				'Fade in' => 'fade_in',
				'Move up' => 'move_up',
				'Scale up' => 'scale_up',
				'Fall perspective' => 'fall_perspective',
				'Fly' => 'fly',
				'Flip' => 'flip',
				'Helix' => 'helix',
				'Scale' => 'scale'
			),
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
		),
		array(
			'heading' => __('Layout', 'dt-the7-core'),
			'param_name' => 'layout',
			'type' => 'dt_radio_image',
			'value' => 'classic',
			'options' => array(
				'classic'       => array(
					'title' => _x( 'Classic', 'dt-the7-core' ),
					'src' => '/inc/shortcodes/images/portf-01.gif',
				),
				'bottom_overlap'        => array(
					'title' => _x( 'Bottom overlap (background)', 'dt-the7-core' ),
					'src' => '/inc/shortcodes/images/portf-02.gif',
				),
				'gradient_rollover'         => array(
					'title' => _x( 'Overlay (gradient)', 'dt-the7-core' ),
					'src' => '/inc/shortcodes/images/portf-04.gif',
				),
				'gradient_overlay'          => array(
					'title' => _x( 'Overlay (background)', 'dt-the7-core' ),
					'src' => '/inc/shortcodes/images/portf-03.gif',
				),
				'gradient_overlap'     => array(
					'title' => _x( 'Bottom overlap (gradient)', 'dt-the7-core' ),
					'src' => '/inc/shortcodes/images/portf-05.gif',
				),
			),
		),
		// -- Bottom overlap style.
		array(
			'heading' => __('Content area width', 'dt-the7-core'),
			'param_name' => 'bo_content_width',
			'type' => 'dt_number',
			'value' => '75%',
			'units' => '%, px',
			'min' => 0,
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'layout',
				'value' => 'bottom_overlap',
			),
		),
		array(
			'heading' => __('Content area overlap', 'dt-the7-core'),
			'param_name' => 'bo_content_overlap',
			'type' => 'dt_number',
			'value' => '100px',
			'units' => 'px',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			"dependency"	=> array(
				"element"		=> "layout",
				"value"			=> 'bottom_overlap',
			),
		),
		// -- Overlay (gradient).

		array(
			"heading"		=> __( "Animation", 'dt-the7-core' ),
			"param_name"	=> "hover_animation",
			"type"			=> "dropdown",
			"value"			=> array(
				'Fade'						=> 'fade',
				'Direction aware'			=> 'direction_aware',
				'Reverse direction aware'	=> 'redirection_aware',
				'Scale in'					=> 'scale_in',
			),
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
			"dependency"	=> array(
				"element"		=> "layout",
				"value"			=> 'gradient_overlay',
			),
		),

		array(
			'heading' => __('Content alignment', 'dt-the7-core'),
			'param_name' => 'content_alignment',
			'type' => 'dropdown',
			'std' => 'left',
			'value' => array(
				'Left' => 'left',
				'Center' => 'center',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		// - Content Area.
		array(
			'heading' => __( 'Content Area', 'dt-the7-core' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
		),
		array(
			'heading' => __('Show background', 'dt-the7-core'),
			'param_name' => 'content_bg',
			'type' => 'dt_switch',
			'value' => 'y',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			'dependency'	=> array(
				'element'	=> 'layout',
				'value' => array( 'classic', 'bottom_overlap', 'gradient_rollover', 'gradient_overlap' ),
			),
		),
		array(
			'heading'		=> __('Color', 'dt-the7-core'),
			'param_name'	=> 'custom_content_bg_color',
			'type'			=> 'colorpicker',
			'value'			=> '',
			'dependency'	=> array(
				'element'	=> 'content_bg',
				'value'		=> 'y',
			),
			'description'   => __( 'Leave empty to use default content boxes color & decoration. Note that decoration doesn\'t apply to gradient backgrounds.', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Content area paddings', 'dt-the7-core'),
			'param_name' => 'post_content_paddings',
			'type' => 'dt_spacing',
			'value' => '25px 30px 30px 30px',
			'units' => 'px',
		),
		// - Image Settings.
		array(
			'heading' => __( 'Image Settings', 'dt-the7-core' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
		),
		array(
			'heading' => __('Image sizing', 'dt-the7-core'),
			'param_name' => 'image_sizing',
			'type' => 'dropdown',
			'std' => 'resize',
			'value' => array(
				'Preserve images proportions' => 'proportional',
				'Resize images' => 'resize',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'headings' => array( __('Width', 'dt-the7-core'), __('Height', 'dt-the7-core') ),
			'param_name' => 'resized_image_dimensions',
			'type' => 'dt_dimensions',
			'value' => '1x1',
			'dependency' => array(
				'element' => 'image_sizing',
				'value' => 'resize',
			),
			'description' => __('Set image proportions, for example: 4x3, 3x2.', 'dt-the7-core'),
		),
		array(
			'heading' => __('Image border radius', 'dt-the7-core'),
			'param_name' => 'image_border_radius',
			'type' => 'dt_number',
			'value' => '0',
			'units' => 'px',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			"type" => "dropdown",
			"heading" => __("Image decoration", 'dt-the7-core'),
			"param_name" => "image_decoration",
			"value" => array(
				"None" => "none",
				"Shadow" => "shadow",
			),
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
		),
		array(
			'heading' => __('Horizontal length', 'dt-the7-core'),
			'param_name' => 'shadow_h_length',
			'type' => 'dt_number',
			'value' => '0px',
			'units' => 'px',
			'dependency' => array(
				'element' => 'image_decoration',
				'value' => 'shadow',
			),
		),
		array(
			'heading' => __('Vertical length', 'dt-the7-core'),
			'param_name' => 'shadow_v_length',
			'type' => 'dt_number',
			'value' => '4px',
			'units' => 'px',
			'dependency' => array(
				'element' => 'image_decoration',
				'value' => 'shadow',
			),
		),
		array(
			'heading' => __('Blur radius', 'dt-the7-core'),
			'param_name' => 'shadow_blur_radius',
			'type' => 'dt_number',
			'value' => '12px',
			'units' => 'px',
			'dependency' => array(
				'element' => 'image_decoration',
				'value' => 'shadow',
			),
		),
		array(
			'heading' => __('Spread', 'dt-the7-core'),
			'param_name' => 'shadow_spread',
			'type' => 'dt_number',
			'value' => '3px',
			'units' => 'px',
			'dependency' => array(
				'element' => 'image_decoration',
				'value' => 'shadow',
			),
		),
		array(
			"heading"		=> __("Shadow color", 'dt-the7-core'),
			"type"			=> "colorpicker",
			"param_name"	=> "shadow_color",
			"value"			=> 'rgba(0,0,0,.25)',
			'dependency' => array(
				'element' => 'image_decoration',
				'value' => 'shadow',
			),
		),
		array(
			'heading' => __('Image paddings', 'dt-the7-core'),
			'param_name' => 'image_paddings',
			'type' => 'dt_spacing',
			'value' => '0px 0px 0px 0px',
			'units' => 'px, %',
		),
		array(
			'heading' => __('Scale animation on hover', 'dt-the7-core'),
			'param_name' => 'image_scale_animation_on_hover',
			'type' => 'dropdown',
			'std' => 'quick_scale',
			'value' => array(
				'Disabled' => 'disabled',
				'Quick scale' => 'quick_scale',
				'Slow scale' => 'slow_scale',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),

		array(
			'heading'          => __( 'Hover background color', 'dt-the7-core' ),
			'param_name'       => 'image_hover_bg_color',
			'type'             => 'dropdown',
			'std'              => 'default',
			'value'            => array(
				'Disabled'    => 'disabled',
				'Default'     => 'default',
				'Mono color' => 'solid_rollover_bg',
				'Gradient'    => 'gradient_rollover_bg',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'heading'		=> __('Background color', 'dt-the7-core'),
			'param_name'	=> 'custom_rollover_bg_color',
			'type'			=> 'colorpicker',
			'value'			=> 'rgba(0,0,0,0.5)',
			'dependency'	=> array(
				'element'	=> 'image_hover_bg_color',
				'value' => array( 'solid_rollover_bg' ),
			),
		),
		array(
			'heading'    => __( 'Gradient', 'dt-the7-core' ),
			'param_name' => 'custom_rollover_bg_gradient',
			'type'       => 'dt_gradient_picker',
			'value'      => '45deg|rgba(12,239,154,0.8) 0%|rgba(0,108,220,0.8) 50%|rgba(184,38,220,0.8) 100%',
			'dependency' => array(
				'element' => 'image_hover_bg_color',
				'value'   => 'gradient_rollover_bg',
			),
		),
		// - Columns & Responsiveness.
		array(
			'heading' => __( 'Columns & Responsiveness', 'dt-the7-core' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
		),
		array(
			'heading' => __('Responsiveness mode', 'dt-the7-core'),
			'param_name' => 'responsiveness',
			'type' => 'dropdown',
			'value' => array(
				'Browser width based' => 'browser_width_based',
				'Post width based' => 'post_width_based',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		// -- Browser width based.
		array(
			'heading' => __('Number of columns', 'dt-the7-core'),
			'param_name' => 'bwb_columns',
			'type' => 'dt_responsive_columns',
			'value' => 'desktop:3|h_tablet:3|v_tablet:2|phone:1',
			'dependency'	=> array(
				'element'	=> 'responsiveness',
				'value'		=> 'browser_width_based',
			),
		),
		// -- Post width based.
		array(
			'heading' => __('Column minimum width', 'dt-the7-core'),
			'param_name' => 'pwb_column_min_width',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'dependency'	=> array(
				'element'	=> 'responsiveness',
				'value'		=> 'post_width_based',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(

			'heading' => __('Desired columns number', 'dt-the7-core'),
			'param_name' => 'pwb_columns',
			'type' => 'dt_number',
			'value' => '',
			'units' => '',
			'max' => 12,
			'description' => __('Affects only masonry layout', 'dt-the7-core'),
			"dependency" => array("element" => "responsiveness", "value" => 'post_width_based' ),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'heading' => __('Gap between columns', 'dt-the7-core'),
			'param_name' => 'gap_between_posts',
			'type' => 'dt_number',
			'value' => '15px',
			'units' => 'px',
			'description' => __('Please note that this setting affects post paddings. So, for example: a value 10px will give you 20px gaps between posts)', 'dt-the7-core'),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'heading' => __('Make all posts the same width', 'dt-the7-core'),
			'param_name' => 'all_posts_the_same_width',
			'type' => 'dropdown',
			'value' => array(
				'No (wide post fills 2 col.)' => 'n',
				'Yes (wide post fills 1 col.)' => 'y',
			),
			'description'   => __( 'Post wide/normal width can be chosen in single post options.', 'dt-the7-core' ),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),

		// Project group.
		// - Post Title.
		array(
			'heading' => __('Links lead to', 'dt-the7-core'),
			'param_name' => 'link_lead',
			'type' => 'dropdown',
			'value' => array(
				'Project details page' => 'go_to_project',
				'External project link' => 'follow_link',
			),
			'group' => __( 'Project', 'dt-the7-core' ),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'description' => __('Affects project title, button & image links. External links can be set up for every portfolio project individually.', 'dt-the7-core'),
		),
		array(
			'heading' => __( 'Project Title', 'dt-the7-core' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
			'group' => __( 'Project', 'dt-the7-core' ),
		),
		array(
			'heading' => __( 'Font style', 'dt-the7-core' ),
			'param_name' => 'post_title_font_style',
			'type' => 'dt_font_style',
			'value' => ':bold:',
			'group' => __( 'Project', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Font size', 'dt-the7-core'),
			'param_name' => 'post_title_font_size',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'description' => __( 'Leave empty to use H4 font size.', 'dt-the7-core' ),
			'group' => __( 'Project', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Line height', 'dt-the7-core'),
			'param_name' => 'post_title_line_height',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'description' => __( 'Leave empty to use H4 line height.', 'dt-the7-core' ),
			'group' => __( 'Project', 'dt-the7-core' ),
		),
		array(
			'heading'		=> __('Font color', 'dt-the7-core'),
			'param_name'	=> 'custom_title_color',
			'type'			=> 'colorpicker',
			'value'			=> '',
			'description' => __( 'Leave empty to use headers color.', 'dt-the7-core' ),
			'group' => __( 'Project', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Gap below title', 'dt-the7-core'),
			'param_name' => 'post_title_bottom_margin',
			'type' => 'dt_number',
			'value' => '5px',
			'units' => 'px',
			'group' => __( 'Project', 'dt-the7-core' ),
		),
		// - Meta Information.
		array(
			'heading' => __( 'Meta Information', 'dt-the7-core' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
			'group' => __( 'Project', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Show project date', 'dt-the7-core'),
			'param_name' => 'post_date',
			'type' => 'dt_switch',
			'value' => 'y',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			'group' => __( 'Project', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Show project categories', 'dt-the7-core'),
			'param_name' => 'post_category',
			'type' => 'dt_switch',
			'value' => 'y',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			'group' => __( 'Project', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Show project author', 'dt-the7-core'),
			'param_name' => 'post_author',
			'type' => 'dt_switch',
			'value' => 'y',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			'group' => __( 'Project', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Show project comments', 'dt-the7-core'),
			'param_name' => 'post_comments',
			'type' => 'dt_switch',
			'value' => 'y',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			'group' => __( 'Project', 'dt-the7-core' ),
		),
		array(
			'heading' => __( 'Font style', 'dt-the7-core' ),
			'param_name' => 'meta_info_font_style',
			'type' => 'dt_font_style',
			'value' => '',
			'group' => __( 'Project', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Font size', 'dt-the7-core'),
			'param_name' => 'meta_info_font_size',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'description' => __( 'Leave empty to use small font size.', 'dt-the7-core' ),
			'group' => __( 'Project', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Line height', 'dt-the7-core'),
			'param_name' => 'meta_info_line_height',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'description' => __( 'Leave empty to use small line height.', 'dt-the7-core' ),
			'group' => __( 'Project', 'dt-the7-core' ),
		),
		array(
			'heading'		=> __('Font color', 'dt-the7-core'),
			'param_name'	=> 'custom_meta_color',
			'type'			=> 'colorpicker',
			'value'			=> '',
			'description' => __( 'Leave empty to use secondary text color.', 'dt-the7-core' ),
			'group' => __( 'Project', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Gap below meta info', 'dt-the7-core'),
			'param_name' => 'meta_info_bottom_margin',
			'type' => 'dt_number',
			'value' => '15px',
			'units' => 'px',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'group' => __( 'Project', 'dt-the7-core' ),
		),
		// - Text.
		array(
			'heading' => __( 'Text', 'dt-the7-core' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
			'group' => __( 'Project', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Content or excerpt', 'dt-the7-core'),
			'param_name' => 'post_content',
			'type' => 'dropdown',
			'std' => 'show_excerpt',
			'value' => array(
				'Off' => 'off',
				'Excerpt' => 'show_excerpt',
				'Content' => 'show_content',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'group' => __( 'Project', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Maximum number of words', 'dt-the7-core'),
			'param_name' => 'excerpt_words_limit',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'post_content',
				'value' => 'show_excerpt',
			),

			'description' => __( 'Leave empty to show full text.', 'dt-the7-core' ),
			'group' => __( 'Project', 'dt-the7-core' ),
		),
		array(
			'heading' => __( 'Font style', 'dt-the7-core' ),
			'param_name' => 'content_font_style',
			'type' => 'dt_font_style',
			'value' => '',
			'dependency' => array(
				'element' => 'post_content',
				'value' => array( 'show_excerpt', 'show_content' ),
			),
			'group' => __( 'Project', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Font size', 'dt-the7-core'),
			'param_name' => 'content_font_size',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'dependency' => array(
				'element' => 'post_content',
				'value' => array( 'show_excerpt', 'show_content' ),
			),
			'description' => __( 'Leave empty to use medium font size.', 'dt-the7-core' ),
			'group' => __( 'Project', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Line height', 'dt-the7-core'),
			'param_name' => 'content_line_height',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'dependency' => array(
				'element' => 'post_content',
				'value' => array( 'show_excerpt', 'show_content' ),
			),
			'description' => __( 'Leave empty to use medium line height.', 'dt-the7-core' ),
			'group' => __( 'Project', 'dt-the7-core' ),
		),
		array(
			'heading'		=> __('Font color', 'dt-the7-core'),
			'param_name'	=> 'custom_content_color',
			'type'			=> 'colorpicker',
			'value'			=> '',
			'dependency' => array(
				'element' => 'post_content',
				'value' => array( 'show_excerpt', 'show_content' ),
			),
			'description' => __( 'Leave empty to use primary text color.', 'dt-the7-core' ),
			'group' => __( 'Project', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Gap below text', 'dt-the7-core'),
			'param_name' => 'content_bottom_margin',
			'type' => 'dt_number',
			'value' => '5px',
			'units' => 'px',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'post_content',
				'value' => array( 'show_excerpt', 'show_content' ),
			),
			'group' => __( 'Project', 'dt-the7-core' ),
		),
		// - "Read More" Button.
		array(
			'heading' => __( 'Button', 'dt-the7-core' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
			'group' => __( 'Project', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Button style', 'dt-the7-core'),
			'param_name' => 'read_more_button',
			'type' => 'dropdown',
			'std' => 'default_link',
			'value' => array(
				'Off' => 'off',
				'Default link' => 'default_link',
				'Default button' => 'default_button',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'group' => __( 'Project', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Button text', 'dt-the7-core'),
			'param_name' => 'read_more_button_text',
			'type' => 'textfield',
			'value' => __( 'Read more', 'dt-the7-core' ),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'read_more_button',
				'value'	=> array(
					'default_link',
					'default_button',
				),
			),
			'group' => __( 'Project', 'dt-the7-core' ),
		),
		//Icons
		array(
			"group" => __("Icons", 'dt-the7-core'),
			'heading' => __('External link', 'dt-the7-core'),
			'param_name' => 'show_link',
			'type' => 'dt_switch',
			'value' => 'y',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
		),
		array(
			"group" => __("Icons", 'dt-the7-core'),
			"heading" => __("Choose external link icon", "dt-the7-core"),
			"param_name" => "external_link_icon",
			"type" => "dt_navigation",
			"value" => "icon-portfolio-p204",
			'dependency'	=> array(
				'element'	=> 'show_link',
				'value'		=> 'y',
				'callback'  => 'the7PortfolioMasonryIconsDependencyCallback',
			),
		),
		array(
			"group" => __("Icons", 'dt-the7-core'),
			'heading' => __('Image zoom', 'dt-the7-core'),
			'param_name' => 'show_zoom',
			'type' => 'dt_switch',
			'value' => 'y',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
		),
		array(
			"group" => __("Icons", 'dt-the7-core'),
			"heading" => __("Choose image zoom icon", "dt-the7-core"),
			"param_name" => "image_zoom_icon",
			"type" => "dt_navigation",
			"value" => "icon-portfolio-p203",
			'dependency'	=> array(
				'element'	=> 'show_zoom',
				'value'		=> 'y',
			),
		),
		array(
			"group" => __("Icons", 'dt-the7-core'),
			'heading' => __('Link to project page', 'dt-the7-core'),
			'param_name' => 'show_details',
			'type' => 'dt_switch',
			'value' => 'y',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
		),
		array(
			"group" => __("Icons", 'dt-the7-core'),
			"heading" => __("Choose project page link icon", "dt-the7-core"),
			"param_name" => "project_link_icon",
			"type" => "dt_navigation",
			"value" => "icon-portfolio-p205",
			'dependency'	=> array(
				'element'	=> 'show_details',
				'value'		=> 'y',
			),
		),

		array(
			"group" => __("Icons", 'dt-the7-core'),
			"heading" => __( "Icon Size & Background", 'dt-the7-core' ),
			"param_name" => "dt_project_icon_title",
			"type" => "dt_title",
			"edit_field_class" => "the7-icons-dependent vc_col-xs-12",
		),
		array(
			"group" => __("Icons", 'dt-the7-core'),
			"heading" => __("Icon size", 'dt-the7-core'),
			"param_name" => "project_icon_size",
			"type" => "dt_number",
			"value" => "16px",
			"units" => "px",
			"edit_field_class" => "the7-icons-dependent vc_col-xs-12",
		),
		array(
			"group" => __("Icons", 'dt-the7-core'),
			"heading" => __("Background size", 'dt-the7-core'),
			"param_name" => "project_icon_bg_size",
			"type" => "dt_number",
			"value" => "44px",
			"units" => "px",
			"edit_field_class" => "the7-icons-dependent vc_col-xs-12",
		),
		array(
			"group" => __("Icons", 'dt-the7-core'),
			"heading" => __("Border width", 'dt-the7-core'),
			"param_name" => "project_icon_border_width",
			"type" => "dt_number",
			"value" => "0",
			"units" => "px",
			"edit_field_class" => "the7-icons-dependent vc_col-xs-12",
		),
		array(
			"group" => __("Icons", 'dt-the7-core'),
			"heading" => __("Border radius", 'dt-the7-core'),
			"param_name" => "project_icon_border_radius",
			"type" => "dt_number",
			"value" => "100px",
			"units" => "px",
			"edit_field_class" => "the7-icons-dependent vc_col-xs-12",
		),

		array(
			"group" => __( "Icons", 'dt-the7-core' ),
			"heading" => __("Gap between icons", 'dt-the7-core'),
			"param_name" => "project_icon_gap",
			"type" => "dt_number",
			"value" => "10px",
			"units" => "px",
			"edit_field_class" => "the7-icons-dependent vc_col-xs-12",
		),
		array(
			"group" => __( "Icons", 'dt-the7-core' ),
			"heading" => __("Gap below icons", 'dt-the7-core'),
			"param_name" => "project_icon_below_gap",
			"type" => "dt_number",
			"value" => "10px",
			"units" => "px",
			"edit_field_class" => "the7-icons-dependent vc_col-xs-12",
		),
		array(
			"group" => __( "Icons", 'dt-the7-core' ),
			"heading" => __("Gap above icons", 'dt-the7-core'),
			"param_name" => "project_icon_above_gap",
			"type" => "dt_number",
			"value" => "10px",
			"units" => "px",
			"edit_field_class" => "the7-icons-dependent vc_col-xs-12",
		),
		array(
			"group" => __("Icons", 'dt-the7-core'),
			"heading" => __( "Normal", 'dt-the7-core' ),
			"param_name" => "dt_soc_icon_title",
			"type" => "dt_title",
			"edit_field_class" => "the7-icons-dependent vc_col-xs-12",
		),
		array(
			"group" => __("Icons", 'dt-the7-core'),
			'heading' => __('Icon color', 'dt-the7-core'),
			'description' => __( "Live empty to use accent color.", 'dt-the7-core' ),
			'param_name' => 'project_icon_color',
			'type' => 'colorpicker',
			'value' => 'rgba(255,255,255,1)',
			"edit_field_class" => "the7-icons-dependent vc_col-xs-12",
		),
		array(
			"group" => __("Icons", 'dt-the7-core'),
			'heading'    => __( 'Show icon border color', 'the7mk2' ),
			'param_name' => 'project_icon_border',
			'type'       => 'dt_switch',
			'value'      => 'y',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
			"edit_field_class" => "the7-icons-dependent vc_col-xs-12",
		),
		array(
			"group" => __("Icons", 'dt-the7-core'),
			'heading' => __('Icon border color  ', 'dt-the7-core'),
			'description' => __( "Live empty to use accent color.", 'dt-the7-core' ),
			'param_name' => 'project_icon_border_color',
			'type' => 'colorpicker',
			'value' => '',
			"edit_field_class" => "the7-icons-dependent vc_col-xs-12",
			'dependency'	=> array(
				'element'	=> 'project_icon_border',
				'value'		=> 'y',
			),
		),
		array(
			"group" => __("Icons", 'dt-the7-core'),
			'heading' => __('Show icon background', 'dt-the7-core'),
			'param_name' => 'project_icon_bg',
			'type' => 'dt_switch',
			'value' => 'y',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			"edit_field_class" => "the7-icons-dependent vc_col-xs-12",
		),
		array(
			"group" => __("Icons", 'dt-the7-core'),
			'heading'		=> __('Icon background color', 'dt-the7-core'),
			'param_name'	=> 'project_icon_bg_color',
			'type'			=> 'colorpicker',
			'value'			=> 'rgba(255,255,255,0.3)',
			'dependency'	=> array(
				'element'	=> 'project_icon_bg',
				'value'		=> 'y',
			),
			'description'   => __( 'Live empty to use accent color.', 'dt-the7-core' ),
			"edit_field_class" => "the7-icons-dependent vc_col-xs-12",
		),
		array(
			"group" => __("Icons", 'dt-the7-core'),
			"heading" => __( "Hover", 'dt-the7-core' ),
			"param_name" => "dt_soc_icon_title",
			"type" => "dt_title",
			"edit_field_class" => "the7-icons-dependent vc_col-xs-12",
		),
		array(
			'group'      => __( 'Icons', 'the7mk2' ),
			'heading'    => __( 'Enable hover', 'the7mk2' ),
			'param_name' => 'dt_icon_hover',
			'type'       => 'dt_switch',
			'value'      => 'y',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
			"edit_field_class" => "the7-icons-dependent vc_col-xs-12",
		),
		array(
			"group" => __("Icons", 'dt-the7-core'),
			'heading' => __('Icon color', 'dt-the7-core'),
			'description' => __( "Live empty to use accent color.", 'dt-the7-core' ),
			'param_name' => 'project_icon_color_hover',
			'type' => 'colorpicker',
			'value' => 'rgba(255,255,255,1)',
			"edit_field_class" => "the7-icons-dependent vc_col-xs-12",
			'dependency' => array(
				'element' => 'dt_icon_hover',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Icons', 'the7mk2' ),
			'heading'    => __( 'Show icon border color', 'the7mk2' ),
			'param_name' => 'project_icon_border_hover',
			'type'       => 'dt_switch',
			'value'      => 'y',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
			"edit_field_class" => "the7-icons-dependent vc_col-xs-12",
			'dependency' => array(
				'element' => 'dt_icon_hover',
				'value'   => 'y',
			),
		),
		array(
			"group" => __("Icons", 'dt-the7-core'),
			'heading' => __('Icon border color  ', 'dt-the7-core'),
			'description' => __( "Live empty to use accent color.", 'dt-the7-core' ),
			'param_name' => 'project_icon_border_color_hover',
			'type' => 'colorpicker',
			'value' => '',
			"edit_field_class" => "the7-icons-dependent vc_col-xs-12",
			'dependency' => array(
				'element' => 'project_icon_border_hover',
				'value'   => 'y',
			),
		),
		array(
			"group" => __("Icons", 'dt-the7-core'),
			'heading' => __('Show icon background', 'dt-the7-core'),
			'param_name' => 'project_icon_bg_hover',
			'type' => 'dt_switch',
			'value' => 'y',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			"edit_field_class" => "the7-icons-dependent vc_col-xs-12",
			'dependency' => array(
				'element' => 'dt_icon_hover',
				'value'   => 'y',
			),
		),
		array(
			"group" => __("Icons", 'dt-the7-core'),
			'heading'		=> __('Icon background color', 'dt-the7-core'),
			'param_name'	=> 'project_icon_bg_color_hover',
			'type'			=> 'colorpicker',
			'value'			=> 'rgba(255,255,255,0.5)',
			'dependency'	=> array(
				'element'	=> 'project_icon_bg_hover',
				'value'		=> 'y',
			),
			'description'   => __( 'Live empty to use accent color.', 'dt-the7-core' ),
			"edit_field_class" => "the7-icons-dependent vc_col-xs-12",
		),

		// - Pagination & Categorization group.
		array(
			'heading' => __( 'Pagination', 'dt-the7-core' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
			'group' => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Pagination mode', 'dt-the7-core'),
			'param_name' => 'loading_mode',
			'type' => 'dropdown',
			'std' => 'disabled',
			'value' => array(
				'Disabled' => 'disabled',
				'Standard' => 'standard',
				'JavaScript pages' => 'js_pagination',
				'"Load more" button' => 'js_more',
				'Infinite scroll' => 'js_lazy_loading',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'group' => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		// -- Disabled.
		array(
			'heading' => __('Total number of posts', 'dt-the7-core'),
			'param_name' => 'dis_posts_total',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'disabled',
			),
			'description' => __('Leave empty to display all posts.', 'dt-the7-core'),
			'group' => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		// -- Standard.
		array(
			'heading' => __('Number of posts to display on one page', 'dt-the7-core'),
			'param_name' => 'st_posts_per_page',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'standard',
			),
			'description' => __('Leave empty to use number from wp settings.', 'dt-the7-core'),
			'group' => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		// -- JavaScript pages.
		array(
			'heading' => __('Total number of posts', 'dt-the7-core'),
			'param_name' => 'jsp_posts_total',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_pagination',
			),
			'description' => __('Leave empty to display all posts.', 'dt-the7-core'),
			'group' => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Number of posts to display on one page', 'dt-the7-core'),
			'param_name' => 'jsp_posts_per_page',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_pagination',
			),
			'description' => __('Leave empty to use number from wp settings.', 'dt-the7-core'),
			'group' => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		// -- js Load more.
		array(
			'heading' => __('Total number of posts', 'dt-the7-core'),
			'param_name' => 'jsm_posts_total',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_more',
			),
			'description' => __('Leave empty to display all posts.', 'dt-the7-core'),
			'group' => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Number of posts to display on one page', 'dt-the7-core'),
			'param_name' => 'jsm_posts_per_page',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_more',
			),
			'description' => __('Leave empty to use number from wp settings.', 'dt-the7-core'),
			'group' => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		// -- js Infinite scroll.
		array(
			'heading' => __('Total number of posts', 'dt-the7-core'),
			'param_name' => 'jsl_posts_total',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_lazy_loading',
			),
			'description' => __('Leave empty to display all posts.', 'dt-the7-core'),
			'group' => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Number of posts to display on one page', 'dt-the7-core'),
			'param_name' => 'jsl_posts_per_page',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_lazy_loading',
			),
			'description' => __('Leave empty to use number from wp settings.', 'dt-the7-core'),
			'group' => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		// -- Posts offset.
		array(
			'heading'          => __( 'Projects offset', 'dt-the7-core' ),
			'param_name'       => 'posts_offset',
			'type'             => 'dt_number',
			'value'            => 0,
			'min'              => 0,
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'description'      => __( 'Offset for projects  query (i.e. 2 means, projects will be displayed starting from the third project).', 'dt-the7-core' ),
			'group'            => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		// -- Standard.
		array(
			'heading' => __('Show all pages in paginator', 'dt-the7-core'),
			'param_name' => 'st_show_all_pages',
			'type' => 'dt_switch',
			'value' => 'n',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'standard',
			),
			'group' => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Gap before pagination', 'dt-the7-core'),
			'param_name' => 'st_gap_before_pagination',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'standard',
			),
			'description' => __('Leave empty to use default gap', 'dt-the7-core'),
			'group' => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		// -- JavaScript pages.
		array(
			'heading' => __('Show all pages in paginator', 'dt-the7-core'),
			'param_name' => 'jsp_show_all_pages',
			'type' => 'dt_switch',
			'value' => 'n',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_pagination',
			),
			'group' => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Gap before pagination', 'dt-the7-core'),
			'param_name' => 'jsp_gap_before_pagination',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_pagination',
			),
			'description' => __('Leave empty to use default gap', 'dt-the7-core'),
			'group' => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		// -- js Load more.
		array(
			'heading' => __('Gap before pagination', 'dt-the7-core'),
			'param_name' => 'jsm_gap_before_pagination',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_more',
			),
			'description' => __('Leave empty to use default gap', 'dt-the7-core'),
			'group' => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		array(
			'heading' => __( 'Categorization & Ordering', 'dt-the7-core' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
			'group' => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Order', 'dt-the7-core'),
			'param_name' => 'order',
			'type' => 'dropdown',
			'std' => 'desc',
			'value' => array(
				'Ascending' => 'asc',
				'Descending' => 'desc',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'group' => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		array(
			'heading'          => __( 'Order by', 'dt-the7-core' ),
			'param_name'       => 'orderby',
			'type'             => 'dropdown',
			'std'              => 'date',
			'value'            => array(
				'Date'          => 'date',
				'Name'          => 'title',
				'ID'            => 'ID',
				'Modified'      => 'modified',
				'Comment count' => 'comment_count',
				'Menu order'    => 'menu_order',
				'Rand'          => 'rand',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'group'            => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Show categories filter', 'dt-the7-core'),
			'param_name' => 'show_categories_filter',
			'type' => 'dt_switch',
			'value' => 'n',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			'group' => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		array(
			'heading'    => __( 'Show name / date ordering', 'dt-the7-core' ),
			'param_name' => 'show_orderby_filter',
			'type'       => 'dt_switch',
			'value'      => 'n',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
			'dependency' => array(
				'element' => 'orderby',
				'value'   => array( 'date', 'title' ),
			),
			'group'      => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Show asc. / desc. ordering', 'dt-the7-core'),
			'param_name' => 'show_order_filter',
			'type' => 'dt_switch',
			'value' => 'n',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			'group' => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Categorization position', 'the7mk2'),
			'param_name' => 'filter_position',
			'type' => 'dropdown',
			'std' => 'center',
			'value' => array(
				'Center' => 'center',
				'Left' => 'left',
				'Right' => 'right',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'group' => __( 'Pagination & Categorization', 'the7mk2' ),
		),
		array(
			'heading' => __( 'Gap below categorization & ordering', 'dt-the7-core' ),
			'param_name' => 'gap_below_category_filter',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'description' => __('Leave empty to use default gap', 'dt-the7-core'),
			'group' => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		array(
			'heading'    => __( 'Enable url navigation', 'dt-the7-core' ),
			'param_name' => 'allow_to_navigate_by_url',
			'type'       => 'dt_switch',
			'value'      => 'n',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
			'dependency' => array(
				'element' => 'loading_mode',
				'value'   => array( 'disabled', 'js_pagination', 'js_more', 'js_lazy_loading' ),
			),
			'group'      => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		array(
			'heading' => __( 'Color Settings', 'dt-the7-core' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'group' => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Font color', 'dt-the7-core'),
			'param_name' => 'navigation_font_color',
			'type' => 'colorpicker',
			'value' => '',
			'description' => __( 'Leave empty to use headers color.', 'dt-the7-core' ),
			'group' => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Accent color', 'dt-the7-core'),
			'param_name' => 'navigation_accent_color',
			'type' => 'colorpicker',
			'value' => '',
			'description' => __( 'Leave empty to use accent color.', 'dt-the7-core' ),
			'group' => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		array(
			'type' => 'css_editor',
			'heading' => __( 'CSS box', 'dt-the7-core' ),
			'param_name' => 'css_dt_portfolio',
			'group' => __( 'Design Options', 'dt-the7-core' )
		),
	),
);
