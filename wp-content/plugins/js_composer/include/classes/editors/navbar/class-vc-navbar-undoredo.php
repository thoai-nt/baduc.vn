<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Class Vc_Navbar_Undoredo
 */
class Vc_Navbar_Undoredo {
	public function __construct() {
		// Backend
		add_filter( 'vc_nav_controls', array(
			$this,
			'addControls',
		) );

		// Frontend
		add_filter( 'vc_nav_front_controls', array(
			$this,
			'addControls',
		) );
	}

	/**
	 * @param $controls
	 * @return array
	 */
	public function addControls( $controls ) {
		$controls[] = array(
			'redo',
			'<li class="vc_pull-right"><a id="vc_navbar-redo" href="javascript:;" class="vc_icon-btn" disabled title="' . esc_attr__( 'Redo', 'js_composer' ) . '"><i class="vc_navbar-icon fa fa-repeat"></i></a></li>',
		);
		$controls[] = array(
			'undo',
			'<li class="vc_pull-right"><a id="vc_navbar-undo" href="javascript:;" class="vc_icon-btn" disabled title="' . esc_attr__( 'Undo', 'js_composer' ) . '"><i class="vc_navbar-icon fa fa-undo"></i></a></li>',
		);

		return $controls;
	}
}
