<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Class WPBakeryShortCode_Vc_Round_Chart
 */
class WPBakeryShortCode_Vc_Round_Chart extends WPBakeryShortCode {
	/**
	 * WPBakeryShortCode_Vc_Round_Chart constructor.
	 * @param $settings
	 */
	public function __construct( $settings ) {
		parent::__construct( $settings );
		$this->jsScripts();
	}

	public function jsScripts() {
		wp_register_script( 'vc_waypoints', vc_asset_url( 'lib/vc_waypoints/vc-waypoints.min.js' ), array( 'jquery' ), WPB_VC_VERSION, true );
		wp_register_script( 'ChartJS', vc_asset_url( 'lib/bower/chartjs/Chart.min.js' ), array(), WPB_VC_VERSION, true );
		wp_register_script( 'vc_round_chart', vc_asset_url( 'lib/vc_round_chart/vc_round_chart.min.js' ), array(
			'jquery',
			'vc_waypoints',
			'ChartJS',
		), WPB_VC_VERSION, true );
	}
}
