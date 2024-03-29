<?php

defined( 'ABSPATH' ) || exit;

return array(
	'weight' => -1,
	'name' => __( 'Blog Masonry and Grid', 'the7mk2' ),
	'base' => 'dt_blog_masonry',
	'class' => 'dt_vc_sc_blog_masonry',
	'icon' => 'dt_vc_ico_blog_posts',
	'category' => __( 'by Dream-Theme', 'the7mk2' ),
	'params' => array(
		// General group.
		array(
			'heading' => __('Show', 'the7mk2'),
			'param_name' => 'post_type',
			'type' => 'dropdown',
			'std' => 'category',
			'value' => array(
				'All posts' => 'posts',
				'Posts from categories' => 'category',
				'Posts by tags' => 'tags',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'type' => 'autocomplete',
			'heading' => __( 'Choose posts', 'the7mk2' ),
			'param_name' => 'posts',
			'settings' => array(
				'multiple' => true,
				'min_length' => 0,
			),
			'save_always' => true,
			'description' => __( 'Field accept post ID, title. Leave empty to show all posts.', 'the7mk2' ),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'post_type',
				'value' => 'posts',
			),
		),
		array(
			'type' => 'autocomplete',
			'heading' => __( 'Choose post categories', 'the7mk2' ),
			'param_name' => 'category',
			'settings' => array(
				'multiple' => true,
				'min_length' => 0,
			),
			'save_always' => true,
			'description' => __( 'Field accept category ID, title, slug. Leave empty to show all posts.', 'the7mk2' ),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'post_type',
				'value' => 'category',
			),
		),
		array(
			'type' => 'autocomplete',
			'heading' => __( 'Choose tags', 'the7mk2' ),
			'param_name' => 'tags',
			'settings' => array(
				'multiple' => true,
				'min_length' => 0,
			),
			'save_always' => true,
			'description' => __( 'Field accept tag ID, title, slug. Leave empty to show all posts.', 'the7mk2' ),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'post_type',
				'value' => 'tags',
			),
		),
		// - Layout Settings.
		array(
			'heading' => __( 'Layout Settings', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
		),
		array(
			'heading' => __('Mode', 'the7mk2'),
			'param_name' => 'mode',
			'type' => 'dropdown',
			'value' => array(
				'Masonry' => 'masonry',
				'Grid' => 'grid',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			"heading" => __("Loading effect", 'the7mk2'),
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
			'heading' => __('Style', 'the7mk2'),
			'param_name' => 'layout',
			'type' => 'dropdown',
			'value' => array(
				'Classic' => 'classic',
				'Bottom overlap (background)' => 'bottom_overlap',
				'Bottom overlap (gradient)' => 'gradient_overlap',
				'Overlay (background)' => 'gradient_overlay',
				'Overlay (gradient)' => 'gradient_rollover',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		// -- Bottom overlap style.
		array(
			'heading' => __('Content area width', 'the7mk2'),
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
			'heading' => __('Content area overlap', 'the7mk2'),
			'param_name' => 'bo_content_overlap',
			'type' => 'dt_number',
			'value' => '100px',
			'units' => 'px',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'layout',
				'value' => 'bottom_overlap',
			),
		),
		array(
			'heading' => __('Overlay background margins', 'the7mk2'),
			'param_name' => 'grovly_content_overlap',
			'type' => 'dt_number',
			'value' => '0px',
			'units' => 'px, %',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'layout',
				'value' => 'gradient_overlay',
			),
		),
		// - Content Area.
		array(
			'heading' => __( 'Content Area', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
		),
		array(
			'heading' => __('Show background', 'the7mk2'),
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
			'heading'		=> __('Color', 'the7mk2'),
			'param_name'	=> 'custom_content_bg_color',
			'type'			=> 'colorpicker',
			'value'			=> '',
			'dependency'	=> array(
				'element'	=> 'content_bg',
				'value'		=> 'y',
			),
			'description'   => __( 'Leave empty to use default content boxes color & decoration. Note that decoration doesn\'t apply to gradient backgrounds.', 'the7mk2' ),
		),
		array(
			'heading' => __('Content area paddings', 'the7mk2'),
			'param_name' => 'post_content_paddings',
			'type' => 'dt_spacing',
			'value' => '25px 30px 30px 30px',
			'units' => 'px',
		),
		// - Image Settings.
		array(
			'heading' => __( 'Image Settings', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
		),
		array(
			'heading' => __('Image sizing', 'the7mk2'),
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
			'headings' => array( __('Width', 'the7mk2'), __('Height', 'the7mk2') ),
			'param_name' => 'resized_image_dimensions',
			'type' => 'dt_dimensions',
			'value' => '3x2',
			'dependency' => array(
				'element' => 'image_sizing',
				'value' => 'resize',
			),
			'description' => __('Set image proportions, for example: 4x3, 3x2.', 'the7mk2'),
		),
		array(
			'heading' => __('Image paddings', 'the7mk2'),
			'param_name' => 'image_paddings',
			'type' => 'dt_spacing',
			'value' => '0px 0px 0px 0px',
			'units' => 'px, %',
		),
		array(
			'heading' => __('Scale animation on hover', 'dt-the7-core'),
			'param_name' => 'image_scale_animation_on_hover',
			'type' => 'dropdown',
			'std' => 'slow_scale',
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
			'std'              => 'disabled',
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
			'heading' => __( 'Columns & Responsiveness', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
		),
		array(
			'heading' => __('Responsiveness mode', 'the7mk2'),
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
			'heading' => __('Number of columns', 'the7mk2'),
			'param_name' => 'bwb_columns',
			'type' => 'dt_responsive_columns',
			'value' => 'desktop:4|h_tablet:3|v_tablet:2|phone:1',
			'dependency'	=> array(
				'element'	=> 'responsiveness',
				'value'		=> 'browser_width_based',
			),
		),
	    // -- Post width based.
		array(
			'heading' => __('Column minimum width', 'the7mk2'),
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

			'heading' => __('Desired columns number', 'the7mk2'),
			'param_name' => 'pwb_columns',
			'type' => 'dt_number',
			'value' => '',
			'units' => '',
			'max' => 12,
			'description' => __('Affects only masonry layout', 'the7mk2'),
			"dependency" => array("element" => "responsiveness", "value" => 'post_width_based'),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'heading' => __('Gap between columns', 'the7mk2'),
			'param_name' => 'gap_between_posts',
			'type' => 'dt_number',
			'value' => '15px',
			'units' => 'px',
			'description' => __('Please note that this setting affects post paddings. So, for example: a value 10px will give you 20px gaps between posts)', 'the7mk2'),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'heading' => __('Make all posts the same width', 'the7mk2'),
			'param_name' => 'all_posts_the_same_width',
			'type' => 'dropdown',
			'value' => array(
				'No (wide post fills 2 col.)' => 'n',
				'Yes (wide post fills 1 col.)' => 'y',
			),
			'description'   => __( 'Post wide/normal width can be chosen in single post options.', 'the7mk2' ),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		// Post group.
		array(
			'heading' => __('Content alignment', 'the7mk2'),
			'param_name' => 'content_alignment',
			'type' => 'dropdown',
			'std' => 'left',
			'value' => array(
				'Left' => 'left',
				'Center' => 'center',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'group' => __( 'Post', 'the7mk2' ),
		),
		// - Post Title.
		array(
			'heading' => __( 'Post Title', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
			'group' => __( 'Post', 'the7mk2' ),
		),
		array(
			'heading' => __( 'Font style', 'the7mk2' ),
			'param_name' => 'post_title_font_style',
			'type' => 'dt_font_style',
			'value' => ':bold:',
			'group' => __( 'Post', 'the7mk2' ),
		),
		array(
			'heading' => __('Font size', 'the7mk2'),
			'param_name' => 'post_title_font_size',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'description' => __( 'Leave empty to use H4 font size.', 'the7mk2' ),
			'group' => __( 'Post', 'the7mk2' ),
		),
		array(
			'heading' => __('Line height', 'the7mk2'),
			'param_name' => 'post_title_line_height',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'description' => __( 'Leave empty to use H4 line height.', 'the7mk2' ),
			'group' => __( 'Post', 'the7mk2' ),
		),
		array(
			'heading'		=> __('Font color', 'the7mk2'),
			'param_name'	=> 'custom_title_color',
			'type'			=> 'colorpicker',
			'value'			=> '',
			'description' => __( 'Leave empty to use headings color.', 'the7mk2' ),
			'group' => __( 'Post', 'the7mk2' ),
		),
		array(
			'heading' => __('Gap below title', 'the7mk2'),
			'param_name' => 'post_title_bottom_margin',
			'type' => 'dt_number',
			'value' => '5px',
			'units' => 'px',
			'group' => __( 'Post', 'the7mk2' ),
		),
		// - Meta Information.
		array(
			'heading' => __( 'Meta Information', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
			'group' => __( 'Post', 'the7mk2' ),
		),
		array(
			'heading' => __('Show post date', 'the7mk2'),
			'param_name' => 'post_date',
			'type' => 'dt_switch',
			'value' => 'y',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			'group' => __( 'Post', 'the7mk2' ),
		),
		array(
			'heading' => __('Show post categories', 'the7mk2'),
			'param_name' => 'post_category',
			'type' => 'dt_switch',
			'value' => 'y',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			'group' => __( 'Post', 'the7mk2' ),
		),
		array(
			'heading' => __('Show post author', 'the7mk2'),
			'param_name' => 'post_author',
			'type' => 'dt_switch',
			'value' => 'y',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			'group' => __( 'Post', 'the7mk2' ),
		),
		array(
			'heading' => __('Show post comments', 'the7mk2'),
			'param_name' => 'post_comments',
			'type' => 'dt_switch',
			'value' => 'y',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			'group' => __( 'Post', 'the7mk2' ),
		),
		array(
			'heading' => __( 'Font style', 'the7mk2' ),
			'param_name' => 'meta_info_font_style',
			'type' => 'dt_font_style',
			'value' => '',
			'group' => __( 'Post', 'the7mk2' ),
		),
		array(
			'heading' => __('Font size', 'the7mk2'),
			'param_name' => 'meta_info_font_size',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'description' => __( 'Leave empty to use small font size.', 'the7mk2' ),
			'group' => __( 'Post', 'the7mk2' ),
		),
		array(
			'heading' => __('Line height', 'the7mk2'),
			'param_name' => 'meta_info_line_height',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'description' => __( 'Leave empty to use small line height.', 'the7mk2' ),
			'group' => __( 'Post', 'the7mk2' ),
		),
		array(
			'heading'		=> __('Font color', 'the7mk2'),
			'param_name'	=> 'custom_meta_color',
			'type'			=> 'colorpicker',
			'value'			=> '',
			'description' => __( 'Leave empty to use secondary text color.', 'the7mk2' ),
			'group' => __( 'Post', 'the7mk2' ),
		),
		array(
			'heading' => __('Gap below meta info', 'the7mk2'),
			'param_name' => 'meta_info_bottom_margin',
			'type' => 'dt_number',
			'value' => '15px',
			'units' => 'px',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'group' => __( 'Post', 'the7mk2' ),
		),
		// - Text.
		array(
			'heading' => __( 'Text', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
			'group' => __( 'Post', 'the7mk2' ),
		),
		array(
			'heading' => __('Content or excerpt', 'the7mk2'),
			'param_name' => 'post_content',
			'type' => 'dropdown',
			'std' => 'show_excerpt',
			'value' => array(
				'Off' => 'off',
				'Excerpt' => 'show_excerpt',
				'Content' => 'show_content',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'group' => __( 'Post', 'the7mk2' ),
		),
		array(
			'heading' => __('Maximum number of words', 'the7mk2'),
			'param_name' => 'excerpt_words_limit',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'post_content',
				'value' => 'show_excerpt',
			),

			'description' => __( 'Leave empty to show full text.', 'the7mk2' ),
			'group' => __( 'Post', 'the7mk2' ),
		),
		array(
			'heading' => __( 'Font style', 'the7mk2' ),
			'param_name' => 'content_font_style',
			'type' => 'dt_font_style',
			'value' => '',
			'dependency' => array(
				'element' => 'post_content',
				'value' => array( 'show_excerpt', 'show_content' ),
			),
			'group' => __( 'Post', 'the7mk2' ),
		),
		array(
			'heading' => __('Font size', 'the7mk2'),
			'param_name' => 'content_font_size',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'dependency' => array(
				'element' => 'post_content',
				'value' => array( 'show_excerpt', 'show_content' ),
			),
			'description' => __( 'Leave empty to use medium font size.', 'the7mk2' ),
			'group' => __( 'Post', 'the7mk2' ),
		),
		array(
			'heading' => __('Line height', 'the7mk2'),
			'param_name' => 'content_line_height',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'dependency' => array(
				'element' => 'post_content',
				'value' => array( 'show_excerpt', 'show_content' ),
			),
			'description' => __( 'Leave empty to use medium line height.', 'the7mk2' ),
			'group' => __( 'Post', 'the7mk2' ),
		),
		array(
			'heading'		=> __('Font color', 'the7mk2'),
			'param_name'	=> 'custom_content_color',
			'type'			=> 'colorpicker',
			'value'			=> '',
			'dependency' => array(
				'element' => 'post_content',
				'value' => array( 'show_excerpt', 'show_content' ),
			),
			'description' => __( 'Leave empty to use primary text color.', 'the7mk2' ),
			'group' => __( 'Post', 'the7mk2' ),
		),
		array(
			'heading' => __('Gap below text', 'the7mk2'),
			'param_name' => 'content_bottom_margin',
			'type' => 'dt_number',
			'value' => '5px',
			'units' => 'px',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'post_content',
				'value' => array( 'show_excerpt', 'show_content' ),
			),
			'group' => __( 'Post', 'the7mk2' ),
		),
		// - "Read More" Button.
		array(
			'heading' => __( '"Read More" Button', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
			'group' => __( 'Post', 'the7mk2' ),
		),
		array(
			'heading' => __('"Read more" button', 'the7mk2'),
			'param_name' => 'read_more_button',
			'type' => 'dropdown',
			'std' => 'default_link',
			'value' => array(
				'Off' => 'off',
				'Default link' => 'default_link',
				'Default button' => 'default_button',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'group' => __( 'Post', 'the7mk2' ),
		),
		array(
			'heading' => __('Button text', 'the7mk2'),
			'param_name' => 'read_more_button_text',
			'type' => 'textfield',
			'value' => _x( 'Read more', 'the7 shortcode', 'the7mk2' ),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'read_more_button',
				'value'	=> array(
					'default_link',
					'default_button',
				),
			),
			'group' => __( 'Post', 'the7mk2' ),
		),
		// Fancy Elements group.
		// - Fancy Date.
		array(
			'heading' => __( 'Fancy Date', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
			'group' => __( 'Fancy Elements', 'the7mk2' ),
		),
		array(
			'heading' => __('Show Fancy date', 'the7mk2'),
			'param_name' => 'fancy_date',
			'type' => 'dt_switch',
			'value' => 'n',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			'group' => __( 'Fancy Elements', 'the7mk2' ),
		),
		array(
			'heading' => __('Font color', 'the7mk2'),
			'param_name' => 'fancy_date_font_color',
			'type' => 'colorpicker',
			'value' => '',
			'dependency' => array(
				'element' => 'fancy_date',
				'value'	=> 'y',
			),
			'description' => __( 'Leave empty to use predefined color.', 'the7mk2' ),
			'group' => __( 'Fancy Elements', 'the7mk2' ),
		),
		array(
			'heading' => __('Background color', 'the7mk2'),
			'param_name' => 'fancy_date_bg_color',
			'type' => 'colorpicker',
			'value' => '',
			'dependency' => array(
				'element' => 'fancy_date',
				'value'	=> 'y',
			),
			'description' => __( 'Leave empty to use predefined color.', 'the7mk2' ),
			'group' => __( 'Fancy Elements', 'the7mk2' ),
		),
		array(
			'heading' => __('Line color', 'the7mk2'),
			'param_name' => 'fancy_date_line_color',
			'type' => 'colorpicker',
			'value' => '',
			'dependency' => array(
				'element' => 'fancy_date',
				'value'	=> 'y',
			),
			'description' => __( 'Leave empty to use accent color.', 'the7mk2' ),
			'group' => __( 'Fancy Elements', 'the7mk2' ),
		),
		// - Fancy Categories.
		array(
			'heading' => __( 'Fancy Categories', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
			'group' => __( 'Fancy Elements', 'the7mk2' ),
		),
		array(
			'heading' => __('Show fancy categories', 'the7mk2'),
			'param_name' => 'fancy_categories',
			'type' => 'dt_switch',
			'value' => 'n',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			'group' => __( 'Fancy Elements', 'the7mk2' ),
		),
		array(
			'heading' => __('Font color', 'the7mk2'),
			'param_name' => 'fancy_categories_font_color',
			'type' => 'colorpicker',
			'value' => '',
			'dependency' => array(
				'element' => 'fancy_categories',
				'value'	=> 'y',
			),
			'description' => __( 'Leave empty to use predefined color or category color indication.', 'the7mk2' ),
			'group' => __( 'Fancy Elements', 'the7mk2' ),
		),
		array(
			'heading' => __('Background color', 'the7mk2'),
			'param_name' => 'fancy_categories_bg_color',
			'type' => 'colorpicker',
			'value' => '',
			'dependency' => array(
				'element' => 'fancy_categories',
				'value'	=> 'y',
			),
			'description' => __( 'Leave empty to use predefined color or category color indication.', 'the7mk2' ),
			'group' => __( 'Fancy Elements', 'the7mk2' ),
		),
		//Icons

		array(
			'group'      => __( 'Hover Icon', 'the7mk2' ),
			'heading'    => __( 'Show icon on image hover', 'the7mk2' ),
			'param_name' => 'show_zoom',
			'type'       => 'dt_switch',
			'value'      => 'n',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
		),
		array(
			'group'      => __( 'Hover Icon', 'the7mk2' ),
			'heading'    => __( 'Choose image zoom icon', 'the7mk2' ),
			'param_name' => 'gallery_image_zoom_icon',
			'type'       => 'dt_navigation',
			'value'      => 'icon-im-hover-001',
			'dependency' => array(
				'element' => 'show_zoom',
				'value'   => 'y',
			),
		),
		array(
			'group'            => __( 'Hover Icon', 'the7mk2' ),
			'heading'          => __( 'Icon Size & Background', 'the7mk2' ),
			'param_name'       => 'dt_project_icon_title',
			'type'             => 'dt_title',
			'dependency'       => array(
				'element' => 'show_zoom',
				'value'   => 'y',
			),
			'edit_field_class' => 'the7-icons-dependent vc_col-xs-12',
		),
		array(
			'group'            => __( 'Hover Icon', 'the7mk2' ),
			'heading'          => __( 'Icon size', 'the7mk2' ),
			'param_name'       => 'project_icon_size',
			'type'             => 'dt_number',
			'value'            => '32px',
			'units'            => 'px',
			'dependency'       => array(
				'element' => 'show_zoom',
				'value'   => 'y',
			),
			'edit_field_class' => 'the7-icons-dependent vc_col-xs-12',
		),
		array(
			'group'            => __( 'Hover Icon', 'the7mk2' ),
			'heading'          => __( 'Icon color', 'the7mk2' ),
			'description'      => __( 'Live empty to use accent color.', 'the7mk2' ),
			'param_name'       => 'project_icon_color',
			'type'             => 'colorpicker',
			'value'            => 'rgba(255,255,255,1)',
			'dependency'       => array(
				'element' => 'show_zoom',
				'value'   => 'y',
			),
			'edit_field_class' => 'the7-icons-dependent vc_col-xs-12',
		),

		array(
			'group'            => __( 'Hover Icon', 'the7mk2' ),
			'heading'          => __( 'Background size', 'the7mk2' ),
			'param_name'       => 'project_icon_bg_size',
			'type'             => 'dt_number',
			'value'            => '44px',
			'units'            => 'px',
			'dependency'       => array(
				'element' => 'show_zoom',
				'value'   => 'y',
			),
			'edit_field_class' => 'the7-icons-dependent vc_col-xs-12',
		),
		array(
			'group'            => __( 'Hover Icon', 'the7mk2' ),
			'heading'          => __( 'Paint background', 'the7mk2' ),
			'param_name'       => 'project_icon_bg',
			'type'             => 'dt_switch',
			'value'            => 'n',
			'options'          => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
			'dependency'       => array(
				'element' => 'show_zoom',
				'value'   => 'y',
			),
			'edit_field_class' => 'the7-icons-dependent vc_col-xs-12',
		),
		array(
			'group'            => __( 'Hover Icon', 'the7mk2' ),
			'heading'          => __( 'Background color', 'the7mk2' ),
			'param_name'       => 'project_icon_bg_color',
			'type'             => 'colorpicker',
			'value'            => 'rgba(255,255,255,0.3)',
			'dependency'       => array(
				'element' => 'project_icon_bg',
				'value'   => 'y',
			),
			'description'      => __( 'Live empty to use accent color.', 'the7mk2' ),
			'edit_field_class' => 'the7-icons-dependent vc_col-xs-12',
		),
		array(
			'group'            => __( 'Hover Icon', 'the7mk2' ),
			'heading'          => __( 'Border radius', 'the7mk2' ),
			'param_name'       => 'project_icon_border_radius',
			'type'             => 'dt_number',
			'value'            => '100px',
			'units'            => 'px',
			'dependency'       => array(
				'element' => 'show_zoom',
				'value'   => 'y',
			),
			'edit_field_class' => 'the7-icons-dependent vc_col-xs-12',
		),
		array(
			'group'            => __( 'Hover Icon', 'the7mk2' ),
			'heading'          => __( 'Border width', 'the7mk2' ),
			'param_name'       => 'project_icon_border_width',
			'type'             => 'dt_number',
			'value'            => '0',
			'units'            => 'px',
			'dependency'       => array(
				'element' => 'show_zoom',
				'value'   => 'y',
			),
			'edit_field_class' => 'the7-icons-dependent vc_col-xs-12',
		),
		array(
			'group'            => __( 'Hover Icon', 'the7mk2' ),
			'heading'          => __( 'Border color', 'the7mk2' ),
			'description'      => __( 'Live empty to use accent color.', 'the7mk2' ),
			'param_name'       => 'project_icon_border_color',
			'type'             => 'colorpicker',
			'value'            => '',
			'dependency'       => array(
				'element' => 'show_zoom',
				'value'   => 'y',
			),
			'edit_field_class' => 'the7-icons-dependent vc_col-xs-12',
		),
		// Pagination & Categorization group.
		// - Pagination.
		array(
			'heading' => __( 'Pagination', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
			'group' => __( 'Pagination & Categorization', 'the7mk2' ),
		),
		array(
			'heading' => __('Pagination mode', 'the7mk2'),
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
			'group' => __( 'Pagination & Categorization', 'the7mk2' ),
		),
		// -- Disabled.
		array(
			'heading' => __('Total number of posts', 'the7mk2'),
			'param_name' => 'dis_posts_total',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'disabled',
			),
			'description' => __('Leave empty to display all posts.', 'the7mk2'),
			'group' => __( 'Pagination & Categorization', 'the7mk2' ),
		),
		// -- Standard.
		array(
			'heading' => __('Number of posts to display on one page', 'the7mk2'),
			'param_name' => 'st_posts_per_page',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'standard',
			),
			'description' => __('Leave empty to use value from the WP Reading settings.', 'the7mk2'),
			'group' => __( 'Pagination & Categorization', 'the7mk2' ),
		),
		// -- JavaScript pages.
		array(
			'heading' => __('Total number of posts', 'the7mk2'),
			'param_name' => 'jsp_posts_total',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_pagination',
			),
			'description' => __('Leave empty to display all posts.', 'the7mk2'),
			'group' => __( 'Pagination & Categorization', 'the7mk2' ),
		),
		array(
			'heading' => __('Number of posts to display on one page', 'the7mk2'),
			'param_name' => 'jsp_posts_per_page',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_pagination',
			),
			'description' => __('Leave empty to use value from the WP Reading settings.', 'the7mk2'),
			'group' => __( 'Pagination & Categorization', 'the7mk2' ),
		),
		// -- js Load more.
		array(
			'heading' => __('Total number of posts', 'the7mk2'),
			'param_name' => 'jsm_posts_total',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_more',
			),
			'description' => __('Leave empty to display all posts.', 'the7mk2'),
			'group' => __( 'Pagination & Categorization', 'the7mk2' ),
		),
		array(
			'heading' => __('Number of posts to display on one page', 'the7mk2'),
			'param_name' => 'jsm_posts_per_page',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_more',
			),
			'description' => __('Leave empty to use value from the WP Reading settings.', 'the7mk2'),
			'group' => __( 'Pagination & Categorization', 'the7mk2' ),
		),
		// -- js Infinite scroll.
		array(
			'heading' => __('Total number of posts', 'the7mk2'),
			'param_name' => 'jsl_posts_total',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_lazy_loading',
			),
			'description' => __('Leave empty to display all posts.', 'the7mk2'),
			'group' => __( 'Pagination & Categorization', 'the7mk2' ),
		),
		array(
			'heading' => __('Number of posts to display on one page', 'the7mk2'),
			'param_name' => 'jsl_posts_per_page',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_lazy_loading',
			),
			'description' => __('Leave empty to use value from the WP Reading settings.', 'the7mk2'),
			'group' => __( 'Pagination & Categorization', 'the7mk2' ),
		),
		// Posts offset.
		array(
			'heading'          => __( 'Posts offset', 'the7mk2' ),
			'param_name'       => 'posts_offset',
			'type'             => 'dt_number',
			'value'            => 0,
			'min'              => 0,
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'description'      => __( 'Offset for posts query (i.e. 2 means, posts will be displayed starting from the third post).', 'the7mk2' ),
			'group' => __( 'Pagination & Categorization', 'the7mk2' ),
		),
		// Rest of the settings.
		// -- Standard
		array(
			'heading' => __('Show all pages in paginator', 'the7mk2'),
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
			'group' => __( 'Pagination & Categorization', 'the7mk2' ),
		),
		array(
			'heading' => __('Gap before pagination', 'the7mk2'),
			'param_name' => 'st_gap_before_pagination',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'standard',
			),
			'description' => __('Leave empty to use default gap', 'the7mk2'),
			'group' => __( 'Pagination & Categorization', 'the7mk2' ),
		),
		// -- JavaScript pages.
		array(
			'heading' => __('Show all pages in paginator', 'the7mk2'),
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
			'group' => __( 'Pagination & Categorization', 'the7mk2' ),
		),
		array(
			'heading' => __('Gap before pagination', 'the7mk2'),
			'param_name' => 'jsp_gap_before_pagination',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_pagination',
			),
			'description' => __('Leave empty to use default gap', 'the7mk2'),
			'group' => __( 'Pagination & Categorization', 'the7mk2' ),
		),
		// -- js Load more.
		array(
			'heading' => __('Gap before pagination', 'the7mk2'),
			'param_name' => 'jsm_gap_before_pagination',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'dependency' => array(
				'element' => 'loading_mode',
				'value'	=> 'js_more',
			),
			'description' => __('Leave empty to use default gap', 'the7mk2'),
			'group' => __( 'Pagination & Categorization', 'the7mk2' ),
		),
		array(
			'heading' => __( 'Categorization & Ordering settings', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
			'group' => __( 'Pagination & Categorization', 'the7mk2' ),
		),
		array(
			'heading' => __('Order', 'the7mk2'),
			'param_name' => 'order',
			'type' => 'dropdown',
			'std' => 'desc',
			'value' => array(
				'Ascending' => 'asc',
				'Descending' => 'desc',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'group' => __( 'Pagination & Categorization', 'the7mk2' ),
		),
		array(
			'heading'          => __( 'Order by', 'the7mk2' ),
			'param_name'       => 'orderby',
			'type'             => 'dropdown',
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
			'group'            => __( 'Pagination & Categorization', 'the7mk2' ),
		),
		array(
			'heading' => __('Show categories filter', 'the7mk2'),
			'param_name' => 'show_categories_filter',
			'type' => 'dt_switch',
			'value' => 'n',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			'group' => __( 'Pagination & Categorization', 'the7mk2' ),
		),
		array(
			'heading'    => __( 'Show name / date ordering', 'the7mk2' ),
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
			'group'      => __( 'Pagination & Categorization', 'the7mk2' ),
		),
		array(
			'heading' => __('Show asc. / desc. ordering', 'the7mk2'),
			'param_name' => 'show_order_filter',
			'type' => 'dt_switch',
			'value' => 'n',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			'group' => __( 'Pagination & Categorization', 'the7mk2' ),
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
			'heading' => __( 'Gap below categorization & ordering', 'the7mk2' ),
			'param_name' => 'gap_below_category_filter',
			'type' => 'dt_number',
			'value' => '',
			'units' => 'px',
			'description' => __('Leave empty to use default gap', 'the7mk2'),
			'group' => __( 'Pagination & Categorization', 'the7mk2' ),
		),
		array(
			'heading' => __( 'Categorization, ordering & pagination colors', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'group' => __( 'Pagination & Categorization', 'the7mk2' ),
		),
		array(
			'heading' => __('Font color', 'the7mk2'),
			'param_name' => 'navigation_font_color',
			'type' => 'colorpicker',
			'value' => '',
			'description' => __( 'Leave empty to use headings color.', 'the7mk2' ),
			'group' => __( 'Pagination & Categorization', 'the7mk2' ),
		),
		array(
			'heading' => __('Accent color', 'the7mk2'),
			'param_name' => 'navigation_accent_color',
			'type' => 'colorpicker',
			'value' => '',
			'description' => __( 'Leave empty to use accent color.', 'the7mk2' ),
			'group' => __( 'Pagination & Categorization', 'the7mk2' ),
		),
	),
);

