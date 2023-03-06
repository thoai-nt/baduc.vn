<?php

// File Security Check.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'weight'            => -1,
	'name'              => __( 'Photos Carousel', 'dt-the7-core' ),
	'description'       => __( 'Images from Photo Albums post type', 'dt-the7-core' ),
	'base'              => 'dt_photos_carousel',
	'icon'              => 'dt_vc_ico_photos_carousel',
	'class'             => 'dt_photos_carousel',
	'category'          => __( 'by Dream-Theme', 'dt-the7-core' ),
	'params'            => array(
		// General group.
		array(
			'heading'          => __( 'Show', 'dt-the7-core' ),
			'param_name'       => 'post_type',
			'type'             => 'dropdown',
			'std'              => 'category',
			'value'            => array(
				'Images from all albums'           => 'posts',
				'Images from albums in categories' => 'category',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'type'             => 'autocomplete',
			'heading'          => __( 'Choose posts', 'dt-the7-core' ),
			'param_name'       => 'posts',
			'settings'         => array(
				'multiple'   => true,
				'min_length' => 0,
			),
			'save_always'      => true,
			'description'      => __( 'Field accept album ID, title. Leave empty to show images from all albums.', 'dt-the7-core' ),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency'       => array(
				'element' => 'post_type',
				'value'   => 'posts',
			),
		),
		array(
			'type'             => 'autocomplete',
			'heading'          => __( 'Choose albums categories', 'dt-the7-core' ),
			'param_name'       => 'category',
			'settings'         => array(
				'multiple'   => true,
				'min_length' => 0,
			),
			'save_always'      => true,
			'description'      => __( 'Field accept album category ID, title, slug. Leave empty to show images from all albums.', 'dt-the7-core' ),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency'       => array(
				'element' => 'post_type',
				'value'   => 'category',
			),
		),
		array(
			'heading'          => __( 'Order', 'dt-the7-core' ),
			'param_name'       => 'order',
			'type'             => 'dropdown',
			'std'              => 'desc',
			'value'            => array(
				'Ascending'  => 'asc',
				'Descending' => 'desc',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'heading'          => __( 'Order by', 'dt-the7-core' ),
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
			'heading'          => __( 'Total number of images', 'dt-the7-core' ),
			'param_name'       => 'dis_posts_total',
			'type'             => 'dt_number',
			'value'            => '6',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'description'      => __( 'Leave empty to display all posts.', 'dt-the7-core' ),
		),


		// - Image Settings.
		array(
			'heading'    => __( 'Image Settings', 'dt-the7-core' ),
			'param_name' => 'dt_title',
			'type'       => 'dt_title',
			'value'      => '',
		),
		array(
			'heading'          => __( 'Image sizing', 'dt-the7-core' ),
			'param_name'       => 'image_sizing',
			'type'             => 'dropdown',
			'std'              => 'resize',
			'value'            => array(
				'Preserve images proportions' => 'proportional',
				'Resize images'               => 'resize',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'headings'    => array( __( 'Width', 'dt-the7-core' ), __( 'Height', 'dt-the7-core' ) ),
			'param_name'  => 'resized_image_dimensions',
			'type'        => 'dt_dimensions',
			'value'       => '1x1',
			'dependency'  => array(
				'element' => 'image_sizing',
				'value'   => 'resize',
			),
			'description' => __( 'Set image proportions, for example: 4x3, 3x2.', 'dt-the7-core' ),
		),
		array(
			'heading'          => __( 'Image border radius', 'dt-the7-core' ),
			'param_name'       => 'image_border_radius',
			'type'             => 'dt_number',
			'value'            => '0',
			'units'            => 'px',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'type'             => 'dropdown',
			'heading'          => __( 'Image decoration', 'dt-the7-core' ),
			'param_name'       => 'image_decoration',
			'value'            => array(
				'None'   => 'none',
				'Shadow' => 'shadow',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'heading'    => __( 'Horizontal length', 'dt-the7-core' ),
			'param_name' => 'shadow_h_length',
			'type'       => 'dt_number',
			'value'      => '0px',
			'units'      => 'px',
			'dependency' => array(
				'element' => 'image_decoration',
				'value'   => 'shadow',
			),
		),
		array(
			'heading'    => __( 'Vertical length', 'dt-the7-core' ),
			'param_name' => 'shadow_v_length',
			'type'       => 'dt_number',
			'value'      => '4px',
			'units'      => 'px',
			'dependency' => array(
				'element' => 'image_decoration',
				'value'   => 'shadow',
			),
		),
		array(
			'heading'    => __( 'Blur radius', 'dt-the7-core' ),
			'param_name' => 'shadow_blur_radius',
			'type'       => 'dt_number',
			'value'      => '12px',
			'units'      => 'px',
			'dependency' => array(
				'element' => 'image_decoration',
				'value'   => 'shadow',
			),
		),
		array(
			'heading'    => __( 'Spread', 'dt-the7-core' ),
			'param_name' => 'shadow_spread',
			'type'       => 'dt_number',
			'value'      => '3px',
			'units'      => 'px',
			'dependency' => array(
				'element' => 'image_decoration',
				'value'   => 'shadow',
			),
		),
		array(
			'heading'    => __( 'Shadow color', 'dt-the7-core' ),
			'type'       => 'colorpicker',
			'param_name' => 'shadow_color',
			'value'      => 'rgba(0,0,0,.25)',
			'dependency' => array(
				'element' => 'image_decoration',
				'value'   => 'shadow',
			),
		),
		array(
			'heading'          => __( 'Scale animation on hover', 'dt-the7-core' ),
			'param_name'       => 'image_scale_animation_on_hover',
			'type'             => 'dropdown',
			'std'              => 'quick_scale',
			'value'            => array(
				'Disabled'    => 'disabled',
				'Quick scale' => 'quick_scale',
				'Slow scale'  => 'slow_scale',
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
			'heading'     => __( 'Background color', 'dt-the7-core' ),
			'param_name'  => 'custom_rollover_bg_color',
			'type'        => 'colorpicker',
			'value'       => 'rgba(0,0,0,0.5)',
			'dependency'  => array(
				'element' => 'image_hover_bg_color',
				'value'   => array( 'solid_rollover_bg' ),
			),
			'description' => __( 'Leave empty to use default hover color.', 'dt-the7-core' ),
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
			'heading'          => __( 'Hover background animation', 'dt-the7-core' ),
			'param_name'       => 'hover_animation',
			'type'             => 'dropdown',
			'value'            => array(
				'Fade'                    => 'fade',
				'Direction aware'         => 'direction_aware',
				'Reverse direction aware' => 'redirection_aware',
				'Scale in'                => 'scale_in',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency'       => array(
				'element' => 'image_hover_bg_color',
				'value'   => array( 'solid_rollover_bg', 'gradient_rollover_bg' ),
			),
		),

		array(
			'heading'    => __( 'Columns & Responsiveness', 'dt-the7-core' ),
			'param_name' => 'dt_title_general',
			'type'       => 'dt_title',
		),

		array(
			'heading'          => __( 'Wide desktop', 'dt-the7-core' ),
			'param_name'       => 'slides_on_wide_desk',
			'type'             => 'textfield',
			'value'            => '6',
			'edit_field_class' => 'vc_media-xs vc_col-xs-2 vc_column',
		),
		array(
			'heading'          => __( 'Desktop', 'dt-the7-core' ),
			'param_name'       => 'slides_on_desk',
			'type'             => 'textfield',
			'value'            => '6',
			'edit_field_class' => 'vc_media-xs vc_col-xs-2 vc_column',
		),
		array(
			'heading'          => __( 'Laptop', 'dt-the7-core' ),
			'param_name'       => 'slides_on_lapt',
			'type'             => 'textfield',
			'value'            => '5',
			'edit_field_class' => 'vc_media-xs vc_col-xs-2 vc_column',
		),
		array(
			'heading'          => __( 'Hor. tablet ', 'dt-the7-core' ),
			'param_name'       => 'slides_on_h_tabs',
			'type'             => 'textfield',
			'value'            => '4',
			'edit_field_class' => 'vc_media-xs vc_col-xs-2 vc_column',
		),
		array(
			'heading'          => __( 'Vert. tablet', 'dt-the7-core' ),
			'param_name'       => 'slides_on_v_tabs',
			'type'             => 'textfield',
			'value'            => '3',
			'edit_field_class' => 'vc_media-xs vc_col-xs-2 vc_column',
		),
		array(
			'heading'          => __( 'Phone', 'dt-the7-core' ),
			'param_name'       => 'slides_on_mob',
			'type'             => 'textfield',
			'value'            => '1',
			'edit_field_class' => 'vc_media-xs vc_col-xs-2 vc_column',
		),
		array(
			'heading'          => __( 'Gap between columns ', 'dt-the7-core' ),
			'param_name'       => 'item_space',
			'type'             => 'dt_number',
			'value'            => '10',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'heading'          => __( 'Stage padding ', 'the7mk2' ),
			'param_name'       => 'stage_padding',
			'type'             => 'dt_number',
			'value'            => '0',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'heading'    => __( 'Scrolling', 'dt-the7-core' ),
			'param_name' => 'dt_title_general',
			'type'       => 'dt_title',
			'value'      => '',
		),
		array(
			'heading'    => __( 'Scroll mode', 'dt-the7-core' ),
			'param_name' => 'slide_to_scroll',
			'type'       => 'dropdown',
			'value'      => array(
				'One slide at a time' => 'single',
				'All slides'          => 'all',
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
			'heading'    => __( 'Autoplay slides‏', 'dt-the7-core' ),
			'param_name' => 'autoplay',
			'type'       => 'dt_switch',
			'value'      => 'n',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
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
			'heading'    => __( 'Extra Class', 'dt-the7-core' ),
			'param_name' => 'dt_title_general',
			'type'       => 'dt_title',
			'value'      => '',
		),
		array(
			'type'        => 'textfield',
			'heading'     => __( 'Extra class name (optional)', 'dt-the7-core' ),
			'param_name'  => 'el_class',
			'value'       => '',
			'description' => __( 'Style particular elements differently - add a class name and refer to it in custom CSS.', 'dt-the7-core' ),
		),

		//Icons

		array(
			'group'      => __( 'Hover Icon', 'dt-the7-core' ),
			'heading'    => __( 'Show icon on image hover', 'dt-the7-core' ),
			'param_name' => 'show_zoom',
			'type'       => 'dt_switch',
			'value'      => 'y',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
		),
		array(
			'group'      => __( 'Hover Icon', 'dt-the7-core' ),
			'heading'    => __( 'Choose image zoom icon', 'dt-the7-core' ),
			'param_name' => 'gallery_image_zoom_icon',
			'type'       => 'dt_navigation',
			'value'      => 'icomoon-the7-font-the7-zoom-06',
			'dependency' => array(
				'element' => 'show_zoom',
				'value'   => 'y',
			),
		),
		array(
			'group'            => __( 'Hover Icon', 'dt-the7-core' ),
			'heading'          => __( 'Icon Size & Background', 'dt-the7-core' ),
			'param_name'       => 'dt_project_icon_title',
			'type'             => 'dt_title',
			'dependency'       => array(
				'element' => 'show_zoom',
				'value'   => 'y',
			),
			'edit_field_class' => 'the7-icons-dependent vc_col-xs-12',
		),
		array(
			'group'            => __( 'Hover Icon', 'dt-the7-core' ),
			'heading'          => __( 'Icon size', 'dt-the7-core' ),
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
			'group'            => __( 'Hover Icon', 'dt-the7-core' ),
			'heading'          => __( 'Icon color', 'dt-the7-core' ),
			'description'      => __( 'Live empty to use accent color.', 'dt-the7-core' ),
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
			'group'            => __( 'Hover Icon', 'dt-the7-core' ),
			'heading'          => __( 'Background size', 'dt-the7-core' ),
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
			'group'            => __( 'Hover Icon', 'dt-the7-core' ),
			'heading'          => __( 'Paint background', 'dt-the7-core' ),
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
			'group'            => __( 'Hover Icon', 'dt-the7-core' ),
			'heading'          => __( 'Background color', 'dt-the7-core' ),
			'param_name'       => 'project_icon_bg_color',
			'type'             => 'colorpicker',
			'value'            => 'rgba(255,255,255,0.3)',
			'dependency'       => array(
				'element' => 'project_icon_bg',
				'value'   => 'y',
			),
			'description'      => __( 'Live empty to use accent color.', 'dt-the7-core' ),
			'edit_field_class' => 'the7-icons-dependent vc_col-xs-12',
		),
		array(
			'group'            => __( 'Hover Icon', 'dt-the7-core' ),
			'heading'          => __( 'Border radius', 'dt-the7-core' ),
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
			'group'            => __( 'Hover Icon', 'dt-the7-core' ),
			'heading'          => __( 'Border width', 'dt-the7-core' ),
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
			'group'            => __( 'Hover Icon', 'dt-the7-core' ),
			'heading'          => __( 'Border color', 'dt-the7-core' ),
			'description'      => __( 'Live empty to use accent color.', 'dt-the7-core' ),
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
			'group'      => __( 'Arrows', 'dt-the7-core' ),
			'heading'    => __( 'Show arrows', 'dt-the7-core' ),
			'param_name' => 'arrows',
			'type'       => 'dt_switch',
			'value'      => 'y',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
		),
		array(
			'group'      => __( 'Arrows', 'dt-the7-core' ),
			'heading'    => __( 'Arrow Icon', 'dt-the7-core' ),
			'param_name' => 'dt_title_arrows',
			'type'       => 'dt_title',
			'value'      => '',
			'dependency' => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Arrows', 'dt-the7-core' ),
			'heading'    => __( 'Choose icon for "Next Arrow"', 'dt-the7-core' ),
			'param_name' => 'next_icon',
			'type'       => 'dt_navigation',
			'value'      => 'icon-ar-017-r',
			'dependency' => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Arrows', 'dt-the7-core' ),
			'heading'    => __( 'Choose icon  for "Prev Arrow"', 'dt-the7-core' ),
			'param_name' => 'prev_icon',
			'type'       => 'dt_navigation',
			'value'      => 'icon-ar-017-l',
			'dependency' => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Arrows', 'dt-the7-core' ),
			'heading'    => __( 'Arrow icon size', 'dt-the7-core' ),
			'param_name' => 'arrow_icon_size',
			'type'       => 'dt_number',
			'value'      => '18px',
			'units'      => 'px',
			'dependency' => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
		),

		array(
			'group'      => __( 'Arrows', 'dt-the7-core' ),
			'heading'    => __( 'Arrow Background', 'dt-the7-core' ),
			'param_name' => 'dt_title_arrows',
			'type'       => 'dt_title',
			'value'      => '',
			'dependency' => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
		),
		array(
			'group'            => __( 'Arrows', 'dt-the7-core' ),
			'heading'          => __( 'Width', 'dt-the7-core' ),
			'param_name'       => 'arrow_bg_width',
			'type'             => 'dt_number',
			'value'            => '36px',
			'units'            => 'x',
			'dependency'       => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
			'edit_field_class' => 'vc_col-sm-3 vc_column dt_col_custom',
		),
		array(
			'group'            => __( 'Arrows', 'dt-the7-core' ),
			'heading'          => __( 'Height', 'dt-the7-core' ),
			'param_name'       => 'arrow_bg_height',
			'type'             => 'dt_number',
			'value'            => '36px',
			'units'            => 'px',
			'dependency'       => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
			'edit_field_class' => 'vc_col-sm-3 vc_column ',
		),
		array(
			'group'      => __( 'Arrows', 'dt-the7-core' ),
			'heading'    => __( 'Arrow border radius', 'dt-the7-core' ),
			'param_name' => 'arrow_border_radius',
			'type'       => 'dt_number',
			'value'      => '500px',
			'units'      => 'px',
			'dependency' => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Arrows', 'dt-the7-core' ),
			'heading'    => __( 'Arrow border width', 'dt-the7-core' ),
			'param_name' => 'arrow_border_width',
			'type'       => 'dt_number',
			'value'      => '0',
			'units'      => 'px',
			'dependency' => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Arrows', 'dt-the7-core' ),
			'heading'    => __( 'Color Setting', 'dt-the7-core' ),
			'param_name' => 'dt_title_arrows',
			'type'       => 'dt_title',
			'value'      => '',
			'dependency' => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
		),
		array(
			'group'       => __( 'Arrows', 'dt-the7-core' ),
			'heading'     => __( 'Arrow icon color', 'dt-the7-core' ),
			'description' => __( 'Live empty to use accent color.', 'dt-the7-core' ),
			'param_name'  => 'arrow_icon_color',
			'type'        => 'colorpicker',
			'value'       => '#ffffff',
			'dependency'  => array(
				'element' => 'arrows',
				'value'   => 'y',
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
			'group'       => __( 'Arrows', 'dt-the7-core' ),
			'heading'     => __( 'Arrow border color', 'dt-the7-core' ),
			'description' => __( 'Live empty to use accent color.', 'dt-the7-core' ),
			'param_name'  => 'arrow_border_color',
			'type'        => 'colorpicker',
			'value'       => '',
			'dependency'  => array(
				'element' => 'arrow_icon_border',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Arrows', 'dt-the7-core' ),
			'heading'    => __( 'Show arrow background', 'dt-the7-core' ),
			'param_name' => 'arrows_bg_show',
			'type'       => 'dt_switch',
			'value'      => 'y',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
			'dependency' => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
		),
		array(
			'group'       => __( 'Arrows', 'dt-the7-core' ),
			'heading'     => __( 'Arrow background color', 'dt-the7-core' ),
			'description' => __( 'Live empty to use accent color.', 'dt-the7-core' ),
			'param_name'  => 'arrow_bg_color',
			'type'        => 'colorpicker',
			'value'       => '',
			'dependency'  => array(
				'element' => 'arrows_bg_show',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Arrows', 'dt-the7-core' ),
			'heading'    => __( 'Hover Color Setting', 'dt-the7-core' ),
			'param_name' => 'dt_title_arrows',
			'type'       => 'dt_title',
			'value'      => '',
			'dependency' => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
		),
		array(
			'group'       => __( 'Arrows', 'dt-the7-core' ),
			'heading'     => __( 'Arrow icon color hover', 'dt-the7-core' ),
			'description' => __( 'Live empty to use accent color.', 'dt-the7-core' ),
			'param_name'  => 'arrow_icon_color_hover',
			'type'        => 'colorpicker',
			'value'       => 'rgba(255,255,255,0.75)',
			'dependency'  => array(
				'element' => 'arrows',
				'value'   => 'y',
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
			'group'       => __( 'Arrows', 'dt-the7-core' ),
			'heading'     => __( 'Arrow border color hover ', 'dt-the7-core' ),
			'description' => __( 'Live empty to use accent color.', 'dt-the7-core' ),
			'param_name'  => 'arrow_border_color_hover',
			'type'        => 'colorpicker',
			'value'       => '',
			'dependency'  => array(
				'element' => 'arrow_icon_border_hover',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Arrows', 'dt-the7-core' ),
			'heading'    => __( 'Show arrow background hover', 'dt-the7-core' ),
			'param_name' => 'arrows_bg_hover_show',
			'type'       => 'dt_switch',
			'value'      => 'y',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
			'dependency' => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
		),
		array(
			'group'       => __( 'Arrows', 'dt-the7-core' ),
			'heading'     => __( 'Arrow background hover color', 'dt-the7-core' ),
			'description' => __( 'Live empty to use accent color.', 'dt-the7-core' ),
			'param_name'  => 'arrow_bg_color_hover',
			'type'        => 'colorpicker',
			'value'       => '',
			'dependency'  => array(
				'element' => 'arrows_bg_hover_show',
				'value'   => 'y',
			),
		),
		// - Right arrow:
		array(
			'group'      => __( 'Arrows', 'dt-the7-core' ),
			'heading'    => __( 'Right Arrow Position', 'dt-the7-core' ),
			'param_name' => 'dt_title_arrows',
			'type'       => 'dt_title',
			'value'      => '',
			'dependency' => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Arrows', 'dt-the7-core' ),
			'heading'    => __( 'Icon paddings', 'dt-the7-core' ),
			'param_name' => 'r_arrow_icon_paddings',
			'type'       => 'dt_spacing',
			'value'      => '0 0 0 0',
			'units'      => 'px',
			'dependency' => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
		),
		array(
			'group'            => __( 'Arrows', 'dt-the7-core' ),
			'heading'          => __( 'Vertical position', 'dt-the7-core' ),
			'param_name'       => 'r_arrow_v_position',
			'type'             => 'dropdown',
			'value'            => array(
				'Center' => 'center',
				'Bottom' => 'bottom',
				'Top'    => 'top',
			),
			'dependency'       => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'group'            => __( 'Arrows', 'dt-the7-core' ),
			'heading'          => __( 'Horizontal position', 'dt-the7-core' ),
			'param_name'       => 'r_arrow_h_position',
			'type'             => 'dropdown',
			'value'            => array(
				'Right'  => 'right',
				'Center' => 'center',
				'Left'   => 'left',
			),
			'dependency'       => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'group'      => __( 'Arrows', 'dt-the7-core' ),
			'heading'    => __( 'Vertical offset', 'dt-the7-core' ),
			'param_name' => 'r_arrow_v_offset',
			'type'       => 'dt_number',
			'value'      => '0',
			'units'      => 'px',
			'dependency' => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Arrows', 'dt-the7-core' ),
			'heading'    => __( 'Horizontal offset', 'dt-the7-core' ),
			'param_name' => 'r_arrow_h_offset',
			'type'       => 'dt_number',
			'value'      => '-43px',
			'units'      => 'px',
			'dependency' => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
		),
		// - Left arrow:
		array(
			'group'      => __( 'Arrows', 'dt-the7-core' ),
			'heading'    => __( 'Left Arrow Position', 'dt-the7-core' ),
			'param_name' => 'dt_title_arrows',
			'type'       => 'dt_title',
			'value'      => '',
			'dependency' => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Arrows', 'dt-the7-core' ),
			'heading'    => __( 'Icon paddings', 'dt-the7-core' ),
			'param_name' => 'l_arrow_icon_paddings',
			'type'       => 'dt_spacing',
			'value'      => '0 0 0 0',
			'units'      => 'px',
			'dependency' => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
		),
		array(
			'group'            => __( 'Arrows', 'dt-the7-core' ),
			'heading'          => __( 'Vertical position', 'dt-the7-core' ),
			'param_name'       => 'l_arrow_v_position',
			'type'             => 'dropdown',
			'value'            => array(
				'Center' => 'center',
				'Bottom' => 'bottom',
				'Top'    => 'top',
			),
			'dependency'       => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'group'            => __( 'Arrows', 'dt-the7-core' ),
			'heading'          => __( 'Horizontal position', 'dt-the7-core' ),
			'param_name'       => 'l_arrow_h_position',
			'type'             => 'dropdown',
			'value'            => array(
				'Left'   => 'left',
				'Right'  => 'right',
				'Center' => 'center',
			),
			'dependency'       => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'group'      => __( 'Arrows', 'dt-the7-core' ),
			'heading'    => __( 'Vertical offset', 'dt-the7-core' ),
			'param_name' => 'l_arrow_v_offset',
			'type'       => 'dt_number',
			'value'      => '0',
			'units'      => 'px',
			'dependency' => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Arrows', 'dt-the7-core' ),
			'heading'    => __( 'Horizontal offset', 'dt-the7-core' ),
			'param_name' => 'l_arrow_h_offset',
			'type'       => 'dt_number',
			'value'      => '-43px',
			'units'      => 'px',
			'dependency' => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
		),
		//Arrows Responsiveness
		array(
			'group'      => __( 'Arrows', 'dt-the7-core' ),
			'heading'    => __( 'Arrows responsiveness', 'dt-the7-core' ),
			'param_name' => 'dt_title_arrows',
			'type'       => 'dt_title',
			'value'      => '',
			'dependency' => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
		),
		array(
			'group'            => __( 'Arrows', 'dt-the7-core' ),
			'heading'          => __( 'Responsive behaviour', 'dt-the7-core' ),
			'param_name'       => 'arrow_responsiveness',
			'type'             => 'dropdown',
			'value'            => array(
				'Reposition arrows' => 'reposition-arrows',
				'Leave as is'       => 'no-changes',
				'Hide arrows'       => 'hide-arrows',
			),
			'dependency'       => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'group'      => __( 'Arrows', 'dt-the7-core' ),
			'heading'    => __( 'Enable if browser width is less then ', 'dt-the7-core' ),
			'param_name' => 'hide_arrows_mobile_switch_width',
			'type'       => 'dt_number',
			'value'      => '778px',
			'units'      => 'px',
			'dependency' => Array( 'element' => 'arrow_responsiveness', 'value' => array( 'hide-arrows' ) ),
		),
		array(
			'group'      => __( 'Arrows', 'dt-the7-core' ),
			'heading'    => __( 'Enable if browser width is less then ', 'dt-the7-core' ),
			'param_name' => 'reposition_arrows_mobile_switch_width',
			'type'       => 'dt_number',
			'value'      => '778px',
			'units'      => 'px',
			'dependency' => Array( 'element' => 'arrow_responsiveness', 'value' => array( 'reposition-arrows' ) ),
		),
		array(
			'group'      => __( 'Arrows', 'dt-the7-core' ),
			'heading'    => __( 'Left arrow horizontal offset', 'dt-the7-core' ),
			'param_name' => 'l_arrows_mobile_h_position',
			'type'       => 'dt_number',
			'value'      => '10px',
			'units'      => 'px',
			'dependency' => Array( 'element' => 'arrow_responsiveness', 'value' => array( 'reposition-arrows' ) ),
		),
		array(
			'group'      => __( 'Arrows', 'dt-the7-core' ),
			'heading'    => __( 'Right arrow horizontal offset', 'dt-the7-core' ),
			'param_name' => 'r_arrows_mobile_h_position',
			'type'       => 'dt_number',
			'value'      => '10px',
			'units'      => 'px',
			'dependency' => Array( 'element' => 'arrow_responsiveness', 'value' => array( 'reposition-arrows' ) ),
		),
		//BULLETS
		array(
			'group'      => __( 'Bullets', 'dt-the7-core' ),
			'heading'    => __( 'Show bullets', 'dt-the7-core' ),
			'param_name' => 'show_bullets',
			'type'       => 'dt_switch',
			'value'      => 'n',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
		),
		array(
			'group'      => __( 'Bullets', 'dt-the7-core' ),
			'heading'    => __( 'Bullets Style, Size & Color', 'dt-the7-core' ),
			'param_name' => 'dt_title_bullets',
			'type'       => 'dt_title',
			'value'      => '',
			'dependency' => array(
				'element' => 'show_bullets',
				'value'   => 'y',
			),

		),
		array(
			'group'            => __( 'Bullets', 'dt-the7-core' ),
			'heading'          => __( 'Choose bullets style', 'dt-the7-core' ),
			'param_name'       => 'bullets_style',
			'type'             => 'dropdown',
			'value'            => array(
				'SMALL DOT STROKE' => 'small-dot-stroke',
				'SCALE UP'         => 'scale-up',
				'STROKE'           => 'stroke',
				'FILL IN'          => 'fill-in',
				'SQUARE'           => 'ubax',
				'RECTANGULAR'      => 'etefu',
			),
			'dependency'       => array(
				'element' => 'show_bullets',
				'value'   => 'y',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'group'      => __( 'Bullets', 'dt-the7-core' ),
			'heading'    => __( 'Bullets size', 'dt-the7-core' ),
			'param_name' => 'bullet_size',
			'type'       => 'dt_number',
			'value'      => '10px',
			'units'      => 'px',
			'dependency' => array(
				'element' => 'show_bullets',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Bullets', 'dt-the7-core' ),
			'heading'    => __( 'Gap between bullets', 'dt-the7-core' ),
			'param_name' => 'bullet_gap',
			'type'       => 'dt_number',
			'value'      => '16px',
			'units'      => 'px',
			'dependency' => array(
				'element' => 'show_bullets',
				'value'   => 'y',
			),
		),
		array(
			'group'       => __( 'Bullets', 'dt-the7-core' ),
			'heading'     => __( 'Bullets color', 'dt-the7-core' ),
			'description' => __( 'Live empty to use accent color.', 'dt-the7-core' ),
			'param_name'  => 'bullet_color',
			'type'        => 'colorpicker',
			'value'       => '',
			'dependency'  => array(
				'element' => 'show_bullets',
				'value'   => 'y',
			),
		),
		array(
			'group'       => __( 'Bullets', 'dt-the7-core' ),
			'heading'     => __( 'Bullets hover color', 'dt-the7-core' ),
			'description' => __( 'Live empty to use accent color.', 'dt-the7-core' ),
			'param_name'  => 'bullet_color_hover',
			'type'        => 'colorpicker',
			'value'       => '',
			'dependency'  => array(
				'element' => 'show_bullets',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Bullets', 'dt-the7-core' ),
			'heading'    => __( 'Bullets Position', 'dt-the7-core' ),
			'param_name' => 'dt_title_bullets',
			'type'       => 'dt_title',
			'value'      => '',
			'dependency' => array(
				'element' => 'show_bullets',
				'value'   => 'y',
			),
		),
		array(
			'group'            => __( 'Bullets', 'dt-the7-core' ),
			'heading'          => __( 'Vertical position', 'dt-the7-core' ),
			'param_name'       => 'bullets_v_position',
			'type'             => 'dropdown',
			'value'            => array(
				'Bottom' => 'bottom',
				'Top'    => 'top',
				'Center' => 'center',
			),
			'dependency'       => array(
				'element' => 'show_bullets',
				'value'   => 'y',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'group'            => __( 'Bullets', 'dt-the7-core' ),
			'heading'          => __( 'Horizontal position', 'dt-the7-core' ),
			'param_name'       => 'bullets_h_position',
			'type'             => 'dropdown',
			'value'            => array(
				'Center' => 'center',
				'Right'  => 'right',
				'Left'   => 'left',
			),
			'dependency'       => array(
				'element' => 'show_bullets',
				'value'   => 'y',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'group'      => __( 'Bullets', 'dt-the7-core' ),
			'heading'    => __( 'Vertical offset', 'dt-the7-core' ),
			'param_name' => 'bullets_v_offset',
			'type'       => 'dt_number',
			'value'      => '20px',
			'units'      => 'px',
			'dependency' => array(
				'element' => 'show_bullets',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Bullets', 'dt-the7-core' ),
			'heading'    => __( 'Horizontal offset', 'dt-the7-core' ),
			'param_name' => 'bullets_h_offset',
			'type'       => 'dt_number',
			'value'      => '0',
			'units'      => 'px',
			'dependency' => array(
				'element' => 'show_bullets',
				'value'   => 'y',
			),
		),
		array(
			'type'       => 'css_editor',
			'heading'    => __( 'CSS box', 'dt-the7-core' ),
			'param_name' => 'css_dt_gallery_carousel',
			'group'      => __( 'Design Options', 'dt-the7-core' ),
		),
	),
);