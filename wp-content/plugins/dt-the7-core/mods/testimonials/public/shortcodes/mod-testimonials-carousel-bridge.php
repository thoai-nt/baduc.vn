<?php

// File Security Check.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	"weight" => -1,
	"name" => __("Testimonials Carousel", 'dt-the7-core'),
	"base" => "dt_testimonials_carousel",
	"icon" => "dt_vc_ico_testimonials_carousel",
	"class" => "dt_testimonials_carousel",
	"category" => __('by Dream-Theme', 'dt-the7-core'),
	"params" => array(
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
		),
		array(
			'heading'          => __( 'Order by', 'dt-the7-core' ),
			'param_name'       => 'orderby',
			'type'             => 'dropdown',
			'std'              => 'date',
			'value'            => array(
				'Author'        => 'author',
				'Slug'          => 'name',
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
			'heading' => __('Total number of posts', 'dt-the7-core'),
			'param_name' => 'dis_posts_total',
			'type' => 'dt_number',
			'value' => '6',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'description' => __('Leave empty to display all posts.', 'dt-the7-core'),
		),
		// - Layout Settings.
		array(
			'heading' => __( 'Layout Settings', 'dt-the7-core' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
		),
		array(
			'heading' => __('Layout', 'dt-the7-core'),
			'param_name' => 'content_layout',
			'type' => 'dt_radio_image',
			'value' => 'layout_4',
			'options' => array(
				'layout_1'       => array(
					'title' => _x( 'Layout 1', 'dt-the7-core' ),
					'src' => '/inc/shortcodes/images/l01.gif',
				),
				'layout_2'        => array(
					'title' => _x( 'Layout 2', 'dt-the7-core' ),
					'src' => '/inc/shortcodes/images/l02.gif',
				),
				'layout_3'         => array(
					'title' => _x( 'Layout 3', 'dt-the7-core' ),
					'src' => '/inc/shortcodes/images/l03.gif',
				),
				'layout_4'          => array(
					'title' => _x( 'Layout 4', 'dt-the7-core' ),
					'src' => '/inc/shortcodes/images/l04.gif',
				),
				'layout_5'     => array(
					'title' => _x( 'Layout 5', 'dt-the7-core' ),
					'src' => '/inc/shortcodes/images/l05.gif',
				),
				'layout_6'       => array(
					'title' => _x( 'Layout 6', 'dt-the7-core' ),
					'src' => '/inc/shortcodes/images/l06.gif',
				),
			),
		),
		// Post group.
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
			'description'   => __( 'Leave empty to use default content boxes color & decoration.', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Content area paddings', 'dt-the7-core'),
			'param_name' => 'post_content_paddings',
			'type' => 'dt_spacing',

			'value' => '30px 30px 20px 30px',
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
			'heading' => __('Show image', 'dt-the7-core'),
			'param_name' => 'show_avatar',
			'type' => 'dt_switch',
			'value' => 'y',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
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
			'dependency'	=> array(
				'element'	=> 'show_avatar',
				'value'		=> 'y',
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
			'heading' => __('Maximum width', 'dt-the7-core'),
			'param_name' => 'img_max_width',
			'type' => 'dt_number',
			'value' => '80',
			'units' => 'px',

			'dependency'	=> array(
				'element'	=> 'show_avatar',
				'value'		=> 'y',
			),
			'description' => __('Leave empty to use default width.', 'dt-the7-core'),
		),
		array(
			'heading' => __('Image paddings', 'dt-the7-core'),
			'param_name' => 'image_paddings',
			'type' => 'dt_spacing',
			'value' => '0px 20px 20px 0px',
			'units' => 'px, %',

			'dependency'	=> array(
				'element'	=> 'show_avatar',
				'value'		=> 'y',
			),
		),
		array(
			'heading' => __('Image border radius', 'dt-the7-core'),
			'param_name' => 'img_border_radius',
			'type' => 'dt_number',
			'value' => '500',
			'units' => 'px',

			'dependency'	=> array(
				'element'	=> 'show_avatar',
				'value'		=> 'y',
			),
		),

		array(
			"heading" => __( "Columns & Responsiveness", 'dt-the7-core' ),
			"param_name" => "dt_title_general",
			"type" => "dt_title",
		),
		array(
			"heading" => __("Wide desktop", 'dt-the7-core'),
			"param_name" => "slides_on_wide_desk",
			"type" => "textfield",
			"value" => "4",
			"edit_field_class" => "vc_media-xs vc_col-xs-2 vc_column",
		),
		array(
			"heading" => __("Desktop", 'dt-the7-core'),
			"param_name" => "slides_on_desk",
			"type" => "textfield",
			"value" => "3",
			"edit_field_class" => "vc_media-xs vc_col-xs-2 vc_column",
		),
		array(
			"heading" => __("Laptop", 'dt-the7-core'),
			"param_name" => "slides_on_lapt",
			"type" => "textfield",
			"value" => "3",
			"edit_field_class" => "vc_media-xs vc_col-xs-2 vc_column",
		),
		array(
			"heading" => __("Hor. tablet ", 'dt-the7-core'),
			"param_name" => "slides_on_h_tabs",
			"type" => "textfield",
			"value" => "2",
			"edit_field_class" => "vc_media-xs vc_col-xs-2 vc_column",
		),
		array(
			"heading" => __("Vert. tablet", 'dt-the7-core'),
			"param_name" => "slides_on_v_tabs",
			"type" => "textfield",
			"value" => "1",
			"edit_field_class" => "vc_media-xs vc_col-xs-2 vc_column",
		),
		array(
			"heading" => __("Phone", 'dt-the7-core'),
			"param_name" => "slides_on_mob",
			"type" => "textfield",
			"value" => "1",
			"edit_field_class" => "vc_media-xs vc_col-xs-2 vc_column",
		),
		array(
			"heading" => __("Gap between columns ", 'dt-the7-core'),
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
			"heading" => __("Enable adaptive height", "dt-the7-core"),
			"param_name" => "adaptive_height",
			'type' => 'dt_switch',
			'value' => 'n',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
		),
		array(
			"heading" => __( "Scrolling", 'dt-the7-core' ),
			"param_name" => "dt_title_general",
			"type" => "dt_title",
			"value" => "",
		),
		array(
			"heading" => __("Scroll mode", 'dt-the7-core'),
			"param_name" => "slide_to_scroll",
			"type" => "dropdown",
			"value" => array(
				"One slide at a time" => "single",
				"All slides" => "all",
			),

			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'heading'     => __( 'Transition speed', 'dt-the7-core' ),
			'description' => __( '(milliseconds)', 'dt-the7-core' ),
			'param_name'  => 'speed',
			'type'        => 'dt_number',
			'value'       => '600',
			'min'         => '100',
			'max'         => '10000',
			'step'        => '100',
		),
		array(
			"heading" => __("Autoplay slides‏", "dt-the7-core"),
			"param_name" => "autoplay",
			'type' => 'dt_switch',
			'value' => 'n',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
		),
		array(
			'heading'     => __( 'Autoplay speed', 'dt-the7-core' ),
			'description' => __( '(milliseconds)', 'dt-the7-core' ),
			'param_name'  => 'autoplay_speed',
			'type'        => 'dt_number',
			'value'       => '6000',
			'min'         => '100',
			'max'         => '10000',
			'step'        => '10',
			'dependency'  => array( 'element' => 'autoplay', 'value' => array( 'y' ) ),
		),
		array(
			'heading' => __( 'Extra Class', 'dt-the7-core' ),
			'param_name' => 'dt_title_general',
			'type' => 'dt_title',
			'value' => '',
		),
		array(
			"type" => "textfield",
			"heading" => __("Extra class name (optional)","dt-the7-core"),
			"param_name" => "el_class",
			"value" => "",
			"description" => __("Style particular elements differently - add a class name and refer to it in custom CSS.", "dt-the7-core"),
		),


		// - Testimonial Author Name.

		array(
			'heading' => __( 'Testimonial Author Name', 'dt-the7-core' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
			'group' => __( 'Testimonial', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Show author name', 'dt-the7-core'),
			'param_name' => 'testimonial_name',
			'type' => 'dt_switch',
			'value' => 'y',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			'group' => __( 'Testimonial', 'dt-the7-core' ),
		),
		array(
			'heading' => __( 'Font style', 'dt-the7-core' ),
			'param_name' => 'post_title_font_style',
			'type' => 'dt_font_style',
			'value' => ':bold:',
			'group' => __( 'Testimonial', 'dt-the7-core' ),
			'dependency' => array(
				'element' => 'testimonial_name',
				'value' => 'y',
			),
		),
		// array(
		// 	'heading' => __('Font size', 'dt-the7-core'),
		// 	'param_name' => 'post_title_font_size',
		// 	'type' => 'dt_number',
		// 	'value' => '',
		// 	'units' => 'px',
		// 	//'edit_field_class' => 'vc_col-sm-3 vc_column',
		// 	'description' => __( 'Leave empty to use H4 font size.', 'dt-the7-core' ),
		// 	'group' => __( 'Testimonial', 'dt-the7-core' ),
		// 	'dependency' => array(
		// 		'element' => 'testimonial_name',
		// 		'value' => 'y',
		// 	),
		// ),
		array(
			'heading' => __( 'Font size', 'dt-the7-core' ),
			'param_name' => 'dt_subtitle',
			'type' => 'dt_subtitle',
			'value' => '',
			'group' => __( 'Testimonial', 'dt-the7-core' ),
		),
		array(
			'heading' => __('', 'dt-the7-core'),
			'param_name' => 'post_title_font_size',
			'type' => 'dt_number_with_icon',
			'value' => '',
			'units' => 'px',
			'icon' => '<i class="ab-item ab-empty-item view-desktop"></i>',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'description' => __( 'Leave empty to use H4 font size. Tablet and mobile font sizes are optional.', 'dt-the7-core' ),
			'group' => __( 'Testimonial', 'dt-the7-core' ),
			'dependency' => array(
				'element' => 'testimonial_name',
				'value' => 'y',
			),
		),

		array(
			'heading' => __(' ', 'dt-the7-core'),
			'param_name' => 'post_title_font_size_tablet',
			'type' => 'dt_number_with_icon',
			'value' => '',
			'units' => 'px',
			'icon' => '<i class="ab-item ab-empty-item view-tablet"></i>',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'group' => __( 'Testimonial', 'dt-the7-core' ),
			'dependency' => array(
				'element' => 'testimonial_name',
				'value' => 'y',
			),
		),

		array(
			'heading' => __(' ', 'dt-the7-core'),
			'param_name' => 'post_title_font_size_phone',
			'type' => 'dt_number_with_icon',
			'value' => '',
			'units' => 'px',
			'icon' => '<i class="ab-item ab-empty-item view-mobile"></i>',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'group' => __( 'Testimonial', 'dt-the7-core' ),
			'dependency' => array(
				'element' => 'testimonial_name',
				'value' => 'y',
			),
		),
		array(
			'heading' => __( 'Line height', 'dt-the7-core' ),
			'param_name' => 'dt_subtitle',
			'type' => 'dt_subtitle',
			'value' => '',
			'group' => __( 'Testimonial', 'dt-the7-core' ),
		),
		array(
			'heading' => __('', 'dt-the7-core'),
			'param_name' => 'post_title_line_height',
			'type' => 'dt_number_with_icon',
			'value' => '',
			'units' => 'px',
			'icon' => '<i class="ab-item ab-empty-item view-desktop"></i>',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'description' => __( 'Leave empty to use H4 line height. Tablet and mobile font line heights are optional.', 'dt-the7-core' ),
			'group' => __( 'Testimonial', 'dt-the7-core' ),
			'dependency' => array(
				'element' => 'testimonial_name',
				'value' => 'y',
			),
		),
		array(
			'heading' => __(' ', 'dt-the7-core'),
			'param_name' => 'post_title_line_height_tablet',
			'type' => 'dt_number_with_icon',
			'value' => '',
			'units' => 'px',
			'icon' => '<i class="ab-item ab-empty-item view-tablet"></i>',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'group' => __( 'Testimonial', 'dt-the7-core' ),
			'dependency' => array(
				'element' => 'testimonial_name',
				'value' => 'y',
			),
		),

		array(
			'heading' => __(' ', 'dt-the7-core'),
			'param_name' => 'post_title_line_height_phone',
			'type' => 'dt_number_with_icon',
			'value' => '',
			'units' => 'px',
			'icon' => '<i class="ab-item ab-empty-item view-mobile"></i>',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'group' => __( 'Testimonial', 'dt-the7-core' ),
			'dependency' => array(
				'element' => 'testimonial_name',
				'value' => 'y',
			),
		),
		array(
			'heading'		=> __('Font color', 'dt-the7-core'),
			'param_name'	=> 'custom_title_color',
			'type'			=> 'colorpicker',
			'value'			=> '',
			'description' => __( 'Leave empty to use headers color.', 'dt-the7-core' ),
			'group' => __( 'Testimonial', 'dt-the7-core' ),
			'dependency' => array(
				'element' => 'testimonial_name',
				'value' => 'y',
			),
		),
		array(
			'heading' => __('Gap below name', 'dt-the7-core'),
			'param_name' => 'post_title_bottom_margin',
			'type' => 'dt_number',
			'value' => '0',
			'units' => 'px',
			'group' => __( 'Testimonial', 'dt-the7-core' ),
			'dependency' => array(
				'element' => 'testimonial_name',
				'value' => 'y',
			),
		),
		// - Meta Information.
		array(
			'heading' => __( 'Testimonial Author Position', 'dt-the7-core' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
			'group' => __( 'Testimonial', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Show position', 'dt-the7-core'),
			'param_name' => 'testimonial_position',
			'type' => 'dt_switch',
			'value' => 'y',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
			'group' => __( 'Testimonial', 'dt-the7-core' ),
		),

		array(
			'heading' => __( 'Font style', 'dt-the7-core' ),
			'param_name' => 'testimonial_position_font_style',
			'type' => 'dt_font_style',
			'value' => 'normal:bold:none',
			'group' => __( 'Testimonial', 'dt-the7-core' ),
			'dependency' => array(
				'element' => 'testimonial_position',
				'value' => 'y',
			),
		),
		// array(
		// 	'heading' => __('Font size', 'dt-the7-core'),
		// 	'param_name' => 'testimonial_position_font_size',
		// 	'type' => 'dt_number',
		// 	'value' => '',
		// 	'units' => 'px',
		// 	'edit_field_class' => 'vc_col-sm-3 vc_column',
		// 	'description' => __( 'Leave empty to use medium font size.', 'dt-the7-core' ),
		// 	'group' => __( 'Testimonial', 'dt-the7-core' ),
		// 	'dependency' => array(
		// 		'element' => 'testimonial_position',
		// 		'value' => 'y',
		// 	),
		// ),
		array(
			'heading' => __( 'Font size', 'dt-the7-core' ),
			'param_name' => 'dt_subtitle',
			'type' => 'dt_subtitle',
			'value' => '',
			'group' => __( 'Testimonial', 'dt-the7-core' ),
		),
		array(
			'heading' => __('', 'dt-the7-core'),
			'param_name' => 'testimonial_position_font_size',
			'type' => 'dt_number_with_icon',
			'value' => '',
			'units' => 'px',
			'icon' => '<i class="ab-item ab-empty-item view-desktop"></i>',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'description' => __( 'Leave empty to use medium font size. Tablet and mobile font sizes are optional.', 'dt-the7-core' ),
			'group' => __( 'Testimonial', 'dt-the7-core' ),
			'dependency' => array(
				'element' => 'testimonial_position',
				'value' => 'y',
			),
		),

		array(
			'heading' => __(' ', 'dt-the7-core'),
			'param_name' => 'testimonial_position_font_size_tablet',
			'type' => 'dt_number_with_icon',
			'value' => '',
			'units' => 'px',
			'icon' => '<i class="ab-item ab-empty-item view-tablet"></i>',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'group' => __( 'Testimonial', 'dt-the7-core' ),
			'dependency' => array(
				'element' => 'testimonial_position',
				'value' => 'y',
			),
		),

		array(
			'heading' => __(' ', 'dt-the7-core'),
			'param_name' => 'testimonial_position_font_size_phone',
			'type' => 'dt_number_with_icon',
			'value' => '',
			'units' => 'px',
			'icon' => '<i class="ab-item ab-empty-item view-mobile"></i>',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'group' => __( 'Testimonial', 'dt-the7-core' ),
			'dependency' => array(
				'element' => 'testimonial_position',
				'value' => 'y',
			),
		),
		// array(
		// 	'heading' => __('Line height', 'dt-the7-core'),
		// 	'param_name' => 'testimonial_position_line_height',
		// 	'type' => 'dt_number',
		// 	'value' => '',
		// 	'units' => 'px',
		// 	'edit_field_class' => 'vc_col-sm-3 vc_column',
		// 	'description' => __( 'Leave empty to use medium line height.', 'dt-the7-core' ),
		// 	'group' => __( 'Testimonial', 'dt-the7-core' ),
		// 	'dependency' => array(
		// 		'element' => 'testimonial_position',
		// 		'value' => 'y',
		// 	),
		// ),
		array(
			'heading' => __( 'Line height', 'dt-the7-core' ),
			'param_name' => 'dt_subtitle',
			'type' => 'dt_subtitle',
			'value' => '',
			'group' => __( 'Testimonial', 'dt-the7-core' ),
		),
		array(
			'heading' => __('', 'dt-the7-core'),
			'param_name' => 'testimonial_position_line_height',
			'type' => 'dt_number_with_icon',
			'value' => '',
			'units' => 'px',
			'icon' => '<i class="ab-item ab-empty-item view-desktop"></i>',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'description' => __( 'Leave empty to use medium line height. Tablet and mobile font line heights are optional.', 'dt-the7-core' ),
			'group' => __( 'Testimonial', 'dt-the7-core' ),
			'dependency' => array(
				'element' => 'testimonial_position',
				'value' => 'y',
			),
		),
		array(
			'heading' => __(' ', 'dt-the7-core'),
			'param_name' => 'testimonial_position_line_height_tablet',
			'type' => 'dt_number_with_icon',
			'value' => '',
			'units' => 'px',
			'icon' => '<i class="ab-item ab-empty-item view-tablet"></i>',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'group' => __( 'Testimonial', 'dt-the7-core' ),
			'dependency' => array(
				'element' => 'testimonial_position',
				'value' => 'y',
			),
		),

		array(
			'heading' => __(' ', 'dt-the7-core'),
			'param_name' => 'testimonial_position_line_height_phone',
			'type' => 'dt_number_with_icon',
			'value' => '',
			'units' => 'px',
			'icon' => '<i class="ab-item ab-empty-item view-mobile"></i>',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'group' => __( 'Testimonial', 'dt-the7-core' ),
			'dependency' => array(
				'element' => 'testimonial_position',
				'value' => 'y',
			),
		),
		array(
			'heading'		=> __('Font color', 'dt-the7-core'),
			'param_name'	=> 'testimonial_position_color',
			'type'			=> 'colorpicker',
			'value'			=> '',
			'description' => __( 'Leave empty to use accent text color.', 'dt-the7-core' ),
			'group' => __( 'Testimonial', 'dt-the7-core' ),
			'dependency' => array(
				'element' => 'testimonial_position',
				'value' => 'y',
			),
		),
		array(
			'heading' => __('Gap below position', 'dt-the7-core'),
			'param_name' => 'testimonial_position_bottom_margin',
			'type' => 'dt_number',
			'value' => '20px',
			'units' => 'px',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'group' => __( 'Testimonial', 'dt-the7-core' ),
			'dependency' => array(
				'element' => 'testimonial_position',
				'value' => 'y',
			),
		),
		// - Text.
		array(
			'heading' => __( 'Testimonial', 'dt-the7-core' ),
			'param_name' => 'dt_title',
			'type' => 'dt_title',
			'value' => '',
			'group' => __( 'Testimonial', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Testimonial content or excerpt', 'dt-the7-core'),
			'param_name' => 'post_content',
			'type' => 'dropdown',
			'std' => 'show_excerpt',
			'value' => array(
				'Excerpt' => 'show_excerpt',
				'Content' => 'show_content',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'group' => __( 'Testimonial', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Maximum number of words', 'dt-the7-core'),
			'param_name' => 'excerpt_words_limit',
			'type' => 'dt_number',
			'value' => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'description' => __( 'Leave empty to show full text.', 'dt-the7-core' ),
			'group' => __( 'Testimonial', 'dt-the7-core' ),
			'dependency' => array(
				'element' => 'post_content',
				'value' => 'show_excerpt',
			),
		),
		array(
			'heading' => __( 'Font style', 'dt-the7-core' ),
			'param_name' => 'content_font_style',
			'type' => 'dt_font_style',
			'value' => '',
			'group' => __( 'Testimonial', 'dt-the7-core' ),
		),
		// array(
		// 	'heading' => __('Font size', 'dt-the7-core'),
		// 	'param_name' => 'content_font_size',
		// 	'type' => 'dt_number',
		// 	'value' => '',
		// 	'units' => 'px',
		// 	'edit_field_class' => 'vc_col-sm-3 vc_column',
		// 	'description' => __( 'Leave empty to use large font size.', 'dt-the7-core' ),
		// 	'group' => __( 'Testimonial', 'dt-the7-core' ),
		// ),
		array(
			'heading' => __( 'Font size', 'dt-the7-core' ),
			'param_name' => 'dt_subtitle',
			'type' => 'dt_subtitle',
			'value' => '',
			'group' => __( 'Testimonial', 'dt-the7-core' ),
		),
		array(
			'heading' => __('', 'dt-the7-core'),
			'param_name' => 'content_font_size',
			'type' => 'dt_number_with_icon',
			'value' => '',
			'units' => 'px',
			'icon' => '<i class="ab-item ab-empty-item view-desktop"></i>',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'description' => __( 'Leave empty to use large font size.', 'dt-the7-core' ),
			'group' => __( 'Testimonial', 'dt-the7-core' ),
		),

		array(
			'heading' => __(' ', 'dt-the7-core'),
			'param_name' => 'content_font_size_tablet',
			'type' => 'dt_number_with_icon',
			'value' => '',
			'units' => 'px',
			'icon' => '<i class="ab-item ab-empty-item view-tablet"></i>',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'group' => __( 'Testimonial', 'dt-the7-core' ),
		),

		array(
			'heading' => __(' ', 'dt-the7-core'),
			'param_name' => 'content_font_size_phone',
			'type' => 'dt_number_with_icon',
			'value' => '',
			'units' => 'px',
			'icon' => '<i class="ab-item ab-empty-item view-mobile"></i>',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'group' => __( 'Testimonial', 'dt-the7-core' ),
		),
		// array(
		// 	'heading' => __('Line height', 'dt-the7-core'),
		// 	'param_name' => 'content_line_height',
		// 	'type' => 'dt_number',
		// 	'value' => '',
		// 	'units' => 'px',
		// 	'edit_field_class' => 'vc_col-sm-3 vc_column',
		// 	'description' => __( 'Leave empty to use medium line height.', 'dt-the7-core' ),
		// 	'group' => __( 'Testimonial', 'dt-the7-core' ),
		// ),
		array(
			'heading' => __( 'Line height', 'dt-the7-core' ),
			'param_name' => 'dt_subtitle',
			'type' => 'dt_subtitle',
			'value' => '',
			'group' => __( 'Testimonial', 'dt-the7-core' ),
		),
		array(
			'heading' => __('', 'dt-the7-core'),
			'param_name' => 'content_line_height',
			'type' => 'dt_number_with_icon',
			'value' => '',
			'units' => 'px',
			'icon' => '<i class="ab-item ab-empty-item view-desktop"></i>',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'description' => __( 'Leave empty to use large line height. Tablet and mobile font sizes are optional.', 'dt-the7-core' ),
			'group' => __( 'Testimonial', 'dt-the7-core' ),
		),

		array(
			'heading' => __(' ', 'dt-the7-core'),
			'param_name' => 'content_line_height_tablet',
			'type' => 'dt_number_with_icon',
			'value' => '',
			'units' => 'px',
			'icon' => '<i class="ab-item ab-empty-item view-tablet"></i>',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'group' => __( 'Testimonial', 'dt-the7-core' ),
		),

		array(
			'heading' => __(' ', 'dt-the7-core'),
			'param_name' => 'content_line_height_phone',
			'type' => 'dt_number_with_icon',
			'value' => '',
			'units' => 'px',
			'icon' => '<i class="ab-item ab-empty-item view-mobile"></i>',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'group' => __( 'Testimonial', 'dt-the7-core' ),
		),
		array(
			'heading'		=> __('Font color', 'dt-the7-core'),
			'param_name'	=> 'custom_content_color',
			'type'			=> 'colorpicker',
			'value'			=> '',
			'description' => __( 'Leave empty to use primary text color. Tablet and mobile font line heights are optional.', 'dt-the7-core' ),
			'group' => __( 'Testimonial', 'dt-the7-core' ),
		),
		array(
			'heading' => __('Gap below testimonial', 'dt-the7-core'),
			'param_name' => 'content_bottom_margin',
			'type' => 'dt_number',
			'value' => '0',
			'units' => 'px',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'group' => __( 'Testimonial', 'dt-the7-core' ),
		),

		// Naviagtion group.
		array(
			"group" => __("Arrows", 'dt-the7-core'),
			"heading" => __("Show arrows", 'dt-the7-core'),
			"param_name" => "arrows",
			'type' => 'dt_switch',
			'value' => 'y',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
		),
		array(
			"group" => __("Arrows", 'dt-the7-core'),
			"heading" => __( "Arrow Icon", 'dt-the7-core' ),
			"param_name" => "dt_title_arrows",
			"type" => "dt_title",
			"value" => "",
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		array(
			"group" => __("Arrows", 'dt-the7-core'),
			"heading" => __("Choose icon for 'Next Arrow'", "dt-the7-core"),
			"param_name" => "next_icon",
			"type" => "dt_navigation",
			"value" => "icon-ar-017-r",
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		array(
			"group" => __("Arrows", 'dt-the7-core'),
			"heading" => __("Choose icon  for 'Prev Arrow'", "dt-the7-core"),
			"param_name" => "prev_icon",
			"type" => "dt_navigation",
			"value" => "icon-ar-017-l",
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		array(
			"group" => __( "Arrows", 'dt-the7-core' ),
			"heading" => __("Arrow icon size", 'dt-the7-core'),
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
			"group" => __("Arrows", 'dt-the7-core'),
			"heading" => __( "Arrow Background", 'dt-the7-core' ),
			"param_name" => "dt_title_arrows",
			"type" => "dt_title",
			"value" => "",
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		array(
			"group" => __( "Arrows", 'dt-the7-core' ),
			"heading" => __("Width", 'dt-the7-core'),
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
			'group' => __( 'Arrows', 'dt-the7-core' ),
			'heading' => __('Height', 'dt-the7-core'),
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
			'group' => __( 'Arrows', 'dt-the7-core' ),
			'heading' => __('Arrow border radius', 'dt-the7-core'),
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
			'group' => __( 'Arrows', 'dt-the7-core' ),
			'heading' => __('Arrow border width', 'dt-the7-core'),
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
			"group" => __("Arrows", 'dt-the7-core'),
			'heading' => __( 'Color Setting', 'dt-the7-core' ),
			'param_name' => 'dt_title_arrows',
			'type' => 'dt_title',
			'value' => '',
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		array(
			'group' => __( 'Arrows', 'dt-the7-core' ),
			'heading' => __('Arrow icon color', 'dt-the7-core'),
			'description' => __( "Live empty to use accent color.", 'dt-the7-core' ),
			'param_name' => 'arrow_icon_color',
			'type' => 'colorpicker',
			'value' => '#ffffff',
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		array(
			'group' => __( 'Arrows', 'dt-the7-core' ),
			'heading'    => __( 'Show arrow border color', 'dt-the7-core' ),
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
			'group' => __( 'Arrows', 'dt-the7-core' ),
			'heading' => __('Arrow border color', 'dt-the7-core'),
			'description' => __( "Live empty to use accent color.", 'dt-the7-core' ),
			'param_name' => 'arrow_border_color',
			'type' => 'colorpicker',
			'value' => '',
			'dependency'	=> array(
				'element'	=> 'arrow_icon_border',
				'value'		=> 'y',
			),
		),
		array(
			"group" => __("Arrows", 'dt-the7-core'),
			"heading" => __("Show arrow background", 'dt-the7-core'),
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
			'group' => __( 'Arrows', 'dt-the7-core' ),
			'heading' => __('Arrow background color', 'dt-the7-core'),
			'description' => __( "Live empty to use accent color.", 'dt-the7-core' ),
			'param_name' => 'arrow_bg_color',
			'type' => 'colorpicker',
			'value' => '',
			'dependency'	=> array(
				'element'	=> 'arrows_bg_show',
				'value'		=> 'y',
			),
		),
		array(
			"group" => __("Arrows", 'dt-the7-core'),
			'heading' => __( 'Hover Color Setting', 'dt-the7-core' ),
			'param_name' => 'dt_title_arrows',
			'type' => 'dt_title',
			'value' => '',
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		array(
			'group' => __( 'Arrows', 'dt-the7-core' ),
			'heading' => __('Arrow icon color hover', 'dt-the7-core'),
			'description' => __( "Live empty to use accent color.", 'dt-the7-core' ),
			'param_name' => 'arrow_icon_color_hover',
			'type' => 'colorpicker',
			'value' => 'rgba(255,255,255,0.75)',
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),

		array(
			'group' => __( 'Arrows', 'dt-the7-core' ),
			'heading'    => __( 'Show arrow border color hover', 'dt-the7-core' ),
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
			'group' => __( 'Arrows', 'dt-the7-core' ),
			'heading' => __('Arrow border color hover ', 'dt-the7-core'),
			'description' => __( "Live empty to use accent color.", 'dt-the7-core' ),
			'param_name' => 'arrow_border_color_hover',
			'type' => 'colorpicker',
			'value' => '',
			'dependency'	=> array(
				'element'	=> 'arrow_icon_border_hover',
				'value'		=> 'y',
			),
		),
		array(
			"group" => __("Arrows", 'dt-the7-core'),
			"heading" => __("Show arrow background hover", 'dt-the7-core'),
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
			'group' => __( 'Arrows', 'dt-the7-core' ),
			'heading' => __('Arrow background hover color', 'dt-the7-core'),
			'description' => __( "Live empty to use accent color.", 'dt-the7-core' ),
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
			"group" => __("Arrows", 'dt-the7-core'),
			'heading' => __( 'Right Arrow Position', 'dt-the7-core' ),
			'param_name' => 'dt_title_arrows',
			'type' => 'dt_title',
			'value' => '',
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		array(
			"group" => __("Arrows", 'dt-the7-core'),
			"heading" => __("Icon paddings", 'dt-the7-core'),
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
			'group' => __( 'Arrows', 'dt-the7-core' ),
			"heading" => __("Vertical position", 'dt-the7-core'),
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
			'group' => __( 'Arrows', 'dt-the7-core' ),
			"heading" => __("Horizontal position", 'dt-the7-core'),
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
			'group' => __( 'Arrows', 'dt-the7-core' ),
			'heading' => __('Vertical offset', 'dt-the7-core'),
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
			'group' => __( 'Arrows', 'dt-the7-core' ),
			'heading' => __('Horizontal offset', 'dt-the7-core'),
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
			"group" => __("Arrows", 'dt-the7-core'),
			'heading' => __( 'Left Arrow Position', 'dt-the7-core' ),
			'param_name' => 'dt_title_arrows',
			'type' => 'dt_title',
			'value' => '',
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		array(
			"group" => __("Arrows", 'dt-the7-core'),
			"heading" => __("Icon paddings", 'dt-the7-core'),
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
			'group' => __( 'Arrows', 'dt-the7-core' ),
			"heading" => __("Vertical position", 'dt-the7-core'),
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
			'group' => __( 'Arrows', 'dt-the7-core' ),
			"heading" => __("Horizontal position", 'dt-the7-core'),
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
			'group' => __( 'Arrows', 'dt-the7-core' ),
			'heading' => __('Vertical offset', 'dt-the7-core'),
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
			'group' => __( 'Arrows', 'dt-the7-core' ),
			'heading' => __('Horizontal offset', 'dt-the7-core'),
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
			"group" => __("Arrows", 'dt-the7-core'),
			'heading' => __( 'Arrows responsiveness', 'dt-the7-core' ),
			'param_name' => 'dt_title_arrows',
			'type' => 'dt_title',
			'value' => '',
			'dependency'	=> array(
				'element'	=> 'arrows',
				'value'		=> 'y',
			),
		),
		array(
			"group" => __("Arrows", 'dt-the7-core'),
			"heading" => __("Arrows behaviour","dt-the7-core"),
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
			"group" => __("Arrows", 'dt-the7-core'),
			'heading' => __('Enable if browser width is less then ', 'dt-the7-core'),
			'param_name' => 'hide_arrows_mobile_switch_width',
			'type' => 'dt_number',
			'value' => '778px',
			'units' => 'px',
			"dependency" => Array("element" => "arrow_responsiveness", "value" => array("hide-arrows")),
		),
		array(
			"group" => __("Arrows", 'dt-the7-core'),
			'heading' => __('Enable if browser width is less then ', 'dt-the7-core'),
			'param_name' => 'reposition_arrows_mobile_switch_width',
			'type' => 'dt_number',
			'value' => '778px',
			'units' => 'px',
			"dependency" => Array("element" => "arrow_responsiveness", "value" => array("reposition-arrows")),
		),
		array(
			"group" => __("Arrows", 'dt-the7-core'),
			'heading' => __('Left arrow horizontal offset', 'dt-the7-core'),
			'param_name' => 'l_arrows_mobile_h_position',
			'type' => 'dt_number',
			'value' => '-18px',
			'units' => 'px',
			"dependency" => Array("element" => "arrow_responsiveness", "value" => array("reposition-arrows")),
		),
		array(
			"group" => __("Arrows", 'dt-the7-core'),
			'heading' => __('Right arrow horizontal offset', 'dt-the7-core'),
			'param_name' => 'r_arrows_mobile_h_position',
			'type' => 'dt_number',
			'value' => '-18px',
			'units' => 'px',
			"dependency" => Array("element" => "arrow_responsiveness", "value" => array("reposition-arrows")),
		),
		//BULLETS
		array(
			"group" => __("Bullets", 'dt-the7-core'),
			"heading" => __("Show bullets", 'dt-the7-core'),
			"param_name" => "show_bullets",
			'type' => 'dt_switch',
			'value' => 'n',
			'options' => array(
				'Yes' => 'y',
				'No' => 'n',
			),
		),
		array(
			"group" => __("Bullets", 'dt-the7-core'),
			'heading' => __( 'Bullets Style, Size & Color', 'dt-the7-core' ),
			'param_name' => 'dt_title_bullets',
			'type' => 'dt_title',
			'value' => '',
			'dependency'	=> array(
				'element'	=> 'show_bullets',
				'value'		=> 'y',
			),

		),
		array(
			"group" => __("Bullets", 'dt-the7-core'),
			"heading" => __("Choose bullets style","dt-the7-core"),
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
			'group' => __( 'Bullets', 'dt-the7-core' ),
			'heading' => __('Bullets size', 'dt-the7-core'),
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
			'group' => __( 'Bullets', 'dt-the7-core' ),
			'heading' => __('Gap between bullets', 'dt-the7-core'),
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
			'group' => __( 'Bullets', 'dt-the7-core' ),
			'heading' => __('Bullets color', 'dt-the7-core'),
			'description' => __( 'Live empty to use accent color.', 'dt-the7-core' ),
			'param_name' => 'bullet_color',
			'type' => 'colorpicker',
			'value' => '',
			'dependency'	=> array(
				'element'	=> 'show_bullets',
				'value'		=> 'y',
			),
		),
		array(
			'group' => __( 'Bullets', 'dt-the7-core' ),
			'heading' => __('Bullets hover color', 'dt-the7-core'),
			'description' => __( 'Live empty to use accent color.', 'dt-the7-core' ),
			'param_name' => 'bullet_color_hover',
			'type' => 'colorpicker',
			'value' => '',
			'dependency'	=> array(
				'element'	=> 'show_bullets',
				'value'		=> 'y',
			),
		),
		array(
			"group" => __("Bullets", 'dt-the7-core'),
			'heading' => __( 'Bullets Position', 'dt-the7-core' ),
			'param_name' => 'dt_title_bullets',
			'type' => 'dt_title',
			'value' => '',
			'dependency'	=> array(
				'element'	=> 'show_bullets',
				'value'		=> 'y',
			),
		),
		array(
			'group' => __( 'Bullets', 'dt-the7-core' ),
			"heading" => __("Vertical position", 'dt-the7-core'),
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
			'group' => __( 'Bullets', 'dt-the7-core' ),
			"heading" => __("Horizontal position", 'dt-the7-core'),
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
			'group' => __( 'Bullets', 'dt-the7-core' ),
			'heading' => __('Vertical offset', 'dt-the7-core'),
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
			'group' => __( 'Bullets', 'dt-the7-core' ),
			'heading' => __('Horizontal offset', 'dt-the7-core'),
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
			'heading' => __( 'CSS box', 'dt-the7-core' ),
			'param_name' => 'css_dt_testimonials_carousel',
			'group' => __( 'Design Options', 'dt-the7-core' )
		),
	),
);

