<?php
/**
 * Prohibit direct script loading.
 *
 * @package Convert_Plus.
 */

// Add new input type "typography".
if ( function_exists( 'smile_add_input_type' ) ) {
	add_action( 'admin_enqueue_scripts', 'cp_gfonts_param_script' );
	smile_add_input_type( 'google_fonts', 'google_fonts_settings_field' );
}

/**
 * Function Name:cp_gfonts_param_script description.
 */
function cp_gfonts_param_script() {
	wp_register_script( 'cp_gfonts_param', SMILE_FRAMEWORK_URI . '/lib/fields/google-fonts/js/google-fonts-param.js', array( 'jquery' ), CP_VERSION, false );
}

/**
 * Function Name:google_fonts_settings_field Function to handle new input type "switch".
 *
 * @param  string $name     settings provided when using the input type "switch".
 * @param  string $settings holds the default / updated value.
 * @param  string $value    html output generated by the function.
 * @return string           html output generated by the function.
 */
function google_fonts_settings_field( $name, $settings, $value ) {

	if ( isset( $settings['use_in'] ) ) {
		$use_in = $settings['use_in'];
	} else {
		$use_in = 'editor';
	}

	wp_enqueue_script( 'cp_gfonts_param' );

	$input_name = $name;
	$output     = '';

	$default_value = $value;

	$type  = isset( $settings['type'] ) ? $settings['type'] : '';
	$class = isset( $settings['class'] ) ? $settings['class'] : '';
	$title = isset( $settings['title'] ) ? $settings['title'] : __( 'Font Name', 'ultimate' );

	// Apply partials.
	$partials = generate_partial_atts( $settings );

	$output .= '<strong><label class="customize-control-title">' . $title . '</label></strong>';

	// Google Fonts.
	$fonts       = get_option( 'ultimate_selected_google_fonts' );
	$fontsvals   = array();
	$basic_fonts = array(
		'Arial',
		'Arial Black',
		'Comic Sans MS',
		'Courier New',
		'Georgia',
		'Impact',
		'Lucida Sans Unicode',
		'Palatino Linotype',
		'Tahoma',
		'Times New Roman',
		'Trebuchet MS',
		'Verdana',
	);

	$default_google_fonts = array(
		'Lato',
		'Open Sans',
		'Libre Baskerville',
		'Montserrat',
		'Neuton',
		'Raleway',
		'Roboto',
		'Sacramento',
		'Varela Round',
		'Pacifico',
		'Bitter',
	);

	$user_added_fonts = array();

	if ( ! empty( $fonts ) && is_array( $fonts ) ) {
		foreach ( $fonts as $key => $font ) {
			$user_added_fonts[] = $font['font_name'];
		}
	}

	$google_fonts = array_merge( $user_added_fonts, $default_google_fonts );
	$google_fonts = array_unique( $google_fonts );
	sort( $google_fonts );
	$fonts = array_merge( $google_fonts, $basic_fonts );

	$output .= '<div class="ultimate_google_font_param_block"><p>';
	$output .= '	<select id="smile_' . $input_name . '" name="font_family" class="smile-input google-font-list" ' . $partials . '>';
	$output .= '		<option value="">' . __( 'Default', 'ultimate_vc' ) . '</option>';

	if ( ! empty( $fonts ) && is_array( $fonts ) ) {
		foreach ( $fonts as $font ) {
			$selected = '';
			if ( $font == $value ) {
				$selected = 'selected';
			}
			$output .= "<option value='" . $font . "' " . $selected . '>' . $font . '</option>';
		}
	}

	$output .= '</select></p>';
	$output .= '</div>';

	if ( 0 === count( $fontsvals ) ) {
		$fontsvals = '';
	}

	// Retrieve saved options.
	$output .= '<input type="hidden" data-use-in="' . $use_in . '" date-fonts="' . $fontsvals . '" id="smile_typo_' . $input_name . '" class="form-control smile-input-gfonts smile-input smile-' . $type . ' ' . $input_name . ' smile_' . $input_name . ' ' . $type . ' ' . $class . '" name="' . $input_name . '" value="' . $default_value . '" />';

	ob_start();

	echo $output; //PHPCS:ignore:WordPress.Security.EscapeOutput.OutputNotEscaped ?>

	<style type="text/css">
	.smile_input_gfonts_contents {
		margin: 15px 0;
		min-height: 15px;
	}
</style>

	<?php
	return ob_get_clean();      }
