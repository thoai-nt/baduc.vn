<?php

// File Security Check.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'weight'   => -1,
	'name'     => __( 'Team Masonry and Grid', 'dt-the7-core' ),
	'base'     => 'dt_team_masonry',
	'icon'     => 'dt_vc_ico_team',
	'class'    => 'dt_team_masonry',
	'category' => __( 'by Dream-Theme', 'dt-the7-core' ),
	'params'   => array(
		// General group.
		array(
			'heading'          => __( 'Show', 'dt-the7-core' ),
			'param_name'       => 'post_type',
			'type'             => 'dropdown',
			'std'              => 'category',
			'value'            => array(
				'All posts'             => 'posts',
				'Posts from categories' => 'category',
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
			'description'      => __( 'Field accept post ID, title. Leave empty to show all posts.', 'dt-the7-core' ),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency'       => array(
				'element' => 'post_type',
				'value'   => 'posts',
			),
		),
		array(
			'type'             => 'autocomplete',
			'heading'          => __( 'Choose post categories', 'dt-the7-core' ),
			'param_name'       => 'category',
			'settings'         => array(
				'multiple'   => true,
				'min_length' => 0,
			),
			'save_always'      => true,
			'description'      => __( 'Field accept category ID, title, slug. Leave empty to show all posts.', 'dt-the7-core' ),
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
		),
		array(
			'heading'    => __( 'Layout Settings', 'dt-the7-core' ),
			'param_name' => 'dt_title',
			'type'       => 'dt_title',
			'value'      => '',
		),
		array(
			'heading'          => __( 'Mode', 'dt-the7-core' ),
			'param_name'       => 'type',
			'type'             => 'dropdown',
			'value'            => array(
				'Grid'    => 'grid',
				'Masonry' => 'masonry',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'heading'          => __( 'Loading effect', 'dt-the7-core' ),
			'param_name'       => 'loading_effect',
			'type'             => 'dropdown',
			'value'            => array(
				'None'             => 'none',
				'Fade in'          => 'fade_in',
				'Move up'          => 'move_up',
				'Scale up'         => 'scale_up',
				'Fall perspective' => 'fall_perspective',
				'Fly'              => 'fly',
				'Flip'             => 'flip',
				'Helix'            => 'helix',
				'Scale'            => 'scale',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		// - Content Area.
		array(
			'heading'    => __( 'Content Area', 'dt-the7-core' ),
			'param_name' => 'dt_title',
			'type'       => 'dt_title',
			'value'      => '',
		),
		array(
			'heading'    => __( 'Show background', 'dt-the7-core' ),
			'param_name' => 'content_bg',
			'type'       => 'dt_switch',
			'value'      => 'y',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
		),
		array(
			'heading'     => __( 'Color', 'dt-the7-core' ),
			'param_name'  => 'custom_content_bg_color',
			'type'        => 'colorpicker',
			'value'       => '',
			'dependency'  => array(
				'element' => 'content_bg',
				'value'   => 'y',
			),
			'description' => __( 'Leave empty to use default content boxes color & decoration.', 'dt-the7-core' ),
		),
		array(
			'heading'    => __( 'Content area paddings', 'dt-the7-core' ),
			'param_name' => 'post_content_paddings',
			'type'       => 'dt_spacing',
			'value'      => '20px 20px 20px 20px',
			'units'      => 'px',
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
			'heading'     => __( 'Maximum width', 'dt-the7-core' ),
			'param_name'  => 'img_max_width',
			'type'        => 'dt_number',
			'value'       => '',
			'units'       => 'px',
			'description' => __( 'Leave empty to use default width.', 'dt-the7-core' ),
		),
		array(
			'heading'    => __( 'Image paddings', 'dt-the7-core' ),
			'param_name' => 'image_paddings',
			'type'       => 'dt_spacing',
			'value'      => '0px 0px 0px 0px',
			'units'      => 'px, %',
		),
		array(
			'heading'    => __( 'Image border radius', 'dt-the7-core' ),
			'param_name' => 'img_border_radius',
			'type'       => 'dt_number',
			'value'      => '0',
			'units'      => 'px',
		),
		array(
			'heading'    => __( 'Enable scale animation on hover', 'dt-the7-core' ),
			'param_name' => 'image_scale_animation_on_hover',
			'type'       => 'dt_switch',
			'value'      => 'y',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
		),
		array(
			'heading'    => __( 'Enable hover background color', 'dt-the7-core' ),
			'param_name' => 'image_hover_bg_color',
			'type'       => 'dt_switch',
			'value'      => 'y',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
		),
		// - Columns & Responsiveness.
		array(
			'heading'    => __( 'Columns & Responsiveness', 'dt-the7-core' ),
			'param_name' => 'dt_title',
			'type'       => 'dt_title',
			'value'      => '',
		),
		array(
			'heading'          => __( 'Responsiveness mode', 'dt-the7-core' ),
			'param_name'       => 'responsiveness',
			'type'             => 'dropdown',
			'value'            => array(
				'Browser width based' => 'browser_width_based',
				'Post width based'    => 'post_width_based',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		// -- Browser width based.
		array(
			'heading'    => __( 'Number of columns', 'dt-the7-core' ),
			'param_name' => 'bwb_columns',
			'type'       => 'dt_responsive_columns',
			'value'      => 'desktop:3|h_tablet:3|v_tablet:2|phone:1',
			'dependency' => array(
				'element' => 'responsiveness',
				'value'   => 'browser_width_based',
			),
		),
		// -- Post width based.
		array(
			'heading'          => __( 'Column minimum width', 'dt-the7-core' ),
			'param_name'       => 'pwb_column_min_width',
			'type'             => 'dt_number',
			'value'            => '',
			'units'            => 'px',
			'dependency'       => array(
				'element' => 'responsiveness',
				'value'   => 'post_width_based',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'heading'     => __( 'Desired columns number', 'dt-the7-core' ),
			'param_name'  => 'pwb_columns',
			'type'        => 'dt_number',
			'value'       => '',
			'units'       => '',
			'max'         => 12,
			'description' => __( 'Affects only masonry layout', 'dt-the7-core' ),
			'dependency'  => array( 'element' => 'responsiveness', 'value' => 'post_width_based' ),

			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'heading'          => __( 'Gap between columns ', 'dt-the7-core' ),
			'param_name'       => 'gap_between_posts',
			'type'             => 'dt_number',
			'value'            => '15',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'description'      => __( 'Please note that this setting affects post paddings. So, for example: a value 10px will give you 20px gaps between posts)', 'dt-the7-core' ),
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
		// Post group.
		array(
			'heading'          => __( 'Content alignment', 'dt-the7-core' ),
			'param_name'       => 'content_alignment',
			'type'             => 'dropdown',
			'std'              => 'center',
			'value'            => array(
				'Left'   => 'left',
				'Center' => 'center',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'group'            => __( 'Team Member', 'dt-the7-core' ),
		),
		// - Team Member Name.
		array(
			'heading'    => __( 'Team Member Name', 'dt-the7-core' ),
			'param_name' => 'dt_title',
			'type'       => 'dt_title',
			'value'      => '',
			'group'      => __( 'Team Member', 'dt-the7-core' ),
		),
		array(
			'heading'    => __( 'Font style', 'dt-the7-core' ),
			'param_name' => 'post_title_font_style',
			'type'       => 'dt_font_style',
			'value'      => ':bold:',
			'group'      => __( 'Team Member', 'dt-the7-core' ),
		),
		array(
			'heading'          => __( 'Font size', 'dt-the7-core' ),
			'param_name'       => 'post_title_font_size',
			'type'             => 'dt_number',
			'value'            => '',
			'units'            => 'px',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'description'      => __( 'Leave empty to use H4 font size.', 'dt-the7-core' ),
			'group'            => __( 'Team Member', 'dt-the7-core' ),
		),
		array(
			'heading'          => __( 'Line height', 'dt-the7-core' ),
			'param_name'       => 'post_title_line_height',
			'type'             => 'dt_number',
			'value'            => '',
			'units'            => 'px',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'description'      => __( 'Leave empty to use H4 line height.', 'dt-the7-core' ),
			'group'            => __( 'Team Member', 'dt-the7-core' ),
		),
		array(
			'heading'     => __( 'Font color', 'dt-the7-core' ),
			'param_name'  => 'custom_title_color',
			'type'        => 'colorpicker',
			'value'       => '',
			'description' => __( 'Leave empty to use headers color.', 'dt-the7-core' ),
			'group'       => __( 'Team Member', 'dt-the7-core' ),
		),
		array(
			'heading'    => __( 'Gap below name', 'dt-the7-core' ),
			'param_name' => 'post_title_bottom_margin',
			'type'       => 'dt_number',
			'value'      => '0',
			'units'      => 'px',
			'group'      => __( 'Team Member', 'dt-the7-core' ),
		),
		// - Meta Information.
		array(
			'heading'    => __( 'Team Member Position', 'dt-the7-core' ),
			'param_name' => 'dt_title',
			'type'       => 'dt_title',
			'value'      => '',
			'group'      => __( 'Team Member', 'dt-the7-core' ),
		),
		array(
			'heading'    => __( 'Show position', 'dt-the7-core' ),
			'param_name' => 'team_position',
			'type'       => 'dt_switch',
			'value'      => 'y',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
			'group'      => __( 'Team Member', 'dt-the7-core' ),
		),
		array(
			'heading'    => __( 'Font style', 'dt-the7-core' ),
			'param_name' => 'team_position_font_style',
			'type'       => 'dt_font_style',
			'value'      => 'normal:bold:none',
			'group'      => __( 'Team Member', 'dt-the7-core' ),
			'dependency' => array(
				'element' => 'team_position',
				'value'   => 'y',
			),
		),
		array(
			'heading'          => __( 'Font size', 'dt-the7-core' ),
			'param_name'       => 'team_position_font_size',
			'type'             => 'dt_number',
			'value'            => '',
			'units'            => 'px',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'description'      => __( 'Leave empty to use large font size.', 'dt-the7-core' ),
			'group'            => __( 'Team Member', 'dt-the7-core' ),
			'dependency'       => array(
				'element' => 'team_position',
				'value'   => 'y',
			),
		),
		array(
			'heading'          => __( 'Line height', 'dt-the7-core' ),
			'param_name'       => 'team_position_line_height',
			'type'             => 'dt_number',
			'value'            => '',
			'units'            => 'px',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'description'      => __( 'Leave empty to use large line height.', 'dt-the7-core' ),
			'group'            => __( 'Team Member', 'dt-the7-core' ),
			'dependency'       => array(
				'element' => 'team_position',
				'value'   => 'y',
			),
		),
		array(
			'heading'     => __( 'Font color', 'dt-the7-core' ),
			'param_name'  => 'team_position_color',
			'type'        => 'colorpicker',
			'value'       => '',
			'description' => __( ' Leave empty to use accent text color.', 'dt-the7-core' ),
			'group'       => __( 'Team Member', 'dt-the7-core' ),
			'dependency'  => array(
				'element' => 'team_position',
				'value'   => 'y',
			),
		),
		array(
			'heading'          => __( 'Gap below position', 'dt-the7-core' ),
			'param_name'       => 'team_position_bottom_margin',
			'type'             => 'dt_number',
			'value'            => '10px',
			'units'            => 'px',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'group'            => __( 'Team Member', 'dt-the7-core' ),
			'dependency'       => array(
				'element' => 'team_position',
				'value'   => 'y',
			),
		),
		// - Text.
		array(
			'heading'    => __( 'Team Member Description', 'dt-the7-core' ),
			'param_name' => 'dt_title',
			'type'       => 'dt_title',
			'value'      => '',
			'group'      => __( 'Team Member', 'dt-the7-core' ),
		),
		array(
			'group'      => __( 'Team Member', 'dt-the7-core' ),
			'heading'    => __( 'Show description', 'dt-the7-core' ),
			'param_name' => 'show_team_desc',
			'type'       => 'dt_switch',
			'value'      => 'y',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
		),
		array(
			'heading'          => __( 'Team member content or excerpt', 'dt-the7-core' ),
			'param_name'       => 'post_content',
			'type'             => 'dropdown',
			'std'              => 'show_excerpt',
			'value'            => array(
				'Excerpt' => 'show_excerpt',
				'Content' => 'show_content',
			),
			'dependency'       => array(
				'element' => 'show_team_desc',
				'value'   => 'y',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'group'            => __( 'Team Member', 'dt-the7-core' ),
		),
		array(
			'heading'          => __( 'Maximum number of words', 'dt-the7-core' ),
			'param_name'       => 'excerpt_words_limit',
			'type'             => 'dt_number',
			'value'            => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency'       => array(
				'element' => 'show_team_desc',
				'value'   => 'y',
			),

			'description' => __( 'Leave empty to show full text.', 'dt-the7-core' ),
			'group'       => __( 'Team Member', 'dt-the7-core' ),
		),
		array(
			'heading'    => __( 'Font style', 'dt-the7-core' ),
			'param_name' => 'content_font_style',
			'type'       => 'dt_font_style',
			'value'      => '',
			'dependency' => array(
				'element' => 'show_team_desc',
				'value'   => 'y',
			),
			'group'      => __( 'Team Member', 'dt-the7-core' ),
		),
		array(
			'heading'          => __( 'Font size', 'dt-the7-core' ),
			'param_name'       => 'content_font_size',
			'type'             => 'dt_number',
			'value'            => '',
			'units'            => 'px',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'dependency'       => array(
				'element' => 'show_team_desc',
				'value'   => 'y',
			),
			'description'      => __( 'Leave empty to use medium font size.', 'dt-the7-core' ),
			'group'            => __( 'Team Member', 'dt-the7-core' ),
		),
		array(
			'heading'          => __( 'Line height', 'dt-the7-core' ),
			'param_name'       => 'content_line_height',
			'type'             => 'dt_number',
			'value'            => '',
			'units'            => 'px',
			'edit_field_class' => 'vc_col-sm-3 vc_column',
			'dependency'       => array(
				'element' => 'show_team_desc',
				'value'   => 'y',
			),
			'description'      => __( 'Leave empty to use medium line height.', 'dt-the7-core' ),
			'group'            => __( 'Team Member', 'dt-the7-core' ),
		),
		array(
			'heading'     => __( 'Font color', 'dt-the7-core' ),
			'param_name'  => 'custom_content_color',
			'type'        => 'colorpicker',
			'value'       => '',
			'dependency'  => array(
				'element' => 'show_team_desc',
				'value'   => 'y',
			),
			'description' => __( 'Leave empty to use primary text color.', 'dt-the7-core' ),
			'group'       => __( 'Team Member', 'dt-the7-core' ),
		),
		array(
			'heading'          => __( 'Gap below description', 'dt-the7-core' ),
			'param_name'       => 'content_bottom_margin',
			'type'             => 'dt_number',
			'value'            => '5px',
			'units'            => 'px',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency'       => array(
				'element' => 'show_team_desc',
				'value'   => 'y',
			),
			'group'            => __( 'Team Member', 'dt-the7-core' ),
		),
		// - 'Read More' Button.
		array(
			'heading'    => __( '"View Details" Button', 'dt-the7-core' ),
			'param_name' => 'dt_title',
			'type'       => 'dt_title',
			'value'      => '',
			'group'      => __( 'Team Member', 'dt-the7-core' ),
		),
		array(
			'heading'          => __( '"View Details" Button', 'dt-the7-core' ),
			'param_name'       => 'read_more_button',
			'type'             => 'dropdown',
			'std'              => 'default_link',
			'value'            => array(
				'Off'            => 'off',
				'Default link'   => 'default_link',
				'Default button' => 'default_button',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'group'            => __( 'Team Member', 'dt-the7-core' ),
			'description'      => __( 'Visible only if link to team member details page is enabled in post settings.', 'dt-the7-core' ),
		),
		array(
			'heading'          => __( 'Button text', 'dt-the7-core' ),
			'param_name'       => 'read_more_button_text',
			'type'             => 'textfield',
			'value'            => 'View details',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency'       => array(
				'element' => 'read_more_button',
				'value'   => array(
					'default_link',
					'default_button',
				),
			),
			'group'            => __( 'Team Member', 'dt-the7-core' ),
		),
		//Social Links
		array(
			'group'      => __( 'Social Links', 'dt-the7-core' ),
			'heading'    => __( 'Show social links', 'dt-the7-core' ),
			'param_name' => 'show_soc_icon',
			'type'       => 'dt_switch',
			'value'      => 'y',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
		),
		array(
			'group'            => __( 'Social Links', 'dt-the7-core' ),
			'heading'          => __( 'Social links position', 'dt-the7-core' ),
			'param_name'       => 'show_icons_under',
			'type'             => 'dropdown',
			'value'            => array(
				'Before description' => 'under_position',
				'Below description'  => 'under_description',
			),
			'dependency'       => array(
				'element' => 'show_soc_icon',
				'value'   => 'y',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
		),
		array(
			'group'      => __( 'Social Links', 'dt-the7-core' ),
			'heading'    => __( 'Icon size', 'dt-the7-core' ),
			'param_name' => 'soc_icon_size',
			'type'       => 'dt_number',
			'value'      => '16px',
			'units'      => 'px',
			'dependency' => array(
				'element' => 'show_soc_icon',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Social Links', 'dt-the7-core' ),
			'heading'    => __( 'Icon Background', 'dt-the7-core' ),
			'param_name' => 'dt_soc_icon_title',
			'type'       => 'dt_title',
			'dependency' => array(
				'element' => 'show_soc_icon',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Social Links', 'dt-the7-core' ),
			'heading'    => __( 'Background size', 'dt-the7-core' ),
			'param_name' => 'soc_icon_bg_size',
			'type'       => 'dt_number',
			'value'      => '26px',
			'units'      => 'px',
			'dependency' => array(
				'element' => 'show_soc_icon',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Social Links', 'dt-the7-core' ),
			'heading'    => __( 'Border width', 'dt-the7-core' ),
			'param_name' => 'soc_icon_border_width',
			'type'       => 'dt_number',
			'value'      => '0',
			'units'      => 'px',
			'dependency' => array(
				'element' => 'show_soc_icon',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Social Links', 'dt-the7-core' ),
			'heading'    => __( 'Border radius', 'dt-the7-core' ),
			'param_name' => 'soc_icon_border_radius',
			'type'       => 'dt_number',
			'value'      => '100px',
			'units'      => 'px',
			'dependency' => array(
				'element' => 'show_soc_icon',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Social Links', 'dt-the7-core' ),
			'heading'    => __( 'Normal', 'dt-the7-core' ),
			'param_name' => 'dt_soc_icon_title',
			'type'       => 'dt_title',
			'dependency' => array(
				'element' => 'show_soc_icon',
				'value'   => 'y',
			),
		),
		array(
			'group'       => __( 'Social Links', 'dt-the7-core' ),
			'heading'     => __( 'Icon color', 'dt-the7-core' ),
			'description' => __( 'Live empty to use accent color.', 'dt-the7-core' ),
			'param_name'  => 'soc_icon_color',
			'type'        => 'colorpicker',
			'value'       => 'rgba(255,255,255,1)',
			'dependency'  => array(
				'element' => 'show_soc_icon',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Social Links', 'dt-the7-core' ),
			'heading'    => __( 'Show icon border color', 'dt-the7-core' ),
			'param_name' => 'soc_icon_border',
			'type'       => 'dt_switch',
			'value'      => 'y',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
			'dependency' => array(
				'element' => 'show_soc_icon',
				'value'   => 'y',
			),
		),
		array(
			'group'       => __( 'Social Links', 'dt-the7-core' ),
			'heading'     => __( 'Icon border color  ', 'dt-the7-core' ),
			'description' => __( 'Live empty to use accent color.', 'dt-the7-core' ),
			'param_name'  => 'soc_icon_border_color',
			'type'        => 'colorpicker',
			'value'       => '',
			'dependency'  => array(
				'element' => 'soc_icon_border',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Social Links', 'dt-the7-core' ),
			'heading'    => __( 'Show icon background', 'dt-the7-core' ),
			'param_name' => 'soc_icon_bg',
			'type'       => 'dt_switch',
			'value'      => 'y',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
			'dependency' => array(
				'element' => 'show_soc_icon',
				'value'   => 'y',
			),
		),
		array(
			'group'       => __( 'Social Links', 'dt-the7-core' ),
			'heading'     => __( 'Icon background color', 'dt-the7-core' ),
			'param_name'  => 'soc_icon_bg_color',
			'type'        => 'colorpicker',
			'value'       => '',
			'dependency'  => array(
				'element' => 'soc_icon_bg',
				'value'   => 'y',
			),
			'description' => __( 'Live empty to use accent color.', 'dt-the7-core' ),
		),
		array(
			'group'      => __( 'Social Links', 'dt-the7-core' ),
			'heading'    => __( 'Hover', 'dt-the7-core' ),
			'param_name' => 'dt_soc_icon_title',
			'type'       => 'dt_title',
			'dependency' => array(
				'element' => 'show_soc_icon',
				'value'   => 'y',
			),
		),
		array(
			'group'       => __( 'Social Links', 'dt-the7-core' ),
			'heading'     => __( 'Icon color', 'dt-the7-core' ),
			'description' => __( 'Live empty to use accent color.', 'dt-the7-core' ),
			'param_name'  => 'soc_icon_color_hover',
			'type'        => 'colorpicker',
			'value'       => 'rgba(255,255,255,0.75)',
			'dependency'  => array(
				'element' => 'show_soc_icon',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Social Links', 'dt-the7-core' ),
			'heading'    => __( 'Show icon border color', 'dt-the7-core' ),
			'param_name' => 'soc_icon_border_hover',
			'type'       => 'dt_switch',
			'value'      => 'y',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
			'dependency' => array(
				'element' => 'show_soc_icon',
				'value'   => 'y',
			),
		),
		array(
			'group'       => __( 'Social Links', 'dt-the7-core' ),
			'heading'     => __( 'Icon border color  ', 'dt-the7-core' ),
			'description' => __( 'Live empty to use accent color.', 'dt-the7-core' ),
			'param_name'  => 'soc_icon_border_color_hover',
			'type'        => 'colorpicker',
			'value'       => '',
			'dependency'  => array(
				'element' => 'soc_icon_border_hover',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Social Links', 'dt-the7-core' ),
			'heading'    => __( 'Show icon background', 'dt-the7-core' ),
			'param_name' => 'soc_icon_bg_hover',
			'type'       => 'dt_switch',
			'value'      => 'y',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
			'dependency' => array(
				'element' => 'show_soc_icon',
				'value'   => 'y',
			),
		),
		array(
			'group'       => __( 'Social Links', 'dt-the7-core' ),
			'heading'     => __( 'Icon background color', 'dt-the7-core' ),
			'param_name'  => 'soc_icon_bg_color_hover',
			'type'        => 'colorpicker',
			'value'       => '',
			'dependency'  => array(
				'element' => 'soc_icon_bg_hover',
				'value'   => 'y',
			),
			'description' => __( 'Live empty to use accent color.', 'dt-the7-core' ),
		),
		array(
			'group'      => __( 'Social Links', 'dt-the7-core' ),
			'heading'    => __( 'Icons gaps', 'dt-the7-core' ),
			'param_name' => 'dt_soc_icon_title',
			'type'       => 'dt_title',
			'dependency' => array(
				'element' => 'show_soc_icon',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Social Links', 'dt-the7-core' ),
			'heading'    => __( 'Gap below icons', 'dt-the7-core' ),
			'param_name' => 'soc_icon_below_gap',
			'type'       => 'dt_number',
			'value'      => '15px',
			'units'      => 'px',
			'dependency' => array(
				'element' => 'show_soc_icon',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Social Links', 'dt-the7-core' ),
			'heading'    => __( 'Gap between icons', 'dt-the7-core' ),
			'param_name' => 'soc_icon_gap',
			'type'       => 'dt_number',
			'value'      => '4px',
			'units'      => 'px',
			'dependency' => array(
				'element' => 'show_soc_icon',
				'value'   => 'y',
			),
		),
		// - Pagination.
		array(
			'heading'    => __( 'Pagination', 'dt-the7-core' ),
			'param_name' => 'dt_title',
			'type'       => 'dt_title',
			'value'      => '',
			'group'      => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		array(
			'heading'          => __( 'Pagination mode', 'dt-the7-core' ),
			'param_name'       => 'loading_mode',
			'type'             => 'dropdown',
			'std'              => 'disabled',
			'value'            => array(
				'Disabled'           => 'disabled',
				'Standard'           => 'standard',
				'JavaScript pages'   => 'js_pagination',
				'"Load more" button' => 'js_more',
				'Infinite scroll'    => 'js_lazy_loading',
			),
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'group'            => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		// -- Disabled.
		array(
			'heading'          => __( 'Total number of posts', 'dt-the7-core' ),
			'param_name'       => 'dis_posts_total',
			'type'             => 'dt_number',
			'value'            => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency'       => array(
				'element' => 'loading_mode',
				'value'   => 'disabled',
			),
			'description'      => __( 'Leave empty to display all posts.', 'dt-the7-core' ),
			'group'            => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		// -- Standard.
		array(
			'heading'          => __( 'Number of posts to display on one page', 'dt-the7-core' ),
			'param_name'       => 'st_posts_per_page',
			'type'             => 'dt_number',
			'value'            => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency'       => array(
				'element' => 'loading_mode',
				'value'   => 'standard',
			),
			'description'      => __( 'Leave empty to use number from wp settings.', 'dt-the7-core' ),
			'group'            => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		// -- JavaScript pages.
		array(
			'heading'          => __( 'Total number of posts', 'dt-the7-core' ),
			'param_name'       => 'jsp_posts_total',
			'type'             => 'dt_number',
			'value'            => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency'       => array(
				'element' => 'loading_mode',
				'value'   => 'js_pagination',
			),
			'description'      => __( 'Leave empty to display all posts.', 'dt-the7-core' ),
			'group'            => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		array(
			'heading'          => __( 'Number of posts to display on one page', 'dt-the7-core' ),
			'param_name'       => 'jsp_posts_per_page',
			'type'             => 'dt_number',
			'value'            => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency'       => array(
				'element' => 'loading_mode',
				'value'   => 'js_pagination',
			),
			'description'      => __( 'Leave empty to use number from wp settings.', 'dt-the7-core' ),
			'group'            => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		// -- js Load more.
		array(
			'heading'          => __( 'Total number of posts', 'dt-the7-core' ),
			'param_name'       => 'jsm_posts_total',
			'type'             => 'dt_number',
			'value'            => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency'       => array(
				'element' => 'loading_mode',
				'value'   => 'js_more',
			),
			'description'      => __( 'Leave empty to display all posts.', 'dt-the7-core' ),
			'group'            => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		array(
			'heading'          => __( 'Number of posts to display on one page', 'dt-the7-core' ),
			'param_name'       => 'jsm_posts_per_page',
			'type'             => 'dt_number',
			'value'            => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency'       => array(
				'element' => 'loading_mode',
				'value'   => 'js_more',
			),
			'description'      => __( 'Leave empty to use number from wp settings.', 'dt-the7-core' ),
			'group'            => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		// -- js Infinite scroll.
		array(
			'heading'          => __( 'Total number of posts', 'dt-the7-core' ),
			'param_name'       => 'jsl_posts_total',
			'type'             => 'dt_number',
			'value'            => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency'       => array(
				'element' => 'loading_mode',
				'value'   => 'js_lazy_loading',
			),
			'description'      => __( 'Leave empty to display all posts.', 'dt-the7-core' ),
			'group'            => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		array(
			'heading'          => __( 'Number of posts to display on one page', 'dt-the7-core' ),
			'param_name'       => 'jsl_posts_per_page',
			'type'             => 'dt_number',
			'value'            => '',
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'dependency'       => array(
				'element' => 'loading_mode',
				'value'   => 'js_lazy_loading',
			),
			'description'      => __( 'Leave empty to use number from wp settings.', 'dt-the7-core' ),
			'group'            => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		// -- Posts offset.
		array(
			'heading'          => __( 'Teammates offset', 'dt-the7-core' ),
			'param_name'       => 'posts_offset',
			'type'             => 'dt_number',
			'value'            => 0,
			'min'              => 0,
			'edit_field_class' => 'vc_col-xs-12 vc_column dt_row-6',
			'description'      => __( 'Offset for team query (i.e. 2 means, teammates will be displayed starting from the third mate).', 'dt-the7-core' ),
			'group'            => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		// -- Standard.
		array(
			'heading'    => __( 'Show all pages in paginator', 'dt-the7-core' ),
			'param_name' => 'st_show_all_pages',
			'type'       => 'dt_switch',
			'value'      => 'n',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
			'dependency' => array(
				'element' => 'loading_mode',
				'value'   => 'standard',
			),
			'group'      => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		array(
			'heading'     => __( 'Gap before pagination', 'dt-the7-core' ),
			'param_name'  => 'st_gap_before_pagination',
			'type'        => 'dt_number',
			'value'       => '',
			'units'       => 'px',
			'dependency'  => array(
				'element' => 'loading_mode',
				'value'   => 'standard',
			),
			'description' => __( 'Leave empty to use default gap', 'dt-the7-core' ),
			'group'       => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		// -- JavaScript pages.
		array(
			'heading'    => __( 'Show all pages in paginator', 'dt-the7-core' ),
			'param_name' => 'jsp_show_all_pages',
			'type'       => 'dt_switch',
			'value'      => 'n',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
			'dependency' => array(
				'element' => 'loading_mode',
				'value'   => 'js_pagination',
			),
			'group'      => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		array(
			'heading'     => __( 'Gap before pagination', 'dt-the7-core' ),
			'param_name'  => 'jsp_gap_before_pagination',
			'type'        => 'dt_number',
			'value'       => '',
			'units'       => 'px',
			'dependency'  => array(
				'element' => 'loading_mode',
				'value'   => 'js_pagination',
			),
			'description' => __( 'Leave empty to use default gap', 'dt-the7-core' ),
			'group'       => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		// -- js Load more.
		array(
			'heading'     => __( 'Gap before pagination', 'dt-the7-core' ),
			'param_name'  => 'jsm_gap_before_pagination',
			'type'        => 'dt_number',
			'value'       => '',
			'units'       => 'px',
			'dependency'  => array(
				'element' => 'loading_mode',
				'value'   => 'js_more',
			),
			'description' => __( 'Leave empty to use default gap', 'dt-the7-core' ),
			'group'       => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		array(
			'heading'    => __( 'Categorization', 'dt-the7-core' ),
			'param_name' => 'dt_title',
			'type'       => 'dt_title',
			'value'      => '',
			'group'      => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		array(
			'heading'    => __( 'Show categories filter', 'dt-the7-core' ),
			'param_name' => 'show_categories_filter',
			'type'       => 'dt_switch',
			'value'      => 'n',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
			'group'      => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		array(
			'heading'    => __( 'Color settings', 'dt-the7-core' ),
			'param_name' => 'dt_title',
			'type'       => 'dt_title',
			'group'      => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		array(
			'heading'     => __( 'Font color', 'dt-the7-core' ),
			'param_name'  => 'navigation_font_color',
			'type'        => 'colorpicker',
			'value'       => '',
			'description' => __( 'Leave empty to use headers color.', 'dt-the7-core' ),
			'group'       => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		array(
			'heading'     => __( 'Accent color', 'dt-the7-core' ),
			'param_name'  => 'navigation_accent_color',
			'type'        => 'colorpicker',
			'value'       => '',
			'description' => __( 'Leave empty to use accent color.', 'dt-the7-core' ),
			'group'       => __( 'Pagination & Categorization', 'dt-the7-core' ),
		),
		array(
			'type'       => 'css_editor',
			'heading'    => __( 'CSS box', 'dt-the7-core' ),
			'param_name' => 'css_dt_team_masonry',
			'group'      => __( 'Design Options', 'dt-the7-core' ),
		),
	),
);

