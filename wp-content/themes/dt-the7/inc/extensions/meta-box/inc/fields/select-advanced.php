<?php
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

// Make sure "select" field is loaded
require_once THE7_RWMB_FIELDS_DIR . 'select.php';

if ( !class_exists( 'THE7_RWMB_Select_Advanced_Field' ) )
{
	class THE7_RWMB_Select_Advanced_Field extends THE7_RWMB_Select_Field
	{
		/**
		 * Enqueue scripts and styles
		 *
		 * @return void
		 */
		static function admin_enqueue_scripts()
		{
			wp_enqueue_style( 'select2', THE7_RWMB_CSS_URL . 'select2/select2.css', array(), '3.2' );
			wp_enqueue_style( 'the7-mb-select-advanced', THE7_RWMB_CSS_URL . 'select-advanced.css', array(), THE7_RWMB_VER );

			wp_register_script( 'select2', THE7_RWMB_JS_URL . 'select2/select2.min.js', array(), '3.2', true );
			wp_enqueue_script( 'the7-mb-select-advanced', THE7_RWMB_JS_URL . 'select-advanced.js', array( 'select2' ), THE7_RWMB_VER, true );
		}

		/**
		 * Get field HTML
		 *
		 * @param string $html
		 * @param mixed  $meta
		 * @param array  $field
		 *
		 * @return string
		 */
		static function html( $html, $meta, $field )
		{
			$html = sprintf(
				'<select class="the7-mb-select-advanced" name="%s" id="%s" size="%s"%s data-options="%s">',
				$field['field_name'],
				$field['id'],
				$field['size'],
				$field['multiple'] ? ' multiple="multiple"' : '',
				esc_attr( json_encode( $field['js_options'] ) )
			);

			$html .= self::options_html( $field, $meta );

			$html .= '</select>';

			return $html;
		}

		/**
		 * Normalize parameters for field
		 *
		 * @param array $field
		 *
		 * @return array
		 */
		static function normalize_field( $field )
		{
			$field = parent::normalize_field( $field );

			$field = wp_parse_args( $field, array(
				'js_options' => array(),
			) );

			$field['js_options'] = wp_parse_args( $field['js_options'], array(
				'allowClear'  => true,
				'width'       => 'resolve',
				'placeholder' => $field['placeholder'],
			) );

			return $field;
		}
	}
}
