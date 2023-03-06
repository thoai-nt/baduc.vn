<?php
/**
 * Prohibit direct script loading.
 *
 * @package Convert_Plus.
 */

if ( ! function_exists( 'modal_theme_social_media_with_form' ) ) {
	/**
	 * Function Name: modal_theme_social_media_with_form.
	 *
	 * @param  array  $atts    array parameters.
	 * @param  string $content string parameter.
	 * @return mixed          string parameter.
	 */
	function modal_theme_social_media_with_form( $atts, $content = null ) {
		/**
		 * Define Variables.
		 */
		global $cp_form_vars;

		$style_id         = '';
		$settings_encoded = '';
		shortcode_atts(
			array(
				'style_id'         => '',
				'settings_encoded' => '',
			),
			$atts
		);
		$style_id         = isset( $atts['style_id'] ) ? $atts['style_id'] : '';
		$settings_encoded = $atts['settings_encoded'];

		$settings       = base64_decode( $settings_encoded );
		$style_settings = json_decode( $settings, true );

		foreach ( $style_settings as $key => $setting ) {
			$style_settings[ $key ] = apply_filters( 'smile_render_setting', $setting );
		}

		unset( $style_settings['style_id'] );

		// Generate UID.
		$uid       = uniqid();
		$uid_class = 'content-' . $uid;

		$individual_vars = array(
			'uid'         => $uid,
			'uid_class'   => $uid_class,
			'style_class' => 'cp-social-form',
		);

		/**
		 * Merge short code variables arrays.
		 *
		 * @array   $individual_vars        Individual style EXTRA short-code variables.
		 * @array   $cp_form_vars           CP Form global short-code variables.
		 * @array   $style_settings         Individual style short-code variables.
		 * @array   $atts                   short-code attributes.
		 */
		$all = array_merge(
			$individual_vars,
			$cp_form_vars,
			$style_settings,
			$atts
		);

		$a = shortcode_atts( $all, $style_settings );

		// Before filter.
		apply_filters_ref_array( 'cp_modal_global_before', array( $a ) );

		?>
		<!-- BEFORE CONTENTS -->
		<div class="cp-row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 cp-text-container " >
				<div class="cp-desc-container 
				<?php
				if ( '' === trim( $a['modal_short_desc1'] ) ) {
					echo 'cp-empty'; }
				?>
					">
					<div class="cp-description cp_responsive" ><?php echo do_shortcode( html_entity_decode( stripcslashes( $a['modal_short_desc1'] ) ) ); ?></div>
				</div>
				<div class="cp-title-container 
				<?php
				if ( '' === trim( $a['modal_title1'] ) ) {
					echo 'cp-empty'; }
				?>
					">
					<h2 class="cp-title cp_responsive"><?php echo do_shortcode( html_entity_decode( $a['modal_title1'] ) ); ?></h2>
				</div>
				<div class="cp-mid-desc-container cp-clear 
				<?php
				if ( '' === trim( $a['modal_middle_desc'] ) ) {
					echo 'cp-empty'; }
				?>
					">
					<div class="cp-mid-description cp_responsive " ><?php echo do_shortcode( html_entity_decode( stripcslashes( $a['modal_middle_desc'] ) ) ); ?></div>
				</div>              		
			</div><!-- end of text container-->

			<div class="cp-row cp-social-form-form" style='border-color:<?php echo esc_attr( $a['form_border_color'] ); ?>; background-color:<?php echo esc_attr( $a['form_bg_color'] ); ?>'>
				<div class="cp-form-container">
					<?php
							// Embed CP Form.
					apply_filters_ref_array( 'cp_get_form', array( $a ) );
					?>
				</div>
				<div class="cp_social_media_wrapper">
					<?php
							// Embed CP Form.
					apply_filters_ref_array( 'cp_get_social', array( $a ) );
					?>
				</div>	             
			</div><!-- .webinar form -->
		</div><!--row-->
		<?php
		// After filter.
		apply_filters_ref_array( 'cp_modal_global_after', array( $a ) );

		return ob_get_clean();
	}
}
