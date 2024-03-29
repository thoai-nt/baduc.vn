<?php

defined( 'ABSPATH' ) || exit;

return array(
	'weight'                  => -1,
	'name'                    => __( 'Multipurpose Carousel', 'the7mk2' ),
	'base'                    => 'dt_carousel',
	'icon'                    => 'dt_vc_ico_carousel',
	'class'                   => 'dt_carousel',
	'as_parent'               => array( 'except' => 'dt_carousel, dt_slideshow, ult_tab_element, dt_team_carousel, dt_testimonials_carousel, dt_small_photos, dt_albums, dt_photos_masonry, dt_testimonials, dt_team, dt_albums_scroller, dt_portfolio_carousel, dt_portfolio_slide, dt_portfolio, dt_albums_carousel, dt_photos_carousel, dt_portfolio_slider, dt_products_carousel, dt_media_gallery_carousel, dt_before_after, dt_blog_scroller, dt_blog_posts, dt_blog_carousel, ult_range_slider, ultimate_carousel' ),
	'content_element'         => true,
	'controls'                => 'full',
	'show_settings_on_create' => true,
	'category'                => __( 'by Dream-Theme', 'the7mk2' ),
	'params'                  => array(
		array(
			'heading'    => __( 'Columns & Responsiveness', 'the7mk2' ),
			'param_name' => 'dt_title_general',
			'type'       => 'dt_title',
		),
		array(
			'heading'          => __( 'Wide desktop', 'the7mk2' ),
			'param_name'       => 'slides_on_wide_desk',
			'type'             => 'textfield',
			'value'            => '4',
			'edit_field_class' => 'vc_media-xs vc_col-xs-2 vc_column',
		),
		array(
			'heading'          => __( 'Desktop', 'the7mk2' ),
			'param_name'       => 'slides_on_desk',
			'type'             => 'textfield',
			'value'            => '3',
			'edit_field_class' => 'vc_media-xs vc_col-xs-2 vc_column',
		),
		array(
			'heading'          => __( 'Laptop', 'the7mk2' ),
			'param_name'       => 'slides_on_lapt',
			'type'             => 'textfield',
			'value'            => '3',
			'edit_field_class' => 'vc_media-xs vc_col-xs-2 vc_column',
		),
		array(
			'heading'          => __( 'Hor. tablet ', 'the7mk2' ),
			'param_name'       => 'slides_on_h_tabs',
			'type'             => 'textfield',
			'value'            => '3',
			'edit_field_class' => 'vc_media-xs vc_col-xs-2 vc_column',
		),
		array(
			'heading'          => __( 'Vert. tablet', 'the7mk2' ),
			'param_name'       => 'slides_on_v_tabs',
			'type'             => 'textfield',
			'value'            => '2',
			'edit_field_class' => 'vc_media-xs vc_col-xs-2 vc_column',
		),
		array(
			'heading'          => __( 'Phone', 'the7mk2' ),
			'param_name'       => 'slides_on_mob',
			'type'             => 'textfield',
			'value'            => '1',
			'edit_field_class' => 'vc_media-xs vc_col-xs-2 vc_column',
		),
		array(
			'heading'          => __( 'Gap between columns ', 'the7mk2' ),
			'param_name'       => 'item_space',
			'type'             => 'dt_number',
			'value'            => '30',
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
			'heading'    => __( 'Enable adaptive height', 'the7mk2' ),
			'param_name' => 'adaptive_height',
			'type'       => 'dt_switch',
			'value'      => 'y',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
		),
		array(
			'heading'    => __( 'Scrolling', 'the7mk2' ),
			'param_name' => 'dt_title_general',
			'type'       => 'dt_title',
			'value'      => '',
		),
		array(
			'heading'    => __( 'Scroll mode', 'the7mk2' ),
			'param_name' => 'slide_to_scroll',
			'type'       => 'dropdown',
			'value'      => array(
				'One slide at a time' => 'single',
				'All slides'          => 'all',
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
			'heading'    => __( 'Autoplay slides‏', 'the7mk2' ),
			'param_name' => 'autoplay',
			'type'       => 'dt_switch',
			'value'      => 'n',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
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
			'heading'    => __( 'Extra Class', 'the7mk2' ),
			'param_name' => 'dt_title_general',
			'type'       => 'dt_title',
			'value'      => '',
		),
		array(
			'type'        => 'textfield',
			'heading'     => __( 'Extra class name (optional)', 'the7mk2' ),
			'param_name'  => 'el_class',
			'value'       => '',
			'description' => __( 'Style particular elements differently - add a class name and refer to it in custom CSS.', 'the7mk2' ),
		),

		// Naviagtion group.
		array(
			'group'      => __( 'Arrows', 'the7mk2' ),
			'heading'    => __( 'Show arrows', 'the7mk2' ),
			'param_name' => 'arrows',
			'type'       => 'dt_switch',
			'value'      => 'y',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
		),
		array(
			'group'      => __( 'Arrows', 'the7mk2' ),
			'heading'    => __( 'Arrow Icon', 'the7mk2' ),
			'param_name' => 'dt_title_arrows',
			'type'       => 'dt_title',
			'value'      => '',
			'dependency' => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Arrows', 'the7mk2' ),
			'heading'    => __( 'Choose icon for "Next Arrow"', 'the7mk2' ),
			'param_name' => 'next_icon',
			'type'       => 'dt_navigation',
			'value'      => 'icon-ar-017-r',
			'dependency' => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Arrows', 'the7mk2' ),
			'heading'    => __( 'Choose icon  for "Prev Arrow"', 'the7mk2' ),
			'param_name' => 'prev_icon',
			'type'       => 'dt_navigation',
			'value'      => 'icon-ar-017-l',
			'dependency' => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Arrows', 'the7mk2' ),
			'heading'    => __( 'Arrow icon size', 'the7mk2' ),
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
			'group'      => __( 'Arrows', 'the7mk2' ),
			'heading'    => __( 'Arrow Background', 'the7mk2' ),
			'param_name' => 'dt_title_arrows',
			'type'       => 'dt_title',
			'value'      => '',
			'dependency' => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
		),
		array(
			'group'            => __( 'Arrows', 'the7mk2' ),
			'heading'          => __( 'Width', 'the7mk2' ),
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
			'group'            => __( 'Arrows', 'the7mk2' ),
			'heading'          => __( 'Height', 'the7mk2' ),
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
			'group'      => __( 'Arrows', 'the7mk2' ),
			'heading'    => __( 'Arrow border radius', 'the7mk2' ),
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
			'group'      => __( 'Arrows', 'the7mk2' ),
			'heading'    => __( 'Arrow border width', 'the7mk2' ),
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
			'group'      => __( 'Arrows', 'the7mk2' ),
			'heading'    => __( 'Color Setting', 'the7mk2' ),
			'param_name' => 'dt_title_arrows',
			'type'       => 'dt_title',
			'value'      => '',
			'dependency' => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
		),
		array(
			'group'       => __( 'Arrows', 'the7mk2' ),
			'heading'     => __( 'Arrow icon color', 'the7mk2' ),
			'description' => __( 'Live empty to use accent color.', 'the7mk2' ),
			'param_name'  => 'arrow_icon_color',
			'type'        => 'colorpicker',
			'value'       => '#ffffff',
			'dependency'  => array(
				'element' => 'arrows',
				'value'   => 'y',
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
			'group'       => __( 'Arrows', 'the7mk2' ),
			'heading'     => __( 'Arrow border color', 'the7mk2' ),
			'description' => __( 'Live empty to use accent color.', 'the7mk2' ),
			'param_name'  => 'arrow_border_color',
			'type'        => 'colorpicker',
			'value'       => '',
			'dependency'  => array(
				'element' => 'arrow_icon_border',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Arrows', 'the7mk2' ),
			'heading'    => __( 'Show arrow background', 'the7mk2' ),
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
			'group'       => __( 'Arrows', 'the7mk2' ),
			'heading'     => __( 'Arrow background color', 'the7mk2' ),
			'description' => __( 'Live empty to use accent color.', 'the7mk2' ),
			'param_name'  => 'arrow_bg_color',
			'type'        => 'colorpicker',
			'value'       => '',
			'dependency'  => array(
				'element' => 'arrows_bg_show',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Arrows', 'the7mk2' ),
			'heading'    => __( 'Hover Color Setting', 'the7mk2' ),
			'param_name' => 'dt_title_arrows',
			'type'       => 'dt_title',
			'value'      => '',
			'dependency' => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
		),
		array(
			'group'       => __( 'Arrows', 'the7mk2' ),
			'heading'     => __( 'Arrow icon color hover', 'the7mk2' ),
			'description' => __( 'Live empty to use accent color.', 'the7mk2' ),
			'param_name'  => 'arrow_icon_color_hover',
			'type'        => 'colorpicker',
			'value'       => 'rgba(255,255,255,0.75)',
			'dependency'  => array(
				'element' => 'arrows',
				'value'   => 'y',
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
			'group'       => __( 'Arrows', 'the7mk2' ),
			'heading'     => __( 'Arrow border color hover ', 'the7mk2' ),
			'description' => __( 'Live empty to use accent color.', 'the7mk2' ),
			'param_name'  => 'arrow_border_color_hover',
			'type'        => 'colorpicker',
			'value'       => '',
			'dependency'  => array(
				'element' => 'arrow_icon_border_hover',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Arrows', 'the7mk2' ),
			'heading'    => __( 'Show arrow background hover', 'the7mk2' ),
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
			'group'       => __( 'Arrows', 'the7mk2' ),
			'heading'     => __( 'Arrow background hover color', 'the7mk2' ),
			'description' => __( 'Live empty to use accent color.', 'the7mk2' ),
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
			'group'      => __( 'Arrows', 'the7mk2' ),
			'heading'    => __( 'Right Arrow Position', 'the7mk2' ),
			'param_name' => 'dt_title_arrows',
			'type'       => 'dt_title',
			'value'      => '',
			'dependency' => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Arrows', 'the7mk2' ),
			'heading'    => __( 'Icon paddings', 'the7mk2' ),
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
			'group'            => __( 'Arrows', 'the7mk2' ),
			'heading'          => __( 'Vertical position', 'the7mk2' ),
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
			'group'            => __( 'Arrows', 'the7mk2' ),
			'heading'          => __( 'Horizontal position', 'the7mk2' ),
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
			'group'      => __( 'Arrows', 'the7mk2' ),
			'heading'    => __( 'Vertical offset', 'the7mk2' ),
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
			'group'      => __( 'Arrows', 'the7mk2' ),
			'heading'    => __( 'Horizontal offset', 'the7mk2' ),
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
			'group'      => __( 'Arrows', 'the7mk2' ),
			'heading'    => __( 'Left Arrow Position', 'the7mk2' ),
			'param_name' => 'dt_title_arrows',
			'type'       => 'dt_title',
			'value'      => '',
			'dependency' => array(
				'element' => 'arrows',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Arrows', 'the7mk2' ),
			'heading'    => __( 'Icon paddings', 'the7mk2' ),
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
			'group'            => __( 'Arrows', 'the7mk2' ),
			'heading'          => __( 'Vertical position', 'the7mk2' ),
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
			'group'            => __( 'Arrows', 'the7mk2' ),
			'heading'          => __( 'Horizontal position', 'the7mk2' ),
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
			'group'      => __( 'Arrows', 'the7mk2' ),
			'heading'    => __( 'Vertical offset', 'the7mk2' ),
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
			'group'      => __( 'Arrows', 'the7mk2' ),
			'heading'    => __( 'Horizontal offset', 'the7mk2' ),
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
			'group'            => __( 'Arrows', 'the7mk2' ),
			'heading'          => __( 'Arrows behaviour', 'the7mk2' ),
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
			'group'      => __( 'Arrows', 'the7mk2' ),
			'heading'    => __( 'Enable if browser width is less then ', 'the7mk2' ),
			'param_name' => 'hide_arrows_mobile_switch_width',
			'type'       => 'dt_number',
			'value'      => '778px',
			'units'      => 'px',
			'dependency' => array( 'element' => 'arrow_responsiveness', 'value' => array( 'hide-arrows' ) ),
		),
		array(
			'group'      => __( 'Arrows', 'the7mk2' ),
			'heading'    => __( 'Enable if browser width is less then ', 'the7mk2' ),
			'param_name' => 'reposition_arrows_mobile_switch_width',
			'type'       => 'dt_number',
			'value'      => '778px',
			'units'      => 'px',
			'dependency' => array( 'element' => 'arrow_responsiveness', 'value' => array( 'reposition-arrows' ) ),
		),
		array(
			'group'      => __( 'Arrows', 'the7mk2' ),
			'heading'    => __( 'Left arrow horizontal offset', 'the7mk2' ),
			'param_name' => 'l_arrows_mobile_h_position',
			'type'       => 'dt_number',
			'value'      => '10px',
			'units'      => 'px',
			'dependency' => array( 'element' => 'arrow_responsiveness', 'value' => array( 'reposition-arrows' ) ),
		),
		array(
			'group'      => __( 'Arrows', 'the7mk2' ),
			'heading'    => __( 'Right arrow horizontal offset', 'the7mk2' ),
			'param_name' => 'r_arrows_mobile_h_position',
			'type'       => 'dt_number',
			'value'      => '10px',
			'units'      => 'px',
			'dependency' => array( 'element' => 'arrow_responsiveness', 'value' => array( 'reposition-arrows' ) ),
		),
		//BULLETS
		array(
			'group'      => __( 'Bullets', 'the7mk2' ),
			'heading'    => __( 'Show bullets', 'the7mk2' ),
			'param_name' => 'show_bullets',
			'type'       => 'dt_switch',
			'value'      => 'n',
			'options'    => array(
				'Yes' => 'y',
				'No'  => 'n',
			),
		),
		array(
			'group'      => __( 'Bullets', 'the7mk2' ),
			'heading'    => __( 'Bullets Style, Size & Color', 'the7mk2' ),
			'param_name' => 'dt_title_bullets',
			'type'       => 'dt_title',
			'value'      => '',
			'dependency' => array(
				'element' => 'show_bullets',
				'value'   => 'y',
			),

		),
		array(
			'group'            => __( 'Bullets', 'the7mk2' ),
			'heading'          => __( 'Choose bullets style', 'the7mk2' ),
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
			'group'      => __( 'Bullets', 'the7mk2' ),
			'heading'    => __( 'Bullets size', 'the7mk2' ),
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
			'group'      => __( 'Bullets', 'the7mk2' ),
			'heading'    => __( 'Gap between bullets', 'the7mk2' ),
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
			'group'       => __( 'Bullets', 'the7mk2' ),
			'heading'     => __( 'Bullets color', 'the7mk2' ),
			'description' => __( 'Live empty to use accent color.', 'the7mk2' ),
			'param_name'  => 'bullet_color',
			'type'        => 'colorpicker',
			'value'       => '',
			'dependency'  => array(
				'element' => 'show_bullets',
				'value'   => 'y',
			),
		),
		array(
			'group'       => __( 'Bullets', 'the7mk2' ),
			'heading'     => __( 'Bullets hover color', 'the7mk2' ),
			'description' => __( 'Live empty to use accent color.', 'the7mk2' ),
			'param_name'  => 'bullet_color_hover',
			'type'        => 'colorpicker',
			'value'       => '',
			'dependency'  => array(
				'element' => 'show_bullets',
				'value'   => 'y',
			),
		),
		array(
			'group'      => __( 'Bullets', 'the7mk2' ),
			'heading'    => __( 'Bullets Position', 'the7mk2' ),
			'param_name' => 'dt_title_bullets',
			'type'       => 'dt_title',
			'value'      => '',
			'dependency' => array(
				'element' => 'show_bullets',
				'value'   => 'y',
			),
		),
		array(
			'group'            => __( 'Bullets', 'the7mk2' ),
			'heading'          => __( 'Vertical position', 'the7mk2' ),
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
			'group'            => __( 'Bullets', 'the7mk2' ),
			'heading'          => __( 'Horizontal position', 'the7mk2' ),
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
			'group'      => __( 'Bullets', 'the7mk2' ),
			'heading'    => __( 'Vertical offset', 'the7mk2' ),
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
			'group'      => __( 'Bullets', 'the7mk2' ),
			'heading'    => __( 'Horizontal offset', 'the7mk2' ),
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
			'heading'    => __( 'CSS box', 'the7mk2' ),
			'param_name' => 'css_dt_carousel',
			'group'      => __( 'Design Options', 'the7mk2' ),
		),

	),
	'js_view'                 => 'VcColumnView',

);

