<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
/**
 * @var array $atts
 * @var string $field_key
 * @var string $custom_field_key
 * @var string $el_class
 */
$field_key = $custom_field_key = $el_class = '';

extract( shortcode_atts( array(
	'field_key' => '',
	'custom_field_key' => '',
	'el_class' => '',
), $atts ) );

$key = strlen( $custom_field_key ) > 0 ? $custom_field_key : $field_key;

$output = '';
if ( strlen( $key ) ) {
	$output .= '<div class="vc_gitem-custom-field-' . esc_attr( $key ) . '">{{ post_meta_value: ' . esc_attr( $key ) . '}}</div>';
}

return $output;
