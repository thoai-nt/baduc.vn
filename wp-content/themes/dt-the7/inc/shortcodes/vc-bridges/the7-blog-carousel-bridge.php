<?php

defined( 'ABSPATH' ) || exit;

return array(
	"weight" => -1,
	"name" => __("Blog Carousel", 'the7mk2'),
	"base" => "dt_blog_carousel",
	"icon" => "dt_vc_ico_blog_carousel",
	"class" => "dt_blog_carousel",
	"category" => __('by Dream-Theme', 'the7mk2'),
	"params" => array(
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
		),
		array(
			'heading' => __('Total number of posts', 'the7mk2'),
			'param_name' => 'dis_posts_total',
			'type' => 'dt_number',
			'value' => '6',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'description' => __('Leave empty to display all posts.', 'the7mk2'),
		),
		array(
			'heading'          => __( 'Posts offset', 'the7mk2' ),
			'param_name'       => 'posts_offset',
			'type'             => 'dt_number',
			'value'            => 0,
			'min'              => 0,
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'description'      => __( 'Offset for posts query (i.e. 2 means, posts will be displayed starting from the third post).', 'the7mk2' ),
		),
		// - Layout Settings.
		array(
			'heading' => __( 'Layout Settings', 'the7mk2' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
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
		// -- Bottom overlap.
		array(
			'heading' => __('Content area width', 'the7mk2'),
			'param_name' => 'bo_content_width',
			'type' => 'dt_number',
			'value' => '75%',
			'units' => 'px, %',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency' => array(
				'element' => 'layout',
				'value' => 'bottom_overlap',
			),
		),
		array(
			'heading' => __('Content area top overlap', 'the7mk2'),
			'param_name' => 'bo_content_top_overlap',
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
			'description'   => __( 'Leave empty to use default content boxes color & decoration.', 'the7mk2' ),
		),
		array(
			'heading' => __('Content area paddings', 'the7mk2'),
			'param_name' => 'post_content_paddings',
			'type' => 'dt_spacing',
			'value' => '15px 20px 20px 20px',
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
		array(
			"heading" => __( "Columns & Responsiveness", 'the7mk2' ),
			"param_name" => "dt_title_general",
			"type" => "dt_title",
		),
		array(
			"heading" => __("Wide desktop", 'the7mk2'),
			"param_name" => "slides_on_wide_desk",
			"type" => "textfield",
			"value" => "4",
			"edit_field_class" => "vc_media-xs vc_col-xs-2 vc_column",
		),
		array(
			"heading" => __("Desktop", 'the7mk2'),
			"param_name" => "slides_on_desk",
			"type" => "textfield",
			"value" => "3",
			"edit_field_class" => "vc_media-xs vc_col-xs-2 vc_column",
		),
		array(
			"heading" => __("Laptop", 'the7mk2'),
			"param_name" => "slides_on_lapt",
			"type" => "textfield",
			"value" => "3",
			"edit_field_class" => "vc_media-xs vc_col-xs-2 vc_column",
		),
		array(
			"heading" => __("Hor. tablet ", 'the7mk2'),
			"param_name" => "slides_on_h_tabs",
			"type" => "textfield",
			"value" => "3",
			"edit_field_class" => "vc_media-xs vc_col-xs-2 vc_column",
		),
		array(
			"heading" => __("Vert. tablet", 'the7mk2'),
			"param_name" => "slides_on_v_tabs",
			"type" => "textfield",
			"value" => "2",
			"edit_field_class" => "vc_media-xs vc_col-xs-2 vc_column",
		),
		array(
			"heading" => __("Phone", 'the7mk2'),
			"param_name" => "slides_on_mob",
			"type" => "textfield",
			"value" => "1",
			"edit_field_class" => "vc_media-xs vc_col-xs-2 vc_column",
		),
		array(
			"heading" => __("Gap between columns ", 'the7mk2'),
			"param_name" => "item_space",
			"type" => "dt_number",
			"value" => "30",
			"edit_field_class" => "vc_col-xs-12 vc_column dt_row-6",
		),
		array(
			'heading'          => __( 'Stage padding ', 'the7mk2' ),
			'param_name'       => 'stage_padding',
			'type'             => 'dt_number',
			'value'            => '0',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			"heading" => __("Enable adaptive height", "the7mk2"),
			"param_name" => "adaptive_height",
			'type' => 'dt_switch',
			'value' => 'y',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
		),
		array(
			"heading" => __( "Scrolling", 'the7mk2' ),
			"param_name" => "dt_title_general",
			"type" => "dt_title",
			"value" => "",
		),
		array(
			"heading" => __("Scroll mode", 'the7mk2'),
			"param_name" => "slide_to_scroll",
			"type" => "dropdown",
			"value" => array(
				"One slide at a time" => "single",
				"All slides" => "all",
			),

			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'heading'     => __( 'Transition speed', 'the7mk2' ),
			'description' => __( '(milliseconds)', 'the7mk2' ),
			'param_name'  => 'speed',
			'type'        => 'dt_number',
			'value'       => '600',
			'min'         => '100',
			'max'         => '10000',
			'step'        => '100',
		),
		array(
			"heading" => __("Autoplay slides‏", "the7mk2"),
			"param_name" => "autoplay",
			'type' => 'dt_switch',
			'value' => 'n',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
		),
		array(
			'heading'     => __( 'Autoplay speed', 'the7mk2' ),
			'description' => __( '(milliseconds)', 'the7mk2' ),
			'param_name'  => 'autoplay_speed',
			'type'        => 'dt_number',
			'value'       => '6000',
			'min'         => '100',
			'max'         => '10000',
			'step'        => '10',
			'dependency'  => array( 'element' => 'autoplay', 'value' => array( 'y' ) ),
		),
		array(
			'heading' => __( 'Extra Class', 'the7mk2' ),
			'param_name' => 'dt_title_general',
			'type' => 'dt_title',
			'value' => '',
		),
		array(
			"type" => "textfield",
			"heading" => __("Extra class name (optional)","the7mk2"),
			"param_name" => "el_class",
			"value" => "",
			"description" => __("Style particular elements differently - add a class name and refer to it in custom CSS.", "the7mk2"),
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
		// Naviagtion group.
		array(
			"group" => __("Arrows", 'the7mk2'),
			"heading" => __("Show arrows", 'the7mk2'),
			"param_name" => "arrows",
			'type' => 'dt_switch',
			'value' => 'y',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
		),
		array(
			"group" => __("Arrows", 'the7mk2'),
			"heading" => __( "Arrow Icon", 'the7mk2' ),
			"param_name" => "dt_title_arrows",
			"type" => "dt_title",
			"value" => "",
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		array(
			"group" => __("Arrows", 'the7mk2'),
			"heading" => __("Choose icon for 'Next Arrow'", "the7mk2"),
			"param_name" => "next_icon",
			"type" => "dt_navigation",
			"value" => "icon-ar-017-r",
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		array(
			"group" => __("Arrows", 'the7mk2'),
			"heading" => __("Choose icon  for 'Prev Arrow'", "the7mk2"),
			"param_name" => "prev_icon",
			"type" => "dt_navigation",
			"value" => "icon-ar-017-l",
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		array(
			"group" => __( "Arrows", 'the7mk2' ),
			"heading" => __("Arrow icon size", 'the7mk2'),
			"param_name" => "arrow_icon_size",
			"type" => "dt_number",
			"value" => "18px",
			"units" => "px",
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),

		array(
			"group" => __("Arrows", 'the7mk2'),
			"heading" => __( "Arrow Background", 'the7mk2' ),
			"param_name" => "dt_title_arrows",
			"type" => "dt_title",
			"value" => "",
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		array(
			"group" => __( "Arrows", 'the7mk2' ),
			"heading" => __("Width", 'the7mk2'),
			"param_name" => "arrow_bg_width",
			"type" => "dt_number",
			"value" => "36px",
			"units" => "x",
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
			"edit_field_class" => "vc_col-sm-3 vc_column dt_col_custom",
		),
		array(
			'group' => __( 'Arrows', 'the7mk2' ),
			'heading' => __('Height', 'the7mk2'),
			'param_name' => 'arrow_bg_height',
			'type' => 'dt_number',
			'value' => '36px',
			'units' => 'px',
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
			"edit_field_class" => "vc_col-sm-3 vc_column ",
		),
		array(
			'group' => __( 'Arrows', 'the7mk2' ),
			'heading' => __('Arrow border radius', 'the7mk2'),
			'param_name' => 'arrow_border_radius',
			'type' => 'dt_number',
			'value' => '500px',
			'units' => 'px',
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		array(
			'group' => __( 'Arrows', 'the7mk2' ),
			'heading' => __('Arrow border width', 'the7mk2'),
			'param_name' => 'arrow_border_width',
			'type' => 'dt_number',
			'value' => '0',
			'units' => 'px',
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		array(
			"group" => __("Arrows", 'the7mk2'),
			'heading' => __( 'Color Setting', 'the7mk2' ),
			'param_name' => 'dt_title_arrows',
			'type' => 'dt_title',
			'value' => '',
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		array(
			'group' => __( 'Arrows', 'the7mk2' ),
			'heading' => __('Arrow icon color', 'the7mk2'),
			'description' => __( "Live empty to use accent color.", 'the7mk2' ),
			'param_name' => 'arrow_icon_color',
			'type' => 'colorpicker',
			'value' => '#ffffff',
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		array(
			'group' => __( 'Arrows', 'the7mk2' ),
			'heading'    => __( 'Show arrow border color', 'the7mk2' ),
			'param_name' => 'arrow_icon_border',
			'type'       => 'dt_switch',
			'value'      => 'y',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		array(
			'group' => __( 'Arrows', 'the7mk2' ),
			'heading' => __('Arrow border color', 'the7mk2'),
			'description' => __( "Live empty to use accent color.", 'the7mk2' ),
			'param_name' => 'arrow_border_color',
			'type' => 'colorpicker',
			'value' => '',
			'dependency'	=> array(
				'element'	=> 'arrow_icon_border',
				'value'		=> 'y',
			),
		),
		array(
			"group" => __("Arrows", 'the7mk2'),
			"heading" => __("Show arrow background", 'the7mk2'),
			"param_name" => "arrows_bg_show",
			'type' => 'dt_switch',
			'value' => 'y',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		array(
			'group' => __( 'Arrows', 'the7mk2' ),
			'heading' => __('Arrow background color', 'the7mk2'),
			'description' => __( "Live empty to use accent color.", 'the7mk2' ),
			'param_name' => 'arrow_bg_color',
			'type' => 'colorpicker',
			'value' => '',
			'dependency'	=> array(
				'element'	=> 'arrows_bg_show',
				'value'		=> 'y',
			),
		),
		array(
			"group" => __("Arrows", 'the7mk2'),
			'heading' => __( 'Hover Color Setting', 'the7mk2' ),
			'param_name' => 'dt_title_arrows',
			'type' => 'dt_title',
			'value' => '',
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		array(
			'group' => __( 'Arrows', 'the7mk2' ),
			'heading' => __('Arrow icon color hover', 'the7mk2'),
			'description' => __( "Live empty to use accent color.", 'the7mk2' ),
			'param_name' => 'arrow_icon_color_hover',
			'type' => 'colorpicker',
			'value' => 'rgba(255,255,255,0.75)',
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		array(
			'group' => __( 'Arrows', 'the7mk2' ),
			'heading'    => __( 'Show arrow border color hover', 'the7mk2' ),
			'param_name' => 'arrow_icon_border_hover',
			'type'       => 'dt_switch',
			'value'      => 'y',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		array(
			'group' => __( 'Arrows', 'the7mk2' ),
			'heading' => __('Arrow border color hover ', 'the7mk2'),
			'description' => __( "Live empty to use accent color.", 'the7mk2' ),
			'param_name' => 'arrow_border_color_hover',
			'type' => 'colorpicker',
			'value' => '',
			'dependency'	=> array(
				'element'	=> 'arrow_icon_border_hover',
				'value'		=> 'y',
			),
		),
		array(
			"group" => __("Arrows", 'the7mk2'),
			"heading" => __("Show arrow background hover", 'the7mk2'),
			"param_name" => "arrows_bg_hover_show",
			'type' => 'dt_switch',
			'value' => 'y',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		array(
			'group' => __( 'Arrows', 'the7mk2' ),
			'heading' => __('Arrow background hover color', 'the7mk2'),
			'description' => __( "Live empty to use accent color.", 'the7mk2' ),
			'param_name' => 'arrow_bg_color_hover',
			'type' => 'colorpicker',
			'value' => '',
			'dependency'	=> array(
				'element'	=> 'arrows_bg_hover_show',
				'value'		=> 'y',
			),
		),
		// - Right arrow:
		array(
			"group" => __("Arrows", 'the7mk2'),
			'heading' => __( 'Right Arrow Position', 'the7mk2' ),
			'param_name' => 'dt_title_arrows',
			'type' => 'dt_title',
			'value' => '',
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		array(
			"group" => __("Arrows", 'the7mk2'),
			"heading" => __("Icon paddings", 'the7mk2'),
			"param_name" => "r_arrow_icon_paddings",
			"type" => "dt_spacing",
			"value" => "0 0 0 0",
			"units" => "px",
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		array(
			'group' => __( 'Arrows', 'the7mk2' ),
			"heading" => __("Vertical position", 'the7mk2'),
			"param_name" => "r_arrow_v_position",
			"type" => "dropdown",
			"value" => array(
				"Center" => "center",
				"Bottom" => "bottom",
				"Top" => "top",
			),
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'group' => __( 'Arrows', 'the7mk2' ),
			"heading" => __("Horizontal position", 'the7mk2'),
			"param_name" => "r_arrow_h_position",
			"type" => "dropdown",
			"value" => array(
				"Right" => "right",
				"Center" => "center",
				"Left" => "left",
			),
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'group' => __( 'Arrows', 'the7mk2' ),
			'heading' => __('Vertical offset', 'the7mk2'),
			'param_name' => 'r_arrow_v_offset',
			'type' => 'dt_number',
			'value' => '0',
			'units' => 'px',
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		array(
			'group' => __( 'Arrows', 'the7mk2' ),
			'heading' => __('Horizontal offset', 'the7mk2'),
			'param_name' => 'r_arrow_h_offset',
			'type' => 'dt_number',
			'value' => '-43px',
			'units' => 'px',
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		// - Left arrow:
		array(
			"group" => __("Arrows", 'the7mk2'),
			'heading' => __( 'Left Arrow Position', 'the7mk2' ),
			'param_name' => 'dt_title_arrows',
			'type' => 'dt_title',
			'value' => '',
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		array(
			"group" => __("Arrows", 'the7mk2'),
			"heading" => __("Icon paddings", 'the7mk2'),
			"param_name" => "l_arrow_icon_paddings",
			"type" => "dt_spacing",
			"value" => "0 0 0 0",
			"units" => "px",
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		array(
			'group' => __( 'Arrows', 'the7mk2' ),
			"heading" => __("Vertical position", 'the7mk2'),
			"param_name" => "l_arrow_v_position",
			"type" => "dropdown",
			"value" => array(
				"Center" => "center",
				"Bottom" => "bottom",
				"Top" => "top",
			),
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'group' => __( 'Arrows', 'the7mk2' ),
			"heading" => __("Horizontal position", 'the7mk2'),
			"param_name" => "l_arrow_h_position",
			"type" => "dropdown",
			"value" => array(
				"Left" => "left",
				"Right" => "right",
				"Center" => "center",
			),
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'group' => __( 'Arrows', 'the7mk2' ),
			'heading' => __('Vertical offset', 'the7mk2'),
			'param_name' => 'l_arrow_v_offset',
			'type' => 'dt_number',
			'value' => '0',
			'units' => 'px',
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		array(
			'group' => __( 'Arrows', 'the7mk2' ),
			'heading' => __('Horizontal offset', 'the7mk2'),
			'param_name' => 'l_arrow_h_offset',
			'type' => 'dt_number',
			'value' => '-43px',
			'units' => 'px',
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		//Arrows Responsiveness
		array(
			"group" => __("Arrows", 'the7mk2'),
			'heading' => __( 'Arrows responsiveness', 'the7mk2' ),
			'param_name' => 'dt_title_arrows',
			'type' => 'dt_title',
			'value' => '',
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		array(
			"group" => __("Arrows", 'the7mk2'),
			"heading" => __("Arrows behaviour","the7mk2"),
			"param_name" => "arrow_responsiveness",
			"type" => "dropdown",
			"value" => array(
				"Reposition arrows" => "reposition-arrows",
				"Leave as is" => "no-changes",
				"Hide arrows" => "hide-arrows",
			),
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			"group" => __("Arrows", 'the7mk2'),
			'heading' => __('Enable if browser width is less then ', 'the7mk2'),
			'param_name' => 'hide_arrows_mobile_switch_width',
			'type' => 'dt_number',
			'value' => '778px',
			'units' => 'px',
			"dependency" => Array("element" => "arrow_responsiveness", "value" => array("hide-arrows")),
		),
		array(
			"group" => __("Arrows", 'the7mk2'),
			'heading' => __('Enable if browser width is less then ', 'the7mk2'),
			'param_name' => 'reposition_arrows_mobile_switch_width',
			'type' => 'dt_number',
			'value' => '778px',
			'units' => 'px',
			"dependency" => Array("element" => "arrow_responsiveness", "value" => array("reposition-arrows")),
		),
		array(
			"group" => __("Arrows", 'the7mk2'),
			'heading' => __('Left arrow horizontal offset', 'the7mk2'),
			'param_name' => 'l_arrows_mobile_h_position',
			'type' => 'dt_number',
			'value' => '10px',
			'units' => 'px',
			"dependency" => Array("element" => "arrow_responsiveness", "value" => array("reposition-arrows")),
		),
		array(
			"group" => __("Arrows", 'the7mk2'),
			'heading' => __('Right arrow horizontal offset', 'the7mk2'),
			'param_name' => 'r_arrows_mobile_h_position',
			'type' => 'dt_number',
			'value' => '10px',
			'units' => 'px',
			"dependency" => Array("element" => "arrow_responsiveness", "value" => array("reposition-arrows")),
		),
		//BULLETS
		array(
			"group" => __("Bullets", 'the7mk2'),
			"heading" => __("Show bullets", 'the7mk2'),
			"param_name" => "show_bullets",
			'type' => 'dt_switch',
			'value' => 'n',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
		),
		array(
			"group" => __("Bullets", 'the7mk2'),
			'heading' => __( 'Bullets Style, Size & Color', 'the7mk2' ),
			'param_name' => 'dt_title_bullets',
			'type' => 'dt_title',
			'value' => '',
			'dependency'	=> array(
				'element'	=> 'show_bullets',
				'value'		=> 'y',
			),

		),
		array(
			"group" => __("Bullets", 'the7mk2'),
			"heading" => __("Choose bullets style","the7mk2"),
			"param_name" => "bullets_style",
			"type" => "dropdown",
			"value" => array(
				"SMALL DOT STROKE" => "small-dot-stroke",
				"SCALE UP" => "scale-up",
				"STROKE" => "stroke",
				"FILL IN" => "fill-in",
				"SQUARE" => "ubax",
				"RECTANGULAR" => "etefu",
			),
			'dependency'	=> array(
				'element'	=> 'show_bullets',
				'value'		=> 'y',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'group' => __( 'Bullets', 'the7mk2' ),
			'heading' => __('Bullets size', 'the7mk2'),
			'param_name' => 'bullet_size',
			'type' => 'dt_number',
			'value' => '10px',
			'units' => 'px',
			'dependency'	=> array(
				'element'	=> 'show_bullets',
				'value'		=> 'y',
			),
		),
		array(
			'group' => __( 'Bullets', 'the7mk2' ),
			'heading' => __('Gap between bullets', 'the7mk2'),
			'param_name' => 'bullet_gap',
			'type' => 'dt_number',
			'value' => '16px',
			'units' => 'px',
			'dependency'	=> array(
				'element'	=> 'show_bullets',
				'value'		=> 'y',
			),
		),
		array(
			'group' => __( 'Bullets', 'the7mk2' ),
			'heading' => __('Bullets color', 'the7mk2'),
			'description' => __( 'Live empty to use accent color.', 'the7mk2' ),
			'param_name' => 'bullet_color',
			'type' => 'colorpicker',
			'value' => '',
			'dependency'	=> array(
				'element'	=> 'show_bullets',
				'value'		=> 'y',
			),
		),
		array(
			'group' => __( 'Bullets', 'the7mk2' ),
			'heading' => __('Bullets hover color', 'the7mk2'),
			'description' => __( 'Live empty to use accent color.', 'the7mk2' ),
			'param_name' => 'bullet_color_hover',
			'type' => 'colorpicker',
			'value' => '',
			'dependency'	=> array(
				'element'	=> 'show_bullets',
				'value'		=> 'y',
			),
		),
		array(
			"group" => __("Bullets", 'the7mk2'),
			'heading' => __( 'Bullets Position', 'the7mk2' ),
			'param_name' => 'dt_title_bullets',
			'type' => 'dt_title',
			'value' => '',
			'dependency'	=> array(
				'element'	=> 'show_bullets',
				'value'		=> 'y',
			),
		),
		array(
			'group' => __( 'Bullets', 'the7mk2' ),
			"heading" => __("Vertical position", 'the7mk2'),
			"param_name" => "bullets_v_position",
			"type" => "dropdown",
			"value" => array(
				"Bottom" => "bottom",
				"Top" => "top",
				"Center" => "center",
			),
			'dependency'	=> array(
				'element'	=> 'show_bullets',
				'value'		=> 'y',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'group' => __( 'Bullets', 'the7mk2' ),
			"heading" => __("Horizontal position", 'the7mk2'),
			"param_name" => "bullets_h_position",
			"type" => "dropdown",
			"value" => array(
				"Center" => "center",
				"Right" => "right",
				"Left" => "left",
			),
			'dependency'	=> array(
				'element'	=> 'show_bullets',
				'value'		=> 'y',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'group' => __( 'Bullets', 'the7mk2' ),
			'heading' => __('Vertical offset', 'the7mk2'),
			'param_name' => 'bullets_v_offset',
			'type' => 'dt_number',
			'value' => '20px',
			'units' => 'px',
			'dependency'	=> array(
				'element'	=> 'show_bullets',
				'value'		=> 'y',
			),
		),
		array(
			'group' => __( 'Bullets', 'the7mk2' ),
			'heading' => __('Horizontal offset', 'the7mk2'),
			'param_name' => 'bullets_h_offset',
			'type' => 'dt_number',
			'value' => '0',
			'units' => 'px',
			'dependency'	=> array(
				'element'	=> 'show_bullets',
				'value'		=> 'y',
			),
		),
		array(
			'type' => 'css_editor',
			'heading' => __( 'CSS box', 'the7mk2' ),
			'param_name' => 'css_dt_blog_carousel',
			'group' => __( 'Design Options', 'the7mk2' )
		),
	),

);
