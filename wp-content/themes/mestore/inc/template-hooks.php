<?php
/**
 * Custom template hooks for this theme.
 *
 *
 * @package mestore
 */


/**
 * Before title meta hook
 */
if ( ! function_exists( 'mestore_before_title' ) ) :
function mestore_before_title() {
	do_action('mestore_before_title');
}
endif;

/**
 * After title meta hook
 */
if ( ! function_exists( 'mestore_after_title' ) ) :
function mestore_after_title() {
	do_action('mestore_after_title');
}
endif;

/**
 * Before title content meta hook
 */
if ( ! function_exists( 'mestore_before_title_content' ) ) :
function mestore_before_title_content() {
	do_action('mestore_before_title_content');
}
endif;

/**
 * After title content meta hook
 */
if ( ! function_exists( 'mestore_after_title_content' ) ) :
function mestore_after_title_content() {
	do_action('mestore_after_title_content');
}
endif;

/**
 * Before menu cart meta hook
 */
if ( ! function_exists( 'mestore_before_header_menu_cart' ) ) :
function mestore_before_header_menu_cart() {
	do_action('mestore_before_header_menu_cart');
}
endif;


/**
 * Single post content after meta hook
 */
if ( ! function_exists( 'mestore_single_post_after_content' ) ) :
function mestore_single_post_after_content($postID) {
	do_action('mestore_single_post_after_content',$postID);
}
endif;